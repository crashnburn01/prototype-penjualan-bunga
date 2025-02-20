<?php
include "../koneksi.php";
include "header.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function formatTanggalExcel($tanggalRaw)
{
    $parts = explode(' ', $tanggalRaw);
    if (count($parts) > 1) {
        $tanggalOnly = trim($parts[1]);
        $dateObject = DateTime::createFromFormat('j/n/Y', $tanggalOnly);
        return $dateObject ? $dateObject->format('Y-m-d') : null;
    }
    return null;
}

$execution_time_bs = null;
$execution_time_ss = null;
$totalPemasukan = 0;
$totalPengeluaran = 0;
$totalSaldo = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    $allData = [];
    $directory = "../uploads/";
    $files = glob($directory . "*.xlsx*");

    foreach ($files as $file) {
        $spreadsheet = IOFactory::load($file);

        for ($sheetIndex = 0; $sheetIndex <= 3; $sheetIndex++) {
            try {
                $sheet = $spreadsheet->getSheet($sheetIndex);
                $sheetData = $sheet->toArray();
                foreach ($sheetData as $index => $row) {
                    if ($index == 0) continue;

                    $tanggalFormatted = formatTanggalExcel($row[1]);
                    if ($tanggalFormatted) {
                        $allData[] = [
                            'tanggal' => $tanggalFormatted,
                            'deskripsi' => $row[2],
                            'pemasukan' => $row[3],
                            'pengeluaran' => $row[4],
                            'file' => basename($file), // Tambahkan nama file
                        ];
                    }
                }
            } catch (\Exception $e) {
                echo "<p style='color: red;'>Error memproses file " . basename($file) . ": " . $e->getMessage() . "</p>";
            }
        }
    }

    usort($allData, function ($a, $b) {
        return strtotime($a['tanggal']) - strtotime($b['tanggal']);
    });

    $start_time_bs = microtime(true);
    $filteredData = binarySearch($allData, $start_date, $end_date);
    $end_time_bs = microtime(true);
    $execution_time_bs = $end_time_bs - $start_time_bs;

    $start_time_ss = microtime(true);
    sequentialSearch($allData, $start_date, $end_date);
    $end_time_ss = microtime(true);
    $execution_time_ss = $end_time_ss - $start_time_ss;

    foreach ($filteredData as $data) {
        $pemasukan = str_replace(['Rp', '.'], '', $data['pemasukan']);
        $pengeluaran = str_replace(['Rp', '.'], '', $data['pengeluaran']);
        $totalPemasukan += (float)$pemasukan;
        $totalPengeluaran += (float)$pengeluaran;
    }

    $totalSaldo = $totalPemasukan - $totalPengeluaran;

    // Melacak dokumen yang berkontribusi
    $contributingFiles = [];
    foreach ($filteredData as $data) {
        if (!in_array($data['file'], $contributingFiles)) {
            $contributingFiles[] = $data['file'];
        }
    }
} else {
    $allData = [];
    $filteredData = [];
    $contributingFiles = []; // Inisialisasi array contributingFiles
}

// Fungsi Binary Search untuk mencari index data berdasarkan periode
function binarySearch($data, $startDate, $endDate)
{
    $low = 0;
    $high = count($data) - 1;
    $startIndex = -1;
    $endIndex = -1;

    // Cari indeks pertama dalam rentang menggunakan binary search
    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);
        $currentDate = $data[$mid]['tanggal'];

        if ($currentDate >= $startDate && $currentDate <= $endDate) {
            $startIndex = $mid;
            $high = $mid - 1; // Coba cari yang lebih kecil
        } elseif ($currentDate < $startDate) {
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }

    if ($startIndex == -1) return []; // Tidak ada data dalam rentang

    // Cari indeks terakhir dalam rentang menggunakan binary search
    $low = 0;
    $high = count($data) - 1;
    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);
        $currentDate = $data[$mid]['tanggal'];

        if ($currentDate >= $startDate && $currentDate <= $endDate) {
            $endIndex = $mid;
            $low = $mid + 1; // Coba cari yang lebih besar
        } elseif ($currentDate < $startDate) {
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }

    // **Meluas ke atas untuk mendapatkan semua data dengan tanggal awal**
    while ($startIndex > 0 && $data[$startIndex - 1]['tanggal'] == $data[$startIndex]['tanggal']) {
        $startIndex--;
    }

    // **Meluas ke bawah untuk mendapatkan semua data dengan tanggal akhir**
    while ($endIndex < count($data) - 1 && $data[$endIndex + 1]['tanggal'] == $data[$endIndex]['tanggal']) {
        $endIndex++;
    }

    return array_slice($data, $startIndex, ($endIndex - $startIndex + 1));
}

// Fungsi Sequential Search untuk mencari index data berdasarkan periode
function sequentialSearch($data, $startDate, $endDate)
{
    $result = [];
    $start_index = -1;
    $end_index = -1;

    // Cari index awal dan akhir
    for ($i = 0; $i < count($data); $i++) {
        $current_date = $data[$i]['tanggal'];
        
        // Tentukan start_index jika belum ditemukan dan current_date memenuhi
        if ($start_index === -1 && $current_date >= $startDate) {
            $start_index = $i;
        }
        
        // Jika start_index sudah ditemukan, perbarui end_index selama current_date masih dalam rentang
        if ($start_index !== -1) {
            if ($current_date <= $endDate) {
                $end_index = $i;
            } else {
                // Karena data terurut, begitu current_date > endDate, kita bisa berhenti
                break;
            }
        }
    }

    // Jika ditemukan, masukkan data dari index awal hingga akhir ke result
    if ($start_index !== -1 && $end_index !== -1) {
        for ($i = $start_index; $i <= $end_index; $i++) {
            $result[] = $data[$i];
        }
    }

    return $result;
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
                    <form method="POST">
                        <div class="form-group">
                            <label for="start_date">Periode Awal</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Periode Akhir</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-rounded">Cari Data</button>
                    </form><br>

                    <!-- Tabel -->
                    <div class="data-tables datatable-primary">
                        <table id="dataTable2" class="text-center" style="width:100%">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Pemasukan</th>
                                    <th>Pengeluaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop untuk menampilkan data hasil pencarian
                                if (!empty($filteredData)) {
                                    foreach ($filteredData as $index => $data) {
                                        echo "<tr>";
                                        echo "<td>" . ($index + 1) . "</td>";
                                        echo "<td>{$data['tanggal']}</td>";
                                        echo "<td>{$data['deskripsi']}</td>";
                                        echo "<td>{$data['pemasukan']}</td>";
                                        echo "<td>{$data['pengeluaran']}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>Tidak ada data dalam rentang tanggal ini.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php
                        if ($execution_time_bs !== null) {
                            ?>
                            <!-- Card untuk Menampilkan Total Pemasukan, Pengeluaran, dan Saldo -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title">Ringkasan Keuangan</h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-white bg-success">
                                                <div class="card-body">
                                                    <h5 class="card-title">Total Pemasukan</h5>
                                                    <p class="card-text text-white">Rp <?php echo number_format($totalPemasukan, 0, ',', '.'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-white bg-danger">
                                                <div class="card-body">
                                                    <h5 class="card-title">Total Pengeluaran</h5>
                                                    <p class="card-text text-white">Rp <?php echo number_format($totalPengeluaran, 0, ',', '.'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-white bg-primary">
                                                <div class="card-body">
                                                    <h5 class="card-title">Saldo Akhir</h5>
                                                    <p class="card-text text-white">Rp <?php echo number_format($totalSaldo, 0, ',', '.'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="font-weight-bold">Waktu eksekusi Binary Search: <?php echo number_format($execution_time_bs, 6); ?> detik</p>
                                        <p class="font-weight-bold">Waktu eksekusi Sequential Search: <?php echo number_format($execution_time_ss, 6); ?> detik</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="header-title">Pencarian Data Pemasukan Berdasarkan Rentang Tanggal</h4> -->
                    <form method="POST">
                        </form>
                    <div class="data-tables datatable-primary">
                        <table id="dataTable2" class="text-center" style="width:100%">
                            </table>
                        <?php if ($execution_time_bs !== null) { ?>
                            <?php } ?>
                        <?php if (!empty($contributingFiles)) { ?>
                            <div class="mt-4">
                                <h5>Dokumen yang Berkontribusi:</h5>
                                <ul>
                                    <?php foreach ($contributingFiles as $fileName) { ?>
                                        <li><a href="detail_dokumen.php?file=<?php echo urlencode($fileName); ?>" target="_blank"><?php echo $fileName; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
