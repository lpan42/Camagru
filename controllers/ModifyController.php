<?php
class ModifyController extends Controller
{
    public function process($args)
    {
		if($args[0] == 'email-prefer'){
		   $this->modify_emailprefer();
	   }
	   else if($args[0] == 'password'){
		   $this->modify_pwd();
		}
    }

	public function modify_emailprefer()
	{
        $userManager = new UserManager();
        $this->head['title'] = 'Change Email Perference';
        $user = $userManager->getUsername();
        $current = $userManager->getCurrentPrefer($user);
        $this->data['current'] = $current['email_prefer'];
        
        if ($_POST)
        {
            if($_POST['emailprefer'] == 'enable')
                $changeto = 1;
            else
                $changeto = 0;
            if($current['email_prefer'] == $changeto){
                $this->addMessage('You Email preference remain unchanged');
            }
            else{
                try{
                    // print_r($changeto);
                    $userManager->modif_EmailPrefer($user, $changeto);
                    $this->addMessage('You Email preference has been updated');
                }
                catch (UserException $ex)
                {
                    $this->addMessage($ex->getMessage());
                }
            }
        }
        $this->view = 'modif_email';
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