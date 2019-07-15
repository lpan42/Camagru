<?php
class ModifemailController extends Controller
{
    public function process($args)
    {
        $userManager = new UserManager;
        $this->head = 'Change Email Perference';
        $user = $userManager->getUsername();
        $current = $userManager->getCurrentPrefer($user);
        $this->data['current'] = $current['email_prefer'];
        
        if ($_POST)
        {
            if($_POST['emailprefer'] == 'enable')
                $changeto = 1;
            else
                $changeto = 0;
            // print_r($_POST);
            // print_r($changeto);
            // print_r($current['email_prefer']);
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
}
?>