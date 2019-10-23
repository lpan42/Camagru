<div class="gallery_div">
    <p id="username"><?=$user_gallery[0]['username']?>'s Gallery
    <div class="img-container">
        <?php foreach($user_gallery as $gallery):?>
            <div class="img-item">
                <a href="Gallery/<?=$gallery['id_gallery']?>"><img class="gallery_pic" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>
                <?php if($user_gallery[0]['id_user'] == $_SESSION['id_user']):?>
                    <button class="delete_btn" data-image="<?=$gallery['id_gallery']?>">Delete</button>
                <?php endif;?>
            </div>
        <?php endforeach;?>
    </div>
</div>

<script>
    const delete_btns = document.getElementsByClassName('delete_btn');
    for(let i = 0; i < delete_btns.length; i++){
        delete_btns[i]. addEventListener("click", function(e) {
    console.log(document.getElementById("delete_btn"));
    })
}
</script>