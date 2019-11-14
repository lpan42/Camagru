document.getElementsByClassName("img-container")[0].addEventListener('click', (event) => {
    const delete_btns = document.getElementsByClassName('delete_btn');
    [...delete_btns].forEach((btn) => {
        if (btn == event.target) {
            const delete_conf = btn.parentNode.getElementsByClassName("delete_comfirm")[0];
            delete_conf.style.display = "inline";
            btn.style.display = "none";
            const cancel = delete_conf.getElementsByClassName("cancel")[0];
            cancel.onclick = () => {
                delete_conf.style.display = "none";
                btn.style.display = "inline";
            }
            const yes = delete_conf.getElementsByClassName("yes")[0];
            yes.onclick = () => {
                fetch('Gallery/delete/picture', {
                    method: 'POST',
                    body: btn.id,
                }).then(function(response) {
                    if (response.status !== 200) {
                        alert('Looks like there was a problem. Status Code: '.response.status);
                        return;
                    } else {
                        btn.parentNode.parentNode.removeChild(btn.parentNode);
                    }
                });
            }
        }
    })
})