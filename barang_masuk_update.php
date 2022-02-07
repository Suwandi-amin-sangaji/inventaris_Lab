<?php
$link_data = '?page=barang_masuk';
$link_update = '?page=update_barang_masuk';

$id_barang = '';
$barang = [];
$result = mysqli_query($con, "select * from barang");
while ($row = mysqli_fetch_array($result)) {
    $barang[] = $row;
}
$tgl_masuk = '';
$jumlah_masuk = '';
$id_supplier = '';
$supplier = [];
$result = mysqli_query($con, "select * from supplier");
while ($row = mysqli_fetch_array($result)) {
    $supplier[] = $row;
}

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $id_barang = $_POST['id_barang'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $jumlah_masuk = $_POST['jumlah_masuk'];
    $id_supplier = $_POST['id_supplier'];

    if ($action == 'add') {
        $q = "insert into barang_masuk(id_barang,tgl_masuk,jumlah_masuk,id_supplier) values ('" . $id_barang . "','" . $tgl_masuk . "','" . $jumlah_masuk . "','" . $id_supplier . "')";
        mysqli_query($con, $q);
        // update stok barang
        $q = "update barang set jumlah_alat=jumlah_alat+" . $jumlah_masuk . " where id_barang='" . $id_barang . "'";
        mysqli_query($con, $q);

        $_SESSION['message'] = 'Data berhasil ditambahkan';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
    if ($action == 'edit') {
        // update stok barang
        $q = mysqli_query($con, "select * from barang_masuk where id_barang_masuk='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $jml_lama = $r['jumlah_masuk'];

        $q = "update barang set jumlah_alat=jumlah_alat-" . $jml_lama . "+" . $jumlah_masuk . " where id_barang='" . $id_barang . "'";
        mysqli_query($con, $q);

        $q = "update barang_masuk set id_barang='" . $id_barang . "',tgl_masuk='" . $tgl_masuk . "',jumlah_masuk='" . $jumlah_masuk . "',id_supplier='" . $id_supplier . "' where id_barang_masuk='" . $id . "'";
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
        $q = mysqli_query($con, "select * from barang_masuk where id_barang_masuk='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $id_barang = $r['id_barang'];
        $tgl_masuk = $r['tgl_masuk'];
        $jumlah_masuk = $r['jumlah_masuk'];
        $id_supplier = $r['id_supplier'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from barang_masuk where id_barang_masuk='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Barang Masuk</h3>
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
                <label for="tgl_masuk" class="col-sm-2 control-label">Tanggal Masuk</label>
                <div class="col-sm-2">
                    <input name="tgl_masuk" id="tgl_masuk" class="form-control" required type="date" value="<?php echo $tgl_masuk; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="jumlah_masuk" class="col-sm-2 control-label">Jumlah</label>
                <div class="col-sm-4">
                    <input name="jumlah_masuk" id="jumlah_masuk" class="form-control" required type="number" value="<?php echo $jumlah_masuk; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="id_supplier" class="col-sm-2 control-label">Supplier</label>
                <div class="col-sm-4">
                    <select name="id_supplier" id="id_supplier" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">Pilih...</option>
                        <?php foreach ($supplier as $row) : ?>
                            <option value="<?= $row['id_supplier'] ?>" <?= $id_supplier == $row['id_supplier'] ? 'selected' : '' ?>><?= $row['nama_supplier'] ?></option>
                        <?php endforeach; ?>
                    </select>
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