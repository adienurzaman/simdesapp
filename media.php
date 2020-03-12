<?php

session_start();

// error_reporting(0);

error_reporting(E_ALL);

include "timeout.php";



if($_SESSION['login']==1){

	if(!cek_login()){

		$_SESSION['login'] = 0;

	}

}

if($_SESSION['login']==0){

  header('location:logout.php');

}

else{

      if (empty($_SESSION['username']) AND $_SESSION['login']==0){

        echo "<link href='style.css' rel='stylesheet' type='text/css'>

      <center>Untuk mengakses modul, Anda harus login <br>";

        echo "<a href=index.php><b>LOGIN</b></a></center>";

      }

else{

  ?>

  <!DOCTYPE html>

  <html class="no-js" lang="">

  <head>

   <?php

   include "head.php" ;

    ?> 

  </head>

  <body>

  <?php 

include "header.php" ;

include "menubar.php" ;

include "konten.php" ;

include "footer.php" ;

include "js.php" ;

   ?>

  </body>

  </html>

  <?php

  }

}

?>