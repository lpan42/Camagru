$("#fileToUpload").change(function(e){
    e.preventDefault();
    $("#uploaded-pic").empty();
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
        const div = document.getElementById("process-final");
        div.appendChild(img);
        console.log(document.getElementById("uploaded-pic").offsetTop);
    	console.log(document.getElementById("uploaded-pic").offsetLeft);
    });
});

// //show post btn
// var isEmpty = document.getElementById('added-sticker-div').innerHTML;
// if(isEmpty === ""){
//     document.getElementById("btn-post").style.display = "none";
// }else{
//     document.getElementById("btn-post").style.display = "block";
// }