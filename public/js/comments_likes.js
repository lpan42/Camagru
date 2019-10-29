if ($check = document.getElementById("submit_comment")) {
    $check.addEventListener("click", function(e) {
        e.preventDefault();
        const comment = document.getElementById("new_comment").value;
        if (!comment) {
            alert("say sth");
        } else {
            const id_gallery = document.getElementsByClassName("single_picture")[0].id;
            let data = { comment, id_gallery };
            data = JSON.stringify(data);
            fetch('Gallery/post/comment', {
                method: 'POST',
                body: data,
            }).then(function(response) {
                if (response.status !== 200) {
                    alert('Looks like there was a problem. Status Code: '.response.status);
                    return;
                }
                response.text().then((text) => {
                    if (text == 0) {
                        alert("Please login first!");
                        return;
                    } else {
                        const newComment = document.createElement("P");
                        newComment.className = "comment_info";
                        const a = document.createElement("A");
                        var linkText = document.createTextNode("[" + text.trim() + "]");
                        a.appendChild(linkText);
                        a.href = "#";
                        newComment.appendChild(a);
                        var textnode = document.createTextNode(comment);
                        newComment.appendChild(textnode);
                        var list = document.getElementById("comments_div");
                        list.insertBefore(newComment, list.childNodes[0]);
                        var addOne = parseInt(document.getElementById("comment_nbr").innerHTML) + 1;
                        document.getElementById("comment_nbr").innerHTML = addOne;
                        document.getElementById("comment_icon").src = "public/icons/comment_icon.png";
                    }
                });
            });
        }
    })
}

document.getElementById("like_icon").addEventListener("click", function(e) {
    let icon = document.getElementById("like_icon").src;
    icon = icon.replace(window.location.origin + "/", '');
    const id_gallery = document.getElementsByClassName("single_picture")[0].id;
    if (icon == "public/icons/like_icon_b.png") {
        fetch('Gallery/post/like_plus', {
            method: 'POST',
            body: id_gallery,
        }).then(function(response) {
            if (response.status !== 200) {
                alert('Looks like there was a problem. Status Code: '.response.status);
                return;
            }
            response.text().then((text) => {
                if (text == 0) {
                    alert("Please login first!");
                    return;
                } else {
                    document.getElementById("like_icon").src = "public/icons/like_icon.png";
                    var addOne = parseInt(document.getElementById("likes_nbr").innerHTML) + 1;
                    document.getElementById("likes_nbr").innerHTML = addOne;
                }
            });
        });
    } else {
        fetch('Gallery/post/like_minus', {
            method: 'POST',
            body: id_gallery,
        }).then(function(response) {
            if (response.status !== 200) {
                alert('Looks like there was a problem. Status Code: '.response.status);
                return;
            } else {
                document.getElementById("like_icon").src = "public/icons/like_icon_b.png";
                var minOne = parseInt(document.getElementById("likes_nbr").innerHTML) - 1;
                document.getElementById("likes_nbr").innerHTML = minOne;
            }
        });
    }
})