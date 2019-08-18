
<div class="stickers_div">stickers_div
    <?php foreach($stickers as $sticker):?>
    <img class="sticker" src="<?=$sticker['path']?>" alt="<?=$sticker['id_sticker']?>">
    <?php endforeach;?>
</div>
<div class="prepics_div">prepics_div
    <?php foreach($prepics as $prepic):?>
    <img class="prepic" src="<?=$prepic['path']?>" alt="<?=$prepic['id_gallery']?>">
    <?php endforeach;?>
</div>
<!-- <button class="toggleButton" data-target="btn">Go back</button> -->
<div class="pic_div">
    <!-- button -->
    <div class="btn" id="btn">
        <button class="toggleButton" id="upload_picture" data-target="uploaded">Upload a Picture</button>
        <button class="toggleButton" id="take_picture" data-target="camera">Take a Picture</button>
    </div>
    <!-- choose file -->
    <div id="form_upload">
        <form id="upload_pic" action="#" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" />
            <!-- <input type="button" class="toggleButton" value="Upload" id="btn_upload" data-target="final_pic"> -->
        </form>
    </div>
    <div class="process_post" id="div2">
        <div class="toggleDiv" id="uploaded"></div>
        <!-- camera -->
        <div class="toggleDiv" id="camera">
            <video id="camera--view" autoplay playsinline></video>
            <canvas id="camera--sensor"></canvas>
            <button class="toggleButton" id="camera--trigger" data-target="final_pic">Say cheese</button>
        </div>
    </div>

    <!-- show pic   -->
    <div id="final_pic">
        <button class="btn" id="btn-post">POST</button>
    </div>
</div>

<script type="text/javascript" src="/public/js.js"></script>