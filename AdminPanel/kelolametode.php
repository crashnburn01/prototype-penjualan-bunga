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
                                <h4 class="header-title">Daftar Metode Pembayaran</h4>
                                <div class="data-tables datatable-primary">
                                    <table id="dataTable2" class="text-center" style="width:100%">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Metode</th>
                                                <th>No. Rek</th>
                                                <th>Atas Nama</th>
                                                <th>Logo URL</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                                $data = mysqli_query($conn, "SELECT * FROM pembayaran");
                                                $nomor = 1;
                                                while($p = mysqli_fetch_array($data)){
                                                    
                                            ?>
                                            <tr>
                                                <td><?php echo $nomor++ ?></td>
                                                <td><?php echo $p['metode']?></td>
                                                <td><?php echo $p['norek']?></td>
                                                <td><?php echo $p['an']?></td>
                                                <td><?php echo $p['logo']?></td>
                                                <th>
                                                    <a href="editmetode.php?no=<?= $p['no']; ?>" class="btn btn-rounded btn-success sm-10">UBAH</a> 
                                                    <a href="?kode=<?= $p["no"];?>" class="btn btn-rounded btn-danger sm-10" onclick="return confirm('Yakin?');" >HAPUS</a>

                                                    <!-- syntax href ubah: edit-ketegori.php?idkategori=< ?= $p["idkategori"];?> -->
                                                    <!-- syntax href hapus: edit-ketegori.php?idkategori=< ?= $p["idkategori"];?> -->
                                                </th>
                                            </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                        if(isset($_GET['kode'])){
                                            mysqli_query($conn, "DELETE FROM pembayaran WHERE no='$_GET[kode]'");
                                            echo "<script>
                                                    alert('Metode Pembayaran berhasil dihapus!');
                                                    document.location.href = 'kelolametode.php';
                                                </script>";
                                        }
                                    ?>
                                </div>
                                <form action="" method="post" class="form-material">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="tambahmetode.php" class="btn btn-primary btn-round">Tambah</a>
                                        </div>     
                                    </div>  
                                </form>
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