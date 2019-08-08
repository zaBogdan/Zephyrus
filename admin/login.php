<?php include "widgets/short_header.php"?>
<?php
if(isset($_POST['submit'])){
  $user = Users::check_user($_POST['username'],$_POST['password']);
  $_SESSION['username'] = $user->username;
  $_SESSION['userID'] = $user->id;
  if(!empty($user)){
    if(isset($_POST['remember-me'])){
      echo $_POST['remember-me'];
      $_SESSION['uuid']=$user->uuid;
    }
    $session->login($user);
    header("Location: /admin");
  }
}
?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="" method="post">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" required>
              <label for="inputEmail">Username</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
              <label for="inputPassword">Password</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="remember-me" value="true">
                Remember Password
              </label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" name="submit">Login</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Register an Account</a>
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

<?php include "widgets/short_footer.php"?>

