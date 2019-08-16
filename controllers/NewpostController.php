<?php
class NewpostController extends Controller
{
    public function process($args){
        $this->authUser();
        $newpost = new NewPost();
        $username = $_SESSION['username'];
        $stickers = $newpost->get_stickers();
        $prepics = $newpost->get_prepics($username);
        $this->data['stickers'] = $stickers;
        $this->data['prepics'] = $prepics;
        if ($args[0] == 'upload_pic'){
            $this->parent->empty_page = TRUE;
            $this->upload_pic();
        } else 
            $this->view = 'newpost';
    }

    public function upload_pic(){
        $target_dir = "public/tmp/";
        $target_file = $target_dir.$_FILES["fileToUpload"]["name"];
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        // if(isset($_POST["submit"])) {
        //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        //     if($check !== false) {
        //         $uploadOk = 1;
        //     } else {
        //         $this->addMessage('File is not an image.');
        //         $uploadOk = 0;
        //     }
        // }
        // Check if file already exists
        if (file_exists($target_file)) {
            $this->addMessage('File already exists.');
            $uploadOk = 0;
        }
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
        }else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // $this->data['uploadedpic'] = $target_file;
                // echo '<img id="uploadedpic" src="'.$target_file.'">';
                $this->addMessage('The file has been uploaded.');
                echo $target_file;
            } else{
                $this->addMessage('An error uploading your file.');
            }
        }
    }
}
?>