<?php
include "../koneksi.php";  // Koneksi ke database
include "header.php";      // Header halaman
require '../vendor/autoload.php';  // Autoload PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

// Proses Pencarian Data Pemasukan Berdasarkan Periode
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $periode_awal = mysqli_real_escape_string($conn, $_POST['periode_awal']);
    $periode_akhir = mysqli_real_escape_string($conn, $_POST['periode_akhir']);

    // Mengubah periode menjadi tanggal pertama dan terakhir pada bulan tersebut
    $periode_awal = date('Y-m-01', strtotime($periode_awal));
    $periode_akhir = date('Y-m-t', strtotime($periode_akhir));
    
    // Menyimpan data hasil pencarian
    $result_data = [];

    // Menentukan direktori tempat file dokumen berada
    $directory = "../uploads/";
    $files = glob($directory . "*.xlsx*");

    foreach ($files as $file) {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        
        // Menyaring data berdasarkan periode
        $data = [];
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            
            $row_data = [];
            foreach ($cellIterator as $cell) {
                $row_data[] = $cell->getValue();
            }

            // Mengonversi tanggal yang ada di kolom pertama ke format Y-m-d
            $tanggal = trim($row_data[0]); // Ambil nilai tanggal dari kolom pertama
            
            // Cek apakah tanggal valid
            $date_object = date_create_from_format('m/d/Y', $tanggal);  // Sesuaikan dengan format Excel yang diinginkan
            if ($date_object) {
                $tanggal = $date_object->format('Y-m-d'); // Ubah ke format Y-m-d
            } else {
                // Jika tanggal tidak valid, lanjutkan ke baris berikutnya
                continue;
            }

            // Debugging: tampilkan tanggal yang diambil
            echo "Tanggal: " . $row_data[0] . " -> " . $tanggal . "<br>";

            // Memeriksa apakah tanggal dalam rentang yang diinginkan
            if ($tanggal >= $periode_awal && $tanggal <= $periode_akhir) {
                $data[] = $row_data;
            }
        }

        // Menyimpan data yang ditemukan dalam rentang periode
        if (!empty($data)) {
            $result_data[$file] = $data;
        }
    }

    // Menyortir hasil berdasarkan tanggal jika diperlukan
    ksort($result_data); // Mengurutkan berdasarkan nama file atau tanggal
} else {
    $result_data = [];
}

// Fungsi Binary Search untuk mencari index data berdasarkan periode
function binarySearch($data, $periode) {
    $low = 0;
    $high = count($data) - 1;

    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);
        $mid_value = $data[$mid][0]; // Misalkan kolom pertama adalah tanggal

        if ($mid_value < $periode) {
            $low = $mid + 1;
        } elseif ($mid_value > $periode) {
            $high = $mid - 1;
        } else {
            return $mid;
        }
    }

    return -1; // Tidak ditemukan
}

?>

<div class="main-content-inner">
    <div class="row">
        <!-- Tabel Data Pemasukan -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Pencarian Data Pemasukan Berdasarkan Rentang Tanggal</h4>

                    <!-- Form untuk Pencarian Data Pemasukan Berdasarkan Periode -->
                    <form action="pencarianbs.php" method="POST">
                        <div class="form-group">
                            <label for="periode_awal">Periode Awal (YYYY-MM-DD)</label>
                            <input type="date" name="periode_awal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="periode_akhir">Periode Akhir (YYYY-MM-DD)</label>
                            <input type="date" name="periode_akhir" class="form-control" required>
                        </div>
                        <button type="submit" name="search" class="btn btn-primary btn-rounded">Cari Data</button>
                    </form><br>

                    <!-- Tabel -->
                    <div class="data-tables datatable-primary">
                        <table id="dataTable2" class="text-center" style="width:100%">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dokumen</th>
                                    <th>Tanggal</th>
                                    <th>Pemasukan/Pengeluaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop untuk menampilkan data hasil pencarian
                                $no = 1;
                                foreach ($result_data as $file => $data) {
                                    foreach ($data as $row) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . basename($file) . "</td>";
                                        echo "<td>" . date('Y-m-d', strtotime($row[0])) . "</td>"; // Anggap tanggal ada di kolom pertama
                                        echo "<td>" . $row[1] . "</td>"; // Anggap pemasukan/pengeluaran ada di kolom kedua
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
