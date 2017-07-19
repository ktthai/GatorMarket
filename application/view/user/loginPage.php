<div class="container">
  <div class ="center_box">
  <div class ="grey_box">
  <h2>User Login</h2>
  <p>Don't have an account? <a href="<?php echo URL. 'user/createAccount'; ?>">Create Account </a></p>
  <div class="gray_box">
  <form  action="<?php echo URL;?>user/varifyUser" method="post">
   <h3> SFSU ID Number</h3><input type="text" name="id"><br />
   <h3> Password</h3><input type="password" name="password"><br />
    <input class="submit_button" type="submit" name="submit" value="Log In">
  </form>
  </div>
  </div>
  </div>
</div>

