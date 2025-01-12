<?php
include "../koneksi.php"; // Koneksi ke database

// Ambil ID dari URL
$id = $_GET['id'];

// Hapus data dokumen berdasarkan ID
$query = "SELECT * FROM pemasukan WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $file_path = "../uploads/" . $row['file_dokumen'];

    // Hapus file fisik jika ada
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // Hapus data dari database
    $delete_query = "DELETE FROM pemasukan WHERE id = '$id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Dokumen berhasil dihapus!'); window.location.href='pemasukantoko.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus dokumen.'); window.location.href='pemasukantoko.php';</script>";
    }
} else {
    echo "<script>alert('Dokumen tidak ditemukan.'); window.location.href='pemasukantoko.php';</script>";
}
?>
