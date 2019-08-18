
//add sticker on top of the img
var ii = document.getElementsByClassName("sticker");
for (var i = 0; i < ii.length; i++) {
    ii[i].addEventListener("click", function(){
        var ele = document.createElement("IMG");
        ele.setAttribute("src", this.src);
        ele.setAttribute("class", "added-sticker");
        document.getElementById("process_final").appendChild(ele); 
    });
}

//move stickers
var container = document.querySelector("#process_final");
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
	else {
		console.log("delete");
		activeItem.remove();
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