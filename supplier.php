<?php
$link_data = '?page=supplier';
$link_update = '?page=update_supplier';
$link_cetak = 'supplier_cetak.php';

$list_data = '';
$q = "select * from supplier order by id_supplier";
$q = mysqli_query($con, $q);
if (mysqli_num_rows($q) > 0) {
    while ($r = mysqli_fetch_array($q)) {
        $id = $r['id_supplier'];
        $list_data .= '
		<tr>
            <td></td>
            <td>' . $r['nama_supplier'] . '</td>
            <td>' . $r['alamat_supplier'] . '</td>
            <td>' . $r['telepon_supplier'] . '</td>
            <td>
                <a href="' . $link_update . '&id=' . $id . '&action=edit" class="btn btn-success btn-xs" title="Ubah">Ubah</a> &nbsp;
                <a href="#" data-href="' . $link_update . '&id=' . $id . '&action=delete" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs" title="Hapus">Hapus</a>
            </td>
		</tr>';
    }
}

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Supplier</h3>
        <div class="box-tools">
            <a href="<?php echo $link_cetak; ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak</a>
            <a href="<?php echo $link_update; ?>" class="btn btn-primary btn-sm">Tambah Supplier</a>
        </div>
    </div>
    <div class="box-body">
        <?php
        if (!empty($message)) {
            echo '<div class="alert bg-success" role="alert">' . $message . '</div>';
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTables1">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $list_data; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>