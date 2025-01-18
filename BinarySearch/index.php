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

foreach ($sheets as $sheetName) {
    // Ambil data dari setiap sheet
    $sheet = $spreadsheet->getSheetByName($sheetName);
    if (!$sheet) {
        echo "<p>Sheet '{$sheetName}' tidak ditemukan.</p>";
        continue;
    }

    $data = $sheet->toArray();

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

    $foundData = false; // Flag untuk mengecek apakah ada data yang sesuai

    foreach ($data as $index => $row) {
        if ($index == 0) continue;

        $tanggalRaw = $row[1];

        $parts = explode(' ', $tanggalRaw);
        if (count($parts) > 1) {
            $tanggalOnly = trim($parts[1]);

            // Gunakan DateTime::createFromFormat dengan format 'j/n/Y'
            $dateObject = DateTime::createFromFormat('j/n/Y', $tanggalOnly);
            if ($dateObject) {
                $tanggalFormatted = $dateObject->format('Y-m-d');
            } else {
                $tanggalFormatted = null;
                echo "<p style='color:red'>Gagal memproses tanggal: {$tanggalRaw}. Format tanggal harus tanggal/bulan/tahun (contoh: 7/10/2024)</p>";
            }


        } else {
            $tanggalFormatted = null;
        }

        // Debugging
        // echo "Raw: {$tanggalRaw} | Parsed: {$tanggalFormatted}<br>";

        if ($startDate && $endDate) {
            if (!$tanggalFormatted || $tanggalFormatted < $startDate || $tanggalFormatted > $endDate) {
                continue;
            }
        }

        $foundData = true;

        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>{$cell}</td>";
        }
        echo "</tr>";
    }

    if (!$foundData) {
        echo "<tr><td colspan='6'>Tidak ada data yang sesuai pada rentang tanggal ini.</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
