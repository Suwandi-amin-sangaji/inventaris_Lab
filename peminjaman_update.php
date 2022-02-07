<?php
$link_data = '?page=peminjaman';
$link_update = '?page=update_peminjaman';
$link_barang = '?page=barang_peminjaman';

$id_pengguna = $_SESSION['id_pengguna'];
$nama_peminjam = $_SESSION['nama_lengkap'];
$nim = $_SESSION['nim'];
$tgl_pinjam = '';
$tgl_kembali = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $nama_peminjam = $_POST['nama_peminjam'];
    $nim = $_POST['nim'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    if ($action == 'add') {
        $q = "insert into peminjaman(id_pengguna,nama_peminjam,nim,tgl_pinjam,tgl_kembali) values ('" . $id_pengguna . "','" . $nama_peminjam . "','" . $nim . "','" . $tgl_pinjam . "','" . $tgl_kembali . "')";
        mysqli_query($con, $q);
        $id_peminjaman = mysqli_insert_id($con);
        exit("<script>location.href='" . $link_barang . "&id=" . $id_peminjaman . "';</script>");
    }
    if ($action == 'edit') {
        $q = "update peminjaman set nama_peminjam='" . $nama_peminjam . "',nim='" . $nim . "',tgl_pinjam='" . $tgl_pinjam . "',tgl_kembali='" . $tgl_kembali . "' where id_peminjaman='" . $id . "'";
        mysqli_query($con, $q);
        $_SESSION['message'] = 'Data berhasil diubah';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
} else {
    if (empty($_GET['action'])) {
        $action = 'add';
    } else {
        $action = $_GET['action'];
    }
    if ($action == 'edit') {
        $id = $_GET['id'];
        $q = mysqli_query($con, "select * from peminjaman where id_peminjaman='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_peminjam = $r['nama_peminjam'];
        $nim = $r['nim'];
        $tgl_pinjam = $r['tgl_pinjam'];
        $tgl_kembali = $r['tgl_kembali'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from peminjaman where id_peminjaman='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Peminjaman</h3>
    </div>
    <form class="form-horizontal" action="<?php echo $link_update; ?>" method="post">
        <input name="id" type="hidden" value="<?php echo $id; ?>">
        <input name="action" type="hidden" value="<?php echo $action; ?>">
        <div class="box-body">
            <?php
            if (!empty($error)) {
                echo '<div class="alert bg-danger" role="alert">' . $error . '</div>';
            }
            ?>
            <div class="form-group">
                <label for="nama_peminjam" class="col-sm-2 control-label">Nama Peminjam</label>
                <div class="col-sm-4">
                    <input name="nama_peminjam" id="nama_peminjam" class="form-control" readonly type="text" value="<?php echo $nama_peminjam; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="nim" class="col-sm-2 control-label">NIM</label>
                <div class="col-sm-4">
                    <input name="nim" id="nim" class="form-control" readonly type="number" value="<?php echo $nim; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tgl_pinjam" class="col-sm-2 control-label">Tanggal Pinjam</label>
                <div class="col-sm-2">
                    <input name="tgl_pinjam" id="tgl_pinjam" type="date" required class="form-control" value="<?php echo $tgl_pinjam; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tgl_kembali" class="col-sm-2 control-label">Tanggal Kembali</label>
                <div class="col-sm-2">
                    <input name="tgl_kembali" id="tgl_kembali" type="date" required class="form-control" value="<?php echo $tgl_kembali; ?>">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center col-sm-6">
                <button type="submit" name="save" class="btn btn-success">Simpan</button>
                <a href="<?php echo $link_data; ?>" class="btn btn-default">Kembali</a>
            </div>
        </div>
    </form>
</div>