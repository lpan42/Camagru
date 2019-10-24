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
    for(let i = 0; i < delete_btns.length; i++){
        delete_btns[i]. addEventListener("click", function(e) {
            // console.log(delete_btns[i].id);
            delete_btns[i].style.display="none";
            const delete_comfirm = document.getElementsByClassName("delete_comfirm");
                // console.log(i);
                delete_comfirm[i].style.display="inline";
                document.getElementsByClassName("cancel")[i].addEventListener("click", function(e) {
                    delete_btns[i].style.display="inline";
                    delete_comfirm[i].style.display="none";
                })
                document.getElementsByClassName("yes")[i].addEventListener("click", function(e) {
                    fetch('Gallery/delete/picture', {
                        method: 'POST',
                        body: delete_btns[i].id,
                    }).then(function(response){
                        if (response.status !== 200) {
                            console.log('Looks like there was a problem. Status Code: '.response.status);
                            return;
                        }
                        else{
                            document.getElementsByClassName("img")[i].remove();
                        }
                    });
                })
            })
}      
</script>