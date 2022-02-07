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
        LAPORAN DATA PEMINJAMAN
        <br> PERIODE <?= date('d/m/Y', strtotime($_GET['tgl1'])) ?> - <?= date('d/m/Y', strtotime($_GET['tgl2'])) ?>
    </h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>NIM</th>
                <th>Tgl Peminjaman</th>
                <th>Keterangan</th>
                <th>Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($con, "select * from peminjaman where tgl_pinjam between '" . $_GET['tgl1'] . "' and '" . $_GET['tgl2'] . "' order by id_peminjaman");
            $no = 0;
            while ($r = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td class="center"><?php echo ++$no ?></td>
                    <td><?= $r['nama_peminjam'] ?></td>
                    <td class="center"><?= $r['nim'] ?></td>
                    <td class="center"><?= date('d/m/Y', strtotime($r['tgl_pinjam'])) ?> - <?= date('d/m/Y', strtotime($r['tgl_kembali'])) ?></td>
                    <td class="center"><?= $r['ket_peminjaman'] ?></td>
                    <td class="center"><?= $r['ket_pengembalian'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
<?php
$filename = "laporan_peminjaman.pdf";
$content = ob_get_clean();

require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($filename, array("Attachment" => FALSE));
?>