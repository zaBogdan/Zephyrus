<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./style/img/logo.svg">
  <link rel="icon" type="image/png" href="./style/img/logo.svg">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Zephyrus - CMS
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="./style/css/material-kit.css?v=2.0.7" rel="stylesheet" />
</head>

<body class="index-page sidebar-collapse">
  <nav class="navbar navbar-transparent navbar-color-on-scroll bg-primary fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
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
            <a class="nav-link" href="javascript:void(0)" onclick="scrollToWhyUs()">
              Why us?
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript:void(0)" onclick="scrollToFeatures()">
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
  <div class="page-header header-filter clear-filter purple-filter" data-parallax="true" style="background-image: url('./style/img/bg2.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ml-auto mr-auto">
          <div class="brand">
            <h1>Zephyrus</h1>
            <h3>A new <b>Content Management System</b> platform</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main main-raised">
    <div class="container">
      <div class="section why-us text-center">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto">
            <h2 class="title">Let&apos;s talk product</h2>
            <h5 class="description">
              This is just a personal project developed by <i>zaBogdan</i>. The aim of it was to 
              create a flexible and scalable Content Management System (CMS) written in pure PHP.
              After a long journey these are three strong points of the Zephyrus app.
            </h5>
          </div>
        </div>
        <div class="features">
          <div class="row">
            <div class="col-md-4">
              
            </div>
            <div class="col-md-4">
              <div class="info">
                <div class="icon icon-success">
                  <i class="material-icons">verified_user</i>
                </div>
                <h4 class="info-title">Moderation</h4>
                <p>
                  One of main problem with this kind of system is related to bots and spam content. That's why
                  I've added some automated checks to be sure all new users content is verified and aproved by
                  humans. 
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="info">
                <div class="icon icon-warning">
                <i class="material-icons">description</i>
                </div>
                <h4 class="info-title">Open Source</h4>
                <p>
                  This project can be found on my <a href="https://github.com/zaBogdan/zaEngine" target="_blank">github</a>
                  and I can add new usefull features to make it a finished project and released project one day.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section sectionFeatures text-center">
        <div class="col-md-8 ml-auto mr-auto">
          <h2 class="title">Built-in features</h2>
        </div>
        <div class="row">
          <div class="info info-horizontal">
            <div class="icon icon-info">
              <i class="material-icons">people_outline</i>
            </div>
            <div class="description">
              <h4 class="info-title">Role-Based access control</h4>
              <p>Because security comes first when dealing with user data, we've implemented a Role system (RBAC) to make sure every user can do only what he is supposed to.</p>
            </div>
          </div>
          <div class="info info-horizontal">
            <div class="icon icon-warning">
              <i class="material-icons">receipt_long</i>
            </div>
            <div class="description">
              <h4 class="info-title">Audit System</h4>
              <p>To make sure everything is running the way it should, there is a logger system that takes care of every error or warning and takes appropriate messures when needed.</p>
            </div>
          </div>
          <div class="info info-horizontal">
            <div class="icon icon-danger">
              <i class="material-icons">favorite</i>
            </div>
            <div class="description">
              <h4 class="info-title">Proof of concept</h4>
              <p>Even though is a one-man project driven and not yet released, the whole documentation of the API is been done here, made available on <a href="#" target="_blank">zabogdan.io</a></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="info info-horizontal">
              <div class="icon icon-rose">
                <i class="material-icons">vpn_key</i>
              </div>
              <div class="description">
                <h4 class="info-title">Secure tokens</h4>
                <p>Being all about learning, I've decided to implement custom tokens insted of using JWT format. Every important action (e.g. sessions, reset password, confirm email) has this built in. </p>
              </div>
            </div>
            <div class="info info-horizontal">
              <div class="icon icon-success">
                <i class="material-icons">subject</i>
              </div>
              <div class="description">
                <h4 class="info-title">TinyMCE Editor</h4>
                <p>In order to support the content and open a whole new range of posibilities I've decided to implement the TinyMCE editor because of it's lightweight and it has a wide variety of plugins.</p>
              </div>
            </div>
            <div class="info info-horizontal">
              <div class="icon icon-primary">
                <i class="material-icons">grass</i>
              </div>
              <div class="description">
                <h4 class="info-title">Twig Rendering</h4>
                <p>Everything it's a pain when working with vanilla HTML and CSS, but with the help of TWIG I've managed to implement each and every page saving a lot of time.</p>
              </div>
            </div>
        </div>
      </div>
      <div class="section text-center">
        <div class="col-md-8 ml-auto mr-auto">
          <h2 class="title">Our numbers look like...</h2>
          <h5 class="description">
              Even though is a demo platform we keep all the posts & users that registered
            </h5>
        </div>
        <div class="row">
          <div class="info">
            <div class="icon icon-info">
              <i class="material-icons">people</i>
            </div>
            <h4 class="info-title">100 Users</h4>
            <p>Verified on our platform</p>
          </div>
          <div class="info">
            <div class="icon icon-primary">
              <i class="material-icons">file_copy</i>
            </div>
            <h4 class="info-title">1.000 Posts</h4>
            <p>aproved by our moderation team</p>
          </div>
          <div class="info">
            <div class="icon icon-success">
              <i class="material-icons">attach_file</i>
            </div>
            <h4 class="info-title">10 Files</h4>
            <p>uploaded on our servers</p>
          </div>         
        </div>
      </div>
      <div class="section section-download" id="downloadSection">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-8 mx-auto">
            <h2>Do you want to try this?</h2>
            <h4>Even though it's not a full release yet, you can see all the features in action.
              For a complete experience you need to login/register an account with a valid email adress!
            </h4>
          </div>
          <div class="col-sm-8 col-md-6 mx-auto">
            <a href="/main/login" class="btn btn-secondary btn-lg">
              <i class="material-icons">login</i> Login
            </a>
            <a href="/main/register" target="_blank" class="btn btn-primary btn-lg" rel="nofollow">
            <i class="material-icons">how_to_reg</i> Register now
            </a>
          </div>
        </div>
      </div>
    </div>
<!-- only the structures -->    
  </div>
</div>
  <!--  End Modal -->
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
  <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
  <script src="./style/js/material-kit.js?v=2.0.7" type="text/javascript"></script>
  <script>
    function scrollToWhyUs() {
      if ($('.why-us').length != 0) {
        $("html, body").animate({
          scrollTop: $('.why-us').offset().top
        }, 1000);
      }
    }
    function scrollToFeatures() {
      if ($('.sectionFeatures').length != 0) {
        $("html, body").animate({
          scrollTop: $('.sectionFeatures').offset().top
        }, 1000);
      }
    }
  </script>
</body>

</html>