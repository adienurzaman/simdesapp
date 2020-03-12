<?php

include "config/koneksi.php";



function anti_injection($data){

  $filter  = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));

  return $filter;

}



$nik = $_POST['nik'];

 $pass = md5($_POST['password']);
//$pass = $_POST['password'];



// pastikan username dan password adalah berupa huruf atau angka.

if (!ctype_alnum($nik) OR !ctype_alnum($pass)){

  include "error-login.php";

}



else{



$login=mysqli_query($konek,"SELECT tb_user.nik as nik, tb_warga.nama as nama , tb_user.level_user as level_user , tb_user.s_user as s_user FROM tb_user LEFT JOIN tb_warga ON tb_warga.nik=tb_user.nik WHERE tb_user.nik='$nik' AND tb_user.password ='$pass' AND tb_user.s_user = 'Aktif' ");

//var_dump($login);

$ketemu=mysqli_num_rows($login);

//var_dump($ketemu);

$r=mysqli_fetch_array($login);



    // Apabila username dan password ditemukan

    if ($ketemu > 0){

      session_start();

      include "timeout.php";



      $_SESSION['nik']            = $r['nik'];
      $_SESSION['nama']            = $r['nama'];


      $_SESSION['level_user']     = $r['level_user'];

      $_SESSION['s_user']         = $r['s_user'];



     

      

      // session timeout

      $_SESSION['login'] = 1;

      timer();



    	$sid_lama = session_id();

    	

    	session_regenerate_id();



    	$sid_baru = session_id();



      mysqli_query($konek,"UPDATE tb_user SET id_session='$sid_baru' WHERE nik='$username'");

      header('location:media.php?module=home');

  }

  else{

    include "error-login.php";

  }



}

?>

 