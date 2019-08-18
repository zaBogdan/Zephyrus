<?php include "widgets/header.php" ?>
<?php
  $tokens = TokenAuth::find_all();
  if(isset($_GET['revoke'])){
    TokenAuth::revokeToken($_GET['revoke']);
    header("Location: /admin/tokens.php");
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
          <li class="breadcrumb-item active">Token manager</li>
        </ol>
<p>
</p>
        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
          <i class="fas fa-users"></i>
            Users table</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTable2"  width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th scope="row">#</th>
                    <th>UUID</th>
                    <th>Linked to</th>
                    <th>Status</th>
                    <th>Target</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th scope="row">#</th>
                    <th>UUID</th>
                    <th>Linked to</th>
                    <th>Status</th>
                    <th>Target</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach($tokens as $token):?>
                  <tr>
                    <td><?=$token->id?></td>
                    <td><?=$token->uuid?></td>
                    <td><?php echo Users::find_by_attribute("uuid",$token->uuid)->username?></td>
                    <td><?=$token->is_expired ? "Expired." : "Valid until: ".date('m/d/Y h:i:s',$token->expiry_date)?></td>
                    <td><i><?=$token->used_for?></i></td>
                    <td>
                    <?php if(!$token->is_expired): ?>
                      <a href="?revoke=<?=$token->token?>" class="btn btn-sm btn-link"><i class="fas fa-times-circle"></i> Revoke</a>
                    <?php endif;?>
                    </td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Last updated <b><?=date('d-M-Y H:i:s')?></b></div>
        </div>


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

