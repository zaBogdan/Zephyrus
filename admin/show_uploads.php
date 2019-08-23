<?php include "widgets/header.php"?>
<?php
$msg = NULL;
if(isset($_POST['submit'])){
  $msg = FileHandler::upload_file($_POST['username'],$_FILES['file_upload']);
  if($msg[0] == "/")
    $msg = "File has been successfully uploaded";
}
?>

<body id="page-top">

    <?php include "widgets/navbar.php" ?>


    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Files uploaded</li>
            </ol>

            <!-- Page Content -->

            <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                    <?php
                    $files = FileHandler::getAllFiles();
                    foreach($files as $file):
                    ?>
                    <div class="card bg-dark text-white">
                        <img src="<?=$file?>" class="card-img" alt="..." >

                    </div>
                    <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->


    <?php include "widgets/footer.php"?>