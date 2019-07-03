<?php
require_once 'database.php';
try{
    $settings = array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception
    $connection = new PDO("mysql:host=localhost;$DB_CHARSET", "root", "rootroot",$settings);
    $query = "CREATE DATABASE IF NOT EXISTS $DB_NAME; USE $DB_NAME;";
    $connection->exec($query);

    $query_users = "CREATE TABLE IF NOT EXISTS `users`(
        `id_user` INT AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(30) NOT NULL UNIQUE,
        `username` VARCHAR(15) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `email_prefer` BOOLEAN DEFAULT TRUE,
        `admin` BOOLEAN DEFAULT FALSE
    );";

    $query_imgs = "CREATE TABLE IF NOT EXISTS `imgs`(
        `id_img` INT AUTO_INCREMENT PRIMARY KEY,
        `id_user` INT NOT NULL,
        `path` VARCHAR(500) NOT NULL,
        `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP()
    );";

    $query_likes = "CREATE TABLE IF NOT EXISTS `likes`(
        `id_like` INT AUTO_INCREMENT PRIMARY KEY,
        `id_img` INT NOT NULL,
        `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP()
    );";

    $query_comments = "CREATE TABLE IF NOT EXISTS `comments`(
        `id_comment` INT AUTO_INCREMENT PRIMARY KEY,
        `id_img` INT NOT NULL,
        `comment` VARCHAR(500) NOT NULL,
        `creation_date` DATETIME DEFAULT CURRENT_TIMESTAMP()
    );";

    $query_stickers = "CREATE TABLE IF NOT EXISTS `stickers`(
        `id_sticker` INT AUTO_INCREMENT PRIMARY KEY,
        `path` VARCHAR(500) NOT NULL
    );";

    $query_stickers_insert = "INSERT INTO `stickers` (path) VALUES(
        
    );";

    $connection->exec($query_users);
    $connection->exec($query_imgs);
    $connection->exec($query_likes);
    $connection->exec($query_comments);
    $connection->exec($query_stickers);


    echo "Database $DB_NAME has been built successfully";
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

?> 