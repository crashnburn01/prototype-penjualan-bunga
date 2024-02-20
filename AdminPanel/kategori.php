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
                                <h4 class="header-title">Daftar Kategori</h4>
                                <div class="data-tables datatable-primary">
                                    <table id="dataTable2" class="text-center" style="width:100%">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Kategori</th>
                                                <th>Jumlah Produk</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $barang = mysqli_query($conn, "SELECT * FROM kategori ORDER BY idkategori ASC");
                                                $no = 1;
                                                while($p = mysqli_fetch_array($barang)){
                                                    $id = $p['idkategori'];
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $p['namakategori'] ?></td>
                                                <td><?php
                                                    $result1 = mysqli_query($conn, "SELECT COUNT(idproduk) AS count FROM produk p, kategori k WHERE p.idkategori=k.idkategori AND k.idkategori='$id' ORDER BY idproduk ASC");
                                                    $cekrow = mysqli_num_rows($result1);
                                                    $row1 = mysqli_fetch_assoc($result1);
                                                    $count = $row1['count'];

                                                    if($cekrow>0){
                                                        echo number_format($count);
                                                    }
                                                    else{
                                                        echo 'NO DATA';
                                                    }
                                                ?></td>
                                                <td><?php echo $p['tgldibuat'] ?></td>
                                                <th>
                                                    <a href="editkategori.php?idkategori=<?= $p['idkategori']; ?>" class="btn btn-rounded btn-success sm-10">UBAH</a> 
                                                    <a href="?kode=<?= $p["idkategori"];?>" class="btn btn-rounded btn-danger sm-10" onclick="return confirm('yakin?');" >HAPUS</a>

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
                                            mysqli_query($conn, "DELETE FROM kategori WHERE idkategori='$_GET[kode]'");
                                            echo "<script>
                                                    alert('Kategori berhasil dihapus!');
                                                    document.location.href = 'kategori.php';
                                                </script>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Primary table end -->
                    
                    <!-- Dark table start -->
                    
                    <!-- Dark table end -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Kategori</h4>
                                    </div>
                                    <div class="modal-body">
                                        <a href="tambahkategori.php" class="form-control btn btn-primary">Tambah Kategori</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

					

            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->

<?php include "footer.php"; ?>