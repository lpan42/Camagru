<?php
class GalleryManager
{
    public function get_gallery(){
        $all_gallery = Db::queryAll(
            'SELECT `username`,`id_gallery`, `path`, `creation_date`
            FROM `gallery` JOIN `users`
            ON `gallery`.`id_user` = `users`.`id_user`
            ORDER BY `id_gallery` DESC;');
        return $all_gallery;
    }

    public function get_user_gallery($id_user){
        $user_gallery = Db::queryAll(
            'SELECT `username`,`gallery`.`id_user`,`id_gallery`, `path`, `creation_date`
            FROM `gallery` JOIN `users`
            ON `gallery`.`id_user` = `users`.`id_user`
            WHERE `users`.`id_user` = ?
            ORDER BY `id_gallery` DESC;',
            array($id_user));
        return $user_gallery;
    }

    public function get_single_pic($id_gallery){
        $single_pic = Db::queryAll(
            'SELECT `username`, `gallery`.`id_user`,`id_gallery`, `path`, `creation_date`
            FROM `gallery` JOIN `users`
            ON `gallery`.`id_user` = `users`.`id_user`
            WHERE `gallery`.`id_gallery` = ?;',
            array($id_gallery));
        return $single_pic;
    }

    public function get_comments($id_gallery){
        $comments = Db::queryAll(
            'SELECT `username`, `id_user_given`,`id_comment`,`comment`, `creation_date`
            FROM `comments` JOIN `users`
            ON `comments`.`id_user_given` = `users`.`id_user`
            WHERE `comments`.`id_gallery` = ?
            ORDER BY `id_comment` DESC;',
            array($id_gallery));
        return $comments;
    }

    public function get_likes($id_gallery){
        $likes = Db::queryAll(
            'SELECT `id_like`, `id_user_given`
            FROM `likes` 
            WHERE `id_gallery` = ?;',
            array($id_gallery));
        return $likes;
    }
    

    public function new_comment($comment, $id_gallery, $id_user_given){
        $new = array(
            'id_gallery' => $id_gallery,
            'id_user_given' => $id_user_given,
            'comment' => $comment
        );
        try{
			Db::insert('comments', $new);
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
    }
    
    public function new_like($id_gallery, $id_user_given){
        $new = array(
            'id_gallery' => $id_gallery,
            'id_user_given' => $id_user_given,
        );
        try{
			Db::insert('likes', $new);
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
    }

    public function  minus_like($id_gallery, $id_user_given)
    {
        $minus_like = Db::query('DELETE FROM `likes` 
                WHERE `id_gallery` = ? 
                AND `id_user_given` = ?;', 
            array($id_gallery, $id_user_given));
        return $minus_like;
    }
}
?>