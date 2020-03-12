<?php

session_start();

if (empty($_SESSION['nik']) AND empty($_SESSION['pass'])){

  echo "<link href='style.css' rel='stylesheet' type='text/css'>

  <center>Untuk mengakses modul, Anda harus login <br>";

  echo "<a href=../../index.php><b>LOGIN</b></a></center>";

}

else{

  include "../../config/koneksi.php";



  $module=$_GET['module'];

  $act=$_GET['act'];



// Input 

  if($module=='smartvillage' AND $act=='hapusall'){

    $q_1 = mysqli_query($konek,"TRUNCATE tb_suhu");
    $q_2 = mysqli_query($konek,"TRUNCATE tb_kualitasudara");
    $q_3 = mysqli_query($konek,"TRUNCATE tb_kebakaran");
    $q_4 = mysqli_query($konek,"TRUNCATE tb_kelembaban");
    $q_5 = mysqli_query($konek,"TRUNCATE tb_gempa");
    $q_6 = mysqli_query($konek,"TRUNCATE tb_keamanan");

    if($q_1 == true && $q_2 == true && $q_3 == true && $q_4 == true && $q_5 == true && $q_6 == true){
      $_SESSION['flashdata'] = 'hapus_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=smartvillage'>";
    }else{
      $_SESSION['flashdata'] = 'hapus_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=smartvillage'>";
    }

  }

}

?>

