<?php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

function extractData($content)
{
    $data = [];
    $lines = explode("\n", $content);
    $startExtract = false;

    foreach ($lines as $line) {
        if (strpos($line, 'NO NOMOR TAGIHAN') !== false) {
            $startExtract = true;
            continue;
        }

        if ($startExtract) {
            // Updated regex to better capture various date formats
            if (preg_match('/(\d+)\s+(\d+)\s+(.*?)\s+(\d+)\s+(LUNAS|BELUM LUNAS)/', $line, $matches)) {
                $data[] = [
                    'no_tagihan' => $matches[2],
                    'pembayaran' => trim($matches[3]),
                    'jumlah_bayar' => $matches[4],
                    'status' => $matches[5]
                ];
            }
        }
    }

    return $data;
}

$extractedData = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdfFile'])) {
    $pdfFile = $_FILES['pdfFile']['tmp_name'];

    $parser = new Parser();
    $pdf = $parser->parseFile($pdfFile);
    $content = $pdf->getText();

    $extractedData = extractData($content);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran</title>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Nomor Tagihan ' + text + ' telah disalin ke clipboard.');
            }, function(err) {
                console.error('Gagal menyalin teks: ', err);
            });
        }

        function updateSelected() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked:not(:disabled)');
            var selectedTable = document.getElementById('selectedTableBody');
            selectedTable.innerHTML = '';
            var total = 0;

            checkboxes.forEach(function(checkbox) {
                var row = checkbox.parentNode.parentNode;
                var noTagihan = row.querySelector('.no-tagihan').innerText;
                var pembayaran = row.querySelector('.pembayaran').innerText;
                var jumlahBayar = parseInt(row.querySelector('.jumlah-bayar').innerText);
                var status = row.querySelector('.status').innerText;


                var newRow = selectedTable.insertRow();
                newRow.insertCell(0).innerText = noTagihan;
                newRow.insertCell(1).innerText = pembayaran;
                newRow.insertCell(2).innerText = jumlahBayar;
                newRow.insertCell(3).innerText = status;


                total += jumlahBayar;
            });

            document.getElementById('totalJumlahBayar').innerText = total;
        }

        function selectPaket(paket) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(:disabled)');
            var start, end;

            if (paket === 'UTS') {
                start = 0;
                end = 2;
            } else if (paket === 'UAS') {
                start = 3;
                end = 9;
            }

            for (var i = start; i <= end; i++) {
                if (i < checkboxes.length) {
                    checkboxes[i].checked = !checkboxes[i].checked;
                }
            }

            updateSelected();
        }
    </script>
</head>

<body>
    <h1>Data Pembayaran</h1>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="pdfFile" accept=".pdf" required>
        <input type="submit" value="Upload dan Proses PDF">
    </form>

    <?php if (!empty($extractedData)) : ?>
        <table>
            <tr>
                <th>Select</th>
                <th>No Tagihan</th>
                <th>Pembayaran</th>
                <th>Jumlah Bayar</th>
                <th>Status</th>
            </tr>
            <?php foreach ($extractedData as $index => $row) : ?>
                <tr>
                    <td><input type="checkbox" onclick="updateSelected()" <?php echo $row['status'] === 'LUNAS' ? 'disabled' : ''; ?>></td>
                    <td class="no-tagihan" onclick="copyToClipboard('<?php echo htmlspecialchars($row['no_tagihan']); ?>')"><?php echo htmlspecialchars($row['no_tagihan']); ?></td>
                    <td class="pembayaran"><?php echo htmlspecialchars($row['pembayaran']); ?></td>
                    <td class="jumlah-bayar"><?php echo htmlspecialchars($row['jumlah_bayar']); ?></td>
                    <td class="status"><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Selected Tagihan</h2>
        <table>
            <tr>
                <th>No Tagihan</th>
                <th>Pembayaran</th>
                <th>Jumlah Bayar</th>
                <th>Status</th>
            </tr>
            <tbody id="selectedTableBody"></tbody>
        </table>
        <h3>Total Jumlah Bayar: <span id="totalJumlahBayar">0</span></h3>
    <?php endif; ?>
</body>

</html>