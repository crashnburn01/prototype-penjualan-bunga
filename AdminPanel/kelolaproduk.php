<?php 
    include "../koneksi.php";
    include "header.php";
?>

            <div class="main-content-inner">
                <div class="row">

                    <!-- Primary table start -->
                    
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Daftar Produk</h4>
                                <div class="data-tables datatable-primary">
                                    <table id="dataTable2" class="text-center" style="width:100%">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>Gambar</th>
                                                <th>Nama</th>
                                                <th>Deskripsi</th>
                                                <th>Stok</th>
                                                <th>Rate</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $produk = mysqli_query($conn, "SELECT * FROM kategori k, produk p WHERE k.idkategori=p.idkategori ORDER BY idproduk ASC");
                                                $no = 1;
                                                while($p=mysqli_fetch_array($produk)){

                                            ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><img src="../produk/<?php echo $p['gambar'] ?>" width="50px"\></td>
                                                <td><?php echo $p['namaproduk']?></td>
                                                <td><?php echo $p['deskripsi']?></td>
                                                <td><?php echo $p['stok']?></td>
                                                <td><?php echo $p['rate']?></td>
                                                <td><?php echo $p['namakategori']?></td>
                                                <td><?php echo $p['hargaafter']?></td>
                                                <th>
                                                    <a href="editproduk.php?idproduk=<?= $p['idproduk']; ?>" class="btn btn-rounded btn-success sm-10">
                                                        <i class="ti-pencil-alt" style="align-items: center;"></i></a> 
                                                    <a href="?kode=<?= $p["idproduk"];?>" class="btn btn-rounded btn-danger sm-10" onclick="return confirm('yakin?');" >
                                                        <i class="ti-trash" style="align-items: center;"></i></a>

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
                                            mysqli_query($conn, "DELETE FROM produk WHERE idproduk='$_GET[kode]'");
                                            echo "<script>
                                                    alert('Produk berhasil dihapus!');
                                                    document.location.href = 'kelolaproduk.php';
                                                </script>";
                                        }
                                    ?>
                                </div>
                                <form action="" method="post" class="form-material">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a href="tambahproduk.php" class="btn btn-primary btn-round">Tambah Data</a>
                                        </div>     
                                    </div>  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->

<?php include "footer.php"; ?>