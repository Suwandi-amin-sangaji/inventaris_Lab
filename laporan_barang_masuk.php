<?php
ob_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        th {
            height: 25px;
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 4px;
        }

        thead {
            background: lightgray;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .table-no-border {
            table-layout: fixed;
        }

        .table-no-border,
        .table-no-border th,
        .table-no-border td {
            border: none;
        }

        .mt-1 {
            margin-top: 20px;
        }

        .mt-2 {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <h3 class="center">
        LAPORAN DATA BARANG MASUK
        <br> PERIODE <?= date('d/m/Y', strtotime($_GET['tgl1'])) ?> - <?= date('d/m/Y', strtotime($_GET['tgl2'])) ?>
    </h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Tanggal Masuk</th>
                <th>Jumlah</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($con, "select * from barang_masuk
            left join barang on barang_masuk.id_barang=barang.id_barang
            left join supplier on barang_masuk.id_supplier=supplier.id_supplier
            where tgl_masuk between '" . $_GET['tgl1'] . "' and '" . $_GET['tgl2'] . "' order by id_barang_masuk");
            $no = 0;
            while ($r = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td class="center"><?php echo ++$no ?></td>
                    <td><?= $r['nama_alat'] ?></td>
                    <td class="center"><?= date('d/m/Y', strtotime($r['tgl_masuk'])) ?></td>
                    <td class="center"><?= $r['jumlah_masuk'] ?></td>
                    <td><?= $r['nama_supplier'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
<?php
$filename = "laporan_barang_masuk.pdf";
$content = ob_get_clean();

require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($filename, array("Attachment" => FALSE));
?>