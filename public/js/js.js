//add sticker on top of the img
var ii = document.getElementsByClassName("sticker");
for (var i = 0; i < ii.length; i++) {
	var a = 0;
    ii[i].addEventListener("click", function(){
        var ele = document.createElement("IMG");
        ele.setAttribute("src", this.src);
				ele.setAttribute("class", "added-sticker");
				ele.setAttribute("id", a++);
		document.getElementById("added-sticker-div").appendChild(ele);
    });
}

//double click to remove stickers
var nn = document.getElementsByClassName("added-sticker");
for (var n = 0; n < nn.length; n++) {
    nn[n].addEventListener("dblclick", function(){
       console.log(n);
    });
}

//move stickers
window.onload = function() {
	document.onmousedown = startDrag;
	document.onmouseup = stopDrag;
	document.ondblclick = remove_sticker; 
}
function remove_sticker(e){
	if (!e) {
		var e = window.event;
	}
	if(e.preventDefault) {
		e.preventDefault();
	}
	targ = e.target ? e.target : e.srcElement;
	if (targ.className != 'added-sticker') {
		return;
	}
	targ.remove();
}
function startDrag(e) {
	// determine event object
	if (!e) {
		var e = window.event;
	}
	if(e.preventDefault) {
		e.preventDefault();
	}
	// IE uses srcElement, others use target
	targ = e.target ? e.target : e.srcElement;
	if (targ.className != 'added-sticker') {
		return;
	}
	// calculate event X, Y coordinates
		offsetX = e.clientX;
		offsetY = e.clientY;
	// assign default values for top and left properties
	if(!targ.style.left) {
		targ.style.left='0px';
	}
	if (!targ.style.top) {
		targ.style.top='0px';
	}
	// calculate integer values for top and left 
	// properties
	coordX = parseInt(targ.style.left);
	coordY = parseInt(targ.style.top);
	drag = true;
	// move div element
	document.onmousemove = dragDiv;
	return false;
	
}

function dragDiv(e) {
	if (!drag) {
		return;
	}
	if (!e) {
		var e = window.event;
	}
	// move div element
	targ.style.left = coordX + e.clientX - offsetX + 'px';
	targ.style.top = coordY + e.clientY - offsetY + 'px';
	return false;
}

function stopDrag() {
	drag=false;
}