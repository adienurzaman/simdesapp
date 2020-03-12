
<?php


function notifikasi($judul, $isi_pesan){
include "config/koneksi.php";

 $query=mysqli_query($konek,"SELECT * FROM tb_push");
    $row = mysqli_fetch_assoc($query);
    //var_dump($row);

    
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

    // echo $fields;



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




}






	 ?>