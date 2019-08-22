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
<div class="pic_div" id="process_final">
    <!-- camera -->
    <div class="toggleDiv" id="camera">
        <video id="camera--view" autoplay playsinline></video>
        <canvas id="camera--sensor"></canvas>
        <button class="btn" id="camera--trigger">Say cheese</button>
        <div id="added-sticker-div"></div>
    </div>
</div>
<div id="final-preview">
</div>
<button class="btn" id="btn-post">POST</button>
<script type="text/javascript" src="/public/js/webcam.js"></script>
<script type="text/javascript" src="/public/js/js.js"></script>