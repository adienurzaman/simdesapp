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
$aksi="modul/mod_jadwal/aksi_jadwal.php";
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
 <div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Jadwal Keamanan Desa Cihaur</h2>
                                    </div>

                                </div>
                            </div>
                            <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>
                             <button class='btn btn-md btn-primary' onclick=\"window.location.href='?module=jadwal&act=tambahjadwal';\">
                               <span class='fa fa-plus'></span> Tambah Data
                               </button>
                               <button id ='hapus' class='btn btn-md btn-danger'>
                               <span class='fa fa-trash'></span> Hapus Data
                               </button>
                               <button  class='btn btn-md btn-warning' onclick=\"window.location.href='?module=jadwal&act=viewjadwal' ;\">
                               <span class='fa fa-refresh'></span> Kembali
                               </button>
                            </div>
                        </div>
                        <br>
                        <form action='$aksi?module=jadwal&act=hapusseleksi' id='hapussemua' method='post'>
                            <table id='data-table-basic' class='table table-striped table-hover table-bordered'>
                                <thead>
                                    <tr>
                                        <th><input type='checkbox' id='pilihsemua'/></th>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Dusun</th>
                                        <th>Hari</th>
                                    </tr>
                                </thead>";
                                
                                 $tampil = mysqli_query($konek,"SELECT tb_ronda.id_ronda As id_ronda, tb_ronda.nik AS nik, tb_warga.nama AS nama, ref_lokasi.dusun AS dusun, ref_hari.hari AS hari FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi LEFT JOIN ref_hari ON ref_hari.id_hari = tb_ronda.id_hari ORDER BY ref_lokasi.dusun, ref_hari.hari ");
                            
                                 
                                $no=$mulai + 1;
                                while ($r=mysqli_fetch_array($tampil)){
                                echo "
                                    <tr>
                                        <td><input type='checkbox' id'tandai' value='$r[id_ronda]' name='data[]' </td>
                                        <td>$no</td>
                                        <td> $r[nik]</td>
                                        <td>$r[nama]</td>
                                        <td>$r[dusun]</td>
                                        <td>$r[hari]</td>
                                    </tr> ";
                            $no++;
                            }
                        ?>

                        <?php
                            echo "</table>
                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
        }

    break;
   
  case "tambahjadwal":
    if ($_SESSION['level_user']=='Admin'){
     echo "<div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='data-table-list'>
                        <div class='basic-tb-hd'>
                            <h2>Tambah Jadwal</h2>
                            <p>Laman Tambah Jadwal Keamanan </p>
                        </div>";
    echo "<table class='table table-striped table-bordered table-hover'>
    <thead>
    <div class='container'>
    <!--container-->

        <form method=POST action='$aksi?module=jadwal&act=input'>
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

              <label class='col-sm-3 col-form-label'>Dusun</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' id='dusuntambah' name='dusun'  readonly>
                <span id='textnik' class='text-info'></span>
              </div>
         </div>


         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Hari</label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='id_hari' id='id_hari' required>
        <option value=''/>Pilih Hari
        ";
         $tampil = mysqli_query($konek,"SELECT * FROM ref_hari  ");
         while($r=mysqli_fetch_array($tampil)){
            echo" 
            <option value='$r[id_hari]'/>$r[hari]";
             }
        echo"
        </select>
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
    </div>";
    }
    else{
      echo "Anda tidak berhak mengakses halaman ini.";
    }
     break;
    
  case "viewjadwal":
    $edit=mysqli_query($konek,"SELECT * FROM tb_warga WHERE id_warga='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    if ($_SESSION['level_user']=='Admin'){
  echo "
    <div class='breadcomb-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='breadcomb-list'>
                        <div class='row'>
                            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Data Jadwal</h2>
                                        <p>Laman Data Jadwal Keamanan</p>
                                    </div>
                                </div>
                            </div>
                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                             <button class='btn btn-md btn-primary' onclick=\"window.location.href='?module=jadwal';\">
                               <span class='fa fa-cog'></span> Atur Jadwal
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
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                    <div class='breadcomb-ctn'>
                                        <h2>Data Jadwal Ronda</h2>
                                        <p>Dusun Cihaur</p>
                                    </div>
                        <div class='table-responsive'>
                            <table  class='table table-striped table-hover table-bordered' >
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>NIK / Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>Senin</td>";

                                  $senin=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 1 AND tb_warga.id_lokasi= 1");

                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($senin)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>

                                  
                                  </tr>
                                  <tr>
                                  <td>Selasa</td>";
                                  $selasa=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 2 AND tb_warga.id_lokasi= 1");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($selasa)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td></tr>
                                  <tr>
                                  <td>Rabu</td>";
                                  $rabu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 3 AND tb_warga.id_lokasi= 1");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($rabu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Kemis</td>";
                                  $kamis=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 4 AND tb_warga.id_lokasi= 1");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($kamis)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Jumat</td>";
                                  $jumat=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 5 AND tb_warga.id_lokasi= 1");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($jumat)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Sabtu</td>";
                                  $sabtu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 6 AND tb_warga.id_lokasi= 1");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($sabtu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Minggu</td>";
                                  $minggu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 7 AND tb_warga.id_lokasi= 1");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($minggu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  </tbody>
                                  </table>

                                
                                        </div>
                                    </div>
                                </div>


              <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                      <div class='breadcomb-ctn'>
                                        <h2>Data Jadwal Ronda</h2>
                                        <p>Dusun Sindamangu</p>
                                    </div>
                        <div class='table-responsive'>
                            <table  class='table table-striped table-hover table-bordered' >
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>NIK / Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>Senin</td>";

                                  $senin=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 1 AND tb_warga.id_lokasi= 2");

                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($senin)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>

                                  
                                  </tr>
                                  <tr>
                                  <td>Selasa</td>";
                                  $selasa=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 2 AND tb_warga.id_lokasi= 2");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($selasa)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td></tr>
                                  <tr>
                                  <td>Rabu</td>";
                                  $rabu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 3 AND tb_warga.id_lokasi= 2");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($rabu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Kemis</td>";
                                  $kamis=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 4 AND tb_warga.id_lokasi= 2");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($kamis)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Jumat</td>";
                                  $jumat=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 5 AND tb_warga.id_lokasi= 2");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($jumat)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Sabtu</td>";
                                  $sabtu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 6 AND tb_warga.id_lokasi= 2");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($sabtu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Minggu</td>";
                                  $minggu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 7 AND tb_warga.id_lokasi= 2");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($minggu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  </tbody>
                                  </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <br><br>

            <div class='data-table-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                    <div class='breadcomb-ctn'>
                        <h2>Data Jadwal Ronda</h2>
                        <p>Dusun Cihaur Kidul</p>
                      </div>
                        <div class='table-responsive'>
                           <table  class='table table-striped table-hover table-bordered' >
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>NIK / Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>Senin</td>";

                                  $senin=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 1 AND tb_warga.id_lokasi= 3");

                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($senin)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>

                                  
                                  </tr>
                                  <tr>
                                  <td>Selasa</td>";
                                  $selasa=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 2 AND tb_warga.id_lokasi= 3");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($selasa)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td></tr>
                                  <tr>
                                  <td>Rabu</td>";
                                  $rabu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 3 AND tb_warga.id_lokasi= 3");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($rabu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Kemis</td>";
                                  $kamis=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 4 AND tb_warga.id_lokasi= 3");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($kamis)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Jumat</td>";
                                  $jumat=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 5 AND tb_warga.id_lokasi= 3");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($jumat)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Sabtu</td>";
                                  $sabtu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 6 AND tb_warga.id_lokasi= 3");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($sabtu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Minggu</td>";
                                  $minggu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 7 AND tb_warga.id_lokasi= 3");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($minggu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  </tbody>
                                  </table>
                                        </div>
                                    </div>
                                </div>


              <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <div class='data-table-list'>
                    <div class='breadcomb-ctn'>
                      <h2>Data Jadwal Ronda</h2>
                      <p>Dusun Garatengah</p>
                    </div>
                        <div class='table-responsive'>
                           <table  class='table table-striped table-hover table-bordered' >
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>NIK / Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>Senin</td>";

                                  $senin=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 1 AND tb_warga.id_lokasi= 4");

                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($senin)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>

                                  
                                  </tr>
                                  <tr>
                                  <td>Selasa</td>";
                                  $selasa=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 2 AND tb_warga.id_lokasi= 4");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($selasa)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td></tr>
                                  <tr>
                                  <td>Rabu</td>";
                                  $rabu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 3 AND tb_warga.id_lokasi= 4");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($rabu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Kemis</td>";
                                  $kamis=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 4 AND tb_warga.id_lokasi= 4");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($kamis)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Jumat</td>";
                                  $jumat=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 5 AND tb_warga.id_lokasi= 4");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($jumat)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Sabtu</td>";
                                  $sabtu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi ,tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 6 AND tb_warga.id_lokasi= 4");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($sabtu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  <tr>
                                  <td>Minggu</td>";
                                  $minggu=mysqli_query($konek,"SELECT tb_warga.id_lokasi AS lokasi , tb_ronda.nik AS nik, tb_warga.nama AS nama FROM tb_ronda LEFT JOIN tb_warga ON tb_warga.nik = tb_ronda.nik LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE tb_ronda.id_hari = 7 AND tb_warga.id_lokasi= 4");
                                  echo "<td>";
                                  while ($r=mysqli_fetch_array($minggu)) {
                                    echo"$r[nik] / $r[nama]<br/>";
                                  }
                                  echo"</td>
                                  </tr>
                                  </tbody>
                                  </table>
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
  $(function(){
    $('#pilihsemua').click(function(){
      $('input:checkbox').not(this).prop('checked',this.checked);
    });
    $('body').on('click','#hapus',function(){
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
          $('#hapussemua').submit();
        }
      });
    });
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
    $("#id_hari").attr("disabled","disabled");
     $("#textnik").text("Kurang");
      $("#namatambah").val("");
      $("#dusuntambah").val("");
}

  
else if(str==16 && str !=""){

 

      $.ajax({
        type:"POST",
        url:"./modelajax.php?id=ceknik2",
        data:{nik:nik},
        success: function(data){
          var nilai=data.split("/");
          if(nilai[0] == 1){
            $("#id_hari").removeAttr("disabled","disabled");
            $("#textnik").text("Terdaftar");
            $("#namatambah").val(nilai[1]);
            $("#dusuntambah").val(nilai[2]);

          }
          else{
             $("#id_hari").attr("disabled","disabled");
            $("#textnik").text("Tidak Terdaftar");
              $("#namatambah").val("");
           $("#dusuntambah").val("");

          }
        }
      });

}
else{
  $("#id_hari").attr("disabled","disabled");
  $("#textnik").text("berlebih");
   $("#namatambah").val("");
   $("#dusuntambah").val("");
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
        'Hapus Data Jadwal Posyandu',
        'Berhasil Menghapus Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'tidak_ada_data' ) {
      Swal.fire(
        'Hapus Data Jadwal Posyandu',
        'Gagal Menghapus Data, Tidak Ada Data Yang Terseleksi',
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


  });
</script>