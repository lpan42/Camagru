<div class="my_profile">
  <h2><i class="fa fa-bell"></i>Change Email Preference </h2>
  <?php if($current == 1):?><p>Enable</p>
  <?php else:?><p>Disable</p>
  <?php endif;?>

  <label class="switch">
    <input id="switch_email" type="checkbox" <?php if($current == 1):?>checked<?php endif;?>>
    <span class="slider round"></span>
  </label>
</div>

<div  class="my_profile">
  <h2><i class="fa fa-envelope"></i></i>Change Email Address </h2>
  <form method="post">
      Old Email Address<br />
          <input type="email" name="old_eadd" /><br />
      New Email Address<br />
          <input type="email" name="new_eadd" /><br />
      New Email Address repeat<br />
          <input type="email" name="new_eadd_repeat" /><br />
      <button type="submit" name= "comfirm_eadd" value="comfirm_eadd">Comfirm</button>
  </form>
</div>

<div  class="my_profile">
  <h2><i class="fa fa-user"></i></i>Change Username </h2>
  <form method="post">
      Old username<br />
          <input type="username" name="old_name" /><br />
      New username<br />
          <input type="username" name="new_name" /><br />
      New username repeat<br />
          <input type="username" name="new_name_repeat" /><br />
      <button type="submit" name= "comfirm_name" value="comfirm_name">Comfirm</button>
  </form>
</div>

<div  class="my_profile">
  <h2><i class="fa fa-key"></i>Change Password</h2>
  <form method="post">
      Old password<br />
          <input type="password" name="old_pwd" /><br />
      New password<br />
          <input type="password" name="new_pwd" /><br />
      New password repeat<br />
          <input type="password" name="new_pwd_repeat" /><br />
      <button type="submit" name= "comfirm_pwd" value="comfirm_pwd">Comfirm</button>
  </form>
</div>

<script type="text/javascript" src="/public/js/my_profile.js"></script>