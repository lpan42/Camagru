<div class="single_pic">
    <a href="Gallery/user_gallery/<?=$single_pic[0]['id_user']?>"><p id="username"><?=$single_pic[0]['username']?></p></a>
    <p id="creation_date"><?=$single_pic[0]['creation_date']?></p>
    <hr>
    <img class="single_picture" id="<?=$single_pic[0]['id_gallery']?>" src="<?=$single_pic[0]['path']?>" alt="<?=$single_pic[0]['id_gallery']?>">
</div>
<div class="comments_likes">
    <div id="likes">
    <?php if($check_like):?>
        <img class="icons" id="like_icon" src="public/icons/like_icon.png">
    <?php else:?>
        <img class="icons" id="like_icon" src="public/icons/like_icon_b.png">
    <?php endif;?>
        (<span id="likes_nbr"><?php echo(count($likes));?></span>)
    </div>
    <div id="comments">
        <?php if($check_comment):?>
            <img class="icons" id="comment_icon" src="public/icons/comment_icon.png">
        <?php else:?>
            <img class="icons" id="comment_icon" src="public/icons/comment_icon_b.png">
        <?php endif;?>
        (<span id="comment_nbr"><?php echo(count($comments));?></span>)
        <?php if($_SESSION['username']):?>
            <form class="comment_form"  method="POST">
                <textarea id="new_comment" name="comment" placeholder="Add a comment..."></textarea>
                <input type="hidden" name="id_gallery" value="<?=$single_pic[0]['id_gallery']?>" />
                <button id="submit_comment">Post</button>
            </form>
        <?php endif?>
        <div id="comments_div">
            <?php foreach ($comments as $comment) : ?>
                <p class="comment_info"><b>[<a href="Gallery/user_gallery/<?=$comment['id_user_given']?>"><?=$comment['username']?></a>]</b><?=$comment['comment']?></p>
            <?php endforeach ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="/public/js/gallery.js"></script>