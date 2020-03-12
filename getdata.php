<?php 
include "config/koneksi.php";


$tanggal = $_GET['tanggal'];
$waktu = $_GET['waktu'];
//$tanggal = "2019-02-05";
//$waktu	= "17:30:00";
$query="SELECT * FROM jadwal WHERE status ='valid' AND tanggal = '$tanggal' AND waktu ='$waktu'";
$sql =mysqli_query($konek, $query );


while($row = mysqli_fetch_array($sql)){
	echo $row['nama_pemesan'];
}

 ?>