<?php
class GalleryController extends Controller
{
    public function process($args)
    {     
        $this->head['title'] = 'Gallery';
       // normal single picture
        if($args[0] == "single_pic" && $args[1]){ 
            $galleryManager = new GalleryManager();
            $single_pic = $galleryManager->get_single_pic($args[1]);
            $comments = $galleryManager->get_comments($args[1]);
            $likes = $galleryManager->get_likes($args[1]);
            foreach($comments as $comment){
                if($comment['id_user_given'] == $_SESSION['id_user']){
                    $check_comment = 1;
                    break;
                }else{
                    $check_comment = 0;
                }
            }
            foreach($likes as $like){
                if($like['id_user_given'] == $_SESSION['id_user']){
                    $check_like = 1;
                    break;
                }else{
                    $check_like = 0;
                }
            }
                //if id_gallery does not exist
            if(!$single_pic){
                $this->redirect('error');
            }
            $this->data['single_pic'] = $single_pic;
            $this->data['comments'] = $comments;
            $this->data['likes'] = $likes;
            $this->data['check_comment'] = $check_comment;
            $this->data['check_like'] = $check_like;
            $this->view = 'gallery_single';
        }

        //need to post new comments or likes
        else if($args[0] == "post"){
            $this->parent->empty_page = TRUE;
            if($args[1] == "comment"){
                $this->post_comment();
            }
            if($args[1] == "like_plus"){
                $this->post_like();
            }
            if($args[1] == "like_minus"){
                $this->minus_like();
            }
        }

        //user gallery
        else if($args[0] == "user_gallery")
        {
            $this->head['title'] = 'My Gallery';
            $galleryManager = new GalleryManager();
            $user_gallery = $galleryManager->get_user_gallery($args[1]);
            if(!$user_gallery){
                $this->redirect('firstpost');
            }
            $this->data['user_gallery'] = $user_gallery;
            $this->view='gallery_user';
        }

        //user delete pics
        else if($args[0] == "delete" && $args[1] == "picture"){
            $this->parent->empty_page = TRUE;
            $this->delete_pic();
        }

        else if($args[0] == "pagination"){
            $this->parent->empty_page = TRUE;
            $this->pagination();
        }
        //all gallery_load first 6
       else {
            $galleryManager = new GalleryManager();
            $all_gallery = $galleryManager->get_gallery(0);
            $this->data['all_gallery'] = $all_gallery;
            $this->view = 'gallery';
        }
    }

    public function post_comment(){
        $data = trim(file_get_contents('php://input'));
        $galleryManager = new GalleryManager();
        $encoded = json_decode($data, TRUE);
        $id_gallery = $encoded['id_gallery'];
        $comment = $encoded['comment'];
        $id_user_given = $_SESSION['id_user'];
        $galleryManager->new_comment($comment, $id_gallery, $id_user_given);
        echo(trim($_SESSION["username"]));
    }

    public function post_like(){
        $id_gallery = trim(file_get_contents('php://input'));
        $id_user_given = $_SESSION['id_user'];
        $galleryManager = new GalleryManager();
        $galleryManager->new_like($id_gallery, $id_user_given);
        echo(trim($_SESSION["username"]));
    }

    public function minus_like(){
        $id_gallery = trim(file_get_contents('php://input'));
        $id_user_given = $_SESSION['id_user'];
        $galleryManager = new GalleryManager();
        $minus_like = $galleryManager->minus_like($id_gallery, $id_user_given);
        echo($minus_like);
    }

    public function delete_pic(){
        $id_gallery = trim(file_get_contents('php://input'));
        $galleryManager = new GalleryManager();
        $path = $galleryManager->delete_pic_com_lik($id_gallery);
        if (file_exists($path[0])){
               unlink($path[0]);
        }
    }

    public function pagination(){
        $offset_nbr = trim(file_get_contents('php://input'));
        $galleryManager = new GalleryManager();
        $all_gallery = $galleryManager->get_gallery($offset_nbr);
        print_r(json_encode($all_gallery));
    }
}
?>