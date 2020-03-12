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



if ($module=='riwayat' AND $act=='input'){

 {

  $query = mysqli_query($konek,"INSERT INTO tb_riwayat (id_riwayat,

                                            nik,

                                            tgl_riwayat,

                                            riwayat)

                                            VALUES ('null',

                                            '$_POST[nik]',

                                            '$_POST[tgl_riwayat]',

                                            '$_POST[riwayat]');");

  if($query){
    $_SESSION['flashdata'] = 'tambah_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=riwayat'>";
  }else{
    $_SESSION['flashdata'] = 'tambah_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=riwayat'>";
  }
          

  }   

  //header('location:../../media.php?module='.$module);

}



// Hapus riwayat

if($module=='riwayat' AND $act=='hapus'){

  $query = mysqli_query($konek,"DELETE FROM tb_riwayat WHERE id_riwayat = '$_GET[id]'");

  if($query){
    $_SESSION['flashdata'] = 'hapus_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=riwayat'>";
  }else{
    $_SESSION['flashdata'] = 'hapus_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=riwayat'>";
  }

}







// Update riwayat

elseif ($module=='riwayat' AND $act=='update'){

  if($_SESSION['level_user']=='Admin'){

      $query = mysqli_query($konek,"UPDATE tb_riwayat SET riwayat              = '$_POST[riwayat]'

                                            WHERE  nik         = '$_POST[nik]'");

      if($query){
        $_SESSION['flashdata'] = 'ubah_sukses';
        echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=riwayat'>";
      }else{
        $_SESSION['flashdata'] = 'ubah_gagal';
        echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=riwayat'>";
      }

  }

 

  }

  }





?>

