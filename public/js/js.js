// add move and remove stickers
const canvas_s = document.getElementById("canvas_stickers");
const { offsetHeight, offsetWidth } = canvas_s;
canvas_s.width = offsetWidth;
canvas_s.height = offsetHeight;
const context_s = canvas_s.getContext('2d');
let layers = [];
let selected = null;
const ii = document.getElementsByClassName("sticker");
for (let i = 0; i < ii.length; i++) {
    ii[i].addEventListener('click', function() {
        add_layer(this.src, { x: 0, y: 0 }, { w: 100, h: 100 });
    });
}

function render() {
    context_s.clearRect(0, 0, canvas_s.width, canvas_s.height);
    layers.forEach((layer) => {
        const { img, pos: { x, y }, size: { w, h } } = layer;
        context_s.drawImage(img, x, y, w, h);
        if (layer === selected) {
            context_s.fillStyle = 'grey';
            context_s.strokeRect(x, y, w, h);
            context_s.fillRect(x - 4, y - 4, 8, 8);
            context_s.fillRect(x + w - 4, y - 4, 8, 8);
            context_s.fillRect(x + w - 4, y + h - 4, 8, 8);
            context_s.fillRect(x - 4, y + h - 4, 8, 8);
        }
    })
    window.requestAnimationFrame(render);
}

function drawDragAnchor(x, y) {
    context_s.beginPath();
    context_s.arc(x, y, 8, 0, Math.PI * 2, false);
    context_s.closePath();
    context_s.fill();
}

function add_layer(url, pos, size) {
    const { x, y } = pos;
    const { w, h } = size;
    const img = new Image();
    img.src = url;
    img.onload = function() {
        layers.push({ url, pos, size, img, dragging: false });
    }
}
render();
canvas_s.addEventListener('mousedown', function({ clientX, clientY }) {
    const rect = canvas_s.getBoundingClientRect();
    const px = clientX - rect.left;
    const py = clientY - rect.top;
    const layer = [...layers].reverse().find(({ pos: { x, y }, size: { w, h } }) => px > x && px < x + w && py > y && py < y + h);
    if (layer) {
        canvas_s.style.cursor = "grab";
        layer.dragging = { x: px - layer.pos.x, y: py - layer.pos.y };
        selected = layer;
    } else {
        canvas_s.style.cursor = "default";
        selected = null;
    }

})

canvas_s.addEventListener('mousemove', function({ clientX, clientY }) {
    const rect = canvas_s.getBoundingClientRect();
    const px = clientX - rect.left;
    const py = clientY - rect.top;
    const layer = layers.find(({ dragging }) => dragging !== false);
    if (layer) {
        layer.pos.x = px - layer.dragging.x;
        layer.pos.y = py - layer.dragging.y;
    }
});

canvas_s.addEventListener('mouseup', function({}) {
    const layer = layers.find(({ dragging }) => dragging !== false);
    if (!layer) {
        return;
    }
    layer.dragging = false;
});

canvas_s.addEventListener('dblclick', function({ clientX, clientY }) {
    const rect = canvas_s.getBoundingClientRect();
    const px = clientX - rect.left;
    const py = clientY - rect.top;
    const layer = [...layers].find(({ pos: { x, y }, size: { w, h } }) => px > x && px < x + w && py > y && py < y + h);
    var i = layers.indexOf(layer);
    if (layer) {
        layers.splice(i, 1);
        selected = layer;
    } else {
        selected = null;
    }

});


// window.addEventListener("resize", () => {
//     console.log("CALL");
//     const { offsetHeight, offsetWidth } = canvas_s;
//     canvas_s.width = offsetWidth;
//     canvas_s.height = offsetHeight;
// });

//check sticker when press post btn and merge img
document.getElementById("btn_merge").addEventListener("click", function() {
    const canvas = document.getElementById("canvas_bg");
    if (layers.length === 0) {
        alert("A sticker is a must-have");
    } else {
        var bg = {
            "url": canvas.toDataURL('image/png'),
            "w": canvas.width,
            "h": canvas.height
        };
        let data = { bg, layers };
        data = JSON.stringify(data);
        fetch('Newpost/merge_pic', {
                method: 'POST',
                body: data,
            })
            .then((response) => response.text()).then((text) => {
                const img = document.createElement("IMG");
                img.id = "final_img";
                img.src = text;
                const div = document.getElementById("final_preview");
                div.appendChild(img);
                document.getElementById("process_final").style.display = "none";
                document.getElementById("btn_merge").style.display = "none";
                if (document.getElementById("form_upload")) {
                    document.getElementById("form_upload").style.display = "none";
                }
                document.getElementById("final_preview").style.display = "block";
                document.getElementById("btn_post").style.display = "block";
                document.getElementById("btn_redo").style.display = "block";
            });
    }
});

//post image to Gallery
document.getElementById("btn_post").addEventListener("click", function() {
    const final_img = document.getElementById("final_img");
    let data = final_img.src;
    data = JSON.stringify(data);
    data = data.replace(window.location.origin + "/", '');
    // console.log(data);
    fetch('Newpost/post_pic', {
            method: 'POST',
            body: data,
        })
        .then((response) => response.text()).then((text) => {
            var para = document.createElement("P");
            para.id = "post_response";
            para.innerHTML = text;
            var div = document.getElementById("post_again");
            div.prepend(para);
            div.style.display = "block";
            document.getElementById("final_preview").style.display = "none";
            document.getElementById("btn_post").style.display = "none";
            document.getElementById("btn_redo").style.display = "none";
        });
});
//redo the pic
document.getElementById("btn_redo").addEventListener("click", function() {
    document.getElementById("process_final").style.display = "block";
    document.getElementById("btn_merge").style.display = "block";
    document.getElementById("final_preview").style.display = "none";
    document.getElementById("btn_post").style.display = "none";
    document.getElementById("btn_redo").style.display = "none";
    var element = document.getElementById("final_img");
    element.parentNode.removeChild(element);
});