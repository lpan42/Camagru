<?php
class ModifpwdController extends Controller
{
    public function process($args)
    {
        $userManager = new UserManager;
        $this->head = 'Change password';
        if ($_POST)
        {
            try
            {
                $userManager->modif_pwd($_POST['old_pwd'], $_POST['new_pwd'], $_POST['new_pwd_repeat']);
                $this->addMessage('Your password has been changed, you may login with your new password');
                session_unset();
                $this->redirect('login');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
        $this->view = 'modif_pwd';
    }
}
?>