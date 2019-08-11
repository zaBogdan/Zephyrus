<?php $redirect = true; include "../widgets/short_header.php"?>
<?php 
$msg = "Confirm the user";
if(isset($_GET['id'])){
  $token = $_GET['id'];
  $user = TokenAuth::validateToken($token,"confirm_email");
  if(empty($user))
    header("Location: /admin");
}else header("Location: /admin");

$user = Users::find_by_attribute("uuid",$user->uuid);
$user->confirmedStatus = true;
$user->save_to_db();
TokenAuth::revokeToken($token);
header("Refresh:10; url=/admin", true, 303);

?>
<body class="bg-dark">
    <div class="container mx-auto mt-5">
<div class="jumbotron text-center">
  <h1 class="display-4">Thank you!</h1>
  <p class="lead">You are now ready to use our application!</p>
  <hr class="my-4">
  <p>You will be redirected in 10 seconds!</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/admin" role="button">Go now</a>
  </p>
</div>
</div>
  <?php include "../widgets/short_footer.php"?>
