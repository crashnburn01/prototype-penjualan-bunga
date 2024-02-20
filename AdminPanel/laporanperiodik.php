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
                                <h4 class="header-title">Riwayat Pemesanan</h4><br>

                                <form action="laporanperiodik.php" method="get">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input class="form-control" type="date" name="dari" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input class="form-control" type="date" name="ke" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input name="cari" type="submit" class="btn btn-rounded btn-primary mb-3" value="Cari">
                                        </div>
                                    </div>
                                </form>
                                
                                <div class="data-tables datatable-primary">
                                    <table id="dataTable2" class="text-center" style="width:100%">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>Tanggal Pemesanan</th>
                                                <th>ID Pemesanan</th>
                                                <th>Nama Kustomer</th>
                                                <th>Alamat</th>
                                                <th>No. Telp</th>
                                                <th>Pembayaran</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            if (isset($_GET['dari']) && isset($_GET['ke'])) {
                                                // Tampilkan data yang sesuai dengan range tanggal yang dicari 
                                                $dari = mysqli_real_escape_string($conn, $_GET['dari']);
                                                $ke = mysqli_real_escape_string($conn, $_GET['ke']);

                                                $query = "SELECT * FROM cart c, login l WHERE c.userid = l.userid AND status='Selesai' AND tglorder BETWEEN '$dari' AND '$ke' ORDER BY idcart ASC";

                                                $brgs = mysqli_query($conn, $query);

                                                if(!$brgs){
                                                    die("Query error: " . mysqli_error($conn));
                                                }
                                            } else{
                                                $brgs = mysqli_query($conn, "SELECT * from cart c, login l where c.userid=l.userid and status='Selesai' order by idcart ASC");
                                            }

											//$brgs=mysqli_query($conn,"SELECT * from cart c, login l where c.userid=l.userid and status='Selesai' order by idcart ASC");
											$no=1;
											while($p=mysqli_fetch_array($brgs)){
											$orderids = $p['orderid'];
										?>

                                            <tr>
                                                <td><?php echo $p['tglorder']?></td>
                                                <td><strong><a href="riwayatpesanan.php?orderid=<?php echo $p['orderid']?>">#<?php echo $p['orderid']?></a></strong></td>
                                                <td><?php echo $p['namalengkap']?></td>
                                                <td><?php echo $p['alamat']?></td>
                                                <td><?php echo $p['notelp']?></td>
                                                
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

                                                <td>Selesai</td>
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