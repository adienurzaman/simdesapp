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



if ($module=='warga' AND $act=='input'){

{

    $query = mysqli_query($konek,"INSERT INTO tb_warga (id_warga,

                                              nokk,

                                              nik,

                                              nama,

                                              tempat_lahir,

                                              tanggal_lahir,

                                              jk,

                                              gol_darah,

                                              rt,

                                              rw,

                                              id_lokasi,

                                              desa,

                                              kecamatan,

                                              kabupaten,

                                              agama,

                                              s_perkawinan,

                                              kewarganegaraan,

                                              jabatan)

                                              VALUES ('null',

                                              '$_POST[nokk]',

                                              '$_POST[nik]',

                                              '$_POST[nama]',

                                              '$_POST[tempat_lahir]',

                                              '$_POST[tanggal_lahir]',

                                              '$_POST[jk]',

                                              '$_POST[gol_darah]',

                                              '$_POST[rt]',

                                              '$_POST[rw]',

                                              '$_POST[id_lokasi]',

                                              '$_POST[desa]',

                                              '$_POST[kecamatan]',

                                              '$_POST[kabupaten]',

                                              '$_POST[agama]',

                                              '$_POST[s_perkawinan]',

                                              '$_POST[kewarganegaraan]',

                                              '$_POST[jabatan]');");

    if($query){
    $pass =md5("123456789");

    $s_user="Aktif";
    mysqli_query($konek,"INSERT INTO tb_user (id_user,

                                              nik,

                                              password,

                                              level_user,

                                              s_user)

                                              VALUES ('null',

                                              '$_POST[nik]',

                                              '$pass',

                                              '$_POST[level_user]',

                                              '$s_user');");

    $_SESSION['flashdata'] = 'tambah_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=warga'>";

    }else{
      $_SESSION['flashdata'] = 'tambah_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=warga'>";
    }

  }   

  //header('location:../../media.php?module='.$module);

}



// Hapus user

if($module=='warga' AND $act=='hapus'){

  $query = mysqli_query($konek,"DELETE FROM tb_warga WHERE nik = '$_GET[nik]'");

  if($query){
    mysqli_query($konek,"DELETE FROM tb_user WHERE nik = '$_GET[nik]'");

    $_SESSION['flashdata'] = 'hapus_sukses';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=warga'>";
  }else{
    $_SESSION['flashdata'] = 'hapus_gagal';
    echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=warga'>";
  }



}







// Update user

elseif ($module=='warga' AND $act=='update'){

  if($_SESSION['level_user']=='Admin'){

  $query = mysqli_query($konek,"UPDATE tb_warga SET 

                                            nokk    ='$_POST[nokk]',

                                            nik     ='$_POST[nik]',

                                            nama    ='$_POST[nama]',

                                            tempat_lahir    ='$_POST[tempat_lahir]',

                                            tanggal_lahir ='$_POST[tanggal_lahir]',

                                            jk            ='$_POST[jk]',

                                            gol_darah ='$_POST[gol_darah]',

                                            rt    ='$_POST[rt]',

                                            rw    ='$_POST[rw]',

                                            id_lokasi     ='$_POST[id_lokasi]',

                                            desa    ='$_POST[desa]',

                                            kecamatan     ='$_POST[kecamatan]',

                                            kabupaten ='$_POST[kabupaten]',

                                            agama ='$_POST[agama]',

                                            s_perkawinan ='$_POST[s_perkawinan]',

                                            kewarganegaraan ='$_POST[kewarganegaraan]',

                                            jabatan ='$_POST[jabatan]'

                                        WHERE  id_warga          = '$_POST[id_warga]'");

 
    if($query){
      $_SESSION['flashdata'] = 'ubah_sukses';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=warga'>";
    }else{
      $_SESSION['flashdata'] = 'ubah_gagal';
      echo "<meta http-equiv='refresh' content='0; url=../../media.php?module=warga'>";
    }

  //header('location:../../media.php?module='.$module);

  }

  }



}

?>

