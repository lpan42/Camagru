//webcam
window.addEventListener('load',cameraStart);
var constraints = { video: { facingMode: "user" }, audio: false };
const cameraView = document.querySelector("#camera--view"),
    // cameraOutput = document.querySelector("#output"),
    cameraSensor = document.querySelector("#camera--sensor"),
    cameraTrigger = document.querySelector("#camera--trigger")
function cameraStart()
{
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
cameraTrigger.onclick = function() 
{
    cameraSensor.width = cameraView.videoWidth;
    cameraSensor.height = cameraView.videoHeight;
    cameraSensor.getContext("2d").drawImage(cameraView, 0, 0, cameraSensor.width, cameraSensor.height);
    track.stop();
    // create output IMG
    var src = cameraSensor.toDataURL();
    var ele = document.createElement("IMG");
        ele.setAttribute("src", src);
        ele.setAttribute("class", "snap-pic");
        document.getElementById("process_final").appendChild(ele); 
    
    document.getElementById("camera").style.display = "none";
};
// document.getElementById("btn-webcam").addEventListener("click", cameraStart);
