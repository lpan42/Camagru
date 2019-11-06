<?php
require_once 'config/database.php';
// require_once 'config/setup.php';

session_start();
mb_internal_encoding("UTF-8");
date_default_timezone_set('UTC');

function autoloadFunction($class)
{
    //echo $class;
    if (preg_match('/Controller$/', $class)){
        require(__DIR__."/controllers/" . $class . ".php");
    }
    else{   
       require(__DIR__."/models/" . $class . ".php");
    }
}
spl_autoload_register("autoloadFunction");// Register given function as __autoload() implementation

//echo $DB_DSN;
Db::connect($DB_DSN, $DB_USER, $DB_PASSWORD);

$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->renderView();
//session_unset();
?>  