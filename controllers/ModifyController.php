<?php
class ModifyController extends Controller
{
    public function process($args)
    {
        $userManager = new UserManager();
        if($args[0] == 'email-prefer'){
		   $this->emailprefer();
	    }
	    else if($args[0] == 'password'){
		   $this->modify_pwd();
        }
        else if($args[0] == "forgetpwd"){
            $this->reset_pwd();
        }
        else if($args[0] == "modify_email"){
            $this->parent->empty_page = TRUE;
            $this->modify_emailprefer();
        }
        else if($args[0] && $args[1])
        {
            try{
                $userManager->auth_reset_hash($args[0], $args[1]);
                if($_POST){
                    $userManager = new UserManager();
                    try
                    {
                        $userManager->reset_pwd($args[0],$_POST['new_pwd'], $_POST['new_pwd_repeat']);
                        $this->addMessage('Your password has been reset, you may login now');
                        $this->redirect('login');
                    }
                    catch (UserException $e)
                    {
                        $this->addMessage($e->getMessage());
                    }
                }
                $this->view = 'reset_pwd';
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
    }

    public function reset_pwd(){
        if($_POST){
            $userManager = new UserManager();
            try
            {
                $userManager->forget_pwd($_POST['login']);
                $this->addMessage('A link has been sent to your registerd email address. Please click the link to reset your password');
                $this->redirect('login');
            }
            catch (UserException $e)
            {
                $this->addMessage($e->getMessage());
            }
        }
       $this->view = 'forgetpwd';
    }
       
	public function emailprefer()
	{
        $userManager = new UserManager();
        $this->head['title'] = 'Change Email Perference';
        $user = $userManager->getUsername();
        $current = $userManager->getCurrentPrefer($user);
        $this->data['current'] = $current['email_prefer'];
        $this->view = 'modif_email';
    }
    
	public function modify_emailprefer(){
        $userManager = new UserManager();
        $user = $userManager->getUsername();
        $data = trim(file_get_contents('php://input'));
        try{
            $userManager->modif_EmailPrefer($user, $data);
            echo $data;
        }
        catch (UserException $ex){
            echo($ex->getMessage());
        }
    }

	public function modify_pwd()
	{
		$userManager = new UserManager;
        $this->head['title'] = 'Change password';
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