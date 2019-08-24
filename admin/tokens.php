<?php include "widgets/header.php" ?>
<?php
  $tokens = TokenAuth::find_all();
  if(isset($_GET['revoke'])){
    TokenAuth::revokeToken($_GET['revoke']);
    header("Location: /admin/tokens.php");
  }
  TokenAuth::revokeExpiredTokens();

?>
<body id="page-top">

  <?php include "widgets/navbar.php" ?>

    <div id="content-wrapper">

      <div class="container-fluid">

      <div class="alert alert-warning" role="alert">Rework completed. Deprecated for now</div>



      </div>
      <!-- /.container-fluid -->

  <?php include "widgets/footer.php" ?>
      <script>
      $(document).ready(function() {
        $('#dataTable2').DataTable( {
            "order": [[ 3, "desc" ]]
        } );
    } );
      </script>

