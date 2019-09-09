<div class="gallery_div">
    <?php foreach($all_gallery as $gallery):?>
    <div class="gallery_cell">
        <!-- <p id="username"><?=$gallery['username']?></p>
        <p id="create_date"><?=$gallery['creation_date']?></p> -->
        <a href="Gallery/<?=$gallery['id_gallery']?>"><img class="gallery_pic" id="gallery<?=$gallery['id_gallery']?>" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>   
        <?php endforeach;?>
    </div>
</div>
