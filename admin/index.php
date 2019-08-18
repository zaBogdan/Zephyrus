<?php include "widgets/header.php" ?>


<body id="page-top">

  <?php include "widgets/navbar.php" ?>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
      <li class="breadcrumb-item">
          <a href="index.php">Administrator</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
      </ol>

      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-comments"></i>
              </div>
              <div class="mr-5"><b>x</b> Files Uploaded</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-list"></i>
              </div>
              <div class="mr-5"><b>x</b> Active users</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-shopping-cart"></i>
              </div>
              <div class="mr-5"><b>x</b> Posts created</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-life-ring"></i>
              </div>
              <div class="mr-5"><b>x</b> Comments</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>

      <!-- Area Chart Example-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-info-circle"></i> Plans for future</div>
        <div class="card-body">
          <div class="col-12">
            <div class="row">
              <div class="col-6">
                <h4>To be done:</h4>
                <ul>
                  <li><s>File upload system</s></li>
                  <li>Posts</li>
                  <li>Link the front-end with the back-end</li>
                  <li>Notification and Message handling</li>
                  <li>Follow system</li>
                  <li>Private messages ( end-to-end encryption )</li>
                  <li>Statistics system </li>
                  <li>API Request</li>
                  <li>User roles ( example: Administrator, Moderator, Writer, Reader )</li>
                  <li>Automatic token expiry</li>
                </ul>
              </div>
              <div class="col-6">
                <h4>Known bugs:</h4>
                <ul>
                  <li>
                  <s>
                  Session, Confirmation and Reset password tokens doesn't keep track where you use them 
                  ( You can use the session token to reset your password, or even confirm your account )
                  </s>
                  </li>
                  <li>
                  When sending an email, the style is removed from the initial page 
                  ( Reset password and Confirmation for now )
                  </li>
                  <li>The login token of the cookie is set as it is found in the database.</li>
                </ul>
              </div>
            </div>
          </div>


        </div>
      </div>



    </div>
    <!-- /.container-fluid -->

    <?php include "widgets/footer.php" ?>