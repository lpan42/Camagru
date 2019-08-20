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
<div id="form_upload">
    <form id="upload_pic" action="#" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload" />
        <!-- <input type="button" class="toggleButton" value="Upload" id="btn_upload" data-target="final_pic"> -->
    </form>
</div>

<div class="pic_div" id="process-final">
    <div id="added-sticker-div"></div>
    <button class="btn" id="btn-post">POST</button>
</div>

<script type="text/javascript" src="/public/js/upload.js"></script>
<script type="text/javascript" src="/public/js/js.js"></script>