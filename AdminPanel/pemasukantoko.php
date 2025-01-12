<?php
include "../koneksi.php"; // Koneksi ke database
include "header.php"; // Header halaman
?>

<div class="main-content-inner">
    <div class="row">
        <!-- Tabel Data Pemasukan -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Pemasukan</h4>

                    <!-- Tombol Tambah Dokumen -->
                    <a href="tambahdokumen.php" class="btn btn-primary btn-rounded mb-3">
                        + Tambah Dokumen
                    </a>

                    <!-- Tabel -->
                    <div class="data-tables datatable-primary">
                        <table id="dataTable2" class="text-center" style="width:100%">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Dokumen</th>
                                    <th>Nama Dokumen</th>
                                    <th>Periode</th>
                                    <th>Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mendapatkan data dari tabel pemasukan
                                $query = "SELECT * FROM pemasukan ORDER BY id ASC";
                                $result = mysqli_query($conn, $query);
                                $no = 1;

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $file_path = "../uploads/" . $row['file_dokumen'];
                                    
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . $row['kode_dokumen'] . "</td>";
                                    echo "<td>" . $row['nama_dokumen'] . "</td>";
                                    echo "<td>" . date('F Y', strtotime($row['periode'])) . "</td>";
                                    echo "<td><a href='$file_path' target='_blank' class='btn btn-success btn-sm'>Lihat Dokumen</a></td>";
                                    echo "<td>
                                            <a href='editdokumen.php?id=" . $row['id'] . "' class='btn btn-rounded btn-success sm-10'><i class='ti-pencil-alt' style='align-items: center;'></i></a>
                                            <a href='deletedokumen.php?id=" . $row['id'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')\" class='btn btn-rounded btn-danger sm-10'><i class='ti-trash' style='align-items: center;'></i></a>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Pencarian Binary Search</h4>
                                    </div>
                                    <div class="modal-body">
                                        <a href="pencarianbs.php" class="form-control btn btn-primary">Cari Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
