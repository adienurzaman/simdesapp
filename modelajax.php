
<?php

include"config/koneksi.php";
//echo "Succesfully Connected";

if ($_GET['id']=='ceknik'){
		$nik=$_POST['nik'];
		$sql="SELECT * FROM tb_warga WHERE nik='$nik' LIMIT 1 ";
		if ($r=mysqli_query($konek,$sql)){
				$jumlah=mysqli_num_rows($r);
					if($jumlah > 0 ){
						while ($q=mysqli_fetch_array($r)) {
							echo $respon="1/".$q['nama'];	
						}
					}
					else{

					echo $respon="0/null";
						}

		}
}

elseif ($_GET['id']=='ceknikstatus'){
	$nik=$_POST['nik'];
	$sql="SELECT * FROM tb_warga WHERE nik='$nik' LIMIT 1 ";
	if ($r=mysqli_query($konek,$sql)){
			$jumlah=mysqli_num_rows($r);
				if($jumlah > 0 ){
					while ($q=mysqli_fetch_array($r)) {
						echo $respon="1/".$q['nama'];	
					}
				}
				else{

				echo $respon="0/null";
					}
		}
	}


elseif ($_GET['id']=='yandu'){
$posyandu=$_POST['posyandu'];
$sql="SELECT ref_yandu.id_lokasi AS id_lokasi, ref_lokasi.dusun AS dusun FROM ref_yandu LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = ref_yandu.id_lokasi WHERE ref_yandu.id_refyandu ='$posyandu'  LIMIT 1 ";
		if ($r=mysqli_query($konek,$sql)){
				$jumlah=mysqli_num_rows($r);
					if($jumlah > 0 ){
					while ($q=mysqli_fetch_array($r)) {
						echo $respon=$q['id_lokasi']."/".$q['dusun'];
					}
				}


					else{

					echo $respon="0/null";
				}


		}else{
			echo $respon="0/null";
		}
}elseif ($_GET['id']=='ceknik2'){
$nik=$_POST['nik'];
$sql="SELECT tb_warga.jk AS jk , tb_warga.nik As nik ,tb_warga.nama AS nama ,ref_lokasi.dusun AS dusun FROM tb_warga LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_warga.nik='$nik' AND tb_warga.jk ='Laki-laki' LIMIT 1 ";
		if ($r=mysqli_query($konek,$sql)){
				$jumlah=mysqli_num_rows($r);
					if($jumlah > 0 ){
					while ($q=mysqli_fetch_array($r)) {
						echo $respon="1/".$q['nama']."/".$q['dusun'];
					}
				}


					else{

					echo $respon="0/null";
				}


		}else{
			echo $respon="0/null";
		}
}elseif ($_GET['id']=='get_image'){
$sql="SELECT * FROM tb_image ORDER BY id_image DESC";
		if ($r=mysqli_query($konek,$sql)){
				$jumlah=mysqli_num_rows($r);
					if($jumlah > 0 ){
						$q = mysqli_fetch_assoc($r);
						echo $respon=$q['waktu_upload']."|"."<img src='./upload/".$q['gambar']."' alt='realtime_image'>";			
					}
					else{

					echo $respon="0/null";
					}


		}else{
			echo $respon="error/null";
		}
}elseif($_GET['id']=='get_data_latest'){
    $sql1=mysqli_query($konek,"SELECT * FROM tb_suhu order by id_suhu desc limit 1");
    $sql2=mysqli_query($konek,"SELECT * FROM tb_kualitasudara order by id_ku desc limit 1");
    $sql3=mysqli_query($konek,"SELECT * FROM tb_kelembaban order by id_kl desc limit 1");
                               
                                
    if($sql1 && $sql2 && $sql3){
        $row1=mysqli_fetch_assoc($sql1);
        $suhu = $row1['nilai_suhu'];
        $row2=mysqli_fetch_assoc($sql2);
        $ku =$row2['n_ku'];
        $row3=mysqli_fetch_assoc($sql3);
        $kl =$row3['n_kl'];
        
        $respon['suhu'] = $suhu;
        $respon['ppm'] = $ku;
        $respon['kl'] = $kl;
        
        echo json_encode($respon);
    }
    
}

?>