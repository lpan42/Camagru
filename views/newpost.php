
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

<div class="btn">btn_div
        <button id="take_picture">Take a Picture</button>
        <button id="upload_picture">Upload a Picture</button>
</div><br/>
<div class="pic_div">pic_div
    <button id="go_back">Go back</button>
    <div id="new-post">
        <?php if($uploadedpic):?>
        <img id="uploadedpic" src="<?=$uploadedpic?>" alt="<?=$uploadedpic?>">
        <?php endif;?>
    </div>
    <form id="upload_pic" action="newpost" method="post" enctype="multipart/form-data" >
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload" name="submit">
    </form>

    
    <div id="camera">
        <!-- draw a snapshot of the webcam video on a webpage -->
        <canvas id="camera--sensor"></canvas>
        <!-- embed a video in a webpage. -->
        <video id="camera--view" autoplay playsinline></video>
        <img src="//:0" alt="" id="camera--output">
        <button id="camera--trigger">Say cheese</button>
    </div>
</div>

<script src="/public/js.js"></script>