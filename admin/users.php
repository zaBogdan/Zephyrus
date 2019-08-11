<?php include "widgets/header.php" ?>
<?php
  $users = Users::find_all();
?>
<body id="page-top">

  <?php include "widgets/navbar.php" ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Users</li>
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
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th scope="row">#</th>
                    <th>UUID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Active</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th scope="row">#</th>
                    <th>UUID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Active</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach($users as $user):?>
                  <tr>
                    <td><?=$user->id?></td>
                    <td><?=$user->uuid?></td>
                    <td><?=$user->username?></td>
                    <td><?=$user->email?></td>
                    <td><?=$user->confirmedStatus ? "YES" : "NO" ?></td>
                    <td>
                      <a href="/profile.php?username=<?=$user->username?>" class="btn btn-info"><i class="fas fa-user-alt"></i></a>
                      <a href="/admin/profile.php?uuid=<?=$user->uuid?>" class="btn btn-success"><i class="fas fa-user-edit"></i></a>
                      <a href="?delete=<?=$user->uuid?>" class="btn btn-danger"><i class="fas fa-user-times"></i></a>
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

