<?php
require_once 'database.php';

// function check_db(){
//     try{
//         $settings = array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception
//         $connection = new PDO("mysql:host=localhost;$DB_CHARSET", "root", "rootroot",$settings);
//         $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'camagru_db'";
//         $count = $connection->exec($query);
//         var_dump($count);
//         if(!$count)
//         {
//             // echo "test";
//             // setup_db();
//         }
//     }
//     catch(PDOException $e){
//         echo $e->getMessage();
//     }
// }

function setup_db(){
    try{
        $settings = array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// set the PDO error mode to exception
        $connection = new PDO("mysql:host=localhost;$DB_CHARSET", "root", "rootroot",$settings);
        $query = "CREATE DATABASE IF NOT EXISTS `camagru_db`; USE `camagru_db`;";
        $connection->exec($query);
    
        $query_users = "CREATE TABLE IF NOT EXISTS `users`(
            `id_user` INT AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `username` VARCHAR(255) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `hash_active` VARCHAR(255) UNIQUE,
            `hash_pwd` VARCHAR(255) UNIQUE,
            `active` BOOLEAN DEFAULT FALSE,
            `email_prefer` BOOLEAN DEFAULT TRUE,
            `admin` BOOLEAN DEFAULT FALSE
        );";
    
        $query_likes = "CREATE TABLE IF NOT EXISTS `likes`(
            `id_like` INT AUTO_INCREMENT PRIMARY KEY,
            `id_gallery` INT NOT NULL,
            `id_user_given` INT NOT NULL,
            `creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );";
    
        $query_comments = "CREATE TABLE IF NOT EXISTS `comments`(
            `id_comment` INT AUTO_INCREMENT PRIMARY KEY,
            `id_gallery` INT NOT NULL,
            `id_user_given` INT NOT NULL,
            `comment` VARCHAR(500) NOT NULL,
            `creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );";
    
        $query_stickers = "CREATE TABLE IF NOT EXISTS `stickers`(
            `id_sticker` INT AUTO_INCREMENT PRIMARY KEY,
            `path` VARCHAR(500) NOT NULL);
            
            INSERT INTO `stickers` (path) VALUES 
            ('public/stickers/sticker2.png'),
            ('public/stickers/sticker3.png'),
            ('public/stickers/sticker1.png'),
            ('public/stickers/sticker4.png'),
            ('public/stickers/sticker5.png'),
            ('public/stickers/sticker6.png'),
            ('public/stickers/sticker7.png'),
            ('public/stickers/sticker8.png'),
            ('public/stickers/sticker9.png'),
            ('public/stickers/sticker10.png'),
            ('public/stickers/sticker11.png'),
            ('public/stickers/sticker12.png'),
            ('public/stickers/sticker13.png'),
            ('public/stickers/sticker14.png'),
            ('public/stickers/sticker15.png'),
            ('public/stickers/sticker16.png'),
            ('public/stickers/sticker17.png'),
            ('public/stickers/sticker18.png'),
            ('public/stickers/sticker20.png'),
            ('public/stickers/sticker21.png'),
            ('public/stickers/sticker22.png'),
            ('public/stickers/sticker23.png'),
            ('public/stickers/sticker24.png'),
            ('public/stickers/sticker25.png'),
            ('public/stickers/sticker26.png'),
            ('public/stickers/sticker27.png');";
    
        $query_gallery = "CREATE TABLE IF NOT EXISTS `gallery`(
            `id_gallery` INT AUTO_INCREMENT PRIMARY KEY,
            `id_user` INT NOT NULL,
            `path` VARCHAR(500) NOT NULL,
            `creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );";

        $connection->exec($query_users);
        $connection->exec($query_likes);
        $connection->exec($query_comments);
        $connection->exec($query_stickers);
        $connection->exec($query_gallery);

        session_unset();
        //delete all the previous gallery files
        $folder = './public/gallery';
        $files = glob($folder . '/*');
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }    
}
// setup_db();
?> 