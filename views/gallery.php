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

<script>
var container = document.getElementsByClassName("img-container")[0];
let offset_nbr = 0;
// Detect when scrolled to bottom and add 6 more pics.
container.addEventListener('scroll', function() {
  if (container.scrollTop + container.clientHeight >= container.scrollHeight) {
    offset_nbr += 6;
    fetch('Gallery/pagination', {
        method: 'POST',
        body: offset_nbr,
    }).then((response) => response.text()).then((text) => {
            text = JSON.parse(text);
            // console.log(text.length);
            for(i = 0; i < text.length; i++){
                let img_item = document.createElement("DIV");
                img_item.className = "img-item";

                let a = document.createElement("A");
                a.href = "Gallery/single_pic/" + text[i]["id_gallery"];

                let img = document.createElement("IMG");
                img.className = "gallery_pic";
                img.id = text[i]["id_gallery"];
                img.src = text[i]["path"];
                img.alt = text[i]["id_gallery"];

                let comments_likes_div = document.createElement("DIV");
                comments_likes_div.className = "comments_likes_div";

                let like_icon = document.createElement("IMG");
                like_icon.className = "icons";
                like_icon.id = "like_icon";
                like_icon.src = "public/icons/like_icon_b.png";

                let likes_nbr = document.createElement("SPAN");
                likes_nbr.id = "likes_nbr";
                likes_nbr.innerHTML = "(" + text[i]["like_count"] + ")";
                
                let comment_icon = document.createElement("IMG");
                comment_icon.className = "icons";
                comment_icon.id = comment_icon;
                comment_icon.src = "public/icons/comment_icon_b.png";

                let comment_nbr = document.createElement("SPAN");
                comment_nbr.id = "comment_nbr";
                comment_nbr.innerHTML = "(" + text[i]["comment_count"] + ")";
                
                comments_likes_div.append(like_icon);
                comments_likes_div.append(likes_nbr);
                comments_likes_div.append(comment_icon);
                comments_likes_div.append(comment_nbr);
                a.append(img);
                img_item.append(a);
                img_item.append(comments_likes_div);
                container.append(img_item);
            }
        });
    }
  });


</script>