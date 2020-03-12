<?php
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/class_paging.php";
$jam=date("H:i:s");
$tgl=tgl_indo(date("Y m d"));

if (empty($_SESSION['nik']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
  <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}

else{
$aksi="modul/mod_smartvillage/aksi_smartvillage.php";
$act =(isset($_GET['act']))?$_GET['act']:'';

switch($act){
  // Tampil User

  default:
    if ($_SESSION['level_user']=='Admin'){
        if (isset($_POST['caridata'])) {
          $cari = $_POST['caridata'];
        } else {
          $cari = "";
        }
      echo "
    <div class='flash-data' data-flashdata='$_SESSION[flashdata]'></div>
    <div class='breadcomb-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='breadcomb-list'>
                        <div class='row'>
                            <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Data Smart Pole</h2>
                                        <p>Laman Data Smart Pole</span></p>
                                    </div>

                                </div>
                            </div>
                            <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                            <a href='$aksi?module=smartvillage&act=hapusall' class='btn btn-md btn-danger' id='truncate'>
                               <span class='fa fa-trash'></span> Hapus Semua Data
                               </a>
                            <a class='btn btn-md btn-info' id='reload'>
                               <span class='fa fa-refresh'></span> Refresh Data
                               </a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
 <div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                    <div class='breadcomb-ctn'>
                                        <h2>Data Suhu</h2>
                                        <p>Laman Data Suhu</span></p>
                                    </div>
                        <div class='table-responsive'>
                            <table id='tb_suhu' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Suhu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            	</table>
                                </div>
                            </div>
                        </div>


              <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                     <div class='breadcomb-ctn'>
                                        <h2>Data Kualitas Udara</h2>
                                        <p>Laman Kualitas Udara</span></p>
                                    </div>
                        <div class='table-responsive'>
                            <table id='tb_kualitasudara' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Kualitas Udara</th>
                                        <th>Kesimpulan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><br>

<div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                     <div class='breadcomb-ctn'>
                                        <h2>Data Sensor Api</h2>
                                        <p>Laman Data Sensor Api</span></p>
                                    </div>
                        <div class='table-responsive'>
                            <table id='tb_kebakaran' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Sensor Api</th>
                                        <th>Kesimpulan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                        </div>
                                    </div>
                                </div>
                              

              <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                     <div class='breadcomb-ctn'>
                                        <h2>Data Kelembaban</h2>
                                        <p>Laman Data Kelembaban</span></p>
                                    </div>
                        <div class='table-responsive'>
                            <table id='tb_kelembaban' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Kelembaban</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><br>


                    <div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                     <div class='breadcomb-ctn'>
                                        <h2>Data Gempa</h2>
                                        <p>Laman Data Gempa</span></p>
                                    </div>
                        <div class='table-responsive'>
                            <table id='tb_gempa' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Nilai</th>
                                        <th>Kesimpulan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                        </div>
                                    </div>
                                </div>
                              

              <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                     <div class='breadcomb-ctn'>
                                        <h2>Data Panik Button</h2>
                                        <p>Laman Data Panik Button</span></p>
                                    </div>
                        <div class='table-responsive'>
                            <table id='tb_keamanan' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Jenis Pesan</th>
                                        <th>Deskripsi</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
        }



    break;

  
}
}

?>
<script type="text/javascript">
  $('#myHTMLTable').convertToFusionCharts({
    swfPath: "Charts/",
    type: "MSColumn3D",
    data: "#myHTMLTable",
    dataFormat: "HTMLTable"
  });
  </script>

<script type="text/javascript">
    $(document).ready( function () {
    	//membuat datatable autoload

    	setInterval(function(){
    		autoload();
    	},5000);

    	var tb_suhu = $('#tb_suhu').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "cache": false,
            "order": [[ 0, 'desc' ]],
            "ajax":
            {
                "url": "./modul/mod_smartvillage/query_builder.php?data=tb_suhu", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[5, 10, 50, 100, 500, 1000, 10000],[5, 10, 50, 100, 500, 1000, 10000]], // Combobox Limit
            "columns": [
                { "data": "tgl_suhu" },
                { "data": "waktu_suhu" },
                { "data": "nilai_suhu" }
            ],
        });

        var tb_kualitasudara = $('#tb_kualitasudara').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "cache": false,
            "order": [[ 0, 'desc' ]],
            "ajax":
            {
                "url": "./modul/mod_smartvillage/query_builder.php?data=tb_kualitasudara", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[5, 10, 50, 100, 500, 1000, 10000],[5, 10, 50, 100, 500, 1000, 10000]], // Combobox Limit
            "columns": [
                { "data": "tgl_ku" },
                { "data": "w_ku" },
                { "data": "n_ku" },
                { "data": "s_ku" }
            ],
        });

        var tb_kebakaran = $('#tb_kebakaran').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "cache": false,
            "order": [[ 0, 'desc' ]],
            "ajax":
            {
                "url": "./modul/mod_smartvillage/query_builder.php?data=tb_kebakaran", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[5, 10, 50, 100, 500, 1000, 10000],[5, 10, 50, 100, 500, 1000, 10000]], // Combobox Limit
            "columns": [
                { "data": "t_kebakaran" },
                { "data": "w_kebakaran" },
                { "data": "n_kebakaran" },
                { "data": "s_kebakaran" }
            ],
        });

        var tb_kelembaban = $('#tb_kelembaban').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "cache": false,
            "order": [[ 0, 'desc' ]],
            "ajax":
            {
                "url": "./modul/mod_smartvillage/query_builder.php?data=tb_kelembaban", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[5, 10, 50, 100, 500, 1000, 10000],[5, 10, 50, 100, 500, 1000, 10000]], // Combobox Limit
            "columns": [
                { "data": "tgl_kl" },
                { "data": "w_kl" },
                { "data": "n_kl" }
            ],
        });

        var tb_gempa = $('#tb_gempa').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "cache": false,
            "order": [[ 0, 'desc' ]],
            "ajax":
            {
                "url": "./modul/mod_smartvillage/query_builder.php?data=tb_gempa", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[5, 10, 50, 100, 500, 1000, 10000],[5, 10, 50, 100, 500, 1000, 10000]], // Combobox Limit
            "columns": [
                { "data": "t_gempa" },
                { "data": "w_gempa" },
                { "data": "n_gempa" },
                { "data": "s_gempa" }
            ],
        });

        var tb_keamanan = $('#tb_keamanan').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true, // Set true agar bisa di sorting
            "cache": false,
            "order": [[ 0, 'desc' ]],
            "ajax":
            {
                "url": "./modul/mod_smartvillage/query_builder.php?data=tb_keamanan", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[5, 10, 50, 100, 500, 1000, 10000],[5, 10, 50, 100, 500, 1000, 10000]], // Combobox Limit
            "columns": [
                { "data": "tgl_keamanan" },
                { "data": "waktu_keamanan" },
                { "data": "jenis_pesan" },
                { "data": "deskripsi" }
            ],
        });

        $('#reload').click(function(){
            location.reload();
        });

        function autoload(){
        	tb_suhu.ajax.reload();
        	tb_keamanan.ajax.reload();
        	tb_gempa.ajax.reload();
        	tb_kelembaban.ajax.reload();
        	tb_kebakaran.ajax.reload();
        	tb_kualitasudara.ajax.reload();
        }

    });

</script>

<script type="text/javascript">
  $(function() {

    const flashdata = $('.flash-data').data('flashdata');
    console.log(flashdata);

    //Hapus
    if ( flashdata == 'hapus_sukses' ) {
      Swal.fire(
        'Hapus Semua Data Smart Village',
        'Berhasil Menghapus Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'hapus_gagal' ) {
      Swal.fire(
        'Hapus Semua Data Smart Village',
        'Gagal Menghapus Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }


    // btn_ubah_admin
    $('#truncate').on('click', function(e) {
      e.preventDefault();
      const href = $(this).attr('href');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Akan Menghapus Seluruh Data pada modul Smartvillage",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#26B99A',
        cancelButtonColor: '#c9302c',
        confirmButtonText: 'Hapus Data'
      }).then((result) => {
        if (result.value) {     
          document.location.href = href;
        }
      })
    });


  });
</script>

