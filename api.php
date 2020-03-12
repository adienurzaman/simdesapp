<?php
// header("Content-type:application/json");
include "config/koneksi.php";
include "notifikasi.php";
//echo "Succesfully Connected";

if ($_GET['id']=='wemos1_receive'){
		
		$suhu=$_POST['nilai_suhu'];
		$kelembaban=$_POST['n_kl'];
		$kualitasudara=$_POST['n_ku'];
		$sku=$_POST['s_ku'];
		$tgl_skrng = date('Y-m-d');
		$waktu_skrng = date('H:i:s');
		$wemos =$_POST['id_wemos'];

		$sqlsuhu="INSERT INTO tb_suhu (id_wemos,tgl_suhu,waktu_suhu,nilai_suhu) VALUES ('$wemos','$tgl_skrng','$waktu_skrng','$suhu')";
		$sqlkelembaban="INSERT INTO tb_kelembaban (id_wemos,tgl_kl,w_kl,n_kl) VALUES ('$wemos','$tgl_skrng','$waktu_skrng','$kelembaban')";   
		$sqlkualitasudara="INSERT INTO tb_kualitasudara (id_wemos,tgl_ku,w_ku,n_ku,s_ku) VALUES ('$wemos','$tgl_skrng','$waktu_skrng','$kualitasudara','$sku')";  
		
		if (mysqli_query($konek,$sqlsuhu)){
			mysqli_query($konek,$sqlkelembaban);
			mysqli_query($konek,$sqlkualitasudara);
		    /*$judul=" Wemos 1";
		    $isi_pesan="Data Terkirim";

		    notifikasi($judul,$isi_pesan);*/

			$response['success'] = true;
			$response['message'] = "Successfully";


		    echo $respon="berhasil";
		}
		else{
		    echo $respon="gagal";
		    $response['success'] = false;
			$response['message'] = "Failure";
			http_response_code(400);
		}
		echo json_encode($response);

}elseif ($_GET['id']=='wemos2_receive'){
		$sensorapi=$_POST['n_kebakaran'];
		$gempa=$_POST['n_gempa'];
		$jp=$_POST['jenis_pesan'];
		$deskripsi=$_POST['deskripsi'];
		$ssensorapi=$_POST['s_kebakaran'];
		$sgempa=$_POST['s_gempa'];
		$tgl_skrng = date('Y-m-d');
		$waktu_skrng = date('H:i:s');
		$wemos =$_POST['id_wemos'];

		
		$sqlapi="INSERT INTO tb_kebakaran (id_wemos,t_kebakaran,w_kebakaran,n_kebakaran,s_kebakaran) VALUES ('$wemos','$tgl_skrng','$waktu_skrng','$sensorapi','$ssensorapi')";
		$sqlgempa="INSERT INTO tb_gempa (id_wemos,t_gempa,w_gempa,n_gempa,s_gempa) VALUES ('$wemos','$tgl_skrng','$waktu_skrng','$gempa','$sgempa')";   
		$sqlkeamanan="UPDATE tb_keamanan SET id_wemos = '$wemos', tgl_keamanan = '$tgl_skrng', waktu_keamanan = '$waktu_skrng', jenis_pesan = '$jp', deskripsi = '$deskripsi' WHERE id_keamanan = '1' ";
		
		if (mysqli_query($konek,$sqlapi)){
			mysqli_query($konek,$sqlgempa);
			mysqli_query($konek,$sqlkeamanan);
			
			/* $judul="Wemos 2";
		    $isi_pesan="Data Terkirim ?";

		    notifikasi($judul,$isi_pesan);		  */  

			if($ssensorapi == 'kebakaran'){
				
				$judul="Terjadi Kebakaran";
			    $isi_pesan="Cepat Merapat Ke Smart POLE" ;

			    notifikasi($judul,$isi_pesan);

			}

			if($jp == 'kriminal'){
							
							$judul="Terjadi Kriminalitas";
						    $isi_pesan= $deskripsi ;

						    notifikasi($judul,$isi_pesan);

						}

			if($jp == 'musibah'){
							
							$judul="Terjadi Musibah";
						    $isi_pesan= $deskripsi ;

						    notifikasi($judul,$isi_pesan);

						}
			
			 if($sgempa == 'Terjadi gempa ringan'){

				$judul="Terjadi Gempa Ringan";
			    $isi_pesan="Gempa Sebesar ".$gempa ;
			
				notifikasi($judul,$isi_pesan);
			}

		    echo $respon="berhasil";
		    $response['success'] = true;
			$response['message'] = "Successfully";
			http_response_code(200);
		}
		else{
		    echo $respon="gagal";
		    $response['success'] = false;
			$response['message'] = "Failure";
			http_response_code(400);
		}
		echo json_encode($response);

	}elseif ($_GET['id']=='login'){
	
				
		if ($_SERVER['REQUEST_METHOD']=='POST') {

	    $nik = $_POST['nik'];
	    $password =  md5($_POST['password']);



	    $sql = "SELECT * FROM tb_user WHERE nik='$nik' ";

	    $response = mysqli_query($konek, $sql);

	    $result = array();
	    $result['login'] = array();
	    
	    if ( mysqli_num_rows($response) === 1 ) {
	        
	        $row = mysqli_fetch_assoc($response);

	        if ( $password===$row['password'] ) {
	            
	            $index['level_user'] = $row['level_user'];
	            $index['nik'] = $row['nik'];
	            $index['id_user'] = $row['id_user'];

	            array_push($result['login'], $index);

	            $result['success'] = "1";
	            $result['message'] = "success";
	            echo json_encode($result);

	            mysqli_close($konek);

	        } else {

	            $result['success'] = "0";
	            $result['message'] = "error";
	            echo json_encode($result);
	            http_response_code(400);

	            mysqli_close($konek);

	        }

	    }

}
	}elseif ($_GET['id']=='get_user'){
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
		$sql = "SELECT * FROM tb_user limit 1";
		$result = $konek->query($sql);
		
		$response = array();
		
		while ($row = mysqli_fetch_array($result) ) {
		    array_push($response,
		    array(
		        'id' => $row['id_user'],
		        'nik' => $row['nik'],
		        'level_user' => $row['level_user'],
		        's_user' => $row['s_user'])
		    );
		    http_response_code(200);
		}
		
		}else{
	    $response['success'] = false;
	    $response['message'] = "Error !";
	    http_response_code(400);
	}
	echo json_encode($response);

}elseif ($_GET['id']=='save_user'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$nik = $_POST['nik'];
	    $pass = $_POST['password'];
	    $password = md5($pass);
	    $level_user = $_POST['level_user'];
	    $s_user = $_POST['s_user'];
	    $panjang = strlen($nik);

	    if($panjang == 16){

			$query = "INSERT INTO tb_user (nik, password, level_user, s_user) VALUES ('$nik','$password','$level_user','$s_user') ";
		    
		    if( mysqli_query($konek,$query) ){
		        $response['success'] = true;
		        $response['message'] = "Successfully";
		        http_response_code(200);
		        echo json_encode($response);
		    }else{
		        $response['success'] = false;
		        $response['message'] = "Failure";
		        echo json_encode($response);
		    }
	    	
	    }else{

			http_response_code(400);
	    	$response['success'] = false;
	        $response['message'] = "NIK Tidak Sesuai";
	        echo json_encode($response);

	    }    
	}else{
	    $response['success'] = false;
	    $response['message'] = "Error !";
	    echo json_encode($response);
	}
    
}elseif ($_GET['id']=='update_user'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
		$id = $_POST['id'];
		$nik = $_POST['nik'];
	    $password = $_POST['password'];
	    $level_user = $_POST['level_user'];
	    $s_user = $_POST['s_user'];
	    $panjang = strlen($nik);
	 	
	 	if($panjang == 16){

			$query = "UPDATE tb_user SET nik = '$nik', password = '$password', level_user = '$level_user', s_user ='$s_user' WHERE id_user = '$id' ";

			if (mysqli_query($konek, $query)){
				
				$response['success'] = true;
				$response['message'] = "Successfully";

			} else {

				$response['success'] = false;
				$response['message'] = "Failure!";
			}
		}else{

			http_response_code(400);
	    	$response['success'] = false;
	        $response['message'] = "NIK Tidak Sesuai";
	        echo json_encode($response);

	    }
 	} else {

		$response['success'] = false;
		$response['message'] = "Error!";
		http_response_code(400);
	}

	echo json_encode($response);

}elseif ($_GET['id']=='delete_user'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	$id = $_POST['id'];

		$query = "DELETE FROM tb_user WHERE id_user = '$id' ";

		if (mysqli_query($konek, $query)){
		
		$response['success'] = true;
		$response['message'] = "Successfully";

		} else {

		$response['success'] = false;
		$response['message'] = "Failure!";
		  http_response_code(400);
		}

	} else {

	$response['success'] = false;
	$response['message'] = "Error!";
	http_response_code(400);
	}

	echo json_encode($response);

}elseif ($_GET['id']=='get_warga'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			$sql = "SELECT * FROM tb_warga limit 1";

			$result = $konek->query($sql);
	
			$response = array();
	
			while ($row = mysqli_fetch_array($result) ) {
	    	array_push($response,
	    	array(
		        'id' => $row['id_warga'],
		        'nik' => $row['nik'],
		        'nokk' => $row['nokk'],
		        'nama' => $row['nama'],
		        'tempat_lahir' => $row['tempat_lahir'],
		        'tanggal_lahir' => $row['tanggal_lahir'],
		        'jk' => $row['jk'],
		        'gol_darah' => $row['gol_darah'],
		        'rt' => $row['rt'],
		        'rw' => $row['rw'],
		        'id_lokasi' => $row['id_lokasi'],
		        'desa' => $row['desa'],
		        'kecamatan' => $row['kecamatan'],
		        'kabupaten' => $row['kabupaten'],
		        'agama' => $row['agama'],
		        's_perkawinan' => $row['s_perkawinan'],
		        'kewarganegaraan' => $row['kewarganegaraan'],
		        'jabatan' => $row['jabatan']
		        )
	    		);
	    	http_response_code(200);
			}
	
		}else{
	    
	    $response['success'] = false;
	    $response['message'] = "Error !";
	    http_response_code(400);
		
		}
		echo json_encode($response);

	
}elseif ($_GET['id']=='save_warga'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $nik = $_POST['nik'];
    $nokk = $_POST['nokk'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jk'];
    $gol_darah = $_POST['gol_darah'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $id_lokasi = $_POST['id_lokasi'];
    $desa = $_POST['desa'];
    $kecamatan = $_POST['kecamatan'];
    $kabupaten = $_POST['kabupaten'];
    $agama = $_POST['agama'];
    $s_perkawinan = $_POST['s_perkawinan'];
    $kewarganegaraan = $_POST['kewarganegaraan'];
    $jabatan = $_POST['jabatan'];
    $panjang = strlen($nik);
    $panjang1 = strlen($nokk);

    	if($panjang == 0){
	    	
	    	http_response_code(400);
	    	$response['success'] = false;
	        $response['message'] = "NIK Kosong";


    	}else if($panjang > 0 && $panjang < 16){


			http_response_code(400);
	    	$response['success'] = false;
	        $response['message'] = "NIK Kurang";



	    }else if($panjang == 16){


    		$query = "INSERT INTO tb_warga (nik,
    										nokk,
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
    										jabatan) VALUES ('$nik',
    														 '$nokk',
    														 '$nama',
    														 '$tempat_lahir',
    														 '$tanggal_lahir',
    														 '$jk',
    														 '$gol_darah',
    														 '$rt',
    														 '$rw',
    														 '$id_lokasi',
    														 '$desa',
    														 '$kecamatan',
    														 '$kabupaten',
    														 '$agama',
    														 '$s_perkawinan',
    														 '$kewarganegaraan',
    														 '$jabatan'
    														 ) ";
    
		    if( mysqli_query($konek,$query) ){
		        $response['success'] = true;
		        $response['message'] = "Successfully";
		        http_response_code(200);
		    }else{
		        $response['success'] = false;
		        $response['message'] = "tidak tersimpan";
		         http_response_code(400);
		    }
		    	
		 }else{

			http_response_code(400);
		    $response['success'] = false;
		    $response['message'] = "NIK Berlebih";

		 }

    
	}else{
	    $response['success'] = false;
	    $response['message'] = "Error !";
	}
	    

	echo json_encode($response);


	}elseif ($_GET['id']=='update_warga'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
	    
		$id = $_POST['id'];
		 $nik = $_POST['nik'];
	    $nokk = $_POST['nokk'];
	    $nama = $_POST['nama'];
	    $tempat_lahir = $_POST['tempat_lahir'];
	    $tanggal_lahir = $_POST['tanggal_lahir'];
	    $jk = $_POST['jk'];
	    $gol_darah = $_POST['gol_darah'];
	    $rt = $_POST['rt'];
	    $rw = $_POST['rw'];
	    $id_lokasi = $_POST['id_lokasi'];
	    $desa = $_POST['desa'];
	    $kecamatan = $_POST['kecamatan'];
	    $kabupaten = $_POST['kabupaten'];
	    $agama = $_POST['agama'];
	    $s_perkawinan = $_POST['s_perkawinan'];
	    $kewarganegaraan = $_POST['kewarganegaraan'];
	    $jabatan = $_POST['jabatan'];
		$panjang = strlen($nik);

			if($panjang== 0){
		    	
		    	http_response_code(400);
		    	$response['success'] = false;
		        $response['message'] = "NIK Kosong";


	    	}else if($panjang > 0 && $panjang < 16){


				http_response_code(400);
		    	$response['success'] = false;
		        $response['message'] = "NIK Kurang";



		    }else if($panjang == 16){


			$query = "UPDATE tb_warga SET nik = '$nik',
										  nokk = '$nokk',
										  nama = '$nama',
										  tempat_lahir = '$tempat_lahir',
										  tanggal_lahir = '$tanggal_lahir',
										  jk = '$jk',
										  gol_darah = '$gol_darah',
										  rt = '$rt',
										  rw = '$rw',
										  id_lokasi = '$id_lokasi',
										  desa = '$desa',
										  kecamatan = '$kecamatan',
										  kabupaten = '$kabupaten',
										  agama = '$agama',
										  s_perkawinan = '$s_perkawinan',
										  kewarganegaraan = '$kewarganegaraan',
										  jabatan = '$jabatan'
										  				 WHERE id_warga = '$id' ";

				if (mysqli_query($konek, $query)){
					
					$response['success'] = true;
					$response['message'] = "Successfully";

				} else {

					$response['success'] = false;
					$response['message'] = "Failure!";
				}

			 }else{

				http_response_code(400);
			    $response['success'] = false;
			    $response['message'] = "NIK Berlebih";

		 	}


	} else {

		$response['success'] = false;
		$response['message'] = "Error!";
	}

		echo json_encode($response);


	}elseif ($_GET['id']=='delete_warga'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		    
			$id = $_POST['id'];

			$query = "DELETE FROM tb_warga WHERE id_warga = '$id' ";

			if (mysqli_query($konek, $query)){
				
				$response['success'] = true;
				$response['message'] = "Successfully";

			} else {

				$response['success'] = false;
				$response['message'] = "Failure!";
				http_response_code(400);
			}

		} else {

				$response['success'] = false;
				$response['message'] = "Error!";
				http_response_code(400);
		}

		echo json_encode($response);
	}elseif ($_GET['id']=='get_riwayat'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			$sql = "SELECT tb_riwayat.id_riwayat as id_riwayat , tb_warga.nama as nama , tb_riwayat.riwayat as riwayat , tb_riwayat.tgl_riwayat as tgl_riwayat FROM tb_riwayat LEFT JOIN tb_warga ON tb_warga.nik=tb_riwayat.nik  limit 1";

			$result = $konek->query($sql);
	
			$response = array();
	
			while ($row = mysqli_fetch_array($result) ) {
	    	array_push($response,
	    	array(
		        'id' => $row['id_riwayat'],
		        'namapasien' => $row['nama'],
		        'penyakitpasien' => $row['riwayat'],
		        'tanggalsakit' => $row['tgl_riwayat'])
	    		);
	    	http_response_code(200);
			}
	
		}else{
	    
	    $response['success'] = false;
	    $response['message'] = "Error !";
	    http_response_code(400);
		
		}
		echo json_encode($response);

	
	}elseif ($_GET['id']=='save_riwayat'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	    $nik = $_POST['nik'];
	    $riwayat = $_POST['riwayat'];
	    $tgl_riwayat = date('Y-m-d');
	    $panjang = strlen($nik);

    	if($panjang== 0){
	    	
	    	http_response_code(400);
	    	$response['success'] = false;
	        $response['message'] = "NIK Kosong";


    	}else if($panjang > 0 && $panjang < 16){


			http_response_code(400);
	    	$response['success'] = false;
	        $response['message'] = "NIK Kurang";



	    }else if($panjang == 16){


    		$query = "INSERT INTO tb_riwayat (nik, riwayat, tgl_riwayat) VALUES ('$nik','$riwayat','$tgl_riwayat') ";
    
		    if( mysqli_query($konek,$query) ){
		        $response['success'] = true;
		        $response['message'] = "Successfully";
		        http_response_code(200);
		    }else{
		        $response['success'] = false;
		        $response['message'] = "Failure";
		    }
		    	
		 }else{

			http_response_code(400);
		    $response['success'] = false;
		    $response['message'] = "NIK Berlebih";

		 }

    
	}else{
	    $response['success'] = false;
	    $response['message'] = "Error !";
	}
	    

	echo json_encode($response);


	}elseif ($_GET['id']=='update_riwayat'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
	    
		$id = $_POST['id'];
		$nik = $_POST['nik'];
		$riwayat = $_POST['riwayat'];
		$panjang = strlen($nik);

			if($panjang== 0){
		    	
		    	http_response_code(400);
		    	$response['success'] = false;
		        $response['message'] = "NIK Kosong";


	    	}else if($panjang > 0 && $panjang < 16){


				http_response_code(400);
		    	$response['success'] = false;
		        $response['message'] = "NIK Kurang";




		    }else if($panjang == 16){


			$query = "UPDATE tb_riwayat SET nik = '$nik', riwayat = '$riwayat' WHERE id_riwayat = '$id' ";

				if (mysqli_query($konek, $query)){
					
					$response['success'] = true;
					$response['message'] = "Successfully";

				} else {

					$response['success'] = false;
					$response['message'] = "Failure!";
					http_response_code(400);
				}

			 }else{

				http_response_code(400);
			    $response['success'] = false;
			    $response['message'] = "NIK Berlebih";

		 	}


	} else {

		$response['success'] = false;
		$response['message'] = "Error!";
	}

		echo json_encode($response);


	}elseif ($_GET['id']=='delete_riwayat'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		    
			$id = $_POST['id'];

			$query = "DELETE FROM tb_riwayat WHERE id_riwayat = '$id' ";

			if (mysqli_query($konek, $query)){
				
				$response['success'] = true;
				$response['message'] = "Successfully";

			} else {

				$response['success'] = false;
				$response['message'] = "Failure!";
				http_response_code(400);
			}

		} else {

				$response['success'] = false;
				$response['message'] = "Error!";
				http_response_code(400);
		}

		echo json_encode($response);

	}elseif ($_GET['id']=='get_ronda'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
			$sql = "SELECT tb_ronda.id_ronda As id_ronda, tb_ronda.nik AS nik, tb_warga.nama AS nama, ref_lokasi.dusun AS dusun, ref_hari.hari AS hari FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi LEFT JOIN ref_hari ON ref_hari.id_hari = tb_ronda.id_hari ";

			$result = $konek->query($sql);
	
			$response = array();

			while ($row = mysqli_fetch_array($result) ) {
	    		array_push($response,
	    		array(
		        'id' => $row['id_ronda'],
		        'nik' => $row['nik'],
		        'nama' => $row['nama'],
		        'dusun' => $row['dusun'],
		        'hari' => $row['hari']
		        )
			    );
	    
			}
	
		}else{
    		$response['success'] = false;
    		$response['message'] = "Error !";
    		http_response_code(400);
	}
		echo json_encode($response);


}elseif ($_GET['id']=='save_ronda'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
		$nik = $_POST['nik'];
    	$id_hari = $_POST['id_hari'];
    
   		 $query = "INSERT INTO tb_ronda (nik, id_hari) VALUES ('$nik','$id_hari')";
    
	    if( mysqli_query($konek,$query) ){
	        $response['success'] = true;
	        $response['message'] = "Successfully";
	    }else{
	        $response['success'] = false;
	        $response['message'] = "Failure";
	        http_response_code(400);
	    }
    
	}else{
   		$response['success'] = false;
    	$response['message'] = "Error !";
    	http_response_code(400);
	}
    

		echo json_encode($response);

	}elseif ($_GET['id']=='update_ronda'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		   $id_ronda = $_POST['id'];
			$nik = $_POST['nik'];
			$id_hari = $_POST['id_hari'];

			$query = "UPDATE tb_ronda SET nik = '$nik', id_hari = '$id_hari' WHERE id_ronda = '$id_ronda'";

			if (mysqli_query($konek, $query)){
				
				$response['success'] = true;
				$response['message'] = "Successfully";

			} else {

				$response['success'] = false;
				$response['message'] = "Failure!";
				http_response_code(400);
			}

		} else {

				$response['success'] = false;
				$response['message'] = "Error!";
				http_response_code(400);
		}

		echo json_encode($response);


	}elseif ($_GET['id']=='delete_ronda'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
  
		$id_ronda = $_POST['id'];

		$query = "DELETE FROM tb_ronda WHERE id_ronda = '$id_ronda' ";

			if (mysqli_query($konek, $query)){
		
				$response['success'] = true;
				$response['message'] = "Successfully";

			} else {

				$response['success'] = false;
				$response['message'] = "Failure!";
				http_response_code(400);
			}

		} else {

		$response['success'] = false;
		$response['message'] = "Error!";
		http_response_code(400);
		}

		echo json_encode($response);

	}elseif ($_GET['id']=='get_posyandu'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
  
			$sql = "SELECT tb_yandu.id_yandu AS id_yandu , ref_yandu.posyandu AS posyandu, tb_yandu.tgl_yandu AS tgl_yandu, ref_lokasi.dusun AS dusun, tb_yandu.waktu_yandu AS waktu_yandu FROM tb_yandu LEFT JOIN ref_yandu ON ref_yandu.id_refyandu = tb_yandu.id_refyandu LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = ref_yandu.id_lokasi ";
			$result = $konek->query($sql);
	
			$response = array();
	
			while ($row = mysqli_fetch_array($result) ) {
	    		array_push($response,
	    		array(
	        		'id' => $row['id_yandu'],
			        'posyandu' => $row['posyandu'],
			        'dusun' => $row['dusun'],
			        'tanggal' => $row['tgl_yandu'],
			        'waktu' => $row['waktu_yandu']
			        )
			    );
	    
			}
	
		}else{
	    $response['success'] = false;
	    $response['message'] = "Error !";
		http_response_code(400);
			}
		echo json_encode($response);

	}elseif ($_GET['id']=='save_posyandu'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		    $id_refyandu = $_POST['id_refyandu'];
		    $tgl_yandu = $_POST['tgl_yandu'];
		    $waktu_yandu = $_POST['waktu_yandu'];
		    
   			$query = "INSERT INTO tb_yandu (id_refyandu, tgl_yandu, waktu_yandu) VALUES ('$id_refyandu','$tgl_yandu','$waktu_yandu')";
    
		    if( mysqli_query($konek,$query) ){
		        $response['success'] = true;
		        $response['message'] = "Successfully";
		    }else{
		        $response['success'] = false;
		        $response['message'] = "Failure";
		    	http_response_code(400);
		    }
    
		}else{
    		$response['success'] = false;
    		$response['message'] = "Error !";
			http_response_code(400);
		}
    

		echo json_encode($response);

	}elseif ($_GET['id']=='update_posyandu'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     
		$id_posyandu = $_POST['id'];
		$tgl_yandu = $_POST['tgl_yandu'];
		$waktu_yandu = $_POST['waktu_yandu'];
		

		$query = "UPDATE tb_yandu SET  tgl_yandu = '$tgl_yandu', waktu_yandu='$waktu_yandu' WHERE id_yandu = '$id_posyandu' ";

			if (mysqli_query($konek, $query)){
				
				$response['success'] = true;
				$response['message'] = "Successfully";

			} else {

				$response['success'] = false;
				$response['message'] = "Failure!";
				http_response_code(400);
			}

		} else {

		$response['success'] = false;
		$response['message'] = "Error!";
		http_response_code(400);
		}

		echo json_encode($response);

	}elseif ($_GET['id']=='delete_posyandu'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
     
			$id_yandu = $_POST['id'];

			$query = "DELETE FROM tb_yandu WHERE id_yandu = '$id_yandu' ";

			if (mysqli_query($konek, $query)){
				
				$response['success'] = true;
				$response['message'] = "Successfully";

			} else {

				$response['success'] = false;
				$response['message'] = "Failure!";
			}

		} else {

			$response['success'] = false;
			$response['message'] = "Error!";
		}

		echo json_encode($response);

	}elseif ($_GET['id']=='get_suhu'){

    
			$sql = "SELECT * FROM tb_suhu  order by id_suhu DESC limit 1 ";

			$response = mysqli_query($konek, $sql);

    $result = array();
    $result['read'] = array();

    if( mysqli_num_rows($response) === 1 ) {
        
        if ($row = mysqli_fetch_assoc($response)) {
 
             $h['ph']        = $row['nilai_suhu'] ;
 
             array_push($result["read"], $h);
 
             $result["success"] = "1";
             echo json_encode($result);
        }
 
   }
	}elseif ($_GET['id']=='get_nilaikelembapan'){

    
			$sql = "SELECT * FROM tb_kelembaban  order by id_kl DESC limit 1 ";

			$response = mysqli_query($konek, $sql);

    $result = array();
    $result['read'] = array();

    if( mysqli_num_rows($response) === 1 ) {
        
        if ($row = mysqli_fetch_assoc($response)) {
 
             $h['n_kl']        = $row['n_kl'] ;
 
             array_push($result["read"], $h);
 
             $result["success"] = "1";
             echo json_encode($result);
        }
 
   }
	}elseif ($_GET['id']=='get_nilaikualitas'){

    
			$sql = "SELECT * FROM tb_kualitasudara  order by id_ku DESC limit 1 ";

			$response = mysqli_query($konek, $sql);

            $result = array();
            $result['read'] = array();

    if( mysqli_num_rows($response) === 1 ) {
        
        if ($row = mysqli_fetch_assoc($response)) {
 
             $h['Nilai']        = $row['n_ku'] ;
              $h['Keterangan']        = $row['s_ku'] ;
 
             array_push($result["read"], $h);
 
             $result["success"] = "1";
             echo json_encode($result);
        }
 
   }
	
	}elseif ($_GET['id']=='get_gempa'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
			$sql = "SELECT * FROM tb_gempa ";

			$result = $konek->query($sql);
	
			$response = array();

			while ($row = mysqli_fetch_array($result) ) {
	    		array_push($response,
	    		array(
		        'id' => $row['id_gempa'],
		        'id_wemos' => $row['id_wemos'],
		        'Tanggal' => $row['t_gempa'],
		        'Waktu' => $row['w_gempa'],
		        'Nilai' => $row['n_gempa'],
		        'Simpulan' => $row['s_gempa']
		        )
			    );
	    
			}
	
		}else{
    		$response['success'] = false;
    		$response['message'] = "Error !";
    		http_response_code(400);
		}
	
		echo json_encode($response);

	}elseif ($_GET['id']=='get_kebakaran'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
			$sql = "SELECT * FROM tb_kebakaran ";

			$result = $konek->query($sql);
	
			$response = array();

			while ($row = mysqli_fetch_array($result) ) {
	    		array_push($response,
	    		array(
		        'id' => $row['id_kebakaran'],
		        'id_wemos' => $row['id_wemos'],
		        'Tanggal' => $row['t_kebakaran'],
		        'Waktu' => $row['w_kebakaran'],
		        'Nilai' => $row['n_kebakaran'],
		        'Simpulan' => $row['s_kebakaran']
		        )
			    );

			$response['success'] = true;
    		$response['message'] = "Successfully !";
    		http_response_code(200);
	    
			}
	
		}else{
    		$response['success'] = false;
    		$response['message'] = "Error !";
    		http_response_code(400);
		}
		echo json_encode($response);
		
	}elseif ($_GET['id']=='get_kelembaban'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
			$sql = "SELECT * FROM tb_kelembaban ";

			$result = $konek->query($sql);
	
			$response = array();

			while ($row = mysqli_fetch_array($result) ) {
	    		array_push($response,
	    		array(
		        'id' => $row['id_kl'],
		        'id_wemos' => $row['id_wemos'],
		        'Tanggal' => $row['tgl_kl'],
		        'Waktu' => $row['w_kl'],
		        'Nilai' => $row['n_kl']
		        
		        )
			    );

			$response['success'] = true;
    		$response['message'] = "Successfully !";
    		http_response_code(200);
	    
			}
	
		}else{
    		$response['success'] = false;
    		$response['message'] = "Error !";
    		http_response_code(400);
		}
		echo json_encode($response);
		
	}elseif ($_GET['id']=='get_kualitasudara'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
			$sql = "SELECT * FROM tb_kualitasudara ";

			$result = $konek->query($sql);
	
			$response = array();

			while ($row = mysqli_fetch_array($result) ) {
	    		array_push($response,
	    		array(
		        'id' => $row['id_ku'],
		        'id_wemos' => $row['id_wemos'],
		        'Tanggal' => $row['tgl_ku'],
		        'Waktu' => $row['w_ku'],
		        'Nilai' => $row['n_ku'],
		        'Keterangan' => $row['s_ku']
		        
		        )
			    );

			$response['success'] = true;
    		$response['message'] = "Successfully !";
    		http_response_code(200);
	    
			}
	
		}else{
    		$response['success'] = false;
    		$response['message'] = "Error !";
    		http_response_code(400);
		}
		echo json_encode($response);
		

	}elseif ($_GET['id']=='get_keamanan'){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
			$sql = "SELECT * FROM tb_keamanan ";

			$result = $konek->query($sql);
	
			$response = array();

			while ($row = mysqli_fetch_array($result) ) {
	    		array_push($response,
	    		array(
		        'id' => $row['id_keamanan'],
		        'id_wemos' => $row['id_wemos'],
		        'nik' => $row['nik'],
		        'jenis_pesan' => $row['jenis_pesan'],
		        'deskripsi' => $row['deskripsi'],
		        'tgl_keamanan' => $row['tgl_keamanan'],
		        'waktu_keamanan' => $row['waktu_keamanan']
		        )
			    );

			$response['success'] = true;
    		$response['message'] = "Successfully !";
    		http_response_code(200);
	    
			}
	
		}else{
    		$response['success'] = false;
    		$response['message'] = "Error !";
    		http_response_code(400);
		}
		echo json_encode($response);

	}elseif ($_GET['id']=='save_keamanan'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nik=$_POST['nik'];
    $tgl_keamanan=date('Y-m-d');
    $waktu_keamanan=date('h:i:sa');
    $deskripsi = $_POST['deskripsi'];
    $jenis_pesan = $_POST['jenis_pesan'];
    
    $query = "INSERT INTO tb_keamanan (nik, jenis_pesan,deskripsi,tgl_keamanan,waktu_keamanan) VALUES ('$nik','$jenis_pesan','$deskripsi','$tgl_keamanan','$waktu_keamanan')";
    
	    if( mysqli_query($konek,$query) ){
	        $response['success'] = true;
	        $response['message'] = "Pesan Terkirim";
	        http_response_code(200);

	        if($jenis_pesan == 'Kriminalitas'){
							
							$judul="Terjadi Kriminalitas";
						    $isi_pesan= $deskripsi ;

						    notifikasi($judul,$isi_pesan);

						}

			if($jenis_pesan == 'Musibah'){
							
							$judul="Terjadi Musibah";
						    $isi_pesan= $deskripsi ;

						    notifikasi($judul,$isi_pesan);

						}
	    }else{
	        $response['success'] = false;
	        $response['message'] = "Gagal Terkirim";
	        http_response_code(400);
	    }
	    
	}else{
    $response['success'] = false;
    $response['message'] = "Error !";
    http_response_code(400);
	}
    

	echo json_encode($response);
		

	}elseif ($_GET['id']=='push_kebakaran'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		    
		    
		    $query = "SELECT * FROM tb_kebakaran WHERE ')";
    
		    if( mysqli_query($konek,$query) ){
		        $response['success'] = true;
		        $response['message'] = "Pesan Terkirim";
		        http_response_code(200);
		    }else{
		        $response['success'] = false;
		        $response['message'] = "Gagal Terkirim";
		        http_response_code(400);
		    }
		    
		}else{
	    $response['success'] = false;
	    $response['message'] = "Error !";
	    http_response_code(400);
		}
	    

		echo json_encode($response);
		


	}elseif ($_GET['id']=='get_data_riwayatsakit'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		   $id=$_POST['id'];
		   //cari data level by id (nik)
		   $cari_data = "SELECT * FROM tb_user WHERE nik = '$id' limit 1 ";
		   $query = mysqli_query($konek,$cari_data);
		   
		   //proses cari level
		   $row = mysqli_fetch_assoc($query);
		   
		   $level_user = $row['level_user'];
		   
		   if($level_user == 'Admin'){
		       $sql = "SELECT * FROM tb_riwayat";
	           $result = $konek->query($sql);
	
	           $response = array();
	
	           while ($row = mysqli_fetch_array($result) ) {
	            array_push($response,
	            array(
	                'id' => $row['id_riwayat'],
    	            'namapasien' => $row['nik'],
    	            'penyakitpasien' => $row['riwayat'],
    	            'tanggalsakit' => $row['tgl_riwayat'])
	            );
	    
	            }

                echo json_encode($response);
		   }else{
		        $sql = "SELECT * FROM tb_riwayat where nik='$id' ";
	           $result = $konek->query($sql);

	
	           $response = array();
	
	           while ($row = mysqli_fetch_array($result) ) {
	            array_push($response,
	            array(
	                'id' => $row['id_riwayat'],
    	            'namapasien' => $row['nik'],
    	            'penyakitpasien' => $row['riwayat'],
    	            'tanggalsakit' => $row['tgl_riwayat'])
	            );
	    
	            }

                echo json_encode($response);
		   }
    }
}
	elseif ($_GET['id']=='get_save_riwayatsakit'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nik = $_POST['namapasien'];
    $riwayat = $_POST['penyakitpasien'];
    $tgl_riwayat = date('Y-m-d');
    
    $query = "INSERT INTO tb_riwayat (nik, riwayat, tgl_riwayat) VALUES ('$nik','$riwayat','$tgl_riwayat') ";
    
    if( mysqli_query($konek,$query) ){
        $response['success'] = true;
        $response['message'] = "Successfully";
    }else{
        $response['success'] = false;
        $response['message'] = "Failure";
    }
    
}else{
    $response['success'] = false;
    $response['message'] = "Error !";
}
    

echo json_encode($response);
	
	}
		elseif ($_GET['id']=='get_update_riwayatsakit'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	$id = $_POST['id'];
	$namapasien = $_POST['namapasien'];
	$penyakitpasien = $_POST['penyakitpasien'];

	$query = "UPDATE tb_riwayat SET nik = '$namapasien', riwayat = '$penyakitpasien' WHERE id_riwayat = '$id' ";

	if (mysqli_query($konek, $query)){
		
		$response['success'] = true;
		$response['message'] = "Successfully";

	} else {

		$response['success'] = false;
		$response['message'] = "Failure!";
	}

} else {

		$response['success'] = false;
		$response['message'] = "Error!";
}

echo json_encode($response);
}

elseif ($_GET['id']=='get_delete_riwayatsakit'){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	$id = $_POST['id'];

	$query = "DELETE FROM tb_riwayat WHERE id_riwayat = '$id' ";

	if (mysqli_query($konek, $query)){
		
		$response['success'] = true;
		$response['message'] = "Successfully";

	} else {

		$response['success'] = false;
		$response['message'] = "Failure!";
	}

} else {

		$response['success'] = false;
		$response['message'] = "Error!";
}

echo json_encode($response);	
}

elseif ($_GET['id']=='get_save_jadwalronda'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama_petugas = $_POST['namapetugas'];
    $id_hari = $_POST['id_hari'];
    
    $query = "INSERT INTO tb_ronda (nik, id_hari) VALUES ('$nama_petugas','$id_hari')";
    
    if( mysqli_query($konek,$query) ){
        $response['success'] = true;
        $response['message'] = "Successfully";
    }else{
        $response['success'] = false;
        $response['message'] = "Failure";
    }
    
}else{
    $response['success'] = false;
    $response['message'] = "Error !";
}
    

echo json_encode($response);


}

elseif ($_GET['id']=='get_data_jadwalronda'){
$sql = "SELECT * FROM tb_ronda, ref_hari, tb_warga where tb_ronda.id_hari=ref_hari.id_hari and tb_ronda.nik=tb_warga.nik Order By tb_ronda.id_hari asc ";
	$result = $konek->query($sql);
	
	$response = array();
	
	while ($row = mysqli_fetch_array($result) ) {
	    array_push($response,
	    array(
	        'id' => $row['id_ronda'],
	        'namapetugas' => $row['nama'],
	        'jadwalpetugas' => $row['hari'],
	        'nik' => $row['nik'],
	        'id_hari' => $row['id_hari']
	        )
	    );
	    
	}

echo json_encode($response);	
}

elseif ($_GET['id']=='get_update_jadwalronda'){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	$id_ronda = $_POST['id'];
	$nama_petugas = $_POST['namapetugas'];
	$id_hari = $_POST['id_hari'];

	$query = "UPDATE tb_ronda SET nik = '$nama_petugas', id_hari = '$id_hari' WHERE id_ronda = '$id_ronda'";

	if (mysqli_query($konek, $query)){
		
		$response['success'] = true;
		$response['message'] = "Successfully";

	} else {

		$response['success'] = false;
		$response['message'] = "Failure!";
	}

} else {

		$response['success'] = false;
		$response['message'] = "Error!";
}

echo json_encode($response);	
}

elseif ($_GET['id']=='get_delete_jadwalronda'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	$id_ronda = $_POST['id'];

	$query = "DELETE FROM tb_ronda WHERE id_ronda = '$id_ronda' ";

	if (mysqli_query($konek, $query)){
		
		$response['success'] = true;
		$response['message'] = "Successfully";

	} else {

		$response['success'] = false;
		$response['message'] = "Failure!";
	}

} else {

		$response['success'] = false;
		$response['message'] = "Error!";
}

echo json_encode($response);
}

elseif ($_GET['id']=='get_save_jadwalposyandu'){
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $tanggal_yandu = $_POST['tanggalyandu'];
    $waktu_yandu = $_POST['waktuyandu'];
    $idrefyandu = $_POST['idtempatposyandu'];
    
    $query = "INSERT INTO tb_yandu (id_refyandu, tgl_yandu, waktu_yandu) VALUES ('$idrefyandu','$tanggal_yandu','$waktu_yandu')";
    
    if( mysqli_query($konek,$query) ){
        $response['success'] = true;
        $response['message'] = "Successfully";
    }else{
        $response['success'] = false;
        $response['message'] = "Failure";
    }
    
}else{
    $response['success'] = false;
    $response['message'] = "Error !";
}
    

echo json_encode($response);	
}

elseif ($_GET['id']=='get_data_jadwalposyandu'){
	$sql = "SELECT * FROM tb_yandu, ref_yandu, ref_lokasi where tb_yandu.id_refyandu=ref_yandu.id_refyandu AND ref_yandu.id_lokasi=ref_lokasi.id_lokasi Order By tb_yandu.id_refyandu desc ";
	$result = $konek->query($sql);
	
	$response = array();
	
	while ($row = mysqli_fetch_array($result) ) {
	    array_push($response,
	    array(
	        'id' => $row['id_yandu'],
	        'lokasi' => $row['posyandu'],
	        'dusun' => $row['dusun'],
	        'id_posyandu' => $row['id_refyandu'],
	        'tgl_yandu' => $row['tgl_yandu'],
	        'waktuyandu' => $row['waktu_yandu'])
	    );
	    
	}

echo json_encode($response);
}

elseif ($_GET['id']=='get_update_jadwalposyandu'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	$id = $_POST['id'];
	$tanggal_posyandu = $_POST['tanggal_posyandu'];
	$waktu_yandu = $_POST['waktu_yandu'];
	$id_jadwalposyandu = $_POST['id_jadwal_posyandu'];

	$query = "UPDATE tb_yandu SET id_refyandu = '$id_jadwalposyandu', tgl_yandu = '$tanggal_posyandu', waktu_yandu= '$waktu_yandu' WHERE id_yandu = $id";

	if (mysqli_query($konek, $query)){
		$response['success'] = true;
		$response['message'] = "Successfully";

	} else {
		$response['success'] = false;
		$response['message'] = "Failure!";
	}

} else {

		$response['success'] = false;
		$response['message'] = "Error!";
}

echo json_encode($response);
}

elseif ($_GET['id']=='get_delete_jadwalposyandu'){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
	$id = $_POST['id'];

	$query = "DELETE FROM tb_yandu WHERE id_yandu = '$id'";

	if (mysqli_query($konek, $query)){
		
		$response['success'] = true;
		$response['message'] = "Successfully";

	} else {

		$response['success'] = false;
		$response['message'] = "Failure!";
	}

} else {

		$response['success'] = false;
		$response['message'] = "Error!";
}

echo json_encode($response);	
}

elseif ($_GET['id']=='get_save_keadaandarurat'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    header("Content-type:application/json");
    $nik=$_POST['getId'];
    $tgl_keamanan=date('Y-m-d');
    $waktu_keamanan=date('h:i:sa');
    $deskripsi = $_POST['pesandarurat'];
    $jenis_pesan = $_POST['jenispesan'];
    
    $q = "SELECT * FROM tb_keamanan";
    $aksi = mysqli_query($konek,$q);
    if($aksi){
        $jmlrow = mysqli_num_rows($aksi);
        if($jmlrow > 0){
            $query = "UPDATE tb_keamanan SET nik = '$nik', jenis_pesan = '$jenis_pesan', deskripsi = '$deskripsi', tgl_keamanan = '$tgl_keamanan', waktu_keamanan = '$waktu_keamanan' WHERE id_keamanan = '1' ";
        }else{
            $query = "INSERT INTO tb_keamanan (nik, jenis_pesan, deskripsi, tgl_keamanan, waktu_keamanan) VALUES ('$nik','$jenis_pesan','$deskripsi','$tgl_keamanan','$waktu_keamanan')";
        }
    }
    
    // $query = "INSERT INTO tb_keamanan (nik, jenis_pesan, deskripsi, tgl_keamanan, waktu_keamanan) VALUES ('$nik','$jenis_pesan','$deskripsi','$tgl_keamanan','$waktu_keamanan')";
    // $query = "UPDATE tb_keamanan SET nik = '$nik', jenis_pesan = '$jenis_pesan', deskripsi = '$deskripsi', tgl_keamanan = '$tgl_keamanan', waktu_keamanan = '$waktu_keamanan' WHERE id_keamanan = '1' ";
    
    if( mysqli_query($konek,$query) ){
        $response['success'] = true;
        $response['message'] = "Pesan Terkirim";
        
         if($jenis_pesan == "kriminal"){
							
						$judul="Terjadi Kriminalitas";
						$isi_pesan= $deskripsi ;

						notifikasi($judul,$isi_pesan);

						}

		if($jenis_pesan == 'musibah'){
							
						$judul="Terjadi Musibah";
					    $isi_pesan= $deskripsi ;

					    notifikasi($judul,$isi_pesan);

						}
						
						
						if($jenis_pesan == 'lainnya'){
							
						$judul="Informasi";
					    $isi_pesan= $deskripsi ;

					    notifikasi($judul,$isi_pesan);

						}
        	

        

    }else{
        $response['success'] = false;
        $response['message'] = "Gagal Terkirim";
    }
    
}else{
    $response['success'] = false;
    $response['message'] = "Error !";
}
    

echo json_encode($response);
}

elseif ($_GET['id']=='get_data_profil'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		   $nik=$_POST['nik'];
	$sql = "SELECT * FROM tb_warga where nik='$nik'";
	$result = $konek->query($sql);
	
	$response = array();
	
	while ($row = mysqli_fetch_array($result) ) {
	    array_push($response,
	    array(
	        'iduser' => $row['id_warga'],
	        'nik' => $row['nik'],
	        'nama' => $row['nama'],
	        'tanggallahir' => $row['tanggal_lahir'],
	        'jeniskelamin' => $row['tempat_lahir'],
	        'alamat' => $row['desa'],
	        'agama' => $row['agama'],
	        'status' => $row['jk'],
	        'pekerjaan' => $row['jabatan'])
	    );
	    
	}

echo json_encode($response);

}}



elseif ($_GET['id']=='get_data_darurat_terakhir')
{
    $sql="SELECT * FROM tb_keamanan ORDER BY id_keamanan DESC LIMIT 1";
    $query=mysqli_query($konek, $sql);
    $row=mysqli_fetch_assoc($query);
    
    // $hasil = "1";
    echo $row['jenis_pesan'].",";
}

	
elseif ($_GET['id']=='upload'){

	$upload='upload/'.$_FILES['gambar']['name'];

	$gambar = $_FILES['gambar']['name'];

	$waktu = date('Y-m-d H:i:s');

	$sql = "UPDATE tb_image SET gambar = '$gambar', waktu_upload = '$waktu' WHERE id_image = '1' ";

	$q = mysqli_query($konek,$sql);

	if($q){

		if(file_exists($upload)) {

		    chmod($upload,0755); //Change the file permissions if allowed

		    unlink($upload); //remove the file

		}

		if(move_uploaded_file($_FILES['gambar']['tmp_name'],$upload)){
			
			$result["success"] = "1";

	        $result["message"] = "success";

	        $result['status'] = "Connected to API";

	        echo json_encode($result);

		}else{
			
	        $result["success"] = "0";

	        $result["message"] = "errorUpload";

	        $result['status'] = "Connected to API";

	        echo json_encode($result);
		}

	}else{
			
        $result["success"] = "0";

        $result["message"] = "errorInsert";

        $result['status'] = "Connected to API";

        echo json_encode($result);
	}
								
}


?>