<?php
$link_data = '?page=pengguna';
$link_update = '?page=update_pengguna';

$nama_lengkap = '';
$username = '';
$password = '';
$arr_level = ['Admin', 'Peminjam'];
$level = '';
$nim = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $nim = empty($_POST['nim']) ? NULL : ($level == 'Peminjam' ? $_POST['nim'] : NULL);

    if ($action == 'add') {
        if (mysqli_num_rows(mysqli_query($con, "select * from pengguna where username='" . $username . "'")) > 0) {
            $error = 'Username sudah ada';
        } else {
            $password = $_POST['password'];
            $q = "insert into pengguna(nama_lengkap,username,password,level,nim) values ('" . $nama_lengkap . "','" . $username . "','" . $password . "','" . $level . "','" . $nim . "')";
            mysqli_query($con, $q);
            $_SESSION['message'] = 'Data berhasil ditambahkan';
            exit("<script>location.href='" . $link_data . "';</script>");
        }
    }
    if ($action == 'edit') {
        $q = mysqli_query($con, "select * from pengguna where id_pengguna='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $username_tmp = $r['username'];
        if (mysqli_num_rows(mysqli_query($con, "select * from pengguna where username='" . $username . "' and username<>'" . $username_tmp . "'")) > 0) {
            $error = 'Username sudah ada';
        } else {
            $q = "update pengguna set nama_lengkap='" . $nama_lengkap . "',username='" . $username . "',level='" . $level . "',nim='" . $nim . "' where id_pengguna='" . $id . "'";
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
        $q = mysqli_query($con, "select * from pengguna where id_pengguna='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_lengkap = $r['nama_lengkap'];
        $username = $r['username'];
        $level = $r['level'];
        $nim = $r['nim'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from pengguna where id_pengguna='" . $id . "'");
        $_SESSION['message'] = 'Data berhasil dihapus';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Pengguna</h3>
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
                <label for="nama_lengkap" class="col-sm-2 control-label">Nama Lengkap</label>
                <div class="col-sm-4">
                    <input name="nama_lengkap" id="nama_lengkap" class="form-control" required type="text" value="<?php echo $nama_lengkap; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-4">
                    <input name="username" id="username" class="form-control" required type="text" value="<?php echo $username; ?>">
                </div>
            </div>
            <?php if ($action == "add") { ?>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-4">
                        <input name="password" id="password" required type="password" class="form-control" value="<?php echo $password; ?>">
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="level" class="col-sm-2 control-label">Level</label>
                <div class="col-sm-4">
                    <select name="level" id="level" class="form-control" required>
                        <option value="">Pilih...</option>
                        <?php foreach ($arr_level as $val) : ?>
                            <option <?= $level == $val ? 'selected' : '' ?>><?= $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="nim" class="col-sm-2 control-label">NIM</label>
                <div class="col-sm-4">
                    <input name="nim" id="nim" class="form-control" type="number" value="<?php echo $nim; ?>">
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