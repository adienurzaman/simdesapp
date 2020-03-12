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
$aksi="modul/mod_restapi/aksi_restapi.php";
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
     echo "<div class='flash-data' data-flashdata='$_SESSION[flashdata]'></div>
    <div class='breadcomb-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='breadcomb-list'>
                        <div class='row'>
                            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Rest API</h2>
                                        <p>Laman Test Rest API</span></p>
                                    </div>

                                </div>
                            </div>
                            <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                             <button class='btn btn-md btn-primary' onclick=\"window.location.href='?module=restapi&act=kirimnotif';\">
                                Test Notifikasi
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
    ";
      $siap =mysqli_query($konek,"SELECT * FROM tb_push");
        $row =mysqli_fetch_assoc($siap);
 
      echo" 

        <form method=POST action='$aksi?module=restapi&act=insert'>
        

              
         <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>App ID</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control'  name='app_id' value='$row[app_id]' >
                <span  class='text-info'></span>
              </div>
         </div>


          <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>API Key</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control'  name='api_key' value='$row[api_key]' >
                <span  class='text-info'></span>
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Auth Key</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control'  name='auth_key' value='$row[auth_key]'  >
                <span  class='text-info'></span>
              </div>
         </div>

        <div class='form-group row'>
                <label class='col-sm-4 col-form-label'></label>
                  <div class='offset-sm-2 col-sm-4'>
                     <button type='submit' class='btn btn-success' name='ubah'><span  aria-hidden='true'></span> submit</button>                           
                       | 
                    <button type='reset' onclick=self.history.back() class='btn btn-danger'><span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span> Batal</button>
                  </div>
          </div>

        </form>

    <!--/container-->             
    </div>
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

   
  case "kirimnotif":
    if ($_SESSION['level_user']=='Admin'){
     echo "<div class='flash-data' data-flashdata='$_SESSION[flashdata]'></div>
    <div class='breadcomb-area'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='breadcomb-list'>
                        <div class='row'>
                            <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
                                <div class='breadcomb-wp'>
                                    <div class='breadcomb-ctn'>
                                        <h2>Rest API</h2>
                                        <p>Laman Test Rest API</span></p>
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
    
       

        <form method=POST action='$aksi?module=restapi&act=proseskirim'>
         
         <div class='form-group row'>

              <label class='col-sm-3 col-form-label'>Judul</label>
              <div class='col-sm-7'>
                <input type='text' class='form-control'  name='judul'  >
                <span id='textnik' class='text-info'></span>
              </div>
         </div>

        <div class='form-group row'>
              <label class='col-sm-3 col-form-label'>Isi Notifikasi</label>
              <div class='col-sm-7'>
                 <textarea  name='isi_pesan'  class='form-control'></textarea>
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

