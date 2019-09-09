
<div class="stickers_div">
    <?php foreach($stickers as $sticker):?>
    <img class="sticker" src="<?=$sticker['path']?>" alt="<?=$sticker['id_sticker']?>">
    <?php endforeach;?>
</div>
<div class="prepics_div">prepics_div
    <?php foreach($prepics as $prepic):?>
    <img class="prepic" id="gallery<?=$prepic['id_gallery']?>" src="<?=$prepic['path']?>" alt="<?=$prepic['id_gallery']?>">
    <?php endforeach;?>
</div>
<div class="pic_div" id="process_final">
    <div id="camera">
        <video id="camera--view" autoplay playsinline></video>
        <canvas class="canvas" id="canvas_bg"></canvas>
    </div>
    <canvas class="canvas" id="canvas_stickers"></canvas>
</div>
<button class="btn" id="btn_merge">Say cheese</button>

<div id="final_preview">
</div>
<button class="btn" id="btn_post">POST</button>

<div id ="post_again">
    <p id="post_response"></p>
    <a href="Newpost/Upload">Upload a Picture</a>
    <a href="Newpost/Webcam">Take a Picture</a>
    <a href="Gallery">To Gallery</a>
</div>
<script type="text/javascript" src="/public/js/webcam.js"></script>
<script type="text/javascript" src="/public/js/js.js"></script>