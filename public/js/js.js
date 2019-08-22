//check sticker when press post btn and merge img
document.getElementById("btn-merge").addEventListener("click", function() {
    var isEmptySticker = document.getElementById('added-sticker-div').innerHTML;
    var isEmptyBackground = document.getElementById('canvas');
    if (isEmptySticker === "") {
        alert("A sticker is a must-have");
    } else if (!isEmptyBackground) {
        alert("need to upload a local picture or take a picture");
    } else {
        var stickers = document.getElementById("process-final").getElementsByTagName("IMG");
        var background = document.getElementById("canvas");
        console.log(stickers);
        var data = { dst: [], src: [] };
        data.dst.push({
            "path": background.src,
            "x": 0,
            "y": 0,
            "w": background.clientWidth,
            "h": background.clientWidth
        });
        for (var i = 0; i < stickers.length; i++) {
            var sticker = stickers[i];
            data.src.push({
                "path": sticker.src,
                "x": sticker.offsetLeft,
                "y": sticker.offsetTop,
                "w": sticker.clientWidth,
                "h": sticker.clientHeight,
            })
        }
    }
    data = JSON.stringify(data);
    console.log(data);
    fetch('Newpost/merge_pic', {
            method: 'POST',
            body: data,
        })
        .then((response) => response.text()).then((text) => {
            var debug = document.createElement("P");
            debug.innerHTML = text;
            // var img = document.createElement("IMG");
            // img.setAttribute("src", text);
            // img.setAttribute("id", "final-pic");
            const div = document.getElementById("final-preview");
            div.appendChild(debug);
            document.getElementById("process-final").style.display = "none";
            document.getElementById("final-preview").style.display = "block";
        });
});

//add sticker on top of the img
var ii = document.getElementsByClassName("sticker");
for (var i = 0; i < ii.length; i++) {
    var a = 0;
    ii[i].addEventListener("click", function() {
        var ele = document.createElement("IMG");
        ele.setAttribute("src", this.src);
        ele.setAttribute("class", "added-sticker");
        ele.setAttribute("id", a++);
        document.getElementById("added-sticker-div").appendChild(ele);
    });
}

//move stickers
window.onload = function() {
    document.onmousedown = startDrag;
    document.onmouseup = stopDrag;
    document.ondblclick = remove_sticker;
}

function remove_sticker(e) {
    if (!e) {
        var e = window.event;
    }
    if (e.preventDefault) {
        e.preventDefault();
    }
    targ = e.target ? e.target : e.srcElement;
    if (targ.className != 'added-sticker') {
        return;
    }
    targ.remove();
}

function startDrag(e) {
    // console.log(document.getElementById("0").offsetTop);
    // console.log(document.getElementById("0").offsetLeft);
    // determine event object
    if (!e) {
        var e = window.event;
    }
    if (e.preventDefault) {
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
    if (!targ.style.left) {
        targ.style.left = '0px';
    }
    if (!targ.style.top) {
        targ.style.top = '0px';
    }
    // calculate integer values for top and left properties
    coordX = parseInt(targ.style.left);
    coordY = parseInt(targ.style.top);
    drag = true;
    // move div element
    document.onmousemove = dragEle;
    return false;

}

function dragEle(e) {
    if (!drag) {
        return;
    }
    if (!e) {
        var e = window.event;
    }
    // move element
    targ.style.left = coordX + e.clientX - offsetX + 'px';
    targ.style.top = coordY + e.clientY - offsetY + 'px';
    return false;
}

function stopDrag() {
    drag = false;
}


// const canvas = document.getElementById("canvas");

// canvas.height = 600;
// canvas.height = 700;
// const context = canvas.getContext('2d');
// let layers = [];
// let selected = null;


// document.getElementById('btn').addEventListener('click', () => {
// 	console.log("CLIC");
//   add_layer('http://localhost:8081/public/stickers/sticker4.png', {x:0, y:0}, {w:50, h:50});
//   add_layer('http://localhost:8081/public/stickers/sticker3.png', {x:100, y:10}, {w:50, h:50});
// })

// canvas.addEventListener('mousedown', ({ clientX, clientY }) => {
// 		const rect = canvas.getBoundingClientRect()
//     const px = clientX - rect.left
//     const py = clientY - rect.top
// 	  const layer = [...layers].reverse().find(({ pos: { x, y }, size: { w, h } }) => px > x && px < x + w && py > y && py < y + h);
// 	 	if (layer)
//     {
//     	layer.dragging = { x: px - layer.pos.x, y: py - layer.pos.y };
//     	selected = layer;
//     }
//     else
//     	selected = null;
// })

// canvas.addEventListener('mousemove', ({ clientX, clientY }) => {
// 	const rect = canvas.getBoundingClientRect()
//     const px = clientX - rect.left
//     const py = clientY - rect.top
// 	const layer = layers.find(({ dragging }) => dragging !== false);
//   if (layer)
//   {
//   	layer.pos.x = px - layer.dragging.x;
//    	layer.pos.y = py - layer.dragging.y;
//   }
// });

// canvas.addEventListener('mouseup', ({ clientX, clientY }) => {
// 	//	selected = null;
// 		const layer  =layers.find(({ dragging }) => dragging !== false);
//     if (!layer)
//     {

//     	return;
//     }
//     layer.dragging = false;
// });

// document.getElementById('upload').addEventListener('click', () => {
// 	console.log(layers);
// })

// function render()
// {
// 	context.clearRect(0, 0, canvas.width, canvas.height);
//   layers.forEach((layer, i) => {
//   	const { img, pos: { x, y}, size: { w, h } } = layer;
//     context.drawImage(img, x, y, w, h);
//     if (layer === selected)
//     {
//     	context.strokeRect(x, y, w, h);
//       context.fillRect(x - 2, y - 2, 4, 4);
//       context.fillRect(x + w - 2, y - 2, 4, 4);
//       context.fillRect(x + w - 2, y + h - 2, 4, 4);
//       context.fillRect(x - 2, y + h - 2, 4, 4);
//     }
//   })
// 	window.requestAnimationFrame(render);
// }

// function add_layer(url, pos, size)
// {
// 	const { x, y } = pos;
// 	const { w, h } = size;
//   const img = new Image();
//   img.src = url;
//   img.onload = function() {
//     //context.drawImage(this, x, y, w, h);
//      layers.push({ url, pos, size, img, dragging: false });
//   }

// }
// render();