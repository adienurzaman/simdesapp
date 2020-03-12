 <?php  if ($_SESSION['level_user']== 'Admin') {
$module = $_GET['module'];

                 ?>
 <!-- Mobile Menu start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul class="mobile-menu-nav">
                                <li><a   href="media.php?module=home">Dashboard</a>
                                </li>
                                <li><a   href="media.php?module=users">User</a>
                                </li>
                                <li><a   href="media.php?module=warga">Warga</a>
                                </li>
                                <li><a  data-target="#Kesehatan" href="#">Kesehatan</a>
                                    <ul id="Kesehatan" class="collapse dropdown-header-top">
                                        <li><a href="media.php?module=riwayat">Riwayat Kesehatan</a></li>
                                        <li><a href="media.php?module=posyandu">Jadwal Posyandu</a></li>
            
                                    </ul>
                                </li>
                                <li><a  data-target="#Keamanan" href="">Keamanan</a>
                                    <ul id="Keamanan" class="collapse dropdown-header-top">
                                        <li><a href="normal-table.html">Jadwal Keamanan</a></li>
                                        <li><a href="data-table.html">Status Keamanan</a></li>
                                    </ul>
                                </li>
                                <li><a   href="media.php?module=smartvillage">Smart Pole</a>
                                    
                                </li><li><a   href="media.php?module=restapi">Tes Rest API</a>
                                    
                                </li>
                                
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu end -->

	<div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li class="<?php if($module == 'home'){echo 'active';} ?>"><a href="media.php?module=home"><i class="fa fa-home"></i> Dashboard</a>
                        </li>
                        <li class="<?php if($module == 'users'){echo 'active';} ?>"><a  href="media.php?module=users"><i class="fa fa-user"></i>  User</a>
                        </li>
                        <li class="<?php if($module == 'warga'){echo 'active';} ?>"><a  href="media.php?module=warga"><i class="fa fa-group"></i> Warga</a>
                        </li>
                        <li><a data-toggle="tab" href="#kesehatan"><i class="fa fa-heartbeat"></i> Kesehatan</a>
                        </li>
                        <li><a data-toggle="tab" href="#keamanan"><i class="fa fa-lock"></i> Keamanan</a>
                        </li>
                        <li class="<?php if($module == 'smartvillage'){echo 'active';} ?>"><a href="media.php?module=smartvillage"><i class="fa fa-database"></i>  Smart Pole</a>
                        </li>
                        <li class="<?php if($module == 'restapi'){echo 'active';} ?>"><a href="media.php?module=restapi"><i class="fa fa-bell"></i> Test Rest API</a>
                        </li>
                    </ul>
                     <div class="tab-content custom-menu-content">
                        <div id="kesehatan" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li class="<?php if($module == 'riwayat'){echo 'active';} ?>"><a href="media.php?module=riwayat">Riwayat Kesehatan</a>
                                </li>
                                <li class="<?php if($module == 'posyandu'){echo 'active';} ?>"><a href="media.php?module=posyandu">Jadwal Posyandu</a>
                                </li>
                            </ul>
                        </div>
                        <div id="keamanan" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li class="<?php if($module == 'jadwal'){echo 'active';} ?>"><a href="media.php?module=jadwal&act=viewjadwal">Jadwal Keamanan</a>
                                </li>
                                <li class="<?php if($module == 'status'){echo 'active';} ?>"><a href="media.php?module=status">Status Keamanan</a>
                                </li>
                            </ul>
                        </div>
                        
                        <?php 
                            }else {
                              
                          
                          
                            }
                         ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  