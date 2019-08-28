//webcam
window.addEventListener('load', cameraStart);
const constraints = { video: { facingMode: "user" }, audio: false };
const cameraView = document.querySelector("#camera--view"),
    canvas = document.querySelector("#canvas_bg");
cameraTrigger = document.querySelector("#btn-merge");
// cameraSensor.height = canvas_s.offsetHeight;
// cameraSensor.width = canvas_s.offsetWidth;

function cameraStart() {
    navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
            track = stream.getTracks()[0];
            cameraView.width = canvas_s.offsetWidth;
            cameraView.height = canvas_s.offsetHeight;
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