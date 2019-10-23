<!-- <div class="newpost_div">
    
<div class="process_div">
    <div class="stickers_div">
        <?php foreach($stickers as $sticker):?>
        <img class="sticker" src="<?=$sticker['path']?>" alt="<?=$sticker['id_sticker']?>">
        <?php endforeach;?>
    </div>
    <div class="pic_div">
        <div id="form_upload" style="margin-left:30%;">
            <form id="upload_pic" action="#" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload" />
            </form>
        </div>
        <div id="process_final">
            <canvas class="canvas" id="canvas_bg"></canvas>
            <canvas class="canvas" id="canvas_stickers"></canvas>
        </div>
        <div id="final_preview">
        </div>
        <div id ="post_again"> 
            <button class="btn" id="upload_picture"><a href="Newpost/Upload" style="color:white;">Upload a Picture</a></button>
            <button class="btn" id="take_picture"><a href="Newpost/Webcam" style="color:white;">Take a Picture</a></button>
            <button class="btn" id="to_gallery"> <a href="Gallery" style="color:white;">To Gallery</a></button>
        </div>
        <div class="buttons" style="margin-left:40%;">
            <button class="btn" id="btn_merge">MERGE</button>
            <button class="btn" id="btn_post">POST</button>
            <button class="btn" id="btn_redo">REDO</button>
        </div>
    </div>
</div>

<div class="prepics_div">
    <?php foreach($prepics as $prepic):?>
    <img class="prepic" id="gallery<?=$prepic['id_gallery']?>" src="<?=$prepic['path']?>" alt="<?=$prepic['id_gallery']?>">
    <?php endforeach;?>
</div>

</div>
 -->

<style>
.wrapper {
  display: flex;  
  flex-flow: row wrap;
  text-align: center;
}

.wrapper > * {
    padding: 10px;
    flex: 1 100%;
}

.main {
  text-align: center;
  height:60vh;
}
@media all and (min-width: 600px) {
  .aside { flex: 1 0 0; }
}

@media all and (min-width: 800px) {
  .main    { flex: 3 0px; }
  .aside-1 { order: 1; } 
  .main    { order: 2; }
  .aside-2 { order: 3; }
  .footer  { order: 4; }
}

.aside-1{
    height: 60vh;
    overflow: scroll;
}

.aside-2{
    height:60vh;
    overflow: scroll;
}

.sticker{
    width:100px;
}

.prepic{
    width:100px;
}

#process_final{
    width: 100%;
    height: 100%;
    display: block;
}

#canvas_bg {
    width:500px;
    height: 500px;
    border: solid black 1px;
    position: absolute;
}

#canvas_stickers {
    width:500px;
    height: 500px;
    position: relative;
}

#btn_post {
    display: none;
}

#btn_redo {
    display: none;
}

#final_preview {
    width:500px;
    height: 500px;
    display: none;
}

#post_again {
    display: none;
}
</style>


<div class="wrapper">
  <!-- <header class="header">Header</header> -->
  <div class="main">
    <!-- <div class="pic_div"> -->
        <div class="buttons">
            <button class="btn" id="btn_merge">MERGE</button>
            <button class="btn" id="btn_post">POST</button>
            <button class="btn" id="btn_redo">REDO</button>
        </div>
        <div id="form_upload">
            <form id="upload_pic" action="#" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload" />
            </form>
        </div>
        <div id="process_final">
            <canvas class="canvas" id="canvas_bg"></canvas>
            <canvas class="canvas" id="canvas_stickers"></canvas>
        </div>
        <div id="final_preview">
        </div>
        <div id ="post_again">
            <button class="btn" id="upload_picture"><a href="Newpost/Upload" style="color:white;">Upload a Picture</a></button>
            <button class="btn" id="take_picture"><a href="Newpost/Webcam" style="color:white;">Take a Picture</a></button>
            <button class="btn" id="to_gallery"> <a href="Gallery" style="color:white;">To Gallery</a></button>
        </div>
   
    <!-- </div> -->
</div>
  <aside class="aside aside-1">
      <div class="overflow">
        <?php foreach($stickers as $sticker):?>
        <img class="sticker" src="<?=$sticker['path']?>" alt="<?=$sticker['id_sticker']?>">
        <?php endforeach;?>
    </div>
  </aside>
  <aside class="aside aside-2">
    <div class="overflow">
        <?php foreach($prepics as $prepic):?>
        <img class="prepic" id="gallery<?=$prepic['id_gallery']?>" src="<?=$prepic['path']?>" alt="<?=$prepic['id_gallery']?>">
        <?php endforeach;?>
    </div>
  </aside>
  <!-- <footer class="footer">Footer</footer> -->
</div>

<script type="text/javascript" src="/public/js/upload.js"></script>
<script type="text/javascript" src="/public/js/js.js"></script>