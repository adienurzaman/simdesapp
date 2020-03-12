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
$aksi="modul/mod_warga/aksi_warga.php";
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
                                        <h2>Data Warga</h2>
                                        <p>Laman Data Warga</span></p>
                                    </div>

                                </div>
                            </div>
                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                             <button class='btn btn-md btn-primary' onclick=\"window.location.href='?module=warga&act=tambahwarga';\">
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
                                        <th>NOKK</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>";
                                if(isset($cari)){
                                 $tampil = mysqli_query($konek,"SELECT * FROM tb_warga WHERE id_warga  like '%$cari%' or nokk like '%$cari%' or nik like '%$cari%'  or nama like '%$cari%' ");
                                 }else{
                                 $tampil = mysqli_query($konek,"SELECT * FROM tb_warga ORDER BY nik ");
                                } 
                                $no=$mulai + 1;
                                while ($r=mysqli_fetch_array($tampil)){
                                echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>$r[nokk]</td>
                                        <td>$r[nik]</td>
                                        <td>$r[nama]</td>
                                        <td class='center' width='275'>
                                         <a value='editwaraga' href='?module=warga&act=detailwarga&id=$r[id_warga]' class='btn btn-sm btn-warning'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Detail</a>
                                         |
                                         <a href='?module=warga&act=editwarga&id=$r[id_warga]' class='btn btn-sm btn-success'><span class='fa fa-pencil-square-o' aria-hidden='true'></span> Ubah</a>
                                         |
                                        <a href='$aksi?module=warga&act=hapus&nik=$r[nik]' class='btn btn-sm btn-danger btn-hapus'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span> Hapus</a></td>
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

    case "detailwarga":
    $detail=mysqli_query($konek,"SELECT * FROM tb_warga LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE id_warga='$_GET[id]'");
    $r=mysqli_fetch_array($detail);

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
                                        <h2>Data Warga </h2>
                                        <p>Laman Detail Data Warga</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                             <button class='btn btn-md btn-primary' onclick=\"window.history.go(-1);\">
                               <span class='fa fa-'></span> Kembali
                               </button> 
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

        <form method=POST action='$aksi?module=warga&act=update'>
              <input type='hidden' class='form-control' name='id_warga' value='$r[id_warga]' required='required'  >
            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>No Kartu Keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nokk' value='$r[nokk]' required='required' readonly >
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>No Induk keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nik' value='$r[nik]' required='required' readonly >
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Nama Lengkap</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nama' value='$r[nama]' required='required'  readonly>
              </div>
         </div>
         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tempat Lahir</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='tempat_lahir' value='$r[tempat_lahir]' required='required' readonly >
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tanggal Lahir</label>
              <div class='col-sm-7'>
                <input type='date' class='form-control' name='tanggal_lahir' value='$r[tanggal_lahir]' required='required' readonly >
              </div>
         </div>
          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jenis Kelamin </label>
              <div class='col-sm-7'>
        <input type='text' class='form-control' name='jk' value='$r[jk]' required='required' readonly >
        </div>
        </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Golongan Darah </label>
              <div class='col-sm-7'>
      <input type='text' class='form-control' name='tempat_lahir' value='$r[gol_darah]' required='required' readonly >
        </div>
        </div>        

            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>RT</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='rt'  value='$r[rt]' readonly >
              </div>
         </div>

             <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>RW</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='rw' value='$r[rw]' readonly>
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Dusun</label>
              <div class='col-sm-7'>
       <input type='text' class='form-control' name='tempat_lahir' value='$r[dusun]' required='required' readonly >
        
        </div>
        </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Desa</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='desa' value='$r[desa]' required='required' readonly>
              </div>
         </div>

          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kecamatan</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='kecamatan'value='$r[kecamatan]'  required='required' readonly>
              </div>
         </div>
          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kabupaten</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='kabupaten' value='$r[kabupaten]' required='required' readonly>
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Agama </label>
              <div class='col-sm-7'>
       <input type='text' class='form-control' name='tempat_lahir' value='$r[agama]' required='required' readonly >
        </div>
         </div>


        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Status Perkawinan </label>
              <div class='col-sm-7'>
       <input type='text' class='form-control' name='tempat_lahir' value='$r[s_perkawinan]' required='required' readonly >
        </div>
         </div>

            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kewarganegaraan </label>
              <div class='col-sm-7'>
        <input type='text' class='form-control' name='tempat_lahir' value='$r[kewarganegaraan]' required='required' readonly >
        </div>
         </div>

          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jabatan </label>
              <div class='col-sm-7'>
       <input type='text' class='form-control' name='tempat_lahir' value='$r[jabatan]' required='required' readonly >
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

  case "tambahwarga":
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
                                        <h2>Data Warga </h2>
                                        <p>Laman Tambah Data Warga</span></p>
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

        <form method=POST action='$aksi?module=warga&act=input'>
             <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>level_user</label>
              <div class='col-sm-7'>
                <select  class='form-control'  name='level_user'>
         <option value=''/>Pilih Level User
        <option value='Admin'/>Admin
        <option value='Warga'/>Warga
        </select>
              </div>
         </div>

         <hr>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>No Induk keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nik' placeholder='Masukan Nomer Induk Keluarga Anda' required='required'id='nik'>
                <span class='text-warning' id='textnik'></span>
              </div>
         </div>

            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>No Kartu Keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nokk' placeholder='Masukan Nomer Kartu Keluarga Anda' required='required' id='nokk'>
                <span class='text-warning' id='textnokk'></span>
              </div>
         </div>


         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Nama Lengkap</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nama' placeholder='Masukan Nama Lengkap Anda' required='required'id='nama'>
              </div>
         </div>
         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tempat Lahir</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='tempat_lahir' placeholder='Masukan Tempat Lahir  Anda' required='required'id='tempat_lahir'>
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tanggal Lahir</label>
              <div class='col-sm-7'>
                <input type='date' class='form-control' name='tanggal_lahir' placeholder='Masukan Tanggal Lahir  Anda' required='required'id='tanggal_lahir'>
              </div>
         </div>

          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jenis Kelamin </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='jk' id='jk'>
         <option value=''/>Pilih Jenis Kelamin
        <option value='Laki-laki'/>Laki-laki 
        <option value='Perempuan'/>Perempuan
        </select>
        </div>
        </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Golongan Darah </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='gol_darah' id='gol_darah'>
         <option value=''/>Pilih Golongan Darah
        <option value='A'/>A
        <option value='B'/>B
        <option value='AB'/>AB
        <option value='O'/>O
        </select>
        </div>
        </div>        

            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>RT</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='rt' placeholder='Masukan RT  Anda' required='required' id='rt'>
              </div>
         </div>

             <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>RW</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='rw' placeholder='Masukan RW  Anda' required='required' id='rw'>
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Dusun</label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='id_lokasi' id='id_lokasi'>
        <option value=''/>Pilih Lokasi
        ";
         $tampil = mysqli_query($konek,"SELECT * FROM ref_lokasi  ");
         while($r=mysqli_fetch_array($tampil)){
            echo" 
            <option value='$r[id_lokasi]'/>$r[dusun]";
             }
        echo"
        </select>
        </div>
        </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Desa</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='desa' value='Cihaur' id='desa' required='required'>
              </div>
         </div>

          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kecamatan</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='kecamatan'value='Maja' id='kecamatan' required='required'>
              </div>
         </div>
          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kabupaten</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='kabupaten' value='Majalengka' id='kabupaten' required='required'>
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Agama </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='agama' id='agama'>
         <option value=''/>Pilih Agama
        <option value='Islam'/>Islam 
        <option value='Katolik'/>Katolik
        <option value='Hindu'/>Hindu
        <option value='Budha'/>Budha
        
        </select> 
        </div>
         </div>


        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Status Perkawinan </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='s_perkawinan' id='s_perkawinan'>
        <option value=''/>Pilih Status Perkawinan 
        <option value='Kawin'/>Kawin 
        <option value='Belum Kawin'/>Belum Kawin
        
        </select> 
        </div>
         </div>

            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kewarganegaraan </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='kewarganegaraan' id='kewarganegaraan'>
        <option value=''/>Pilih Warga negara
        <option value='WNI'/>WNI
        <option value='WNA'/>WNA
        
        </select> 
        </div>
         </div> 

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jabatan </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='jabatan' id='jabatan'>
        <option value=''/>Pilih Jabatan 
        <option value='Bidan'/>Bidan
        <option value='Limnas'/>Limnas
        <option value='Warga'/>Warga
        
        </select> 
        </div>
         </div>
        
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
    
  case "editwarga":
    $edit=mysqli_query($konek,"SELECT * FROM tb_warga LEFT JOIN ref_lokasi ON ref_lokasi.id_lokasi = tb_warga.id_lokasi WHERE id_warga='$_GET[id]'");
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
                                        <h2>Data Warga </h2>
                                        <p>Laman Ubah Data Warga</span></p>
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

        <form method=POST action='$aksi?module=warga&act=update'>
              <input type='hidden' class='form-control' name='id_warga' value='$r[id_warga]' required='required'  >
            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>No Kartu Keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nokk' value='$r[nokk]' required='required' readonly >
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>No Induk keluarga</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nik' value='$r[nik]' required='required' readonly >
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Nama Lengkap</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='nama' value='$r[nama]' required='required' >
              </div>
         </div>
         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tempat Lahir</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='tempat_lahir' value='$r[tempat_lahir]' required='required' >
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Tanggal Lahir</label>
              <div class='col-sm-7'>
                <input type='date' class='form-control' name='tanggal_lahir' value='$r[tanggal_lahir]' required='required' >
              </div>
         </div>
          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jenis Kelamin </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='jk' >
        <option value='$r[jk]'/>$r[jk]
        <option value=''/>--- Ubah Jenis Kelamin ---
        <option value='Laki-laki'/>Laki-laki 
        <option value='Perempuan'/>Perempuan
        </select>
        </div>
        </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Golongan Darah </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='gol_darah'>
         <option value='$r[gol_darah]'/>$r[gol_darah]
         <option value=''/>--- Ubah Golongan Darah ---
        <option value='A'/>A
        <option value='B'/>B
        <option value='AB'/>AB
        <option value='O'/>O
        </select>
        </div>
        </div>        

            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>RT</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='rt'  value='$r[rt]' >
              </div>
         </div>

             <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>RW</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='rw' value='$r[rw]' >
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Dusun</label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='id_lokasi'>
        <option value='$r[id_lokasi]'/>$r[dusun]
        <option value=''/>--- Ubah Lokasi ---";
        $lokasi=mysqli_query($konek,"SELECT * FROM ref_lokasi");
        while ($d=mysqli_fetch_array($lokasi)){
            echo"<option value='$d[id_lokasi]'/>$d[dusun]";
        }
        echo"
         </select>
        
        </div>
        </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Desa</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='desa' value='$r[desa]' required='required'>
              </div>
         </div>

          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kecamatan</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='kecamatan'value='$r[kecamatan]'  required='required'>
              </div>
         </div>
          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kabupaten</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control' name='kabupaten' value='$r[kabupaten]' required='required'>
              </div>
         </div>

         <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Agama </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='agama'>
         <option value='$r[agama]'/>$r[agama]
         <option value=''/>--- Ubah Agama ---
        <option value='Islam'/>Islam 
        <option value='Katolik'/>Katolik
        <option value='Hindu'/>Hindu
        <option value='Budha'/>Budha
        
        </select> 
        </div>
         </div>


        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Status Perkawinan </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='s_perkawinan'>
        <option value='$r[s_perkawinan]'/>$r[s_perkawinan]
        <option value='Kawin'/>Kawin 
        <option value='Belum Kawin'/>Belum Kawin
        
        </select> 
        </div>
         </div>

            <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Kewarganegaraan </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='kewarganegaraan'>
        <option value='$r[kewarganegaraan]'/>$r[kewarganegaraan]
        <option value='WNI'/>WNI
        <option value='WNA'/>WNA
        
        </select> 
        </div>
         </div>

          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Jabatan </label>
              <div class='col-sm-7'>
        <select  class='form-control'  name='jabatan'>
        <option value='$r[jabatan]'/>$r[jabatan]
        <option value='Bidan'/>Bidan
        <option value='Limnas'/>Limnas
        <option value='Warga'/>Warga
        
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
      nokk();
    
    },400) ;


    function nokk(){
        var nokk=$("#nokk").val();
        var str=nokk.length;
        var nik=$("#nik").val();
     if(str>0 && str<16  || str== ""){
     $("#textnokk").text("Kurang");
        }
        else if (str==16 && str !="" && nokk!=nik){
            $("#textnokk").text("");
        }else if(str==16 && str !="" && nokk==nik){
            $("#textnokk").text("NOKK Tidak Boleh Sama Dengan NIK");
        }else{
    
            $("#textnokk").text("berlebih");
        }
    }
    
  function carinik(){
      var nik=$("#nik").val();
  var str=nik.length;
  if(str>0 && str<16  || str== ""){
    $("#nokk").attr("disabled","disabled");
    $("#nama").attr("disabled","disabled");
    $("#tempat_lahir").attr("disabled","disabled");
    $("#tanggal_lahir").attr("disabled","disabled");
    $("#jk").attr("disabled","disabled");
    $("#gol_darah").attr("disabled","disabled");
    $("#rt").attr("disabled","disabled");
    $("#rw").attr("disabled","disabled");
    $("#id_lokasi").attr("disabled","disabled");
    $("#desa").attr("disabled","disabled");
    $("#kecamatan").attr("disabled","disabled");
    $("#kabupaten").attr("disabled","disabled");
    $("#agama").attr("disabled","disabled");
    $("#s_perkawinan").attr("disabled","disabled");
    $("#kewarganegaraan").attr("disabled","disabled");
    $("#jabatan").attr("disabled","disabled");
     $("#textnik").text("Kurang");
     
}

  
else if(str==16 && str !=""){

 

      $.ajax({
        type:"POST",
        url:"./modelajax.php?id=ceknik",
        data:{nik:nik},
        success: function(data){
          var nilai=data.split("/");
          if(nilai[0] == 1){
           $("#nokk").attr("disabled","disabled");
    $("#nama").attr("disabled","disabled");
    $("#tempat_lahir").attr("disabled","disabled");
    $("#tanggal_lahir").attr("disabled","disabled");
    $("#jk").attr("disabled","disabled");
    $("#gol_darah").attr("disabled","disabled");
    $("#rt").attr("disabled","disabled");
    $("#rw").attr("disabled","disabled");
    $("#id_lokasi").attr("disabled","disabled");
    $("#desa").attr("disabled","disabled");
    $("#kecamatan").attr("disabled","disabled");
    $("#kabupaten").attr("disabled","disabled");
    $("#agama").attr("disabled","disabled");
    $("#s_perkawinan").attr("disabled","disabled");
    $("#kewarganegaraan").attr("disabled","disabled");
    $("#jabatan").attr("disabled","disabled");
            $("#textnik").text("Terdaftar");
           
          }
          else{
            $("#nokk").removeAttr("disabled","disabled");
    $("#nama").removeAttr("disabled","disabled");
    $("#tempat_lahir").removeAttr("disabled","disabled");
    $("#tanggal_lahir").removeAttr("disabled","disabled");
    $("#jk").removeAttr("disabled","disabled");
    $("#gol_darah").removeAttr("disabled","disabled");
    $("#rt").removeAttr("disabled","disabled");
    $("#rw").removeAttr("disabled","disabled");
    $("#id_lokasi").removeAttr("disabled","disabled");
    $("#desa").removeAttr("disabled","disabled");
    $("#kecamatan").removeAttr("disabled","disabled");
    $("#kabupaten").removeAttr("disabled","disabled");
    $("#agama").removeAttr("disabled","disabled");
    $("#s_perkawinan").removeAttr("disabled","disabled");
    $("#kewarganegaraan").removeAttr("disabled","disabled");
    $("#jabatan").removeAttr("disabled","disabled");
            $("#textnik").text("Belum Terdaftar");
             
          }
        }
      });

}
else{
 $("#nokk").attr("disabled","disabled");
    $("#nama").attr("disabled","disabled");
    $("#tempat_lahir").attr("disabled","disabled");
    $("#tanggal_lahir").attr("disabled","disabled");
    $("#jk").attr("disabled","disabled");
    $("#gol_darah").attr("disabled","disabled");
    $("#rt").attr("disabled","disabled");
    $("#rw").attr("disabled","disabled");
    $("#id_lokasi").attr("disabled","disabled");
    $("#desa").attr("disabled","disabled");
    $("#kecamatan").attr("disabled","disabled");
    $("#kabupaten").attr("disabled","disabled");
    $("#agama").attr("disabled","disabled");
    $("#s_perkawinan").attr("disabled","disabled");
    $("#kewarganegaraan").attr("disabled","disabled");
    $("#jabatan").attr("disabled","disabled");
  $("#textnik").text("berlebih");
  
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
        'Hapus Data Warga',
        'Berhasil Menghapus Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'hapus_gagal' ) {
      Swal.fire(
        'Hapus Data Warga',
        'Gagal Menghapus Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Tambah
    if ( flashdata == 'tambah_sukses' ) {
      Swal.fire(
        'Tambah Data Warga',
        'Berhasil Menambah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'tambah_gagal' ) {
      Swal.fire(
        'Tambah Data Warga',
        'Gagal Menambah Data',
        'error'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    //Ubah
    if ( flashdata == 'ubah_sukses' ) {
      Swal.fire(
        'Ubah Data Warga',
        'Berhasil Mengubah Data',
        'success'
      );
    <?php unset($_SESSION['flashdata']); ?>
    }

    if ( flashdata == 'ubah_gagal' ) {
      Swal.fire(
        'Ubah Data Warga',
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
        text: "Akan menghapus data warga ini",
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
