<div class="gallery_div">
    <p id="username"><?=$user_gallery[0]['username']?>'s Gallery
    <div class="img-container">
        <?php foreach($user_gallery as $gallery):?>
            <div class="img-item">
                <a href="Gallery/single_pic/<?=$gallery['id_gallery']?>"><img class="gallery_pic" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>
                <?php if($user_gallery[0]['id_user'] == $_SESSION['id_user']):?>
                    <button class="delete_btn"id="delete_btn<?=$gallery['id_gallery']?>">Delete</button>
                    <button class="share_btn" id="<?=$gallery['id_gallery']?>">Share</button>
                <?php endif;?>
                <div class="delete_comfirm">
                    <p>Are you sure you want to delete this picture?</p>
                    <button class="yes">Yes</button>
                    <button class="cancel">Cancel</button>
                </div>
                <div class="share_choice">
                    <a href="#" class="fa fa-facebook fa-2x"></a>
                    <a href="#" class="fa fa-twitter fa-2x"></a>
                    <a href="#" class="fa fa-instagram fa-2x"></a>
                    <button class="cancel">Cancel</button>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<script type="text/javascript" src="/public/js/gallery_user.js"></script>