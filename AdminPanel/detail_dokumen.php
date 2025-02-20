<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_GET['file'])) {
    $fileName = $_GET['file'];
    $filePath = "../uploads/" . $fileName;

    if (file_exists($filePath)) {
        $spreadsheet = IOFactory::load($filePath);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Detail Dokumen: <?php echo $fileName; ?></title>
            <style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid black; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h1>Detail Dokumen: <?php echo $fileName; ?></h1>
            <?php
            for ($sheetIndex = 0; $sheetIndex <= 3; $sheetIndex++) {
                try {
                    $sheet = $spreadsheet->getSheet($sheetIndex);
                    $sheetData = $sheet->toArray();
                    echo "<h2>Sheet " . ($sheetIndex + 1) . "</h2>";
                    echo "<table>";
                    foreach ($sheetData as $rowIndex => $rowData) {
                        echo "<tr>";
                        // Hanya tampilkan 5 kolom pertama (NO, TANGGAL, DESKRIPSI, PEMASUKAN, PENGELUARAN)
                        for ($i = 0; $i < 5; $i++) {
                            echo "<td>" . $rowData[$i] . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } catch (\Exception $e) {
                    echo "<p style='color: red;'>Error memproses sheet " . ($sheetIndex + 1) . ": " . $e->getMessage() . "</p>";
                }
            }
            ?>
        </body>
        </html>
        <?php
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "Parameter file tidak diberikan.";
}
?>