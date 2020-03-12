<?php
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/class_paging.php";
include "../../modelajax.php";

$jam=date("H:i:s");
$tgl=tgl_indo(date("Y m d"));

$tgl_real = date("d-m-Y");
$tgl_skrng = date("Y-m-d");


if (empty($_SESSION['nik']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
  <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}

else{
$aksi="modul/mod_riwayat/aksi_riwayat.php";
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
                            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Data Riwayat</h2>
                                        <p>Laman Data Riwayat Kesehatan</span></p>
                                    </div>

                                </div>
                            </div>
                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                             <button class='btn btn-md btn-primary' onclick=\"window.location.href='?module=riwayat&act=tambahriwayat';\">
                               <span class='fa fa-plus'></span> Tambah Data
                               </button> 
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
                                        <th>Tanggal</th>
                                        <th>Riwayat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>";
                                if(isset($cari)){
                                  $tampil = mysqli_query($konek,"SELECT tb_riwayat.id_riwayat AS id_riwayat ,tb_riwayat.nik AS nik, tb_riwayat.tgl_riwayat AS tgl_riwayat, tb_warga.nama AS nama ,tb_riwayat.riwayat AS riwayat  FROM tb_riwayat LEFT JOIN tb_warga ON tb_riwayat.nik = tb_warga.nik WHERE tb_riwayat.nik like '%$cari%' ");
                                 }else{
                                $tampil = mysqli_query($konek,"SELECT tb_riwayat.id_riwayat AS id_riwayat ,tb_riwayat.nik AS nik, tb_riwayat.tgl_riwayat AS tgl_riwayat,tb_warga.nama AS nama, tb_riwayat.riwayat AS riwayat  FROM tb_riwayat LEFT JOIN tb_warga ON tb_riwayat.nik = tb_warga.nik ");
                                } 
                                $no= 1;
                                while ($r=mysqli_fetch_array($tampil)){
                                echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>$r[nik]</td>
                                        <td>$r[nama]</td>
                                        <td>$r[tgl_riwayat]</td>
                                        <td>$r[riwayat]</td>
                                        <td class='center' width='275'>
                                         <a href='?module=riwayat&act=editriwayat&id=$r[id_riwayat]' class='btn btn-sm btn-warning'><span class='fa fa-pencil-square-o' aria-hidden='true'></span> Ubah</a>
                                         |
                                        <a href='$aksi?module=riwayat&act=hapus&id=$r[id_riwayat]' class='btn btn-sm btn-danger btn-hapus'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span> Hapus</a></td>
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

   
  case "tambahriwayat":
    if ($_SESSION['level_user']=='Admin'){
     echo "<div class='breadcomb-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='breadcomb-list'>
                        <div class='row'>
                            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Tambah Riwayat </h2>
                                        <p>Laman Tambah Data Riwayat Kesehatan</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    echo "

    <div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class='data-table-list'>

        <form method=POST action='$aksi?module=riwayat&act=input'>
         <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>No Induk keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' id='niktambah' name='nik' placeholder='Masukan Nomer Induk Keluarga ' required='required'>
                <span id='textnik' class='text-info'></span>
              </div>
         </div>
         <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>Nama Lengkap</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' id='namatambah' name='nama'  readonly>
                <span id='textnik' class='text-info'></span>
              </div>
         </div>


          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tanggal Pemerikasaan</label>
              <div class='col-sm-7'>
                <input type='date' class='form-control' id='tgltambah' name='tgl_riwayat' value='$tgl_skrng' required='required'>
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Riwayat</label>
              <div class='col-sm-7'>
                 <textarea  id='riwayattambah'name='riwayat'  class='form-control'></textarea>
              </div>
         </div>
       

        <div class='form-group row'>
                <label class='col-sm-4 col-form-label'></label>
                  <div class='offset-sm-2 col-sm-4'>
                    <button type='submit' class='btn btn-info' name='simpan'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Simpan</button>                            
                       | 
                    <button type='reset' onclick=self.history.back() class='btn btn-warning'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span> Batal</button>
                  </div>
          </div>

        </form>

    <!--/container-->             
    </div>
    </div>
    </div>
    </div>
    
   
    ";
    }
    else{
      echo "Anda tidak berhak mengakses halaman ini.";
    }
     break;
    
  case "editriwayat":
    $id=$_GET['id'];
    $edit=mysqli_query($konek,"SELECT tb_riwayat.id_riwayat AS id_riwayat ,tb_riwayat.nik AS nik, tb_riwayat.tgl_riwayat AS tgl_riwayat, tb_warga.nama AS nama ,tb_riwayat.riwayat AS riwayat  FROM tb_riwayat LEFT JOIN tb_warga ON tb_riwayat.nik = tb_warga.nik WHERE tb_riwayat.id_riwayat ='$id' ");
    $r=mysqli_fetch_array($edit);

    if ($_SESSION['level_user']=='Admin'){
  echo "<div class='breadcomb-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='breadcomb-list'>
                        <div class='row'>
                            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Data Riwayat </h2>
                                        <p>Laman Ubah Data Riwayat Kesehatan</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    echo "

    <div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class='data-table-list'>

        <form method=POST action='$aksi?module=riwayat&act=update'>
         <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>No Induk keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control'  name='nik' value='$r[nik]'required='required'readonly >
                
              </div>
         </div>
         <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>Nama Lengkap</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nama' value='$r[nama]' readonly >
                
              </div>
         </div>


          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tanggal Pemerikasaan</label>
              <div class='col-sm-7'>
                <input type='date' class='form-control'  name='tgl_riwayat' value='$r[tgl_riwayat]' required='required' readonly>
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Riwayat</label>
              <div class='col-sm-7'>
                 <textarea name='riwayat'  class='form-control' value='$r[riwayat]' placeholder='Masukan Perubahan Riwayat'></textarea>
              </div>
         </div>
       

        <div class='form-group row'>
                <label class='col-sm-4 col-form-label'></label>
                  <div class='offset-sm-2 col-sm-4'>
                    <button type='submit' class='btn btn-info' name='simpan'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Simpan</button>                            
                       | 
                    <button type='reset' onclick=self.history.back() class='btn btn-warning'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span> Batal</button>
                  </div>
          </div>

        </form>

    <!--/container-->             
    </div>
    </div>
    </div>
    </div>
    
   
    ";
    }
    else{
      echo "Anda tidak berhak mengakses halaman ini.";
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
  $(function(){
    setInterval(function(){
      carinik();
    
    },400) ;

    
  function carinik(){
      var nik=$("#niktambah").val();
  var str=nik.length;
  if(str>0 && str<16  || str== ""){
    $("#tgltambah").attr("disabled","disabled");
    $("#riwayattambah").attr("disabled","disabled");
     $("#textnik").text("Kurang");
      $("#namatambah").val("");
}

  
else if(str==16 && str !=""){

 

      $.ajax({
        type:"POST",
        url:"./modelajax.php?id=ceknik",
        data:{nik:nik},
        success: function(data){
          var nilai=data.split("/");
          if(nilai[0] == 1){
            $("#tgltambah").removeAttr("disabled","disabled");
            $("#riwayattambah").removeAttr("disabled","disabled");
            $("#textnik").text("Terdaftar");
            $("#namatambah").val(nilai[1]);

          }
          else{
            $("#tgltambah").attr("disabled","disabled");
            $("#riwayattambah").attr("disabled","disabled");
            $("#textnik").text("Tidak Terdaftar");
              $("#namatambah").val("");
          }
        }
      });

}
else{
  $("#tgltambah").attr("disabled","disabled");
    $("#riwayattambah").attr("disabled","disabled");
  $("#textnik").text("berlebih");
   $("#namatambah").val("");
}
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
        'Hapus Data Riwayat Kesehatan',
        'Berhasil Menghapus Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'hapus_gagal' ) {
      Swal.fire(
        'Hapus Data Riwayat Kesehatan',
        'Gagal Menghapus Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Tambah
    if ( flashdata == 'tambah_sukses' ) {
      Swal.fire(
        'Tambah Data Riwayat Kesehatan',
        'Berhasil Menambah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'tambah_gagal' ) {
      Swal.fire(
        'Tambah Data Riwayat Kesehatan',
        'Gagal Menambah Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Ubah
    if ( flashdata == 'ubah_sukses' ) {
      Swal.fire(
        'Ubah Data Riwayat Kesehatan',
        'Berhasil Mengubah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'ubah_gagal' ) {
      Swal.fire(
        'Ubah Data Riwayat Kesehatan',
        'Gagal Mengubah Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }





    // btn_hapus
    $('.btn-hapus').on('click', function(e) {
      e.preventDefault();
      const href = $(this).attr('href');

      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Akan menghapus data riwayat ini",
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

