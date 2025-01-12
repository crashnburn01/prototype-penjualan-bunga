<?php
    session_start();
    include '../koneksi.php';
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>212173</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.php"><img src="assets/images/icon/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="index.php" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                            </li>

                            <li>
                                <a href="keloladata.php" aria-expanded="true"><i class="ti-server"></i><span>Kelola Pesanan</span></a>
                            </li>

                            <li>
                                <a href="laporanperiodik.php" aria-expanded="true"><i class="ti-server"></i><span>Riwayat Pemesanan</span></a>
                            </li>
                            <li>
                                <a href="pemasukantoko.php" aria-expanded="true"><i class="ti-server"></i><span>Data Pemasukan</span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>Kelola Toko</span></a>
                                <ul class="collapse">
                                    <li><a href="kategori.php">Kategori</a></li>

                                    <li><a href="kelolaproduk.php">Produk</a></li>

                                    <li><a href="kelolametode.php">Metode Pembayaran</a>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i><span>Kelola Akses</span></a>
                                <ul class="collapse">
                                    <li><a href="kelolapelanggan.php">Kelola Pelanggan</a></li>
                                    <li><a href="kelolastaff.php">Kelola Staff</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-info-alt"></i><span>Lainnya</span></a>
                                <ul class="collapse">
                                    <li><a href="../Web-Penjualan/index.php">Kembali ke Toko</a></li>
                                    <li><a href="../Web-Penjualan/logout.php">Logout</a></li>
                                </ul>
                            </li>

                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Selamat Datang</h4>
                            
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">Admin </h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->