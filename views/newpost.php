
<div class="stickers_div">stickers_div
    <?php foreach($stickers as $sticker):?>
    <img class="sticker" src="<?=$sticker['path']?>" alt="<?=$sticker['id_sticker']?>" onclick="console.log(document.querySelector('img').src)">
    <?php endforeach;?>
</div>
<div class="prepics_div">prepics_div
    <?php foreach($prepics as $prepic):?>
    <img class="prepic" src="<?=$prepic['path']?>" alt="<?=$prepic['id_gallery']?>">
    <?php endforeach;?>
</div>

<div id="pic_div">
    <button id="take_picture" class="btn">Take a Picture</button>
    <button id="upload_picture" class="btn">Upload a Picture</button>

    <form id="upload_pic" action="newpost" method="post" enctype="multipart/form-data" >
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload" name="submit">
    </form>
    <div id="upload">
        <?php if($uploadedpic):?>
        <img id="uploadedpic" src="<?=$uploadedpic?>" alt="<?=$uploadedpic?>">
        <?php endif;?>
    </div>
    <div id="camera">
        <!-- draw a snapshot of the webcam video on a webpage -->
        <canvas id="camera--sensor"></canvas>
        <!-- embed a video in a webpage. -->
        <video id="camera--view" autoplay playsinline></video>
        <img src="//:0" alt="" id="camera--output">
        <button id="camera--trigger">Say cheese</button>
    </div>
</div>

<script>
    var constraints = { video: { facingMode: "user" }, audio: false };
    const cameraView = document.querySelector("#camera--view"),
        cameraOutput = document.querySelector("#camera--output"),
        cameraSensor = document.querySelector("#camera--sensor"),
        cameraTrigger = document.querySelector("#camera--trigger")
    function cameraStart() {
        $("#camera").show();
        $("#upload").hide();
        navigator.mediaDevices
            .getUserMedia(constraints)
            .then(function(stream) {
            track = stream.getTracks()[0];
            cameraView.srcObject = stream;
        })
        .catch(function(error) {
            console.error("Oops. Something is broken.", error);
        });
    }
    cameraTrigger.onclick = function() {
        cameraSensor.width = cameraView.videoWidth;
        cameraSensor.height = cameraView.videoHeight;
        cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);
        cameraOutput.src = cameraSensor.toDataURL("public/gallery");
        cameraOutput.classList.add("taken");
    };
    document.getElementById("take_picture").addEventListener("click", cameraStart);

    function chooseFileToUpload() {
        $("#camera").hide();
        $("#upload").show();
        $("#upload_pic").toggle("slow");
        return false;
    }
    document.getElementById("upload_picture").addEventListener("click", chooseFileToUpload);
</script>
