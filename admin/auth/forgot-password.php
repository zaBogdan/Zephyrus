<?php include "../widgets/short_header.php"?>
<?php 
$msg='Enter your email address and we will send you instructions on how to reset your password.';
if(isset($_POST['submit'])){
  //logics
  if(!Users::send_forgot_password($_POST['email']))
    $msg = "Email doesn't exists in the database.";
  $msg = "Please check your email! We've sent you rest link there!";
}

?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>Forgot your password?</h4>
          <p><?=$msg?></p>
        </div>
        <form action="" method="post"> 
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Enter email address" required="required" autofocus="autofocus">
              <label for="inputEmail">Enter email address</label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" name="submit">Reset password</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.php">Register an Account</a>
          <a class="d-block small" href="login.php">Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <?php include "../widgets/short_footer.php"?>
