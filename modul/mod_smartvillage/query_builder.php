<?php  

include "../../config/koneksi.php"; // Load file koneksi.php
$data = $_GET['data'];

switch ($data) {

	case 'tb_suhu':
		$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
		$limit = $_POST['length']; // Ambil data limit per page
		$start = $_POST['start']; // Ambil data start
		$sql = mysqli_query($konek, "SELECT * FROM tb_suhu ORDER BY nilai_suhu"); // Query untuk menghitung seluruh data siswa
		$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql
		$query = "SELECT * FROM tb_suhu WHERE (tgl_suhu LIKE '%".$search."%' OR waktu_suhu LIKE '%".$search."%' OR nilai_suhu LIKE '%".$search."%' )";
		$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
		$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
		$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
		$sql_data = mysqli_query($konek, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
		$sql_filter = mysqli_query($konek, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
		$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter

		$data = [];
		while ($row = $sql_data->fetch_assoc()) {
			$data[] = $row;
		}

		$callback = array(
		    'draw'=>$_POST['draw'], // Ini dari datatablenya
		    'recordsTotal'=>$sql_count,
		    'recordsFiltered'=>$sql_filter_count,
		    'data'=>$data
		);
		header('Content-Type: application/json');
		echo json_encode($callback); // Convert array $callback ke json
		break;

	case 'tb_kualitasudara':
		$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
		$limit = $_POST['length']; // Ambil data limit per page
		$start = $_POST['start']; // Ambil data start
		$sql = mysqli_query($konek, "SELECT * FROM tb_kualitasudara"); // Query untuk menghitung seluruh data siswa
		$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql
		$query = "SELECT * FROM tb_kualitasudara WHERE (tgl_ku LIKE '%".$search."%' OR w_ku LIKE '%".$search."%' OR n_ku LIKE '%".$search."%' OR s_ku LIKE '%".$search."%')";
		$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
		$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
		$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
		$sql_data = mysqli_query($konek, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
		$sql_filter = mysqli_query($konek, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
		$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter

		$data = [];
		while ($row = $sql_data->fetch_assoc()) {
			$data[] = $row;
		}

		$callback = array(
		    'draw'=>$_POST['draw'], // Ini dari datatablenya
		    'recordsTotal'=>$sql_count,
		    'recordsFiltered'=>$sql_filter_count,
		    'data'=>$data
		);
		header('Content-Type: application/json');
		echo json_encode($callback); // Convert array $callback ke json
		break;

	case 'tb_kebakaran':
		$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
		$limit = $_POST['length']; // Ambil data limit per page
		$start = $_POST['start']; // Ambil data start
		$sql = mysqli_query($konek, "SELECT * FROM tb_kebakaran"); // Query untuk menghitung seluruh data siswa
		$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql
		$query = "SELECT * FROM tb_kebakaran WHERE (t_kebakaran LIKE '%".$search."%' OR w_kebakaran LIKE '%".$search."%' OR n_kebakaran LIKE '%".$search."%' OR s_kebakaran LIKE '%".$search."%')";
		$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
		$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
		$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
		$sql_data = mysqli_query($konek, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
		$sql_filter = mysqli_query($konek, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
		$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter
		
		$data = [];
		while ($row = $sql_data->fetch_assoc()) {
			$data[] = $row;
		}

		$callback = array(
		    'draw'=>$_POST['draw'], // Ini dari datatablenya
		    'recordsTotal'=>$sql_count,
		    'recordsFiltered'=>$sql_filter_count,
		    'data'=>$data
		);
		header('Content-Type: application/json');
		echo json_encode($callback); // Convert array $callback ke json
		break;

	case 'tb_kelembaban':
		$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
		$limit = $_POST['length']; // Ambil data limit per page
		$start = $_POST['start']; // Ambil data start
		$sql = mysqli_query($konek, "SELECT * FROM tb_kelembaban"); // Query untuk menghitung seluruh data siswa
		$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql
		$query = "SELECT * FROM tb_kelembaban WHERE (tgl_kl LIKE '%".$search."%' OR w_kl LIKE '%".$search."%' OR n_kl LIKE '%".$search."%')";
		$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
		$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
		$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
		$sql_data = mysqli_query($konek, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
		$sql_filter = mysqli_query($konek, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
		$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter
		
		$data = [];
		while ($row = $sql_data->fetch_assoc()) {
			$data[] = $row;
		}

		$callback = array(
		    'draw'=>$_POST['draw'], // Ini dari datatablenya
		    'recordsTotal'=>$sql_count,
		    'recordsFiltered'=>$sql_filter_count,
		    'data'=>$data
		);
		header('Content-Type: application/json');
		echo json_encode($callback); // Convert array $callback ke json
		break;

	case 'tb_gempa':
		$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
		$limit = $_POST['length']; // Ambil data limit per page
		$start = $_POST['start']; // Ambil data start
		$sql = mysqli_query($konek, "SELECT * FROM tb_gempa"); // Query untuk menghitung seluruh data siswa
		$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql
		$query = "SELECT * FROM tb_gempa WHERE (t_gempa LIKE '%".$search."%' OR w_gempa LIKE '%".$search."%' OR n_gempa LIKE '%".$search."%' OR s_gempa LIKE '%".$search."%')";
		$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
		$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
		$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
		$sql_data = mysqli_query($konek, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
		$sql_filter = mysqli_query($konek, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
		$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter
		
		$data = [];
		while ($row = $sql_data->fetch_assoc()) {
			$data[] = $row;
		}

		$callback = array(
		    'draw'=>$_POST['draw'], // Ini dari datatablenya
		    'recordsTotal'=>$sql_count,
		    'recordsFiltered'=>$sql_filter_count,
		    'data'=>$data
		);
		header('Content-Type: application/json');
		echo json_encode($callback); // Convert array $callback ke json
		break;

	case 'tb_keamanan':
		$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
		$limit = $_POST['length']; // Ambil data limit per page
		$start = $_POST['start']; // Ambil data start
		$sql = mysqli_query($konek, "SELECT * FROM tb_keamanan"); // Query untuk menghitung seluruh data siswa
		$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql
		$query = "SELECT * FROM tb_keamanan WHERE (tgl_keamanan LIKE '%".$search."%' OR waktu_keamanan LIKE '%".$search."%' OR jenis_pesan LIKE '%".$search."%' OR deskripsi LIKE '%".$search."%')";
		$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
		$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
		$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
		$sql_data = mysqli_query($konek, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
		$sql_filter = mysqli_query($konek, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
		$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter
		
		$data = [];
		while ($row = $sql_data->fetch_assoc()) {
			$data[] = $row;
		}
		
		$callback = array(
		    'draw'=>$_POST['draw'], // Ini dari datatablenya
		    'recordsTotal'=>$sql_count,
		    'recordsFiltered'=>$sql_filter_count,
		    'data'=>$data
		);
		header('Content-Type: application/json');
		echo json_encode($callback); // Convert array $callback ke json
		break;

		default:
		echo "Pilih Modul";
		break;
	}

	?>