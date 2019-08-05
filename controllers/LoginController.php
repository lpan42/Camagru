<?php
class LoginController extends Controller
{
    public function process($args)
    {
        $userManager = new UserManager;
        $this->head['title'] = 'Login';
        if($args[0] && $args[1])
        {
            try{
                $userManager->active($args[0], $args[1]);
                $this->addMessage('your account has been successfully actived, you may login now.');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
        if ($_POST)
        {
            try
            {
                $userManager->login($_POST['login'], $_POST['password']);
                $this->addMessage('You were successfully logged in.');
                $this->redirect('gallery');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
        $this->view = 'login';
    }
}
?>