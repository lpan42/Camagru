<div class="gallery_div">
    <div class="img-container">
        <?php foreach($all_gallery as $gallery):?>
            <div class="img-item">
                <a href="Gallery/single_pic/<?=$gallery['id_gallery']?>"><img class="gallery_pic" id="gallery<?=$gallery['id_gallery']?>" src="<?=$gallery['path']?>" alt="<?=$gallery['id_gallery']?>"></a>
                <div class="comments_likes_div">
                    <img class="icons" id="like_icon" src="public/icons/like_icon_b.png">
                    (<span id="likes_nbr"><?php echo($gallery['like_count']);?></span>)
                    <img class="icons" id="comment_icon" src="public/icons/comment_icon_b.png">
                    (<span id="comment_nbr"><?php echo($gallery['comment_count']);?></span>)
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<script>
var container = document.getElementsByClassName("img-container")[0];
let offset_nbr = 0;
// Detect when scrolled to bottom and add 6 more pics.
container.addEventListener('scroll', function() {
  if (container.scrollTop + container.clientHeight >= container.scrollHeight) {
    offset_nbr =  offset_nbr + 6;
    fetch('Gallery/pagination', {
        method: 'POST',
        body: offset_nbr,
    }).then((response) => response.text()).then((text) => {
            text = JSON.parse(text);
            // console.log(text.length);
            for(i = 0; i < text.length; i++){
                let img_item = document.createElement("DIV");
                img_item.className = "img-item";
                img_item.parentNode.appendChild(img_item);
                console.log(text[i]);
            }
        });
    }
  });


</script>