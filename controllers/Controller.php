<?php
abstract class Controller //the parent class for all controllers
{
    protected $data = array(); //be used to store data retrieved from models. will be passed to a view 
    protected $view = "";
    protected $head = array('title' => '');
    
    abstract function process($args);
    
    public function renderView()
    {
        if ($this->view)
        {
            extract($this->data);//$this->data['variable'] = 'value';
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("Camagru/views/" . $this->view . ".php");
        }
    }

    public function redirect($url)
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    public function addMessage($message)
    {
        if (isset($_SESSION['messages']))
            $_SESSION['messages'][] = $message;
        else
            $_SESSION['messages'] = array($message);
    }

    public function getMessages()
    {
        if (isset($_SESSION['messages']))
        {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        }
        else
            return array();
    }

    public function authUser($admin = false)
    {
        $userManager = new UserManager();
        $user = $userManager->getUser();
        if (!$user || ($admin && !$user['admin']))
        {
            $this->addMessage('You are not authorized to complete this action.');
            $this->redirect('login');
        }
    }
}
?>