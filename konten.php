<?php
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/class_paging.php";
// Bagian Home
if ($_GET['module']=='home'){
   if ($_SESSION['level_user']=='Admin'){
  $jam=date("H:i:s");
  $tgl=tgl_indo(date("Y m d"));
  
  $tgl_real = date("d-m-Y");
  $tgl_skrng = date("Y-m-d");

?>

<style type="text/css">
.img-responsive{
    overflow:hidden;
    padding-bottom:56.25%;
    position:relative;
    height:0;
}
.img-responsive iframe{
    left:0;
    top:0;
    height:100%;
    width:100%;
    position:absolute;
}
</style>

<script type="text/javascript">
$(function(){
    setInterval(function(){
        cek();
    },2000);

function cek() {
    $.ajax({
        url: "./modelajax.php?id=get_image",
        cache: false,
        success: function(data){
            var str = data.split("|");
            $("#monitor").html("");
            $("#monitor").html(str[1]);
            $("#ket_waktu").text("");
            $("#ket_waktu").text(str[0]);
        }
    });
}

});

</script>

<!-- MAIN CONTENT-->
                        
            <!-- Breadcomb area Start-->
    <div class="breadcomb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcomb-list">
                        <div class="row">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcomb-wp">
                                    <div class="breadcomb-icon">
                                    </div>
                                    <div class="breadcomb-ctn">
                                        <h2><center>Selamat Datang </center></h2>
                                        <p align=center><?php echo"Hai <b>$_SESSION[nama]</b>, selamat datang di halaman Administrator. 
                                            Silahkan klik menu pilihan yang berada di bagian Menubar untuk mengelola  Smart Village System Desa Cihaur  . <br /> <b>$hari_ini, $tgl, $jam </b>WIB</p>";?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcomb area End-->
    <div class="notika-status-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                        <div class="website-traffic-ctn">
                            <h2 id='areaSuhu'></h2>
                            <p>Suhu Udara</p>
                        </div>
                        
                        <div class="sparkline-bar-stats1"><?php 
                          $sql=mysqli_query($konek,"SELECT * FROM tb_suhu order by id_suhu desc limit 6");
                          while($row = mysqli_fetch_array($sql))  {

                            echo $row['nilai_suhu'].",";
                          }
                         ?></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                    	 
                        <div class="website-traffic-ctn">
                            <h2 id='areaKU'></h2>
                            <p>Kualitas Udara</p>
                        </div>
                        <div class="sparkline-bar-stats2"><?php 
                          $sql=mysqli_query($konek,"SELECT * FROM tb_kualitasudara order by id_ku desc limit 6");
                          while($row = mysqli_fetch_array($sql))  {

                            echo $row['n_ku'].",";
                          }
                         ?></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                    	 
                        <div class="website-traffic-ctn">
                            <h2 id='areaKL'></h2>
                            <p>Kelembaban</p>
                        </div>
                        <div class="sparkline-bar-stats3"><?php 
                          $sql=mysqli_query($konek,"SELECT * FROM tb_kelembaban order by id_kl desc limit 6");
                          while($row = mysqli_fetch_array($sql))  {

                            echo $row['n_kl'].",";
                          }
                         ?></div>
                    </div>
                </div>
                
                <script>
                    $(function(){
                        setInterval(function(){
                            suhu();
                        },1000);
                                
                        function suhu()
                        {
                            $.ajax({
                                url : "./modelajax.php?id=get_data_latest",
                                cache : false,
                                dataType: "JSON",
                                success : function(data){
                                        var suhu = ""+data.suhu+"&#176; Celcius";
                                        var ku = ""+data.ppm+" PPM";
                                        var kl = ""+data.kl+" %";
                                        $("#areaSuhu").html(suhu); 
                                        $("#areaKU").html(ku);
                                        $("#areaKL").html(kl); 
                                }
                            });    
                        }
                                 
                    });
                </script>
                
            </div>
        </div>
    </div>
    <!-- End Status area-->
    <!-- Start Sale Statistic area-->
    <div class="sale-statistic-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
                    <div class="sale-statistic-inner notika-shadow mg-tb-30">
                        <div class="curved-inner-pro">
                            <div class="curved-ctn">
                                <h2>Monitoring Lingkungan</h2>
                                
                            </div>
                        </div>
                        <div class="img-responsive" id="monitor" width="600" height="450" frameborder="0" style="border:0">
                            
                        </div>
                        <c class='text-warning' id="ket_waktu"></c>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
                    <div class="statistic-right-area notika-shadow mg-tb-30 sm-res-mg-t-0">
                        <!-- <div class="past-day-statis">
                            <h3>Kualitas Udara</h3>
                        </div>
                        <div class="dash-widget-visits"></div> -->
                        <h2>Posyandu</h2>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3>Haurkuning I</h3>
                                <p>Blok Desa</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-bar"></div>
                            </div>
                        </div>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3>Haurkuning II</h3>
                                <p>Sindangmangu</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-bar"></div>
                            </div>
                        </div>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3>Haurkuning III</h3>
                                <p>Cihaur Kidul</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-bar-2"></div>
                            </div>
                        </div>
                        <div class="past-statistic-an">
                            <div class="past-statistic-ctn">
                                <h3>Haurkuning IV</h3>
                                <p>Garatengah</p>
                            </div>
                            <div class="past-statistic-graph">
                                <div class="stats-bar-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sale Statistic area-->
<?php
}
elseif ($_SESSION['level_user']=='Warga') {
    $jam=date("H:i:s");
  $tgl=tgl_indo(date("Y m d"));
  
  $tgl_real = date("d-m-Y");
  $tgl_skrng = date("Y-m-d");
 
    ?>

  <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- 404 Page area Start-->
    <div class="error-page-area">
        <div class="error-page-wrap">
            <i class="notika-icon notika-close"></i>
            <h2>ERROR <span class="counter">404</span></h2>
            <p>Maaf fitur ini belum dapat di akses oleh warga di web service.</p>
            <a href="http://simdesapp.windstandrobotic.org//" class="btn">Logout</a>
            <a href="#" class="btn error-btn-mg">Report Problem</a>
        </div>
    </div>
    <!-- 404 Page area End-->
    <!-- jquery
        ============================================ -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
        ============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- wow JS
        ============================================ -->
    <script src="js/wow.min.js"></script>
    <!-- price-slider JS
        ============================================ -->
    <script src="js/jquery-price-slider.js"></script>
    <!-- owl.carousel JS
        ============================================ -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- scrollUp JS
        ============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- meanmenu JS
        ============================================ -->
    <script src="js/meanmenu/jquery.meanmenu.js"></script>
    <!-- counterup JS
        ============================================ -->
    <script src="js/counterup/jquery.counterup.min.js"></script>
    <script src="js/counterup/waypoints.min.js"></script>
    <script src="js/counterup/counterup-active.js"></script>
    <!-- mCustomScrollbar JS
        ============================================ -->
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sparkline JS
        ============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/sparkline-active.js"></script>
    <!-- flot JS
        ============================================ -->
    <script src="js/flot/jquery.flot.js"></script>
    <script src="js/flot/jquery.flot.resize.js"></script>
    <script src="js/flot/flot-active.js"></script>
    <!-- knob JS
        ============================================ -->
    <script src="js/knob/jquery.knob.js"></script>
    <script src="js/knob/jquery.appear.js"></script>
    <script src="js/knob/knob-active.js"></script>
    <!--  wave JS
        ============================================ -->
    <script src="js/wave/waves.min.js"></script>
    <script src="js/wave/wave-active.js"></script>
    <!--  Chat JS
        ============================================ -->
    <script src="js/chat/jquery.chat.js"></script>
    <!--  todo JS
        ============================================ -->
    <script src="js/todo/jquery.todo.js"></script>
    <!-- plugins JS
        ============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
        ============================================ -->
    <script src="js/main.js"></script>
            
    <?php
}
}
elseif ($_GET['module']=='users'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_users/users.php";
  }
}

// Bagian Warga
elseif ($_GET['module']=='warga'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_warga/warga.php";
  }
}

// Bagian posyandu
elseif ($_GET['module']=='posyandu'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_posyandu/posyandu.php";
  }
}

// Bagian Riwayat Kesehatan
elseif ($_GET['module']=='riwayat'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_riwayat/riwayat.php";
  }
}
// Bagian Jadwal Keamanan
elseif ($_GET['module']=='jadwal'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_jadwal/jadwal.php";
  }
}
// Bagian Jadwal Keamanan
elseif ($_GET['module']=='smartvillage'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_smartvillage/smartvillage.php";
  }
}
// Bagian Status Keamanan
elseif ($_GET['module']=='status'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_status/status.php";
  }
}

// Bagian Reset
elseif ($_GET['module']=='restapi'){
  if ($_SESSION['level_user']=='Admin'){
    include "modul/mod_restapi/restapi.php";
  }
}

// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}

?>
