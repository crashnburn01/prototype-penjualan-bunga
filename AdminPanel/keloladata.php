<?php 
    include "../koneksi.php";
    include "header.php"; 
?>

            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    
                    <!-- data table end -->
                    <!-- Primary table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Daftar Pesanan</h4>
                                <div class="data-tables datatable-primary">
                                    <table id="dataTable2" class="text-center" style="width:100%">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>ID Pemesanan</th>
                                                <th>Nama Customer</th>
                                                <th>Tanggal Order</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
											$brgs=mysqli_query($conn,"SELECT * from cart c, login l where c.userid=l.userid and status!='Cart' and status!='Selesai' order by idcart ASC");
											$no=1;
											while($p=mysqli_fetch_array($brgs)){
											$orderids = $p['orderid'];
										?>

                                            <tr>
                                                <td><?php echo $no++?></td>
                                                <td><strong><a href="invoice.php?orderid=<?php echo $p['orderid']?>">#<?php echo $p['orderid']?></a></strong></td>
                                                <td><?php echo $p['namalengkap']?></td>
                                                <td><?php echo $p['tglorder']?></td>
                                                <td>Rp
                                                    <?php
                                                        $result1 = mysqli_query($conn,"SELECT SUM(d.qty*p.hargaafter) AS count FROM detailorder d, produk p where orderid='$orderids' and p.idproduk=d.idproduk order by d.idproduk ASC");
                                                        $cekrow = mysqli_num_rows($result1);
												        $row1 = mysqli_fetch_assoc($result1);
												        $count = $row1['count']+10000;

                                                        if($cekrow){
                                                            echo number_format($count);
                                                        } else{
                                                            echo 'No Data';
                                                        }
                                                    ?>
                                                </td>

                                                <td><?php
                                                    $orders = $p['orderid'];
                                                    $konfirmasipembayaran = mysqli_query($conn, "SELECT * FROM konfirmasi WHERE orderid='$orders'");
                                                    $cekrow = mysqli_num_rows($konfirmasipembayaran);

                                                    if($cekrow>0){
                                                        echo 'Confirmed';
                                                    } else{
                                                        if($p['status']!='Pengiriman'){
                                                            echo "Menunggu Konfirmasi";
                                                        } else{
                                                            echo "Pengiriman";
                                                        };
                                                    }
                                                ?></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Primary table end -->
                    
                    <!-- Dark table start -->
                    
                    <!-- Dark table end -->
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->

<?php include "footer.php"; ?>