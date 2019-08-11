<?php include "../widgets/short_header.php"?>
<?php
$msg="Fill up the form to register";
if(isset($_POST['submit'])){
  $user = new Users();
  $msg = $user->create_user($_POST);
  if($msg=="OK"){
    $msg="Please check your email for confirmation and activation! Page will reload in 5 seconds!";
    $user->send_confirmation();
    $user->save_to_db();
    header("Refresh:5; url=/admin", true, 303);
  }
}
?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
      <div class="text-center mb-4">
          <p><?=$msg?></p>
        </div>
        <form action="" method="post">
        <div class='notifications bottom-right'></div>
        <div class="form-group">
            <div class="form-label-group">
              <input 
                type="text" 
                id="inputUsername" 
                class="form-control" 
                <?=isset($_POST['username'])? 'value="'.$_POST['username'].'"' : 'placeholder="Username"'?>
                name="username" 
                required="required" 
                autofocus="autofocus"
                >
              <label for="inputUsername">Username</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input 
                  type="text" 
                  id="firstName" 
                  class="form-control" 
                  name="firstname" 
                  <?=isset($_POST['firstname'])? 'value="'.$_POST['firstname'].'"' : 'placeholder="Firstname"'?>                  
                  required="required"
                  >
                  <label for="firstName">First name</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input 
                  type="text" 
                  id="lastName" 
                  class="form-control" 
                  name="lastname" 
                  <?=isset($_POST['lastname'])? 'value="'.$_POST['lastname'].'"' : 'placeholder="Lastname"'?>
                  required="required">
                  <label for="lastName">Last name</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input 
              type="email" 
              id="inputEmail" 
              class="form-control" 
              name="email" 
              <?=isset($_POST['email'])? 'value="'.$_POST['email'].'"' : 'placeholder="Email"'?>              
              required="required">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
                <div class="form-label-group">
                  <input 
                  type="password" 
                  id="inputPassword" 
                  class="form-control" 
                  name="password" 
                  placeholder="password" 
                  required="required">
                  <label for="inputPassword">Password</label>
                </div>
          </div>
          <button class="btn btn-primary btn-block" name="submit">Register</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

<?php include "../widgets/short_footer.php"?>