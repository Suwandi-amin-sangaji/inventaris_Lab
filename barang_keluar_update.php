<?php
$link_data = '?page=barang_keluar';
$link_update = '?page=update_barang_keluar';

$id_barang = '';
$barang = [];
$result = mysqli_query($con, "select * from barang");
while ($row = mysqli_fetch_array($result)) {
    $barang[] = $row;
}
$tgl_keluar = '';
$jumlah_keluar = '';
$lokasi_barang = '';
$penerima = '';
$keterangan_barang = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $id_barang = $_POST['id_barang'];
    $tgl_keluar = $_POST['tgl_keluar'];
    $jumlah_keluar = $_POST['jumlah_keluar'];
    $lokasi_barang = $_POST['lokasi_barang'];
    $penerima = $_POST['penerima'];
    $keterangan_barang = $_POST['keterangan_barang'];

    if ($action == 'add') {
        $data_barang = mysqli_fetch_array(mysqli_query($con, "select * from barang where id_barang='$id_barang'"));
        if ($jumlah_keluar > $data_barang['jumlah_alat']) {
            $error = 'Jumlah Alat tersisa tidak cukup. Sisa stok ada ' . $data_barang['jumlah_alat'] . '.';
        } else {
            $q = "insert into barang_keluar(id_barang,tgl_keluar,jumlah_keluar,lokasi_barang,penerima,keterangan_barang) values ('" . $id_barang . "','" . $tgl_keluar . "','" . $jumlah_keluar . "','" . $lokasi_barang . "','" . $penerima . "','" . $keterangan_barang . "')";
            mysqli_query($con, $q);
            // update stok barang
            $q = "update barang set jumlah_alat=jumlah_alat-" . $jumlah_keluar . " where id_barang='" . $id_barang . "'";
            mysqli_query($con, $q);

            $_SESSION['message'] = 'Data berhasil ditambahkan';
            exit("<script>location.href='" . $link_data . "';</script>");
        }
    }
    if ($action == 'edit') {
        // update stok barang
        $q = mysqli_query($con, "select * from barang_keluar where id_barang_keluar='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $jml_lama = $r['jumlah_keluar'];

        $q = "update barang set jumlah_alat=jumlah_alat+" . $jml_lama . "-" . $jumlah_keluar . " where id_barang='" . $id_barang . "'";
        mysqli_query($con, $q);

        $q = "update barang_keluar set id_barang='" . $id_barang . "',tgl_keluar='" . $tgl_keluar . "',jumlah_keluar='" . $jumlah_keluar . "',lokasi_barang='" . $lokasi_barang . "',penerima='" . $penerima . "',keterangan_barang='" . $keterangan_barang . "' where id_barang_keluar='" . $id . "'";
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
        $q = mysqli_query($con, "select * from barang_keluar where id_barang_keluar='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $id_barang = $r['id_barang'];
        $tgl_keluar = $r['tgl_keluar'];
        $jumlah_keluar = $r['jumlah_keluar'];
        $lokasi_barang = $r['lokasi_barang'];
        $penerima = $r['penerima'];
        $keterangan_barang = $r['keterangan_barang'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from barang_keluar where id_barang_keluar='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Barang Keluar</h3>
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
                <label for="id_barang" class="col-sm-2 control-label">Barang</label>
                <div class="col-sm-4">
                    <select name="id_barang" id="id_barang" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">Pilih...</option>
                        <?php foreach ($barang as $row) : ?>
                            <option value="<?= $row['id_barang'] ?>" <?= $id_barang == $row['id_barang'] ? 'selected' : '' ?>><?= $row['nama_alat'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tgl_keluar" class="col-sm-2 control-label">Tanggal Keluar</label>
                <div class="col-sm-2">
                    <input name="tgl_keluar" id="tgl_keluar" class="form-control" required type="date" value="<?php echo $tgl_keluar; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="jumlah_keluar" class="col-sm-2 control-label">Jumlah</label>
                <div class="col-sm-4">
                    <input name="jumlah_keluar" id="jumlah_keluar" class="form-control" required type="number" value="<?php echo $jumlah_keluar; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="lokasi_barang" class="col-sm-2 control-label">Lokasi Barang</label>
                <div class="col-sm-4">
                    <input name="lokasi_barang" id="lokasi_barang" class="form-control" type="text" value="<?php echo $lokasi_barang; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="penerima" class="col-sm-2 control-label">Penerima</label>
                <div class="col-sm-4">
                    <input name="penerima" id="penerima" class="form-control" type="text" value="<?php echo $penerima; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="keterangan_barang" class="col-sm-2 control-label">Keterangan Barang</label>
                <div class="col-sm-4">
                    <input name="keterangan_barang" id="keterangan_barang" class="form-control" type="text" value="<?php echo $keterangan_barang; ?>">
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