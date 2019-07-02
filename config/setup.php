<?php
require_once 'database.php';
try{
    $settings = array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception
    $connection = new PDO("mysql:host=localhost;$DB_CHARSET", "root", "rootroot",$settings);
    $query = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
    $connection->exec($query);
    echo "Database built successfully";
}
catch(PDOException $e){
    echo $e->getMessage();
}

$query_users = "CREATE TABLE `users` (
    `id_user` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `username` VARCHAR(15) NOT NULL UNIQUE,
    `password` VARCHAR(25) NOT NULL,
    `email_prefer` BOOLEAN DEFAULT true,
    `admin` BOOLEAN DEFAULT false,
    )";

$query_imgs = "CREATE TABLE `imgs` (
    `id_img` INT AUTO_INCREMENT PRIMARY KEY,
    `id_user` INT NOT NULL,
    `path` VARCHAR(1000) NOT NULL,
    `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
)";

$connection = null;
?> 