<?php include "../widgets/short_header.php"?>
<?php 
$msg = "Reset your password";
if(isset($_GET['id'])){
  $token = $_GET['id'];
  $user = TokenAuth::validateToken($token);
  if(empty($user))
    header("Location: /admin");
}else header("Location: /admin");

if(isset($_POST['submit'])){
  $user = Users::find_by_attribute("uuid",$user->uuid);
  $user->password = $user->hashPassword($_POST['newpassword']);
  TokenAuth::revokeToken($token);
  $user->save_to_db();
  header("Location: /admin");
}
?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <!-- <div class="card-header">Reset Password</div> -->
      <div class="card-body">
        <div class="text-center mb-4">
          <h3><?=$msg?></h3>
        </div>
        <form action="" method="post"> 
          <div class="form-group">
                <div class="form-label-group">
                  <input 
                  type="password" 
                  id="inputPassword" 
                  class="form-control" 
                  name="newpassword" 
                  placeholder="password"
                  autofocus="autofocus"
                  required="required">
                  <label for="inputPassword">Password</label>
                </div>
          </div>
          <div class="form-group">
                <div class="form-label-group">
                  <input 
                  type="password" 
                  id="confirmPassword" 
                  class="form-control" 
                  placeholder="Confirm password" 
                  required="required">
                  <label for="confirmPassword">Confirm Password</label>
                </div>
          </div>
          <button class="btn btn-primary btn-block" name="submit">Reset password</button>
        </form>
      </div>
    </div>
  </div>

  <?php include "../widgets/short_footer.php"?>
