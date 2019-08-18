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
        <li class="breadcrumb-item active">Upload a file</li>
      </ol>
      <?php if(!empty($msg)): ?>
      <div class="alert alert-info" role="alert">
        <?=$msg?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times"></i></span>
        </button>
      </div>
      <?php endif;?>
      <!-- Page Content -->
      
      <div class="col-12">
        <div class="row">
          <div class="col-6">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Username</label>
                  <input type="text" class="form-control" id="inputEmail4" placeholder="Username" name="username"
                    required>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword4">Password</label>
                  <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                </div>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="file_upload" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
              <br>
              <br>
              <button type="submit" name="submit" class="btn btn-primary">Upload file</button>
            </form>
          </div>
          <div class="col-1"></div>
          <div class="col-3">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title text-center">Upload information</h5>
                <p class="card-text">
                  <ul>
                    <li><b>Upload limit:</b> 100MB/file</li>
                    <li><b>Files uploaded:</b> <?=FileHandler::getAllUploaded()?></li>
                    <li><b>Permission:</b> file.upload_file</li>
                  </ul>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->


    <?php include "widgets/footer.php"?>