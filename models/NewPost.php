<?php
class NewPost
{
    public function getImgName(){
        $img_name = 'public/gallery/'.date('YmdHis').'.jpg';
        return $img_name;
    }

    public function changeImagetoBase64($image){
        $path = $image;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}
?>