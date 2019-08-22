$("#fileToUpload").change(function(e) {
    e.preventDefault();
    var check = document.getElementById("canvas");
    // if (check) {
    //     check.remove();
    // }
    var fd = new FormData();
    var files = $('#fileToUpload')[0].files[0];
    fd.append('fileToUpload', files);
    fetch('Newpost/Upload/upload_pic', {
            method: 'POST',
            body: fd,
        })
        .then((response) => response.text()).then((text) => {
            const canvas = document.getElementById("canvas");

            const { offsetHeight, offsetWidth } = canvas;

            console.log(canvas, offsetWidth, offsetHeight);
            const context = canvas.getContext("2d");
            context.canvas.width = offsetWidth;
            context.canvas.height = offsetHeight;
            const img = new Image();
            img.src = text;
            img.onload = function() {
                console.log(canvas, offsetWidth, offsetHeight, this);
                context.drawImage(this, 0, 0, offsetWidth, offsetHeight);
            }
        });
})