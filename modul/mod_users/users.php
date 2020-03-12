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
$aksi="modul/mod_users/aksi_users.php";
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
                            <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Data User</h2>
                                        <p>Laman Data User</span></p>
                                    </div>

                                </div>
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
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='data-table-list'>
                        <div class='table-responsive'>
                            <table id='data-table-basic' class='table table-striped table-hover table-bordered'>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Level User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>";
                                if(isset($cari)){
                                 $tampil = mysqli_query($konek,"SELECT tb_user.id_user AS id_user,tb_user.nik AS nik, tb_user.level_user as level_user, tb_warga.nama AS nama, tb_warga.jabatan AS jabatan FROM tb_user LEFT JOIN tb_warga ON tb_user.nik = tb_warga.nik WHERE tb_user.nik like '%$cari%' ");
                                 }else{
                                 $tampil = mysqli_query($konek,"SELECT tb_user.id_user AS id_user, tb_user.nik AS nik, tb_user.level_user as level_user, tb_warga.nama AS nama, tb_warga.jabatan AS jabatan  FROM tb_user LEFT JOIN tb_warga ON tb_user.nik = tb_warga.nik ");
                                } 
                                $no=1;
                                while ($r=mysqli_fetch_array($tampil)){
                                    // var_dump($r);
                                echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>$r[nik]</td>
                                        <td>$r[nama]</td>
                                        <td>$r[jabatan]</td>
                                        <td>$r[level_user]</td>
                                        <td class='center' width='250'>";
                                        if($r['level_user']== 'Admin'){
                                         echo"   
                                         <a href='$aksi?module=users&act=ubahlevel&id=$r[id_user]&u=warga' class='btn btn-sm btn-success btn-ubah-warga'><span class='fa fa-refresh' aria-hidden='true'></span> Ubah Ke Warga</a>";
                                        }
                                        else{
                                         echo"   
                                         <a href='$aksi?module=users&act=ubahlevel&id=$r[id_user]&u=admin' class='btn btn-sm btn-info btn-ubah-admin'><span class='fa fa-refresh' aria-hidden='true'></span> Ubah Ke Admin</a>";
                                         
                                        }
                                        echo"
                                         <a title ='password default :123456789' href='$aksi?module=users&act=resetpass&id=$r[id_user]' class='btn btn-sm btn-danger btn-reset'><span class='fa fa-reply' aria-hidden='true'></span> Reset Password</a>

                                       </td>
                                    </tr> ";
                            $no++;
                            }
                        ?>

                        <?php
                            echo "</table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
    

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
  $(function() {

    const flashdata = $('.flash-data').data('flashdata');
    console.log(flashdata);

    if ( flashdata == 'reset_sukses' ) {
      Swal.fire(
        'Reset Password',
        'Berhasil Mereset Password',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'reset_gagal' ) {
      Swal.fire(
        'Reset Password',
        'Gagal Mereset Password',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'ubah_warga_sukses' ) {
      Swal.fire(
        'Ubah Level User',
        'Berhasil mengubah level user menjadi Warga',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'ubah_warga_gagal' ) {
      Swal.fire(
        'Ubah Level User',
        'Gagal mengubah level user menjadi Warga',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    } 

    if ( flashdata == 'ubah_admin_sukses' ) {
      Swal.fire(
        'Ubah Level User',
        'Berhasil mengubah level user menjadi Admin',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'ubah_admin_gagal' ) {
      Swal.fire(
        'Ubah Level User',
        'Gagal mengubah level user menjadi Admin',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }



    // btn_reset
    $('.btn-reset').on('click', function(e) {
      e.preventDefault();
      const href = $(this).attr('href');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Password Akun ini akan direset",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#26B99A',
        cancelButtonColor: '#c9302c',
        confirmButtonText: 'Reset Password'
      }).then((result) => {
        if (result.value) {     
          document.location.href = href;
        }
      })
    });

    // btn_ubah_warga
    $('.btn-ubah-warga').on('click', function(e) {
      e.preventDefault();
      const href = $(this).attr('href');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Akan merubah Level User akun ini menjadi Warga ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#26B99A',
        cancelButtonColor: '#c9302c',
        confirmButtonText: 'Ubah Level User'
      }).then((result) => {
        if (result.value) {     
          document.location.href = href;
        }
      })
    });

    // btn_ubah_admin
    $('.btn-ubah-admin').on('click', function(e) {
      e.preventDefault();
      const href = $(this).attr('href');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Akan merubah Level User akun ini menjadi Admin ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#26B99A',
        cancelButtonColor: '#c9302c',
        confirmButtonText: 'Ubah Level User'
      }).then((result) => {
        if (result.value) {     
          document.location.href = href;
        }
      })
    });


  });
</script>
