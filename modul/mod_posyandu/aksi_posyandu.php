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



if ($module=='posyandu' AND $act=='input'){

 {

  $query = mysqli_query($konek,"INSERT INTO tb_yandu (id_yandu,

                                            id_refyandu,

                                            tgl_yandu,

                                            waktu_yandu)

                                            VALUES ('null',

                                            '$_POST[posyandu]',

                                            '$_POST[tgl_yandu]',

                                            '$_POST[waktu_yandu]');");

  if($query){
    $_SESSION['flashdata'] = 'tambah_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=posyandu'>";
  }else{
    $_SESSION['flashdata'] = 'tambah_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=posyandu'>";
  }
            

  }   

  //header('location:../../media.php?module='.$module);

}



// Hapus user

if($module=='posyandu' AND $act=='hapus'){

  $query = mysqli_query($konek,"DELETE FROM tb_yandu WHERE id_yandu = '$_GET[id]'");

  if($query){
    $_SESSION['flashdata'] = 'hapus_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=posyandu'>";
  }else{
    $_SESSION['flashdata'] = 'hapus_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=posyandu'>";
  }

}





// Update user

elseif ($module=='posyandu' AND $act=='update'){

  if($_SESSION['level_user']=='Admin'){

   $query = mysqli_query($konek,"UPDATE tb_yandu SET tgl_yandu              = '$_POST[tgl_yandu]',

                                                waktu_yandu          = '$_POST[waktu_yandu]'

                                        WHERE  id_yandu          = '$_POST[id]'");

    if($query){
      $_SESSION['flashdata'] = 'ubah_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=posyandu'>";
    }else{
      $_SESSION['flashdata'] = 'ubah_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=posyandu'>";
    }

  //header('location:../../media.php?module='.$module);

  }

  }



}

?>

