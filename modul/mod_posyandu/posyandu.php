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
$aksi="modul/mod_posyandu/aksi_posyandu.php";
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
                                        <h2>Data Posyandu</h2>
                                        <p>Laman Data Jadwal Poyandu</span></p>
                                    </div>

                                </div>
                            </div>
                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                             <button class='btn btn-md btn-primary' onclick=\"window.location.href='?module=posyandu&act=tambahyandu';\">
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
                                        <th>Posyandu</th>
                                        <th>Setiap Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Waktu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>";
                               
                                 $tampil = mysqli_query($konek,"SELECT tb_yandu.id_yandu AS id_yandu , ref_yandu.posyandu AS posyandu, tb_yandu.tgl_yandu AS tgl_yandu, ref_lokasi.dusun AS dusun, tb_yandu.waktu_yandu AS waktu_yandu FROM tb_yandu LEFT JOIN ref_yandu ON ref_yandu.id_refyandu = tb_yandu.id_refyandu LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = ref_yandu.id_lokasi");
                                
                                $no=$mulai + 1;
                                while ($r=mysqli_fetch_array($tampil)){
                                  
                                  $tgl =date_create($r['tgl_yandu']);
                                  $tanggal=date_format($tgl,'d');
                                    echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>$r[posyandu]</td>
                                        <td>$tanggal</td>
                                        <td>$r[dusun]</td>
                                        <td>$r[waktu_yandu]</td>
                                        <td class='center' width='275'>
                                         
                                         <a href='?module=posyandu&act=editposyandu&id=$r[id_yandu]' class='btn btn-sm btn-warning'><span class='fa fa-pencil-square-o' aria-hidden='true'></span> Ubah</a>
                                         
                                        <a href='$aksi?module=posyandu&act=hapus&id=$r[id_yandu]' class='btn btn-sm btn-danger btn-hapus'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span> Hapus</a></td>
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


  case "tambahyandu":
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
                                        <h2>Tambah Posyandu </h2>
                                        <p>Laman Tambah Data Posyandu</span></p>
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

        <form method=POST action='$aksi?module=posyandu&act=input'>
            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Nama Posyandu</label>
              <div class='col-sm-7'>
                <select  class='form-control' onChange='loadDusun()' id='posyandutambah' name='posyandu'>
                <option value=''/>Pilih Posyandu";
                $query_refyandu=mysqli_query($konek,"SELECT * FROM ref_yandu");
                while ($r=mysqli_fetch_array($query_refyandu)){
                  echo"
                <option value='$r[id_refyandu]'/>$r[posyandu]" ;
                }

               echo"
                </select>
              </div>
         </div>


          <div id='areadusun'>
          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Dusun </label>
                  <div class='col-sm-7'>
                  <input type='text' name='text_dusun' class='form-control' id='text_dusun' readonly>
                  <input type='hidden' name='id_lokasi' class='form-control' id='dusun' readonly>
              </div>  
            </div> 
          </div>
         
        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tanggal </label>
              <div class='col-sm-7'>
                <input type='date' class='form-control' name='tgl_yandu' placeholder='Masukan Tanggal ' required='required'>
              </div>
         </div>

          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Waktu</label>
              <div class='col-sm-7'>
                <input type='time' class='form-control' name='waktu_yandu' placeholder='Masukan Waktu ' required='required'>
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
    
  case "editposyandu":
    $edit=mysqli_query($konek,"SELECT tb_yandu.id_yandu AS id_yandu , ref_yandu.posyandu AS posyandu, tb_yandu.tgl_yandu AS tgl_yandu, ref_lokasi.dusun AS dusun, tb_yandu.waktu_yandu AS waktu_yandu FROM tb_yandu LEFT JOIN ref_yandu ON ref_yandu.id_refyandu = tb_yandu.id_refyandu LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = ref_yandu.id_lokasi WHERE id_yandu = '$_GET[id]'");
    $r=mysqli_fetch_array($edit);

     $tgl =date_create($r['tgl_yandu']);
     $tanggal=date_format($tgl,'d');

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
                                        <h2>Data Posyandu </h2>
                                        <p>Laman Ubah Data Posyandu</span></p>
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

        <form method=POST action='$aksi?module=posyandu&act=update'>
        <input type='hidden' class='form-control' name='id' value='$r[id_yandu]' required='required' readonly>
            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Posyandu</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='posyandu' value='$r[posyandu]' required='required' readonly>
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Lokasi</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='lokasi' value='$r[dusun]' required='required' readonly>
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tanggal</label>
              <div class='col-sm-7'>
                <input type='date' class='form-control' name='tgl_yandu' value='$r[tgl_yandu]' required='required'>
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Waktu</label>
              <div class='col-sm-7'>
                <input type='time' class='form-control' name='waktu_yandu' value='$r[waktu_yandu]' required='required'>
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
  $('#myHTMLTable').convertToFusionCharts({
    swfPath: "Charts/",
    type: "MSColumn3D",
    data: "#myHTMLTable",
    dataFormat: "HTMLTable"
  });
  </script>

  <script type="text/javascript"> 
  $(function(){

  $('#posyandutambah').change(function(){
      var posyandu=$("#posyandutambah").val();

       $('#areadusun').hide();
       $('#text_dusun').attr('readonly','readonly');
      if(posyandu !=''){
      $('#areadusun').show();
         $.ajax({
            type:"POST",
            url:"./modelajax.php?id=yandu",
            data:{posyandu:posyandu},
            success: function(data){
                var val = data.split("/");
                //alert(val[1]);
                $('#dusun').val(val[0]);
                $('#text_dusun').val(val[1]);            
                $('#text_dusun').attr('readonly','readonly');            

            }
          });     

        }else{
           $('#areadusun').hide();
           $('#text_dusun').attr('readonly','readonly');
        }
    
  });

});

  </script>

<script type="text/javascript">
  $(function() {

    const flashdata = $('.flash-data').data('flashdata');
    console.log(flashdata);

    //Hapus
    if ( flashdata == 'hapus_sukses' ) {
      Swal.fire(
        'Hapus Data Jadwal Posyandu',
        'Berhasil Menghapus Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'hapus_gagal' ) {
      Swal.fire(
        'Hapus Data Jadwal Posyandu',
        'Gagal Menghapus Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Tambah
    if ( flashdata == 'tambah_sukses' ) {
      Swal.fire(
        'Tambah Data Jadwal Posyandu',
        'Berhasil Menambah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'tambah_gagal' ) {
      Swal.fire(
        'Tambah Data Jadwal Posyandu',
        'Gagal Menambah Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Ubah
    if ( flashdata == 'ubah_sukses' ) {
      Swal.fire(
        'Ubah Data Jadwal Posyandu',
        'Berhasil Mengubah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'ubah_gagal' ) {
      Swal.fire(
        'Ubah Data Jadwal Posyandu',
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
        text: "Akan menghapus data jadwal posyandu ini",
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
