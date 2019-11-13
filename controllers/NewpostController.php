<?php
class NewpostController extends Controller
{
    public function process($args){
        $this->head['title'] = 'NewPost';
        $this->authUser();
        $newpost = new NewPost();
        $id_user = $_SESSION['id_user'];
        $stickers = $newpost->get_stickers();
        $prepics = $newpost->get_prepics($id_user);
        $this->data['stickers'] = $stickers;
        $this->data['prepics'] = $prepics;
        
        if($args[0] === 'Upload' && !$args[1]){
            $this->head['title'] = 'upload';
            $this->view = 'newpost_upload';
        }
        if($args[0] === 'Webcam' && !$args[1]){
            $this->head['title'] = 'webcam';
            $this->view = 'newpost_webcam';
        }
        if($args[0] === 'merge_pic'){
            $this->parent->empty_page = TRUE;
            $this->merge_pic();
        }
        if ($args[1] == 'upload_pic'){
            $this->parent->empty_page = TRUE;
            $this->upload_pic();
        }
        if ($args[0] == 'post_pic'){
			$this->parent->empty_page = TRUE;
            $this->post_pic();
        }
    }
    
    public function upload_pic(){
        $target_dir = "public/tmp/";
        $files = glob($target_dir."*");
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }
        $target_file = $target_dir.$_FILES["fileToUpload"]["name"];
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            $uploadOk = 0;
        }
        // Allow certain file formats
        $valid_extensions = array("jpg","jpeg","png", "gif");
        if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
            $uploadOk = -1;
        }
        // Check if $uploadOk is set to 0 by an error
        if($uploadOk == 1){
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo $target_file;
            } 
        }else{
            echo $uploadOk;
        }
    }
    public function img_decode64($data){
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        return ($data);
    }

    public function merge_pic()
    {
        $data = trim(file_get_contents('php://input'));
        $encoded = json_decode($data, TRUE);
        $target_dir = "public/tmp/";
        $bg = $encoded["bg"];
        $stickers = $encoded["layers"];
        $bg_url = explode(',', $bg["url"])[1];
        $decode_url = base64_decode($bg_url);
        $dest = imagecreatefromstring($decode_url);
        foreach($stickers as $sticker){
            $src = imagecreatefrompng($sticker['url']);
            list($width, $height) = getimagesize($sticker['url']);
            $src_x = $sticker['pos']['x'];
            $src_y = $sticker['pos']['y'];
            $src_w = $sticker['size']['w'];
            $src_h = $sticker['size']['h'];
            $new = imagecreatetruecolor($src_w, $src_h);
            $background = imagecolorallocatealpha($new, 255, 255, 255, 127); 
            imagecolortransparent($new, $background);
            imagealphablending($new, true);
            imagesavealpha($new, true); 
            imagefill($new, 0, 0, $background);
            imagecopyresized($new, $src, 0, 0, 0, 0, $src_w, $src_h, $width, $height);
            imagecopy($dest, $new, $src_x, $src_y,  0, 0, $src_w, $src_h); 
            imagedestroy($src);
            imagedestroy($new);
        }
        $name = $this->name_file();
        imagejpeg($dest, $target_dir.$name);
        imagedestroy($dest);
        echo $target_dir.$name;
    }

    public function post_pic(){
        $target_dir = "public/gallery/";
        $name = $this->name_file();
        $data = trim(file_get_contents('php://input'));
        if(copy($data, $target_dir.$name)){
            try
            {
                $new_post = new NewPost();
                $post = array(
                    'id_user' => $_SESSION['id_user'],
                    'path' => $target_dir.$name,
                    );
                $id_gallery = $new_post->post_picture($post);
                unlink($data);
                echo json_encode($id_gallery['id_gallery']); 
            }
            catch (UserException $e)
            {  
                echo json_encode(0); 
            }
           
        }
        else{
            echo json_encode(0); 
        }
    }
}
?>