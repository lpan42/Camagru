<?php
class RegisterController extends Controller
{
    public function process($args)
    {
        // HTML head
        $this->head = 'Register';
        if ($_POST)
        {
            try
            {
                $userManager = new UserManager();
                $userManager->register($_POST['email'], $_POST['username'], $_POST['password'], $_POST['password_repeat']);
                $this->addMessage('You were successfully registered. A link has been sent to your registerd email address. Please click the link to activate your account');
                $this->redirect('login');
            }
            catch (UserException $e)
            {
                $this->addMessage($e->getMessage());
            }
        }
        $this->view = 'register';
    }
}
?>