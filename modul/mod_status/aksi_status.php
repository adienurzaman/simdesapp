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



if ($module=='status' AND $act=='input'){

 {

  $tgl_skrng=date('Y-m-d');

  $wkt_skrng=date('H:i:s');

  $query = mysqli_query($konek,"INSERT INTO tb_keamanan (id_keamanan,

                                            nik,

                                            tgl_keamanan,

                                            waktu_keamanan,

                                            jenis_pesan,

                                            deskripsi)

                                            VALUES ('null',

                                            '$_POST[nik]',

                                            '$tgl_skrng',

                                            '$wkt_skrng',

                                            '$_POST[jp]',

                                            '$_POST[deskripsi]');");

  if($query){
    $_SESSION['flashdata'] = 'tambah_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=status'>";
  }else{
    $_SESSION['flashdata'] = 'tambah_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=status'>";
  }
            

  }   

  //header('location:../../media.php?module='.$module);

}



// Hapus user

if($module=='status' AND $act=='hapus'){

  $query = mysqli_query($konek,"DELETE FROM tb_keamanan WHERE id_keamanan = '$_GET[id]'");

  if($query){
    $_SESSION['flashdata'] = 'hapus_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=status'>";
  }else{
    $_SESSION['flashdata'] = 'hapus_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=status'>";
  }

}







// Update user

elseif ($module=='status' AND $act=='update'){

  if($_SESSION['level_user']=='Admin'){

    $query = mysqli_query($konek,"UPDATE tb_keamanan SET jenis_pesan              = '$_POST[jenis_pesan]',

                                                deskripsi          = '$_POST[deskripsi]'

                                        WHERE  id_keamanan       = '$_POST[id_keamanan]'");

    if($query){
      $_SESSION['flashdata'] = 'ubah_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=status'>";
    }else{
      $_SESSION['flashdata'] = 'ubah_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=status'>";
    }  

  }

  }



}

?>

