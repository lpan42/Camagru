<!-- <script>window.onload = function(){
    $('#btn').show();
    $('.toggleDiv').hide();
};
</script> -->

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
<div class="pic_div">pic_div
    <!-- button -->
    <div class="btn" id="btn">
        <button class="toggleButton" id="upload_picture" data-target="upload_pic">Upload a Picture</button>
        <button class="toggleButton" id="take_picture" data-target="div2">Take a Picture</button>
    </div>
    <div class="process_post">process_post
        <!-- choose file -->
       <input type="file" name="fileToUpload" id="fileToUpload">
        <!-- camera -->
        <div class="toggleDiv" id="div2">div2
            <video id="camera--view" autoplay playsinline></video>
            <canvas id="camera--sensor"></canvas>
            <button class="toggleButton" id="camera--trigger" data-target="final_pic">Say cheese</button>
        </div>

        <!-- show pic   -->
        <div class="toggleDiv" id="final_pic">final_pic
            <button class="btn" id="btn-post">POST</button>
            <?php if($uploadedpic):?>
                <img id="uploadedpic" src="<?=$uploadedpic?>" alt="<?=$uploadedpic?>">
            <?php endif;?>
          
        </div>
    </div>
</div>

<script type="text/javascript" src="/public/js.js"></script>