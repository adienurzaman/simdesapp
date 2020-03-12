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
$aksi="modul/mod_status/aksi_status.php";
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
                                        <h2>Data Status Keamanan</h2>
                                        <p>Laman Data Status Keamanan</p>
                                    </div>

                                </div>
                            </div>
                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                             <button class='btn btn-md btn-primary' onclick=\"window.location.href='?module=status&act=tambahstatus';\">
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
                            <table id='data-table-basic' class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jenis Pesan</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>";
                                
                                 
                                 $tampil = mysqli_query($konek,"SELECT tb_keamanan.id_keamanan AS id_keamanan, tb_keamanan.nik AS nik, tb_warga.nama AS nama, tb_keamanan.jenis_pesan AS jenis_pesan, tb_keamanan.deskripsi AS deskripsi FROM tb_keamanan LEFT JOIN tb_warga ON tb_keamanan.nik = tb_warga.nik   ");
                              
                                $no=$mulai + 1;
                                while ($r=mysqli_fetch_array($tampil)){
                                echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>$r[nik]</td>
                                        <td>$r[nama]</td>
                                        <td>$r[jenis_pesan]</td>
                                        <td>$r[deskripsi]</td>
                                        <td class='center' width='275'>
                                         
                                         <a href='?module=status&act=editstatus&id=$r[id_keamanan]' class='btn btn-sm btn-warning'><span class='fa fa-edit' aria-hidden='true'></span> Ubah</a>
                                         |
                                        <a href='$aksi?module=status&act=hapus&id=$r[id_keamanan]' class='btn btn-sm btn-danger btn-hapus'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span> Hapus</a></td>
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

   

  case "tambahstatus":
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
                                        <h2>Tambah Status Keamanan </h2>
                                        <p>Laman Tambah Data Status Keamanan</span></p>
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

        <form method=POST action='$aksi?module=status&act=input'>
            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>NIK</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' id='nikstatus' name='nik' placeholder='Masukan Nomer Induk Keluarga ' required='required'>
                <span id='textnik' class='text-info'></span>
              </div>
         </div>

          <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>Nama Lengkap</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' id='namastatus' name='nama'  readonly>
                <span id='textnik' class='text-info'></span>
              </div>
         </div>


          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jenis Pesan</label>
              <div class='col-sm-7'>
        <select  class='form-control' id='jpstatus' name='jp'>
        <option value=''/>Pilih Jenis Pesan  
        <option value='Kriminalitas'/>Kriminalitas 
        <option value='Musibah'/>Musibah
        <option value='Lainya'/>Lainya
        </select>
              </div>
         </div>



           <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Deskripsi</label>
              <div class='col-sm-7'>
                 <textarea  id='deskripsistatus' name='deskripsi'  class='form-control'></textarea>
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
    
  case "editstatus":
    $edit=mysqli_query($konek,"SELECT tb_keamanan.id_keamanan AS id_keamanan, tb_keamanan.nik AS nik, tb_warga.nama AS nama, tb_keamanan.jenis_pesan AS jenis_pesan, tb_keamanan.deskripsi AS deskripsi FROM tb_keamanan LEFT JOIN tb_warga ON tb_keamanan.nik = tb_warga.nik  WHERE id_keamanan ='$_GET[id]'");
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
                                        <h2>Data Status Keamanan </h2>
                                        <p>Laman Ubah Data Status Keamanan</span></p>
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
        <form method=POST action='$aksi?module=status&act=update'>
            <div class='form-group row'>
             <input type='hidden' class='form-control'   name='id_keamanan' value='$r[id_keamanan]' placeholder='Masukan Nomer Induk Keluarga ' required='required' >
              <label class='col-sm-3 col-form-label'>NIK</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control'   name='nik' value='$r[nik]' placeholder='Masukan Nomer Induk Keluarga ' required='required' readonly>
                <span id='textnik' class='text-info'></span>
              </div>
         </div>

          <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>Nama Lengkap</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' id='namastatus' value='$r[nama]' name='nama'  readonly>
                <span id='textnik' class='text-info'></span>
              </div>
         </div>


          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jenis Pesan</label>
              <div class='col-sm-7'>
        <select  class='form-control' id='jpstatus' name='jenis_pesan'>
        <option value='$r[jenis_pesan]'>$r[jenis_pesan]
        <option value=''/>Pilih Jenis Pesan  
        <option value='Kriminalitas'/>Kriminalitas 
        <option value='Musibah'/>Musibah
        <option value='Lainya'/>Lainya
        </select>
              </div>
         </div>



           <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Deskripsi</label>
              <div class='col-sm-7'>
                 <textarea  id='deskripsistatus' name='deskripsi'  class='form-control'>$r[deskripsi]</textarea>
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
    setInterval(function(){
      carinik();
    
    },400) ;

    
  function carinik(){
      var nik=$("#nikstatus").val();
  var str=nik.length;
  if(str>0 && str<16  || str== ""){
    $("#jpstatus").attr("disabled","disabled");
    $("#waktustatus").attr("disabled","disabled");
    $("#dusunstatus").attr("disabled","disabled");
    $("#tglstatus").attr("disabled","disabled");
    $("#deskripsistatus").attr("disabled","disabled");
     $("#textnik").text("Kurang");
      $("#namastatus").val("");
}

  
else if(str==16 && str !=""){

 

      $.ajax({
        type:"POST",
        url:"./modelajax.php?id=ceknikstatus",
        data:{nik:nik},
        success: function(data){
          var nilai=data.split("/");
          if(nilai[0] == 1){
            $("#jpstatus").removeAttr("disabled","disabled");
            $("#waktustatus").removeAttr("disabled","disabled");
            $("#dusunstatus").removeAttr("disabled","disabled");
            $("#tglstatus").removeAttr("disabled","disabled");
            $("#deskripsistatus").removeAttr("disabled","disabled");
            $("#textnik").text("Terdaftar");
            $("#namastatus").val(nilai[1]);

          }
          else{
            $("#jpstatus").attr("disabled","disabled");
            $("#waktustatus").attr("disabled","disabled");
            $("#dusunstatus").attr("disabled","disabled");
            $("#tglstatus").attr("disabled","disabled");
            $("#deskripsistatus").attr("disabled","disabled");
            $("#textnik").text("Tidak Terdaftar");
              $("#namastatus").val("");
          }
        }
      });

}
else{
   $("#jpstatus").attr("disabled","disabled");
   $("#waktustatus").attr("disabled","disabled");
   $("#dusunstatus").attr("disabled","disabled");
   $("#tglstatus").attr("disabled","disabled");
   $("#deskripsistatus").attr("disabled","disabled");
  $("#textnik").text("berlebih");
   $("#namastatus").val("");
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
        'Hapus Data Status Keamanan',
        'Berhasil Menghapus Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'hapus_gagal' ) {
      Swal.fire(
        'Hapus Data Status Keamanan',
        'Gagal Menghapus Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Tambah
    if ( flashdata == 'tambah_sukses' ) {
      Swal.fire(
        'Tambah Data Status Keamanan',
        'Berhasil Menambah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'tambah_gagal' ) {
      Swal.fire(
        'Tambah Data Status Keamanan',
        'Gagal Menambah Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Ubah
    if ( flashdata == 'ubah_sukses' ) {
      Swal.fire(
        'Ubah Data Status Keamanan',
        'Berhasil Mengubah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'ubah_gagal' ) {
      Swal.fire(
        'Ubah Data Status Keamanan',
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
        text: "Akan menghapus data status keamanan ini",
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

