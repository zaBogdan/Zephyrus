<?php include "widgets/header.php"?>

<?php
$user = Users::find_by_attribute("id",$_SESSION['userID']);
if(isset($_GET['send_email'])){
  $user->send_confirmation();
  header("Refresh: 1");
}
?>
<body id="page-top">

  <?php include "widgets/navbar.php" ?>


    <div id="content-wrapper">

      <div class="container-fluid">

      
      <!-- Page Content -->
        <h1>Test page</h1>
        <hr>
        <p>
        <?php
  if(!$user->confirmedStatus)
  echo '<div class="alert alert-danger text-center" role="alert">
  You have not confirmed your email'.$user->email.' Click the button to send a confirmation link
  <a href="?send_email=true" class="btn btn-link">Send Email</a>
  </div>';
?>


        </p>





      </div>
      <!-- /.container-fluid -->


<?php include "widgets/footer.php"?>


