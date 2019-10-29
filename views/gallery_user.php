<div class="gallery_div">
    <p id="username"><?=$user_gallery[0]['username']?>'s Gallery
    <div class="img-container">
        <?php foreach($user_gallery as $gallery):?>
            <div class="img-item">
                <a href="Gallery/<?=$gallery['id_gallery']?>"><img class="gallery_pic" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>
                <?php if($user_gallery[0]['id_user'] == $_SESSION['id_user']):?>
                    <button class="delete_btn" id="<?=$gallery['id_gallery']?>">Delete</button>
                <?php endif;?>
                <div class="delete_comfirm">
                    <p>Are you sure you want to delete this picture?</p>
                    <button class="yes">Yes</button>
                    <button class="cancel">Cancel</button>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<script>
    const delete_btns = document.getElementsByClassName('delete_btn');
    document.getElementsByClassName("img-container")[0].addEventListener('click', (event) => {
        const delete_btns = document.getElementsByClassName('delete_btn');
        [...delete_btns].forEach((btn) => {
            if (btn == event.target)
            {
                const delete_conf = btn.parentNode.getElementsByClassName("delete_comfirm")[0];
                delete_conf.style.display="inline"
                const cancel = delete_conf.getElementsByClassName("cancel")[0];
                cancel.onclick = () => {
                    delete_conf.style.display = "none";
                }
                const yes = delete_conf.getElementsByClassName("yes")[0];
                yes.onclick = () => {
                    fetch('Gallery/delete/picture', {
                        method: 'POST',
                        body: btn.id,
                    }).then(function(response){
                        if (response.status !== 200) {
                            alert('Looks like there was a problem. Status Code: '.response.status);
                            return;
                        }
                        else{
                            btn.parentNode.parentNode.removeChild(btn.parentNode);
                        }
                    });
                }
            }
        })
    })    
</script>