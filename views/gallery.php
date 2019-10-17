<div class="gallery_div">
    <div class="img-row">
        <?php foreach($all_gallery as $gallery):?>
        <div class="img-container">
            <a href="Gallery/<?=$gallery['id_gallery']?>"><img class="gallery_pic" id="gallery<?=$gallery['id_gallery']?>" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>   
            <?php endforeach;?>
            <!-- <div class="overlay">
                <a href="#">READ ME>></a>
            </div> -->
        </div>
    </div>  
</div>
