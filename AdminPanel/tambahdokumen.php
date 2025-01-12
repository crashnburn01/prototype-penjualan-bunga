<?php
include "../koneksi.php"; // Koneksi ke database
include "header.php"; // Header halaman

// Proses upload dokumen
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_dokumen = ''; // Kode dokumen yang akan dihasilkan
    $nama_dokumen = mysqli_real_escape_string($conn, $_POST['nama_dokumen']);
    $periode = mysqli_real_escape_string($conn, $_POST['periode']); // YYYY-MM
    $periode = $periode . '-01'; // Menambahkan '-01' untuk menyesuaikan dengan format DATE
    $tanggal = date('Y-m-d');

    // Membuat kode dokumen berdasarkan periode
    $bulan = date('m', strtotime($periode)); // Ambil bulan dari periode
    $tahun = date('y', strtotime($periode)); // Ambil dua digit tahun dari periode
    $kode_dokumen = "DOC" . $bulan . $tahun; // Format kode dokumen

    // Cek apakah file diunggah
    if (isset($_FILES['file_dokumen']) && $_FILES['file_dokumen']['error'] == 0) {
        $file_name = $_FILES['file_dokumen']['name'];
        $file_tmp = $_FILES['file_dokumen']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validasi ekstensi file (hanya XLS dan XLSX yang diizinkan)
        $allowed_extensions = ['xls', 'xlsx'];
        if (in_array($file_ext, $allowed_extensions)) {
            // Pindahkan file ke folder uploads
            $file_path = "../uploads/" . $file_name;
            move_uploaded_file($file_tmp, $file_path);

            // Simpan informasi dokumen ke dalam database
            $query = "INSERT INTO pemasukan (kode_dokumen, nama_dokumen, periode, file_dokumen, tanggal) 
                      VALUES ('$kode_dokumen', '$nama_dokumen', '$periode', '$file_name', '$tanggal')";
            if (mysqli_query($conn, $query)) {
                echo "
                <script>
                    alert('Data Berhasil Disimpan');
                    document.location.href = 'pemasukantoko.php';
                </script>";
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Hanya file dengan format .xls atau .xlsx yang diizinkan!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Silakan unggah file dokumen!</div>";
    }
}
?>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Tambah Dokumen Pemasukan</h4><br>

                    <!-- Form Upload Dokumen -->
                    <form action="tambahdokumen.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="kode_dokumen">Kode Dokumen</label>
                            <!-- Kode Dokumen otomatis terisi berdasarkan periode -->
                            <input type="text" name="kode_dokumen" class="form-control" value="<?php echo isset($kode_dokumen) ? $kode_dokumen : ''; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_dokumen">Nama Dokumen</label>
                            <input type="text" name="nama_dokumen" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="periode">Periode (Bulan dan Tahun)</label>
                            <input type="month" name="periode" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="file_dokumen">Pilih File (Format XLS)</label>
                            <input type="file" name="file_dokumen" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded">Tambahkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
