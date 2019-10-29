<div class="wrapper">
  <div class="main">
        <div class="buttons">
            <button class="btn" id="btn_merge">Say cheese</button>
            <button class="btn" id="btn_post">POST</button>
            <button class="btn" id="btn_redo">REDO</button>
        </div>
         <div class="pic_div">
            <div id="process_final">
                <video id="camera--view" autoplay playsinline></video>
                <canvas class="canvas" id="canvas_bg"></canvas>
                <canvas class="canvas" id="canvas_stickers"></canvas> 
            </div>
            <div id="final_preview">
            </div>
            <div id ="post_again">
                <button class="btn" id="upload_picture"><a href="Newpost/Upload">Upload a Picture</a></button>
                <button class="btn" id="take_picture"><a href="Newpost/Webcam">Take a Picture</a></button>
                <button class="btn" id="to_gallery"> <a href="Gallery">To Gallery</a></button>
            </div>
        </div>
</div>
  <aside class="aside aside-1">
    <?php foreach($stickers as $sticker):?>
        <img class="sticker" src="<?=$sticker['path']?>" alt="<?=$sticker['id_sticker']?>">
    <?php endforeach;?>
  </aside>
  <aside class="aside aside-2">
    <?php if($prepics):?>
      <?php foreach($prepics as $prepic):?>
        <img class="prepic" id="gallery<?=$prepic['id_gallery']?>" src="<?=$prepic['path']?>" alt="<?=$prepic['id_gallery']?>">
      <?php endforeach;?>
      <?php else:?>
        <p> You don't have any posted picture.</p>
    <?php endif;?>
  </aside>
</div>

<script type="text/javascript" src="/public/js/webcam.js"></script>
<script type="text/javascript" src="/public/js/js.js"></script>