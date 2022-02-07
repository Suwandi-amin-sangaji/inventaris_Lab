<?php
$link_data = '?page=peminjaman';
$link_update = '?page=update_peminjaman';
$link_barang = '?page=barang_peminjaman';

$list_data = '';
if ($_SESSION['level'] == 'Admin') {
    $q = "select * from peminjaman order by id_peminjaman desc";
} elseif ($_SESSION['level'] == 'Peminjam') {
    $q = "select * from peminjaman where id_pengguna='" . $_SESSION['id_pengguna'] . "' order by id_peminjaman desc";
}
$q = mysqli_query($con, $q);
if (mysqli_num_rows($q) > 0) {
    while ($r = mysqli_fetch_array($q)) {
        $id = $r['id_peminjaman'];
        $list_data .= '
		<tr>
            <td></td>
            <td>' . $r['nama_peminjam'] . '</td>
            <td>' . $r['nim'] . '</td>
            <td>' . date('d/m/Y', strtotime($r['tgl_pinjam'])) . ' - ' . date('d/m/Y', strtotime($r['tgl_kembali'])) . '</td>
            <td>
                <a href="' . $link_barang . '&id=' . $id . '" class="btn btn-info btn-xs" title="Daftar Barang"><i class="fa fa-list"></i> Daftar Barang</a>
            </td>
            <td>' . $r['ket_peminjaman'] . '</td>
            <td>' . $r['ket_pengembalian'] . '</td>
            <td>
                <a href="' . $link_update . '&id=' . $id . '&action=edit" class="btn btn-success btn-xs" title="Ubah">Ubah</a> &nbsp;';
        if ($_SESSION['level'] == 'Peminjam') {
            $list_data .= '
                <a href="#" data-href="' . $link_update . '&id=' . $id . '&action=delete" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs" title="Hapus">Hapus</a>';
        }
        $list_data .= '
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
        <h3 class="box-title">Data Peminjaman</h3>
        <?php if ($_SESSION['level'] == 'Peminjam') : ?>
            <div class="box-tools">
                <a href="<?php echo $link_update; ?>" class="btn btn-primary btn-sm">Pengajuan Peminjaman</a>
            </div>
        <?php endif; ?>
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
                        <th>Nama Peminjam</th>
                        <th>NIM</th>
                        <th>Tgl Peminjaman</th>
                        <th>Barang</th>
                        <th>Keterangan</th>
                        <th>Pengembalian</th>
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