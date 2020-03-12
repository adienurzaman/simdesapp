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

  

/*if ($module=='users' AND $act=='input'){

 {

  $pass=md5($_POST['password']);

  mysqli_query($konek,"INSERT INTO tb_user (id_user,

                                            nik,

                                            nama,

                                            password,

                                            level_user)

                                            VALUES ('null',

                                            '$_POST[nik]',

                                            '$_POST[nama]',

                                            '$pass',

                                            '$_POST[level _user]');"

                                          );

  echo"<script>alert('INPUT DATA BERHASIL'); </script>";

  echo "<meta http-equiv='refresh' content='1; url=../../media.php?module=users'>";             

  }   

  //header('location:../../media.php?module='.$module);

}

*/

// Hapus user

if($module=='users' AND $act=='hapus'){

  mysqli_query($konek,"DELETE FROM tb_user WHERE id_user = '$_GET[id]'");

  echo"<script>alert('DELETE DATA BERHASIL'); </script>";

  echo "<meta http-equiv='refresh' content='1; url=../../media.php?module=users'>";

}
   
        // Ubah level User


elseif($module=='users' AND $act=='ubahlevel'){

  if($_GET['u']== 'warga'){

    $query = mysqli_query($konek,"UPDATE tb_user SET level_user='Warga' WHERE id_user = '$_GET[id]'");

    if($query){
      $_SESSION['flashdata'] = 'ubah_warga_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=users'>";
    }else{
      $_SESSION['flashdata'] = 'ubah_warga_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=users'>";
    }
    

  }else{

    $query = mysqli_query($konek,"UPDATE tb_user SET level_user='Admin' WHERE id_user = '$_GET[id]'");

    if($query){
      $_SESSION['flashdata'] = 'ubah_admin_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=users'>";
    }else{
      $_SESSION['flashdata'] = 'ubah_admin_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=users'>";
    }

  }

}



// Resset Password

else if($module=='users' AND $act=='resetpass'){

  if($_SESSION['level_user']=='Admin')

  {

    $pass=md5('123456789');

    $query = mysqli_query($konek,"UPDATE tb_user SET password  = '$pass' WHERE  id_user = '$_GET[id]'");


    if($query){
      $_SESSION['flashdata'] = 'reset_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=users'>";
    }else{
      $_SESSION['flashdata'] = 'reset_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=users'>";
    }


  }

}







}

?>

