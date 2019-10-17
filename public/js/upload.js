$("#fileToUpload").change(function(e) {
    e.preventDefault();
    const fd = new FormData();
    const files = $('#fileToUpload')[0].files[0];
    fd.append('fileToUpload', files);
    fetch('Newpost/Upload/upload_pic', {
            method: 'POST',
            body: fd,
        })
        .then((response) => response.text()).then((text) => {
            console.log(text);
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