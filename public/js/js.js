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
    let { w, h } = size;
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
        if (px > layer.pos.x + layer.size.w - 8 && px < layer.pos.x + layer.size.w + 8 && py > layer.pos.y + layer.size.h - 8 && py < layer.pos.y + layer.size.h + 8) {
            canvas_s.style.cursor = "nwse-resize";
            layer.resizing = true;
        } else
            layer.resizing = false;
    } else {
        canvas_s.style.cursor = "default";
        selected = null;

    }

})

canvas_s.addEventListener('mousemove', function(event) {
    const { clientX, clientY } = event;
    const rect = canvas_s.getBoundingClientRect();
    const px = clientX - rect.left;
    const py = clientY - rect.top;
    const layer = layers.find(({ dragging }) => dragging !== false);
    if (layer) {
        if (layer.resizing) {
            // console.log(px, py);
            // console.log(layer.pos.x, layer.pos.y);
            // console.log(px - layer.pos.x, py - layer.pos.y);
            if (layer.size.w >= 20 && layer.size.h >= 20) {
                layer.size.w += event.movementX;
                layer.size.h += event.movementY;
            } else {
                layer.size.w = 20;
                layer.size.h = 20;
            }
        } else {
            layer.pos.x = px - layer.dragging.x;
            layer.pos.y = py - layer.dragging.y;
        }
    }

    const selected_layer = layers.find((l) => l === selected);
    if (selected_layer) {
        canvas_s.style.cursor = "grab";
        if (px > selected_layer.pos.x + selected_layer.size.w - 8 && px < selected_layer.pos.x + selected_layer.size.w + 8 && py > selected_layer.pos.y + selected_layer.size.h - 8 && py < selected_layer.pos.y + selected_layer.size.h + 8) {
            canvas_s.style.cursor = "nwse-resize";
        }
    } else {
        canvas_s.style.cursor = "default";
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

//check sticker when press post btn and merge img
document.getElementById("btn_merge").addEventListener("click", function() {
    const canvas = document.getElementById("canvas_bg");
    if (layers.length === 0) {
        alert("A sticker is a must-have");
    } else {
        if (canvas.width !== canvas.offsetWidth || canvas.height !== canvas.offsetHeight) {
            const { offsetHeight, offsetWidth } = canvas;
            canvas.width = offsetWidth;
            canvas.height = offsetHeight;
        }
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
                document.getElementById("btn_post").style.display = "inline";
                document.getElementById("btn_redo").style.display = "inline";
            });
    }
});

//post image to Gallery
document.getElementById("btn_post").addEventListener("click", function() {
    const final_img = document.getElementById("final_img");
    let data = final_img.src;
    data = data.replace(window.location.origin + "/", '');
    fetch('Newpost/post_pic', {
            method: 'POST',
            body: data,
        })
        .then((response) => response.text()).then((text) => {
            text = JSON.parse(text);
            const para = document.createElement("P");
            para.id = "post_response";
            if (text == 0) {
                para.innerHTML = "Sorry fail to post, try again?";
            } else {
                para.innerHTML = "You picture has been posted, want to post aother one?";
            }
            const div = document.getElementById("post_again");
            div.prepend(para);
            div.style.display = "block";
            document.getElementById("final_preview").style.display = "none";
            document.getElementById("btn_post").style.display = "none";
            document.getElementById("btn_redo").style.display = "none";

            const pre_pic = document.getElementsByClassName("aside aside-2")[0];
            if (document.getElementsByClassName("prepic")[0]) {
                const img = document.createElement("IMG");
                img.className = "prepic";
                img.id = "gallery" + text;
                img.src = data;
                img.alt = text;
                pre_pic.insertBefore(img, pre_pic.childNodes[0]);
            } else {
                document.getElementsByTagName("P")[1].style.display = "none";
                const img = document.createElement("IMG");
                img.className = "prepic";
                img.id = "gallery" + text;
                img.src = data;
                img.alt = text;
                pre_pic.insertBefore(img, pre_pic.childNodes[0]);
            }

        });
});;