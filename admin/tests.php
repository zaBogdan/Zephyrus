<?php include "widgets/header.php"?>
<?php include "classes/init.php"  ?>


<body id="page-top">

  <?php include "widgets/navbar.php" ?>


    <div id="content-wrapper">

      <div class="container-fluid">

      
      <!-- Page Content -->
        <h1>Blank Page</h1>
        <hr>
        <p>
        <?php
          $_SESSION['userID']=1;
          $_SESSION['username']='zaBogdan';
          $session->login(true);
          // $token = $session->create_token(1, "zaBogdan");
          // echo "encoded: ".$token."<br>";
          // $session->decode_token($token);
        ?>  

        </p>





      </div>
      <!-- /.container-fluid -->


<?php include "widgets/footer.php"?>


