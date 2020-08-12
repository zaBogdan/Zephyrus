<!doctype html>
<html lang="en">

<head>
  <title>Zephyrus - Hello World</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="icon" type="image/png" href="./style/img/logo.svg">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="./style/css/material-kit.css?v=2.0.7" rel="stylesheet" />
</head>
  <body class="settings-page sidebar-collapse">
  <nav class="navbar fixed-top navbar-expand-lg" color-on-scroll="100">
        <div class="navbar-translate">
            <a class="navbar-brand" href="/main">
            <img src="./style/img/logo.svg" alt="Logo"  height="32" width="142" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse">
          <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="#pablo" class="nav-link">Popular</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Documentation</a>
                        <a class="dropdown-item" href="#">Adventure</a>
                        <a class="dropdown-item" href="#">Horror</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#pablo" class="nav-link">Following</a>
                </li>
            </ul>
            
            
            <ul class="navbar-nav ml-auto mr-5">
            <form class="form-inline mr-3">
              <div class="form-group no-border">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-white btn-raised btn-fab btn-round">
                <i class="material-icons">search</i>
              </button>
            </form>
            <li class="nav-item mr-auto">
                <a href="#pablo" class="btn btn-white btn-just-icon btn-round">
                    <i class="material-icons">add</i>
                </a>
            </li>
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle" style="width: 40px; height: 40px;" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/fd/fd4372b86edca6468c80bfa8c79361c250fbb22c_full.jpg" alt="zaBogdan">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <hr>
                        <a class="dropdown-item" href="#">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
</nav>


<div class="page-header header-filter" data-parallax="true" style="background-image: url('assets/img/bg10.jpg')">
</div>

<div class="main main-raised">
  


  
    <div class="container">
        <div class="section text-center">
        <h2 class="title">zaBogdan's settings</h2>
        </div>
    </div>
        <div class="container">
            <div class="row">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:;">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="javascript:;">Disabled</a>
                </li>
            </ul>
            <div class="text-right">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
            </div>
            </div>
        
        </div>
    </div>

<footer class="footer" data-background-color="black">
    <div class="container">
      <nav class="float-left">
        <ul>
          <li>
            <a href="#">
              zaBogdan
            </a>
          </li>
          <li>
            <a href="/presentation">
              About Us
            </a>
          </li>
          <li>
            <a href="/blog">
              Blog
            </a>
          </li>
          <li>
            <a href="/license">
              Licenses
            </a>
          </li>
        </ul>
      </nav>
      <div class="copyright float-right">
        &copy; Zephyrus
        <script>
          document.write(new Date().getFullYear())
        </script>, created by <b>zaBogdan</b>
      </div>
    </div>
  </footer>
<!--   Core JS Files   -->
<script src="./style/js/core/jquery.min.js" type="text/javascript"></script>
<script src="./style/js/core/popper.min.js" type="text/javascript"></script>
<script src="./style/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
<script src="./style/js/plugins/moment.min.js"></script>
<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
<script src="./style/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="./style/js/plugins/nouislider.min.js" type="text/javascript"></script>
<!--  Google Maps Plugin  -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
<script src="./style/js/material-kit.js?v=2.0.4" type="text/javascript"></script></body>
</html>