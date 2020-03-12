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



if ($module=='jadwal' AND $act=='input'){

 {

  $query = mysqli_query($konek,"INSERT INTO tb_ronda (id_ronda,

                                            nik,

                                            id_hari)

                                            VALUES ('null',

                                            '$_POST[nik]',

                                            '$_POST[id_hari]');");

  if($query){
    $_SESSION['flashdata'] = 'tambah_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=jadwal'>";
  }else{
    $_SESSION['flashdata'] = 'tambah_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=jadwal'>";
  }
         

  }   

  //header('location:../../media.php?module='.$module);

}



elseif ($module=='jadwal' AND $act=='hapusseleksi'){

  if($_SESSION['level_user']=='Admin'){

    if(!empty($_POST['data'])){

      foreach ($_POST['data'] as $key => $id_ronda) {

        mysqli_query($konek,"DELETE FROM tb_ronda WHERE id_ronda='$id_ronda'");

      }

      $_SESSION['flashdata'] = 'hapus_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=jadwal'>";

    }  else{

      $_SESSION['flashdata'] = 'tidak_ada_data';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=jadwal'>";

    } 

   

  

  

  

  //header('location:../../media.php?module='.$module);

  }

      

  }



}

?>

