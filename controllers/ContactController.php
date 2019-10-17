<?php
class ContactController extends Controller
{
    public function process($args)
    {
        $this->head = array('title' => 'Contact form');
        if ($_POST)
        {
            try
            {
                $emailSender = new EmailSender();
                $emailSender->send($_POST['email'], "Email from Camagru", $_POST['message'], "ashley.lepan@gmail.com");
                $this->addMessage('The email was successfully sent.');
                $this->redirect('contact');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
        //$this->view = 'contact';
    }
}
?>