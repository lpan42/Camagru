<?php
abstract class Controller //the parent class for all controllers
{
    protected $data = array(); //be used to store data retrieved from models. will be passed to a view 
    protected $view = "";
    protected $head = "";
    protected $parent = NULL;
    protected $empty_page = FALSE;
    
    abstract function process($args);
    
    public function renderView()
    {
        if ($this->view)
        {
            extract($this->data);
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/" . $this->view . ".php");
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

    public function authUser()
    {
        $userManager = new UserManager();
        $user = $userManager->getUsername();
        if (!$user)
        {
            $this->addMessage('You need to login first.');
            $this->redirect('login');
        }
    }

    public function html_print($arg)
    {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }

    public function name_file(){
        $username = $_SESSION['username'];
        $name = $username.date('YmdHis').".jpg";
        return $name;
    }

    // public function changeImagetoBase64($image){
    //     $path = $image;
    //     $type = pathinfo($path, PATHINFO_EXTENSION);
    //     $data = file_get_contents($path);
    //     $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    //     return $base64;
    // }
}
?>