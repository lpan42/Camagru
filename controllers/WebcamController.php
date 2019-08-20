<?php
class WebcamController extends Controller
{
    public function process($args){
        $this->authUser();
        $newpost = new Newpost();
        $username = $_SESSION['username'];
        $stickers = $newpost->get_stickers();
        $prepics = $newpost->get_prepics($username);
        $this->data['stickers'] = $stickers;
        $this->data['prepics'] = $prepics;
        $this->view = 'newpost_webcam';
    }
}
