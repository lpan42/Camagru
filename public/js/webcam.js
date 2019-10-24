window.addEventListener('load', cameraStart);
const constraints = { video: { facingMode: "user" }, audio: false };
const cameraView = document.getElementById("camera--view"),
    canvas = document.getElementById("canvas_bg");
cameraTrigger = document.getElementById("btn_merge");

function cameraStart() {
    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
            track = stream.getTracks()[0];
            cameraView.width = canvas.offsetWidth;
            cameraView.height = canvas.offsetHeight;
            canvas.width = cameraView.width;
            canvas.height = cameraView.height;
            cameraView.srcObject = stream;
        })
        .catch(function(error) {
            console.error("Oops. Something is broken.", error);
        });
}
cameraTrigger.onclick = function() {
    // console.log(layers);
    if (layers.length !== 0) {
        canvas.getContext("2d").drawImage(cameraView, 0, 0, cameraView.width, cameraView.height);
        track.stop();
        cameraView.style.display = "none";
    }
};

//redo the pic
document.getElementById("btn_redo").addEventListener("click", function() {
    document.getElementById("process_final").style.display = "block";

    const constraints = { video: { facingMode: "user" }, audio: false };
    const cameraView = document.getElementById("camera--view"),
        canvas = document.getElementById("canvas_bg");
    cameraView.style.display = "inline";
    cameraTrigger = document.getElementById("btn_merge");
    cameraStart();

    document.getElementById("btn_merge").style.display = "inline";
    document.getElementById("final_preview").style.display = "none";
    document.getElementById("btn_post").style.display = "none";
    document.getElementById("btn_redo").style.display = "none";
    var element = document.getElementById("final_img");
    element.parentNode.removeChild(element);
});