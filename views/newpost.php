
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
    <button class="toggleButton" data-target="btn">Go back</button>
</div><br/>

<div class="pic_div" onload="enterNewPostPage()">pic_div
    <!-- button -->
    <div class="btn" id="btn">
        <button class="toggleButton" id="upload_picture" data-target="div1">Upload a Picture</button>
        <button class="toggleButton" id="take_picture" data-target="div2">Take a Picture</button>
    </div>
    
    <!-- choose file -->
    <form id="upload_pic" action="newpost" method="post" enctype="multipart/form-data" >
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload" name="submit">
    </form>

     <!-- show upload pic   -->
    <div class="toggleDiv" id="div1">
        <?php if($uploadedpic):?>
        <img id="uploadedpic" src="<?=$uploadedpic?>" alt="<?=$uploadedpic?>">
        <?php endif;?>
    </div>

    <!-- camera -->
    <div class="toggleDiv" id="div2">
        <video id="camera--view" autoplay playsinline></video>
        <canvas id="camera--sensor"></canvas>
        <button class="toggleButton" id="camera--trigger" data-target="div3">Say cheese</button>
    </div>

    <!-- show snap pic -->
    <div class="toggleDiv" id="div3">
        <img src="//:0" alt="" id="camera--output">
    </div>
</div>

<script src="/public/js.js"></script>