<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./style/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./style/img/logo.svg">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Zephyrus - Login
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="./style/css/material-kit.css?v=2.0.7" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
</head>

<body class="login-page sidebar-collapse">
  <nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="/main">
        <img src="./style/img/logoText.svg" alt="Logo"  height="32" width="142" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse ">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/main">
              Why us?
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/main">
              Features
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/blog/documentation" target="_blank">
              Documentation
            </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline btn-round" style="color: #9124A3;background-color: #fff" href="/main/login">
              Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="page-header header-filter" style="background-image: url('./style/img/bg8.jpg'); background-size: cover; background-position: top center;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 ml-auto mr-auto">
        <div class="card">
          <div class="card-header card-header-text card-header-primary">
            <div class="card-text text-center">
              <h4 class="card-title">Login</h4>
            </div>
          </div>
          <div class="card-body">
            <p class="text-muted text-center">Please fill in all the crendetials.</p>
            <form class="form" method="post">
                <div class="form-group">
                    <label for="username" class="bmd-label-floating">
                       Username
                    </label>
                    <input type="text" name="username" class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="password" class="bmd-label-floating">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="text-center">
                    <button class="btn btn-success btn-round" type="submit" name="submit">Sign in</button>
                </div>
            </form>
            <div class="text-center">
                <a href="/main/forgot-password" class="d-block small mt-3">Forgot Password?</a>
                <a href="/main/register" class="d-block small">Register an account</a>
            </div>
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
  </div>
  <!--   Core JS Files   -->
  <script src="./style/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="./style/js/core/popper.min.js" type="text/javascript"></script>
  <script src="./style/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
  <script src="./style/js/plugins/moment.min.js"></script>
  <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
  <script src="./style/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="./style/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <!--  Google Maps Plugin    -->
  <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
  <script src="./style/js/material-kit.js?v=2.0.7" type="text/javascript"></script>
</body>

</html>