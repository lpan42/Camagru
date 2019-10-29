
<h2>Current email preference: </h2>
<?php if($current == 1):?><p>Enable</p>
<?php else:?><p>Disable</p>
<?php endif;?>

<label class="switch">
  <input id="switch_email" type="checkbox" <?php if($current == 1):?>checked<?php endif;?>>
  <span class="slider round"></span>
</label>



<script>
  document.getElementById("switch_email").addEventListener("click", function() {
  var text = document.getElementsByTagName("input")[0].checked;
  if(text == false){
    data = 0;
  }
  else{
    data = 1;
  }
  fetch('Modify/modify_email', {
          method: 'POST',
          body: data,
      })
      .then((response) => response.text()).then((text) => {
        if(text == 1){
          document.getElementsByTagName("P")[0].innerHTML = "Enable";
        }
        else{
          document.getElementsByTagName("P")[0].innerHTML = "Disable";
        }
      });
});
</script>