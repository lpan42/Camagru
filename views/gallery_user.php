<div class="gallery_div">
    <p id="username"><?=$user_gallery[0]['username']?>'s Gallery
    <?php if($user_gallery[0]['id_user'] == $_SESSION['id_user']):?>
    <button>Delete Pictures</button></p>
    <?php endif;?>
    <?php foreach($user_gallery as $gallery):?>
    <div class="img-container">
        <a href="Gallery/<?=$gallery['id_gallery']?>"><img class="gallery_pic" id="gallery<?=$gallery['id_gallery']?>" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>   
        <?php endforeach;?>
    </div>
</div>
