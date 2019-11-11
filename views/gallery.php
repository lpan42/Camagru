<div class="gallery_div">
    <div class="img-container">
        <?php foreach($all_gallery as $gallery):?>
            <div class="img-item">
                <a href="Gallery/single_pic/<?=$gallery['id_gallery']?>"><img class="gallery_pic" id="<?=$gallery['id_gallery']?>" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>
                <div class="comments_likes_div">
                    <img class="icons" id="like_icon" src="public/icons/like_icon_b.png">
                    <span id="likes_nbr">(<?php echo($gallery['like_count']);?>)</span>
                    <img class="icons" id="comment_icon" src="public/icons/comment_icon_b.png">
                    <span id="comment_nbr">(<?php echo($gallery['comment_count']);?>)</span>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<script type="text/javascript" src="/public/js/gallery.js"></script>