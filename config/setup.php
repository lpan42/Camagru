<?php
require_once 'database.php';

function setup_db(){
    try{
        $settings = array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection = new PDO("mysql:host=localhost;$DB_CHARSET", "root", "rootroot",$settings);
        $query = "CREATE DATABASE IF NOT EXISTS `camagru_db`; USE `camagru_db`;";
        $connection->exec($query);
        
        $password = 'Ashley0930';
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query_users = "CREATE TABLE IF NOT EXISTS `users`(
            `id_user` INT AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `username` VARCHAR(255) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `hash_active` VARCHAR(255) UNIQUE,
            `hash_pwd` VARCHAR(255) UNIQUE,
            `active` BOOLEAN DEFAULT FALSE,
            `email_prefer` BOOLEAN DEFAULT TRUE);
            INSERT INTO `users` (`email`, `username`, `password`, `active`)
            VALUES ('ashley.lepan@gmail.com', 'admin', :password, TRUE);
        ";
      
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
            ('public/stickers/sticker27.png'),
            ('public/stickers/sticker28.png'),
            ('public/stickers/sticker29.png'),
            ('public/stickers/sticker30.png'),
            ('public/stickers/sticker31.png');";
      
        $query_gallery = "CREATE TABLE IF NOT EXISTS `gallery`(
            `id_gallery` INT AUTO_INCREMENT PRIMARY KEY,
            `id_user` INT NOT NULL,
            `path` VARCHAR(500) NOT NULL,
            `creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);
            
            INSERT INTO `gallery` (`id_user`, `path`, `creation_date`) VALUES
            (1, 'public/gallery/admin20191114113527.jpg', 20191114113527), 
            (1, 'public/gallery/admin20191114113544.jpg', 20191114113544), 
            (1, 'public/gallery/admin20191114113622.jpg', 20191114113622), 
            (1, 'public/gallery/admin20191114113811.jpg', 20191114113811), 
            (1, 'public/gallery/admin20191114114052.jpg', 20191114114052), 
            (1, 'public/gallery/admin20191114114248.jpg', 20191114114248);";
       
        $connection->exec($query_likes);    
        $connection->exec($query_comments);
        $connection->exec($query_stickers);
        $connection->exec($query_gallery);
        $result = $connection->prepare($query_users);
        $result -> bindValue(':password', $password);
        $result -> execute();

        session_unset();

        //delete all the previous gallery files
        $folder = './public/gallery/';
        $admin_file = array(
            'admin20191114113527.jpg',
            'admin20191114113544.jpg',
            'admin20191114113622.jpg',
            'admin20191114113811.jpg',
            'admin20191114114052.jpg',
            'admin20191114114248.jpg',
        );
        $files = glob($folder . '*');
        foreach($files as $file){
            if(!in_array(basename($file), $admin_file)){
                unlink($file);
            }
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }    
}
?> 