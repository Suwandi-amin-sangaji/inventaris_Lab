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
        LAPORAN DATA SUPPLIER
    </h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($con, "select * from supplier");
            $no = 0;
            while ($r = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td class="center"><?php echo ++$no ?></td>
                    <td><?= $r['nama_supplier'] ?></td>
                    <td><?= $r['alamat_supplier'] ?></td>
                    <td class="center"><?= $r['telepon_supplier'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
<?php
$filename = "supplier.pdf";
$content = ob_get_clean();

require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($filename, array("Attachment" => FALSE));
?>