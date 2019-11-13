<?php
class NewPost
{
    public function nameImg(){
        $img_name = 'public/gallery/'.date('YmdHis').'.jpg';
        return $img_name;
    }

    public function get_stickers()
    {
        $stickers = Db::queryAll('SELECT id_sticker, path FROM stickers;');
        return $stickers;
    }
    
    public function get_prepics($id_user)
    {
        $galleries = Db::queryAll(
            'SELECT `id_gallery`, `path`, `creation_date`
            FROM `gallery`
            WHERE `id_user` = ? ORDER BY `id_gallery` DESC;', array($id_user));
        return $galleries;
    }

    public function post_picture($post)
    {
        Db::insert('gallery', $post);
        $id_gallery = Db::queryOne(
            'SELECT `id_gallery` 
            FROM `gallery` 
            WHERE `path`= ?;', array($post["path"]));
        return $id_gallery;
    }
}
?>