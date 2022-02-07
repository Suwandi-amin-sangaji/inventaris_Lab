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
        LAPORAN DATA BARANG KELUAR
        <br> PERIODE <?= date('d/m/Y', strtotime($_GET['tgl1'])) ?> - <?= date('d/m/Y', strtotime($_GET['tgl2'])) ?>
    </h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Tgl Keluar</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Penerima</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($con, "select * from barang_keluar
            left join barang on barang_keluar.id_barang=barang.id_barang
            where tgl_keluar between '" . $_GET['tgl1'] . "' and '" . $_GET['tgl2'] . "' order by id_barang_keluar");
            $no = 0;
            while ($r = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td class="center"><?php echo ++$no ?></td>
                    <td><?= $r['nama_alat'] ?></td>
                    <td class="center"><?= date('d/m/Y', strtotime($r['tgl_keluar'])) ?></td>
                    <td class="center"><?= $r['jumlah_keluar'] ?></td>
                    <td><?= $r['lokasi_barang'] ?></td>
                    <td><?= $r['penerima'] ?></td>
                    <td><?= $r['keterangan_barang'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
<?php
$filename = "laporan_barang_keluar.pdf";
$content = ob_get_clean();

require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($filename, array("Attachment" => FALSE));
?>