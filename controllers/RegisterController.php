<?php
require_once 'Controller.php';
class RegisterController extends Controller
{
    public function process($params)
    {
        // HTML head
        $this->head['title'] = 'Register';
        if ($_POST)
        {
            try
            {
                $userManager = new UserManager();
                $userManager->register($_POST['email'], $_POST['username'], $_POST['password'], $_POST['password_repeat']);
                $userManager->login($_POST['email'], $_POST['password']);
                $this->addMessage('You were successfully registered.');
                $this->redirect('administration');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
        $this->view = 'register';
    }
}
?>