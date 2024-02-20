<?php
    include "../koneksi.php";
    include "header.php";

    $orderids = $_GET['orderid'];
    $liatcust = mysqli_query($conn, "SELECT * FROM login l, cart c WHERE orderid='$orderids' AND l.userid=c.userid");
    $checkdb = mysqli_fetch_array($liatcust);

    if(isset($_POST['kirim'])){
        $updatestatus = mysqli_query($conn, "UPDATE cart SET status='Pengiriman' WHERE orderid='$orderids'");
        $del = mysqli_query($conn, "DELETE FROM konfirmasi where orderid='$orderids'");

        if($updatestatus&&$del){
            echo 
            "<script>
            alert('Pesanan Dikirim!');
            document.location.href = 'keloladata.php';
            </script>";
        } else{
            echo 
            "<script>
            alert('Gagal Submit, Silahkan Coba Lagi!');
            document.location.href = 'keloladata.php';
            </script>";
        }
    };

    if(isset($_POST['selesai'])){
        $updatestatus = mysqli_query($conn, "UPDATE cart SET status='Selesai' WHERE orderid='$orderids'");

        // Decrease stock in 'produk' table based on cart information
        $updatestock = mysqli_query($conn, "
            UPDATE produk p
            JOIN detailorder d ON p.idproduk = d.idproduk
            SET p.stok = p.stok - d.qty
            WHERE d.orderid = '$orderids'
        ");

        if($updatestatus && $updatestock){
            echo 
            "<script>
            alert('Transaksi Diselesaikan!');
            document.location.href = 'keloladata.php';
            </script>";
        } else{
            echo 
            "<script>
            alert('Gagal Submit, Silahkan Coba Lagi!');
            document.location.href = 'keloladata.php';
            </script>";
        }
    };

?>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-area">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="iv-left col-6">
                                                <span>INVOICE</span>
                                            </div>
                                            <div class="iv-right col-6 text-md-right">
                                                <span>#<?php echo $orderids?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="invoice-address">
                                                <h3>invoiced to</h3>
                                                <h5><?php echo $checkdb['namalengkap'];?></h5>
                                                <p><?php echo $checkdb['alamat'];?></p>
                                                <p>Makassar</p>
                                                <p>Indonesia</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <ul class="invoice-date">
                                                <li>Waktu Order&nbsp;:&nbsp;&nbsp;<?php echo $checkdb['tglorder'];?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                    <th class="text-center" style="width: 5%;">No</th>
                                                    <th class="text-left" style="width: 45%; min-width: 130px;">Nama Produk</th>
                                                    <th>Jumlah</th>
                                                    <th style="min-width: 100px">Harga</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $barang = mysqli_query($conn, "SELECT * FROM detailorder d, produk p WHERE orderid='$orderids' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
                                                    $no = 1;

                                                    while($p=mysqli_fetch_array($barang)){
                                                        $total = $p['qty']*$p['hargaafter'];

                                                        $result = mysqli_query($conn, "SELECT SUM(d.qty*p.hargaafter) AS count FROM detailorder d, produk p WHERE orderid='$orderids' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
                                                        $row = mysqli_fetch_assoc($result);
                                                        $cekrow = mysqli_num_rows($result);
                                                        $count = $row['count'];
                                                    
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++?></td>
                                                    <td class="text-left"><?php echo $p['namaproduk']?></td>
                                                    <td><?php echo $p['qty']?></td>
                                                    <td>Rp.<?php echo number_format($p['hargaafter'])?></td>
                                                    <td>Rp.<?php echo number_format($total)?></td>
                                                </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">TOTAL BELANJA (Ongkir 10k)&nbsp;:</td>
                                                    <td>Rp.<?php
                                                        $result1 = mysqli_query($conn, "SELECT SUM(d.qty*p.hargaafter) AS count FROM detailorder d, produk p WHERE orderid='$orderids' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
                                                        $cekrow = mysqli_num_rows($result1);
                                                        $row1 = mysqli_fetch_assoc($result1);
                                                        $count = $row1['count']+10000;
                                                        if($cekrow > 0){
                                                            echo number_format($count);
                                                        } else{
                                                            echo 'No Data';
                                                        }
                                                    ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br>
                                    <?php
                                        if($checkdb['status']=='Confirmed'){
                                            $ambilinfo = mysqli_query($conn, "SELECT * FROM konfirmasi WHERE orderid='$orderids'");
                                            while($tarik=mysqli_fetch_array($ambilinfo)){
                                                $met = $tarik['payment'];
                                                $namarek = $tarik['namarekening'];
                                                $tglb = $tarik['tglbayar'];

                                                echo'
                                                <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                    <th class="text-left">Metode</th>
                                                    <th class="text-left">Pemilik Rekening</th>
                                                    <th>Tanggal Pembayaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-left">'.$met.'</td>
                                                    <td class="text-left">'.$namarek.'</td>
                                                    <td>'.$tglb.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <form method="post">
                                    <input type="submit" name="kirim" class="form-control btn btn-success" value="Kirim"\>
                                    </form>
                                                ';
                                            };
                                        } else{
                                            echo '
                                            <form method="post">
                                                <input type="submit" name="selesai" class="form-control btn btn-success" value="Selesaikan"\>
                                            </form>
                                            ';
                                        }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php include "footer.php"; ?>