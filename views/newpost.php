
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

<div id="pic_div"></div>
<div id="camera"></div><br>
<button id="take_picture" class="btn">Take a Picture</button>
<button id="upload_picture" class="btn">Upload a Picture</button>
<script>
    $("#upload_picture").click(function() {  
        $("#upload_pic").toggle("slow");
        return false;
    });
</script>

<form id="upload_pic" action="newpost" method="post" enctype="multipart/form-data" >
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

