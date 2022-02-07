<?php
$id_peminjaman = isset($_GET['id']) ? $_GET['id'] : '';
$link_data = '?page=peminjaman';
$link_update = '?page=update_barang_peminjaman&id=' . $id_peminjaman;
$link_barang = '?page=barang_peminjaman&id=' . $id_peminjaman;

$peminjaman = mysqli_fetch_array(mysqli_query($con, "select * from peminjaman where id_peminjaman='$id_peminjaman'"));

$list_data = '';
$q = "select * from peminjaman_barang
      left join barang on peminjaman_barang.id_barang=barang.id_barang
      where id_peminjaman='$id_peminjaman' order by id_peminjaman_barang";
$q = mysqli_query($con, $q);
if (mysqli_num_rows($q) > 0) {
    while ($r = mysqli_fetch_array($q)) {
        $id = $r['id_peminjaman_barang'];
        $list_data .= '
		<tr>
            <td></td>
            <td>' . $r['nama_alat'] . '</td>
            <td>' . $r['jumlah_pinjam'] . '</td>
            <td>' . $r['kondisi'] . '</td>
            <td>' . $r['lokasi'] . '</td>';
        if ($_SESSION['level'] == 'Peminjam') {
            $list_data .= '
            <td>
                <a href="' . $link_update . '&idp=' . $id . '&action=edit" class="btn btn-success btn-xs" title="Ubah">Ubah</a> &nbsp;
                <a href="#" data-href="' . $link_update . '&idp=' . $id . '&action=delete" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs" title="Hapus">Hapus</a>
            </td>';
        }
        $list_data .= '
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
        <h3 class="box-title">Daftar Peminjaman Barang</h3>
        <div class="box-tools">
            <a href="<?php echo $link_data; ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            <?php if ($_SESSION['level'] == 'Peminjam') : ?>
                <a href="<?php echo $link_update; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Barang</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="box-body">
        <?php
        if (!empty($message)) {
            echo '<div class="alert bg-success" role="alert">' . $message . '</div>';
        }
        ?>
        <table class="table table-bordered">
            <tr>
                <td width="140">Nama Peminjam</td>
                <td><?= $peminjaman['nama_peminjam'] ?></td>
            </tr>
            <tr>
                <td width="140">NIM</td>
                <td><?= $peminjaman['nim'] ?></td>
            </tr>
            <tr>
                <td width="140">Tanggal Pinjam</td>
                <td><?= date('d/m/Y', strtotime($peminjaman['tgl_pinjam'])) . ' - ' . date('d/m/Y', strtotime($peminjaman['tgl_kembali'])) ?></td>
            </tr>
        </table>
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTables1">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <?php if ($_SESSION['level'] == 'Peminjam') : ?>
                            <th width="80">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $list_data; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>