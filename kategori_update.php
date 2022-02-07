<?php
$link_data = '?page=kategori';
$link_update = '?page=update_kategori';

$nama_kategori = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $nama_kategori = $_POST['nama_kategori'];

    if ($action == 'add') {
        if (mysqli_num_rows(mysqli_query($con, "select * from kategori where nama_kategori='" . $nama_kategori . "'")) > 0) {
            $error = 'Nama Kategori sudah ada';
        } else {
            $q = "insert into kategori(nama_kategori) values ('" . $nama_kategori . "')";
            mysqli_query($con, $q);
            $_SESSION['message'] = 'Data berhasil ditambahkan';
            exit("<script>location.href='" . $link_data . "';</script>");
        }
    }
    if ($action == 'edit') {
        $q = mysqli_query($con, "select * from kategori where id_kategori='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_kategori_tmp = $r['nama_kategori'];
        if (mysqli_num_rows(mysqli_query($con, "select * from kategori where nama_kategori='" . $nama_kategori . "' and nama_kategori<>'" . $nama_kategori_tmp . "'")) > 0) {
            $error = 'Nama Kategori sudah ada';
        } else {
            $q = "update kategori set nama_kategori='" . $nama_kategori . "' where id_kategori='" . $id . "'";
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
        $q = mysqli_query($con, "select * from kategori where id_kategori='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_kategori = $r['nama_kategori'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from kategori where id_kategori='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Kategori</h3>
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
                <label for="nama_kategori" class="col-sm-2 control-label">Nama Kategori</label>
                <div class="col-sm-4">
                    <input name="nama_kategori" id="nama_kategori" class="form-control" required type="text" value="<?php echo $nama_kategori; ?>">
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