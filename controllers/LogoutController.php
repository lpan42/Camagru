<?php
    class LogoutController extends Controller
    {
        public function process($args)
        {
            $userManager = new UserManager();
            $this->head['title'] = 'Logout';
            if ($_SESSION['email'])
            {
                try
                {
                    $userManager->logout();
                    $this->addMessage('You were successfully logged off.');
                // $this->redirect('login');
                }
                catch (UserException $ex)
                {
                    $this->addMessage($ex->getMessage());
                }
            }
            else
                $this->addMessage('You did not login.');
           // $this->view = 'logout';
        }
    }
?>