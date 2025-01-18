<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Baca file Excel
$filePath = 'Flowers by Khansa Oktober 2024.xlsx';
$spreadsheet = IOFactory::load($filePath);

// Daftar nama sheet yang ingin ditampilkan
$sheets = ['PEKAN 1', 'PEKAN 2', 'PEKAN 3', 'PEKAN 4'];

// Ambil parameter pencarian
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Validasi rentang tanggal
if ($startDate && $endDate && $startDate > $endDate) {
    echo "<p style='color: red;'>Tanggal mulai harus lebih kecil dari tanggal selesai.</p>";
    return;
}

echo "<h1>Data Penjualan Toko Bunga</h1>";

echo "<form method='GET'>
        <label for='start_date'>Tanggal Mulai:</label>
        <input type='date' name='start_date' value='{$startDate}' required>
        <label for='end_date'>Tanggal Selesai:</label>
        <input type='date' name='end_date' value='{$endDate}' required>
        <button type='submit'>Cari</button>
    </form>";

// *** Pindahkan definisi fungsi binarySearch() ke luar loop foreach ***
function binarySearch($array, $target)
{
    $low = 0;
    $high = count($array) - 1;

    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);
        if ($array[$mid] == $target) {
            return $mid; // Ditemukan
        } elseif ($array[$mid] < $target) {
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }
    return -1; // Tidak ditemukan
}

foreach ($sheets as $sheetName) {
    // Ambil data dari setiap sheet
    $sheet = $spreadsheet->getSheetByName($sheetName);
    if (!$sheet) {
        echo "<p>Sheet '{$sheetName}' tidak ditemukan.</p>";
        continue;
    }

    $data = $sheet->toArray();

    // Buat array untuk menyimpan tanggal-tanggal yang sudah diformat dan indexnya
    $tanggalArray = [];
    $dataTanggal = [];
    foreach ($data as $index => $row) {
        if ($index == 0) continue;

        $tanggalRaw = $row[1];
        $parts = explode(' ', $tanggalRaw);
        if (count($parts) > 1) {
            $tanggalOnly = trim($parts[1]);
            $dateObject = DateTime::createFromFormat('j/n/Y', $tanggalOnly);
            if ($dateObject) {
                $tanggalFormatted = $dateObject->format('Y-m-d');
                $tanggalArray[] = $tanggalFormatted;
                // Simpan semua index yang memiliki tanggal yang sama
                if (!isset($dataTanggal[$tanggalFormatted])) {
                    $dataTanggal[$tanggalFormatted] = [];
                }
                $dataTanggal[$tanggalFormatted][] = $index;
            }
        }
    }

    sort($tanggalArray);

    echo "<h2>Sheet: {$sheetName}</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<thead>
            <tr>
                <th>NO</th>
                <th>TANGGAL</th>
                <th>DESKRIPSI</th>
                <th>PEMASUKAN</th>
                <th>PENGELUARAN</th>
                <th>SALDO AKHIR</th>
            </tr>
        </thead>";
    echo "<tbody>";

    $foundData = false;

    if ($startDate && $endDate) {
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $indexFound = binarySearch($tanggalArray, $currentDate);

            if ($indexFound != -1) {
                $foundData = true;
                $tanggalDitemukan = $tanggalArray[$indexFound];

                // *** Perubahan penting: loop melalui semua index untuk tanggal yang ditemukan ***
                foreach ($dataTanggal[$tanggalDitemukan] as $indexData) {
                    $row = $data[$indexData];
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td>{$cell}</td>";
                    }
                    echo "</tr>";
                }
            }
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
    }

    if (!$foundData) {
        echo "<tr><td colspan='6'>Tidak ada data yang sesuai pada rentang tanggal ini.</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
}