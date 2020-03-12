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

if ($module=='restapi' AND $act=='insert'){
 {

    $cek = "SELECT * FROM tb_push";

    $query=mysqli_query($konek,$cek);
    $cekdata=mysqli_num_rows($query);

    if ($cekdata == 0) {
      mysqli_query($konek,"INSERT INTO tb_push (id_push,
                                            app_id,
                                            api_key,
                                            auth_key)
                                            VALUES ('null',
                                            '$_POST[app_id]',
                                            '$_POST[api_key]',
                                            '$_POST[auth_key]');");
      
    }
      else{
          mysqli_query($konek,"UPDATE tb_push SET api_key              = '$_POST[api_key]',
                                                  auth_key              = '$_POST[auth_key]',
                                                   app_id         = '$_POST[app_id]'
                                            WHERE  id_push         = '1'");

      }
  echo"<script>alert('PROSES DATA BERHASIL'); </script>";
  echo "<meta http-equiv='refresh' content='1; url=../../media.php?module=restapi'>";             
  }   
  //header('location:../../media.php?module='.$module);
}

// Hapus riwayat
if($module=='restapi' AND $act=='proseskirim'){

  $query=mysqli_query($konek,"SELECT * FROM tb_push");
    $row = mysqli_fetch_assoc($query);


    $judul=$_POST['judul'];
    $isi_pesan=$_POST['isi_pesan'];
    
    $heading = array(

       "en" => $judul

    );



    $content = array(

          "en" => $isi_pesan

    );

    $fields = array(

      'app_id' => $row['app_id'],

      'included_segments' => array('All'),

      // 'include_player_ids' => array("be1a007b-0db3-4c32-bc2a-dd3685e1c64c"),

      'data' => array("pilih_activity" => "PenerimaActivity"),

      'headings' => $heading,

      'contents' => $content,

      'status' => TRUE

    );

    

    $fields = json_encode($fields);

    echo $fields;



      // print("\nJSON sent:\n");

      // print($fields);

    

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',

                           'Authorization: Basic '.$row['api_key']));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);



    $response = curl_exec($ch);

    curl_close($ch);

      echo"<script>alert('PROSES DATA BERHASIL'); </script>";
      echo "<meta http-equiv='refresh' content='1; url=../../media.php?module=restapi'>"; 

        }



  }


?>
