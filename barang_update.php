<?php
$link_data = '?page=barang';
$link_update = '?page=update_barang';

$id_kategori = '';
$kategori = [];
$result = mysqli_query($con, "select * from kategori");
while ($row = mysqli_fetch_array($result)) {
    $kategori[] = $row;
}
$nama_alat = '';
$jumlah_alat = '';
$kondisi = '';
$lokasi = '';
$keterangan = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $id_kategori = $_POST['id_kategori'];
    $nama_alat = $_POST['nama_alat'];
    $jumlah_alat = $_POST['jumlah_alat'];
    $kondisi = $_POST['kondisi'];
    $lokasi = $_POST['lokasi'];
    $keterangan = $_POST['keterangan'];

    if ($action == 'add') {
        if (mysqli_num_rows(mysqli_query($con, "select * from barang where nama_alat='" . $nama_alat . "'")) > 0) {
            $error = 'Nama Alat sudah ada';
        } else {
            $q = "insert into barang(id_kategori,nama_alat,jumlah_alat,kondisi,lokasi,keterangan) values ('" . $id_kategori . "','" . $nama_alat . "','" . $jumlah_alat . "','" . $kondisi . "','" . $lokasi . "','" . $keterangan . "')";
            mysqli_query($con, $q);
            $_SESSION['message'] = 'Data berhasil ditambahkan';
            exit("<script>location.href='" . $link_data . "';</script>");
        }
    }
    if ($action == 'edit') {
        $q = mysqli_query($con, "select * from barang where id_barang='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_alat_tmp = $r['nama_alat'];
        if (mysqli_num_rows(mysqli_query($con, "select * from barang where nama_alat='" . $nama_alat . "' and nama_alat<>'" . $nama_alat_tmp . "'")) > 0) {
            $error = 'Nama Alat sudah ada';
        } else {
            $q = "update barang set id_kategori='" . $id_kategori . "',nama_alat='" . $nama_alat . "',jumlah_alat='" . $jumlah_alat . "',kondisi='" . $kondisi . "',lokasi='" . $lokasi . "',keterangan='" . $keterangan . "' where id_barang='" . $id . "'";
            mysqli_query($con, $q);
            $_SESSION['message'] = 'Data berhasil diubah';
            exit("<script>location.href='" . $link_data . "';</script>");
        }
    }
} else {
    if (empty($_GET['action'])) {
        $action = 'add';
    } else {
        $action = $_GET['action'];
    }
    if ($action == 'edit') {
        $id = $_GET['id'];
        $q = mysqli_query($con, "select * from barang where id_barang='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $id_kategori = $r['id_kategori'];
        $nama_alat = $r['nama_alat'];
        $jumlah_alat = $r['jumlah_alat'];
        $kondisi = $r['kondisi'];
        $lokasi = $r['lokasi'];
        $keterangan = $r['keterangan'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from barang where id_barang='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Barang</h3>
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
                <label for="id_kategori" class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-4">
                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                        <option value="">Pilih...</option>
                        <?php foreach ($kategori as $row) : ?>
                            <option value="<?= $row['id_kategori'] ?>" <?= $id_kategori == $row['id_kategori'] ? 'selected' : '' ?>><?= $row['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="nama_alat" class="col-sm-2 control-label">Nama Alat</label>
                <div class="col-sm-4">
                    <input name="nama_alat" id="nama_alat" class="form-control" required type="text" value="<?php echo $nama_alat; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="jumlah_alat" class="col-sm-2 control-label">Jumlah</label>
                <div class="col-sm-4">
                    <input name="jumlah_alat" id="jumlah_alat" class="form-control" required type="number" value="<?php echo $jumlah_alat; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="kondisi" class="col-sm-2 control-label">Kondisi</label>
                <div class="col-sm-4">
                    <input name="kondisi" id="kondisi" type="text" class="form-control" value="<?php echo $kondisi; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="lokasi" class="col-sm-2 control-label">Lokasi</label>
                <div class="col-sm-4">
                    <input name="lokasi" id="lokasi" type="text" class="form-control" value="<?php echo $lokasi; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
                <div class="col-sm-4">
                    <input name="keterangan" id="keterangan" type="text" class="form-control" value="<?php echo $keterangan; ?>">
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