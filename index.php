<?php
require_once 'config/database.php';

session_start();
mb_internal_encoding("UTF-8");
date_default_timezone_set('UTC');

function autoloadFunction($class)
{
    //echo $class;
    if (preg_match('Camagru/Controller$/', $class)){
        require("Camagru/controllers/" . $class . ".php");
    }
    else{   
       require("Camagru/models/" . $class . ".php");
    }
}
spl_autoload_register("autoloadFunction");

//echo $DB_DSN;
//Db::connect($DB_DSN, $DB_USER, $DB_PASSWORD);

$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->renderView();
?>  