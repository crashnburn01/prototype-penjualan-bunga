<?php 
    include "header.php"; 
    include "../koneksi.php";

    $rawcust = mysqli_query($conn,"select count(userid) as jumlahcust from login where role='Member'");
	$rawcust2 = mysqli_fetch_assoc($rawcust);
	$itungcust = $rawcust2['jumlahcust'];
	
	$raworder = mysqli_query($conn,"select count(idcart) as jumlahorder from cart where status not like 'Selesai' and status not like 'Canceled'");
	$raworder2 = mysqli_fetch_assoc($raworder);
	$itungorder = $raworder2['jumlahorder'];
	
	$rawtrans = mysqli_query($conn,"select count(orderid) as jumlahtrans from konfirmasi");
	$rawtrans2 = mysqli_fetch_assoc($rawtrans);
	$itungtrans = $rawtrans2['jumlahtrans'];

?>

            <div class="main-content-inner">
                <!-- sales report area start -->
                <div class="sales-report-area mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="single-report mb-xs-30">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-group"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Pelanggan</h4>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h1><?php echo $itungcust?></h1>
                                    </div>
									</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="single-report">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-circle-o-notch"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Pesanan</h4>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h1><?php echo $itungorder?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="single-report mb-xs-30">
                                <div class="s-report-inner pr--20 pt--30 mb-3">
                                    <div class="icon"><i class="fa fa-check"></i></div>
                                    <div class="s-report-title d-flex justify-content-between">
                                        <h4 class="header-title mb-0">Konfirmasi Pembayaran</h4>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <h1><?php echo $itungtrans?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
<?php include "footer.php"; ?>