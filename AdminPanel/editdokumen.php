<?php
include "../koneksi.php"; // Koneksi ke database
include "header.php"; // Header halaman

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data dokumen berdasarkan ID
$query = "SELECT * FROM pemasukan WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Proses update data dokumen
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_dokumen = mysqli_real_escape_string($conn, $_POST['kode_dokumen']);
    $nama_dokumen = mysqli_real_escape_string($conn, $_POST['nama_dokumen']);
    $periode = mysqli_real_escape_string($conn, $_POST['periode']);

    // Update data dokumen
    $update_query = "UPDATE pemasukan SET 
                        kode_dokumen = '$kode_dokumen', 
                        nama_dokumen = '$nama_dokumen', 
                        periode = '$periode' 
                    WHERE id = '$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert alert-success'>Dokumen berhasil diperbarui!</div>";
        header("Refresh:2; url=datapemasukan.php"); // Redirect ke pemasukantoko.php
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit Dokumen</h4><br>

                    <!-- Form Edit Dokumen -->
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="kode_dokumen">Kode Dokumen</label>
                            <input type="text" name="kode_dokumen" class="form-control" value="<?php echo $row['kode_dokumen']; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_dokumen">Nama Dokumen</label>
                            <input type="text" name="nama_dokumen" class="form-control" value="<?php echo $row['nama_dokumen']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="periode">Periode (Bulan dan Tahun)</label>
                            <input type="month" name="periode" class="form-control" value="<?php echo $row['periode']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded">Update Dokumen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
