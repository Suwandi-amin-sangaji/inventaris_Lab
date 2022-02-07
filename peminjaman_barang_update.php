<?php
$id_peminjaman = isset($_GET['id']) ? $_GET['id'] : '';
$link_update = '?page=update_barang_peminjaman&id=' . $id_peminjaman;
$link_barang = '?page=barang_peminjaman&id=' . $id_peminjaman;

$id_barang = '';
$barang = [];
$result = mysqli_query($con, "select * from barang");
while ($row = mysqli_fetch_array($result)) {
    $barang[] = $row;
}
$jumlah_pinjam = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $id_barang = $_POST['id_barang'];
    $jumlah_pinjam = $_POST['jumlah_pinjam'];

    if ($action == 'add') {
        if (mysqli_num_rows(mysqli_query($con, "select * from peminjaman_barang where id_peminjaman='$id_peminjaman' and id_barang='$id_barang'")) > 0) {
            $error = 'Barang sudah ada';
        } else {
            $data_barang = mysqli_fetch_array(mysqli_query($con, "select * from barang where id_barang='$id_barang'"));
            if ($jumlah_pinjam > $data_barang['jumlah_alat']) {
                $error = 'Jumlah Alat tersisa tidak cukup. Sisa stok ada ' . $data_barang['jumlah_alat'] . '.';
            } else {
                $q = "insert into peminjaman_barang(id_peminjaman,id_barang,jumlah_pinjam) values ('" . $id_peminjaman . "','" . $id_barang . "','" . $jumlah_pinjam . "')";
                mysqli_query($con, $q);
                $_SESSION['message'] = 'Data berhasil ditambahkan';
                exit("<script>location.href='" . $link_barang . "';</script>");
            }
        }
    }
    if ($action == 'edit') {
        $data_barang = mysqli_fetch_array(mysqli_query($con, "select * from barang where id_barang='$id_barang'"));
        if ($jumlah_pinjam > $data_barang['jumlah_alat']) {
            $error = 'Jumlah Alat tersisa tidak cukup. Sisa stok ada ' . $data_barang['jumlah_alat'] . '.';
            $nama_alat = $data_barang['nama_alat'];
        } else {
            $q = "update peminjaman_barang set jumlah_pinjam='" . $jumlah_pinjam . "' where id_peminjaman_barang='" . $id . "'";
            mysqli_query($con, $q);
            $_SESSION['message'] = 'Data berhasil diubah';
            exit("<script>location.href='" . $link_barang . "';</script>");
        }
    }
} else {
    if (empty($_GET['action'])) {
        $action = 'add';
    } else {
        $action = $_GET['action'];
    }
    if ($action == 'edit') {
        $id = $_GET['idp'];
        $q = mysqli_query($con, "select * from peminjaman_barang left join barang on peminjaman_barang.id_barang=barang.id_barang where id_peminjaman_barang='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_alat = $r['nama_alat'];
        $id_barang = $r['id_barang'];
        $jumlah_pinjam = $r['jumlah_pinjam'];
    }
    if ($action == 'delete') {
        $id = $_GET['idp'];
        mysqli_query($con, "delete from peminjaman_barang where id_peminjaman_barang='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_barang . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Peminjaman Barang</h3>
    </div>
    <form class="form-horizontal" action="<?php echo $link_update; ?>" method="post">
        <input name="id" type="hidden" value="<?php echo $id; ?>">
        <input name="action" type="hidden" value="<?php echo $action; ?>">
        <input name="id_barang" type="hidden" value="<?php echo $id_barang; ?>">
        <div class="box-body">
            <?php
            if (!empty($error)) {
                echo '<div class="alert bg-danger" role="alert">' . $error . '</div>';
            }
            ?>
            <?php if ($action == 'edit') : ?>
                <div class="form-group">
                    <label for="nama_alat" class="col-sm-2 control-label">Nama Alat</label>
                    <div class="col-sm-4">
                        <input name="nama_alat" id="nama_alat" class="form-control" readonly type="text" value="<?php echo $nama_alat; ?>">
                    </div>
                </div>
            <?php else : ?>
                <div class="form-group">
                    <label for="id_barang" class="col-sm-2 control-label">Nama Alat</label>
                    <div class="col-sm-4">
                        <select name="id_barang" id="id_barang" class="form-control selectpicker" data-live-search="true" required>
                            <option value="">Pilih...</option>
                            <?php foreach ($barang as $row) : ?>
                                <option value="<?= $row['id_barang'] ?>" <?= $id_barang == $row['id_barang'] ? 'selected' : '' ?>><?= $row['nama_alat'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="jumlah_pinjam" class="col-sm-2 control-label">Jumlah Pinjam</label>
                <div class="col-sm-4">
                    <input name="jumlah_pinjam" id="jumlah_pinjam" class="form-control" required type="number" value="<?php echo $jumlah_pinjam; ?>">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center col-sm-6">
                <button type="submit" name="save" class="btn btn-success">Simpan</button>
                <a href="<?php echo $link_barang; ?>" class="btn btn-default">Kembali</a>
            </div>
        </div>
    </form>
</div>