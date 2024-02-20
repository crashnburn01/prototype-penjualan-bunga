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
                                <h4 class="header-title">Daftar Pelanggan</h4>
                                <div class="data-tables datatable-primary">
                                    <table id="dataTable2" class="text-center" style="width:100%">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pelanggan</th>
                                                <th>No. Telepon</th>
                                                <th>Alamat</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                                $data = mysqli_query($conn, "SELECT * FROM login WHERE role='Member'");
                                                $no = 1;
                                                while($p = mysqli_fetch_array($data)){
                                                    
                                            ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $p['namalengkap']?></td>
                                                <td><?php echo $p['notelp']?></td>
                                                <td><?php echo $p['alamat']?></td>
                                                <td><?php echo $p['email']?></td>
                                                <th>
                                                    <a href="?userid=<?= $p["userid"];?>" class="btn btn-rounded btn-danger sm-10" onclick="return confirm('yakin?');" >HAPUS</a>

                                                    <!-- syntax href ubah: edit-ketegori.php?idkategori=< ?= $p["idkategori"];?> -->
                                                    <!-- syntax href hapus: edit-ketegori.php?idkategori=< ?= $p["idkategori"];?> -->
                                                </th>
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

<?php include "footer.php"; ?>