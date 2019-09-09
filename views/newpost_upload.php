
<div class="stickers_div">
    <?php foreach($stickers as $sticker):?>
    <img class="sticker" src="<?=$sticker['path']?>" alt="<?=$sticker['id_sticker']?>">
    <?php endforeach;?>
</div>
<div class="prepics_div">
    <?php foreach($prepics as $prepic):?>
    <img class="prepic" id="gallery<?=$prepic['id_gallery']?>" src="<?=$prepic['path']?>" alt="<?=$prepic['id_gallery']?>">
    <?php endforeach;?>
</div>
<div id="form_upload">
    <form id="upload_pic" action="#" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload" />
        <!-- <input type="button" class="toggleButton" value="Upload" id="btn_upload" data-target="final_pic"> -->
    </form>
</div>

<div class="pic_div" id="process_final">
    <canvas class="canvas" id="canvas_bg"></canvas>
    <canvas class="canvas" id="canvas_stickers"></canvas>
</div>
<button class="btn" id="btn_merge">MERGE</button>

<div id="final_preview">
</div>
<button class="btn" id="btn_post">POST</button>

<div id ="post_again">
    <p id="post_response"></p>
    <a class="btn" id="upload_picture" href="Newpost/Upload">Upload a Picture</a>
    <a class="btn" id="take_picture" href="Newpost/Webcam">Take a Picture</a>
    <a class="btn" id="to_gallery" href="Gallery">To Gallery</a>
</div>

<script type="text/javascript" src="/public/js/upload.js"></script>
<script type="text/javascript" src="/public/js/js.js"></script>