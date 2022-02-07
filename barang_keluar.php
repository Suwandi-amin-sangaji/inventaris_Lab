<?php
$link_data = '?page=barang_keluar';
$link_update = '?page=update_barang_keluar';

$list_data = '';
$q = "select * from barang_keluar
      left join barang on barang_keluar.id_barang=barang.id_barang
      order by id_barang_keluar";
$q = mysqli_query($con, $q);
if (mysqli_num_rows($q) > 0) {
    while ($r = mysqli_fetch_array($q)) {
        $id = $r['id_barang_keluar'];
        $list_data .= '
		<tr>
            <td></td>
            <td>' . $r['nama_alat'] . '</td>
            <td>' . date('d/m/Y', strtotime($r['tgl_keluar'])) . '</td>
            <td>' . $r['jumlah_keluar'] . '</td>
            <td>' . $r['lokasi_barang'] . '</td>
            <td>' . $r['penerima'] . '</td>
            <td>' . $r['keterangan_barang'] . '</td>
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
        <h3 class="box-title">Data Barang Keluar</h3>
        <div class="box-tools">
            <a href="<?php echo $link_update; ?>" class="btn btn-primary btn-sm">Tambah Barang Keluar</a>
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
                        <th>Barang</th>
                        <th>Tanggal Keluar</th>
                        <th>Jumlah</th>
                        <th>Lokasi</th>
                        <th>Penerima</th>
                        <th>Keterangan</th>
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