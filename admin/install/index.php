<?php require_once('../classes/init.php') ?>
<?php
if(!env('CORE_RUN_SCRIPT')){
    $msg = "Start the setup, get more information on the run";
    if(isset($_GET['run']) && $_GET['run']==true){
        /**
         * Add here all the installation needed!
         */
        $msg = "<b>Core:</b> Settings things up.... <br>";

        try{ 

          $env = ROOT_DIR.'/vendor/env.php';
          if(!file_exists($env))
            throw new Exception("Please setup the env.php file!");

          //Create the database
          if(!$db->create_tables())
            throw new Exception("Tables couldn't be created");
          $msg .= "<b>Database:</b> Tables have been successfully created! <br>";
          
          //Create the storage files
          if(!file_exists(ROOT_DIR.'/storage/'))
            if(!mkdir(ROOT_DIR.'/storage/',0777, true))
              throw new Exception("Permissions for the folders are wrong. Please set them to 777");
          $msg .= "<b>FileHandler:</b> Storage files have been created! <br>";
          


          $msg .= "<b>Core:</b> Setup finished successfully<br>";
          $msg .= "<b>Core:</b> Go to /vendor/env.php and set the 'CORE_RUN_SCRIPT' to TRUE.";

        }catch (Exception $e){
          $msg .="<b>ERROR:</b>  ".$e->getMessage().'<br>';
        }

    }
}else $msg = "<b>ERROR:</b> You've already installed the application";




?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AdminCP | Install</title>

  <!-- Custom fonts for this template-->
  <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="/vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
    <div class="container mx-auto mt-5">
<div class="jumbotron text-center">
  <h1 class="display-4">Run the initial setup</h1>
  <p class="lead">Click down to automatically install the musts for the application</p>
  <hr class="my-4">
  <p><?=$msg?></p>
  <p class="lead">
  <?php if(!env('CORE_RUN_SCRIPT')): ?>
    <a class="btn btn-primary btn-lg" href="?run=true" role="button">Go now</a>
<?php endif; ?>
  </p>
</div>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="/vendor/js/bootstrap-notify.min.js"></script>
  
</body>

</html>
