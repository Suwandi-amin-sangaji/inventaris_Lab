<?php
$link_data = '?page=supplier';
$link_update = '?page=update_supplier';

$nama_supplier = '';
$alamat_supplier = '';
$telepon_supplier = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $nama_supplier = $_POST['nama_supplier'];
    $alamat_supplier = $_POST['alamat_supplier'];
    $telepon_supplier = $_POST['telepon_supplier'];

    if ($action == 'add') {
        if (mysqli_num_rows(mysqli_query($con, "select * from supplier where nama_supplier='" . $nama_supplier . "'")) > 0) {
            $error = 'Nama Supplier sudah ada';
        } else {
            $q = "insert into supplier(nama_supplier,alamat_supplier,telepon_supplier) values ('" . $nama_supplier . "','" . $alamat_supplier . "','" . $telepon_supplier . "')";
            mysqli_query($con, $q);
            $_SESSION['message'] = 'Data berhasil ditambahkan';
            exit("<script>location.href='" . $link_data . "';</script>");
        }
    }
    if ($action == 'edit') {
        $q = mysqli_query($con, "select * from supplier where id_supplier='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_supplier_tmp = $r['nama_supplier'];
        if (mysqli_num_rows(mysqli_query($con, "select * from supplier where nama_supplier='" . $nama_supplier . "' and nama_supplier<>'" . $nama_supplier_tmp . "'")) > 0) {
            $error = 'Nama Supplier sudah ada';
        } else {
            $q = "update supplier set nama_supplier='" . $nama_supplier . "',alamat_supplier='" . $alamat_supplier . "',telepon_supplier='" . $telepon_supplier . "' where id_supplier='" . $id . "'";
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
        $q = mysqli_query($con, "select * from supplier where id_supplier='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_supplier = $r['nama_supplier'];
        $alamat_supplier = $r['alamat_supplier'];
        $telepon_supplier = $r['telepon_supplier'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from supplier where id_supplier='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Supplier</h3>
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
                <label for="nama_supplier" class="col-sm-2 control-label">Nama Supplier</label>
                <div class="col-sm-4">
                    <input name="nama_supplier" id="nama_supplier" class="form-control" required type="text" value="<?php echo $nama_supplier; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="alamat_supplier" class="col-sm-2 control-label">Alamat</label>
                <div class="col-sm-4">
                    <input name="alamat_supplier" id="alamat_supplier" class="form-control" required type="text" value="<?php echo $alamat_supplier; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="telepon_supplier" class="col-sm-2 control-label">Telepon</label>
                <div class="col-sm-4">
                    <input name="telepon_supplier" id="telepon_supplier" type="number" required class="form-control" value="<?php echo $telepon_supplier; ?>">
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