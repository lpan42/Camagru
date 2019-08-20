
$(document).ready(function(){
//upload pic and preview
	$("#fileToUpload").change(function(e){
	e.preventDefault();
	var fd = new FormData();
	var files = $('#fileToUpload')[0].files[0];
	fd.append('fileToUpload',files);
	fetch('Upload/upload_pic', {
		method: 'POST',
		body: fd,
	}).then((response) => response.text()).then((text) => {
		var img = document.createElement("IMG");
		img.setAttribute("src", text);
		img.setAttribute("id", "uploaded-pic");
		const div = document.getElementById("uploaded");
		$("#uploaded").empty();
		div.appendChild(img);
		});
	});
	});

	//add sticker on top of the img
	var ii = document.getElementsByClassName("sticker");
	for (var i = 0; i < ii.length; i++) {
	ii[i].addEventListener("click", function(){
		var ele = document.createElement("IMG");
		ele.setAttribute("src", this.src);
		ele.setAttribute("class", "added-sticker");
		document.getElementById("uploaded").appendChild(ele); 
	});
	}

	//webcam
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
	// create output IMG
	var src = cameraSensor.toDataURL("public/temp");
	var ele = document.createElement("IMG");
		ele.setAttribute("src", src);
		ele.setAttribute("class", "snap-pic");
		document.getElementById("final_pic").appendChild(ele); 
	track.stop();
	};
	document.getElementById("take_picture").addEventListener("click", cameraStart);

	//move stickers
	var container = document.querySelector("#final_pic");
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
		} 
		// else {
		// 	console.log("delete");
		// 	activeItem.remove();
		// }
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