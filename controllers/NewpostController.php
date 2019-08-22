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
            $this->addMessage('File is too large.');
            $uploadOk = 0;
        }
        // Allow certain file formats
        $valid_extensions = array("jpg","jpeg","png", "gif");
        if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if($uploadOk == 0){
            echo 0;
        }
        else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // $this->addMessage('The file has been uploaded.');
                echo $target_file;
            } else{
                $this->addMessage('An error uploading your file.');
            }
        }
    }
    public function name_file(){
        $username = $_SESSION['username'];
        $name = $username.date('YmdHis').".jpg";
        return $name;
    }
    public function merge_pic()
    {
        $data = trim(file_get_contents('php://input'));
        $encoded = json_decode($data, TRUE);
        // $this->debugp($encoded);
        $target_dir = "public/tmp/";
        // Create image instances 
       
        print_r($encoded['dst'][0]);
        $data_dest = $encoded['dst'][0];
        $dest = imagecreatefromstring(file_get_contents($data_dest['path'])); 
        $image = imagecreatetruecolor( $data_dest['w'],  $data_dest['h']);
        imageAlphaBlending($image, true);
        imagesavealpha($image, true);
        imagecopy($image, $dest, 0, 0,  $data_dest['x'],  $data_dest['y'],  $data_dest['w'],  $data_dest['h']);
        $alpha_channel = imagecolorallocatealpha($image, 0, 0, 0, 127); 
        imagecolortransparent($image, $alpha_channel); 
        imagefill($image, 0, 0, $alpha_channel); 
        $length = count($encoded['src']);
       // echo $length;
        for($i = 0; $i<$length; $i++){
            $data_src = $encoded['src'][$i];
            // print_r($data_src);
            $src = imagecreatefromstring(file_get_contents($data_src['path']));
            imageAlphaBlending($src, true);
            imagesavealpha($src, true);
            imagecolortransparent($src);
            $src_x = $data_src['x'];
            $src_y = $data_src['y'];
            $src_w = $data_src['w'];
            $src_h = $data_src['h'];
            imagecopy($image, $src, 0, 0, $src_x, $src_y, $src_w, $src_h); 
        }
        $name = $this->name_file();
        // header('Content-Type: image/gif'); 
        imagejpeg($image, $target_dir.$name);
        if(file_exists($target_dir.$name))
        {
            echo $target_dir.$name;
        }
        else{
            echo "sth wrong";
        }
    }
}

// <?php
// $data = json_decode(file_get_contents('input.json'), true);
// $image = imagecreatetruecolor(256, 256);
// imageAlphaBlending($image, true);
// imagesavealpha($image, true);
// $alpha_channel = imagecolorallocatealpha($image, 0, 0, 0, 127); 
// imagecolortransparent($image, $alpha_channel); 
// imagefill($image, 0, 0, $alpha_channel); 

// foreach ($data as $layer)
// {
//     $img = imagecreatefrompng("http://localhost:8080".$layer['url']);
//     imageAlphaBlending($img, true);
//     imagesavealpha($img, true);
//     imagecolortransparent($img);
//     if (isset($layer['color']))
//     {
//         for ($y = 0; $y < 256; $y++)
//         {    
//             for ($x = 0; $x < 256; $x++)
//             {
//                 $rgb = imagecolorat($img, $x, $y);
//                 $c = imagecolorsforindex($img, $rgb);
//                 $c['red'] *= ($layer['color']['r'] / 255);
//                 $c['green'] *= ($layer['color']['g'] / 255);
//                 $c['blue'] *= ($layer['color']['b'] / 255);
//                 $c['alpha'] *= $layer['color']['a'];
//                 $color = imagecolorallocatealpha($image, $c['red'], $c['green'], $c['blue'], $c['alpha']);
//                 imagesetpixel($img, $x, $y, $color);
//             }
//         }
//         imagecopy($image, $img, 0, 0, 0, 0, 256, 256);
//     }
//     else
//     {
//         imagecopy($image, $img, 0, 0, 0, 0, 256, 256);
//         imagedestroy($img);
//     }
// }


// header('Content-Type: image/png');
// imagepng($image);
// imagedestroy($image);

?>