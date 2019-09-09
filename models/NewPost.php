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