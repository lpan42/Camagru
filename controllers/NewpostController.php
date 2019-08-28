<?php
class NewpostController extends Controller
{
    public function process($args){
        $this->authUser();
        $newpost = new Newpost();
        $username = $_SESSION['username'];
        $stickers = $newpost->get_stickers();
        $prepics = $newpost->get_prepics($username);
        $this->data['stickers'] = $stickers;
        $this->data['prepics'] = $prepics;
        
        if($args[0] === 'Upload' && !$args[1]){
            $this->view = 'newpost_upload';
        }
        if($args[0] === 'Webcam' && !$args[1]){
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
        $image = imagecreatetruecolor($bg['w'], $bg['h']);
        imageAlphaBlending($image, true);
        imagesavealpha($image, true);
        imagecopy($image, $dest, 0, 0, 0, 0, $bg['w'], $bg['h']);
        // $alpha_channel = imagecolorallocatealpha($image, 0, 0, 0, 127); 
        // imagecolortransparent($image, $alpha_channel); 
        // imagefill($image, 0, 0, $alpha_channel); 
        $length = count($stickers);
        // echo $stickers[0]['url'];
        foreach($stickers as $sticker){
            $src = imagecreatefromstring(file_get_contents($sticker['url']));
            imageAlphaBlending($src, true);
            imagesavealpha($src, true);
            imagecolortransparent($src);
            $src_x = $sticker['x'];
            $src_y = $sticker['y'];
            $src_w = $sticker['w'];
            $src_h = $sticker['h'];
            imagecopy($image, $src, 0, 0, $src_x, $src_y, $src_w, $src_h); 
        }
        $name = $this->name_file();
        imagepng($image, $target_dir.$name);
        echo $target_dir.$name;
    }
}
?>