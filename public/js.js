

//add sticker on top of the img
var ii = document.getElementsByClassName("sticker");
for (var i = 0; i < ii.length; i++) {
    ii[i].addEventListener("click", function(){
        console.log(this.src);
        var ele = document.createElement("IMG");
        ele.setAttribute("src", this.src);
        ele.setAttribute("class", "added-sticker");
        document.getElementById("div1").appendChild(ele); 
    });
}

//show different div
$(function(){
  $('.toggleButton').click(function(){

        var target = $('#' + $(this).attr('data-target'));
        $('.toggleDiv').not(target).hide();
        target.show();
  });
});


//webcam
var ii = document.getElementsByClas
var constraints = { video: { facingMode: "user" }, audio: false };
    const cameraView = document.querySelector("#camera--view"),
        cameraOutput = document.querySelector("#camera--output"),
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
    cameraOutput.src = cameraSensor.toDataURL("public/gallery");
    cameraOutput.classList.add("taken");
    track.stop();
};
document.getElementById("take_picture").addEventListener("click", cameraStart);


//upload a file
function chooseFileToUpload() 
{
    $("#upload_pic").toggle("slow");
    return false;
}
document.getElementById("upload_picture").addEventListener("click", chooseFileToUpload);


//move stickers
var container = document.querySelector(".toggleDiv");
var activeItem = null;

var active = false;

container.addEventListener("touchstart", dragStart, false);
container.addEventListener("touchend", dragEnd, false);
container.addEventListener("touchmove", drag, false);

container.addEventListener("mousedown", dragStart, false);
container.addEventListener("mouseup", dragEnd, false);
container.addEventListener("mousemove", drag, false);

function dragStart(e) {

  if (e.target !== e.currentTarget) {
    active = true;

    // this is the item we are interacting with
    activeItem = e.target;

    if (activeItem !== null) {
      if (!activeItem.xOffset) {
        activeItem.xOffset = 0;
      }

      if (!activeItem.yOffset) {
        activeItem.yOffset = 0;
      }

      if (e.type === "touchstart") {
        activeItem.initialX = e.touches[0].clientX - activeItem.xOffset;
        activeItem.initialY = e.touches[0].clientY - activeItem.yOffset;
      } else {
        console.log("doing something!");
        activeItem.initialX = e.clientX - activeItem.xOffset;
        activeItem.initialY = e.clientY - activeItem.yOffset;
      }
    }
  }
}

function dragEnd(e) {
  if (activeItem !== null) {
    activeItem.initialX = activeItem.currentX;
    activeItem.initialY = activeItem.currentY;
  }

  active = false;
  activeItem = null;
}

function drag(e) {
  if (active) {
    if (e.type === "touchmove") {
      e.preventDefault();

      activeItem.currentX = e.touches[0].clientX - activeItem.initialX;
      activeItem.currentY = e.touches[0].clientY - activeItem.initialY;
    } else {
      activeItem.currentX = e.clientX - activeItem.initialX;
      activeItem.currentY = e.clientY - activeItem.initialY;
    }

    activeItem.xOffset = activeItem.currentX;
    activeItem.yOffset = activeItem.currentY;

    setTranslate(activeItem.currentX, activeItem.currentY, activeItem);
  }
}

function setTranslate(xPos, yPos, el) {
  el.style.transform = "translate3d(" + xPos + "px, " + yPos + "px, 0)";
}