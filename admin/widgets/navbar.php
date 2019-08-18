<?php
// if(isset($_GET['send_email'])){
//   $user->send_confirmation();
//   header("Refresh: 1");
// }
?>
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

<a class="navbar-brand mr-1" href="index.php">Start Bootstrap</a>

<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
  <i class="fas fa-bars"></i>
</button>

<!-- Navbar Search -->
<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
  <div class="input-group">
    <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
    <div class="input-group-append">
      <button class="btn btn-primary" type="button">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>
</form>

<!-- Navbar -->
<ul class="navbar-nav ml-auto ml-md-0">
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-bell fa-fw"></i>
      <span class="badge badge-danger">9+</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
    <a class="dropdown-item" href="#">Action</a>
      <a class="dropdown-item" href="#">Another action</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Something else here</a>
    </div>
  </li>
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-envelope fa-fw"></i>
      <span class="badge badge-danger">7</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
      <a class="dropdown-item" href="#">Action</a>
      <a class="dropdown-item" href="#">Another action</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Something else here</a>
    </div>
  </li>
  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-user-circle fa-fw"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="#"><?=$user->username?></a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Settings</a>
      <a class="dropdown-item" href="#">Activity Log</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
    </div>
  </li>
</ul>

</nav>
<div id="wrapper">

<!-- Sidebar -->
<ul class="sidebar navbar-nav">
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <div class="dropdown-divider"></div>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-fw fa-folder"></i>
      <span>Pages</span>
    </a>
    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
      <h6 class="dropdown-header">Other Pages:</h6>
      <a class="dropdown-item" href="404.php"><i class="fas fa-exclamation-triangle"></i> 404 Page</a>
      <a class="dropdown-item" href="blank.php"><i class="far fa-file"></i> Blank Page</a>
      <a class="dropdown-item" href="charts.php"><i class="fas fa-fw fa-chart-area"></i> Charts</a>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="add_post.php">
    <i class="fas fa-file-word"></i> 
      <span>Add a post</span></a>
  </li>
  <!-- manager stuff -->
  <div class="dropdown-divider"></div>
  <li class="nav-item">
    <a class="nav-link" href="users.php">
    <i class="fas fa-user-shield"></i>
      <span>Users</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="tokens.php">
    <i class="fas fa-key"></i>
      <span>Tokens</span></a>
  </li>

  <!-- Test stuff -->
  <div class="dropdown-divider"></div>
  <li class="nav-item">
    <a class="nav-link" href="tests.php">
      <i class="fas fa-vial"></i>
      <span>Tests</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="upload.php">
    <i class="fas fa-file-upload"></i>
      <span>Upload a file</span></a>
  </li>

</ul>
