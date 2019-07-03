<?php
require_once 'Controller.php';
class LoginController extends Controller
{
    public function process($args)
    {
        $userManager = new UserManager;
        // HTML head
        $this->head['title'] = 'Login';
        if ($_POST)
        {
            try
            {
                $userManager->login($_POST['email'], $_POST['password']);
                $this->addMessage('You were successfully logged in.');
               // $this->redirect('administration');
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