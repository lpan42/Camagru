document.getElementById("fileToUpload").addEventListener("change", function(e) {
    e.preventDefault();
    const fd = new FormData();
    const files = document.getElementById("fileToUpload").files[0];
    fd.append('fileToUpload', files);
    fetch('Newpost/Upload/upload_pic', {
            method: 'POST',
            body: fd,
        })
        .then((response) => response.text()).then((text) => {
            // console.log(text);
            if (text == -1) {
                alert("Only jpg, jpeg, png, gif file are allowed");
            } else if (text == 0) {
                alert("File is too big");
            } else {
                const canvas = document.getElementById("canvas_bg");
                const { offsetHeight, offsetWidth } = canvas;
                const context = canvas.getContext("2d");
                context.canvas.width = offsetWidth;
                context.canvas.height = offsetHeight;
                const img = new Image();
                img.src = text;
                img.onload = function() {
                    context.drawImage(this, 0, 0, offsetWidth, offsetHeight);
                }
            }
        });
})

//redo the pic
document.getElementById("btn_redo").addEventListener("click", function() {
    document.getElementById("process_final").style.display = "block";
    document.getElementById("form_upload").style.display = "block";
    document.getElementById("btn_merge").style.display = "inline";
    document.getElementById("final_preview").style.display = "none";
    document.getElementById("btn_post").style.display = "none";
    document.getElementById("btn_redo").style.display = "none";
    var element = document.getElementById("final_img");
    element.parentNode.removeChild(element);
});