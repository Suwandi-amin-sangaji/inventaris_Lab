<?php
$link_data = '?page=pengguna';
$link_update = '?page=update_pengguna';

$list_data = '';
$q = "select * from pengguna order by id_pengguna";
$q = mysqli_query($con, $q);
if (mysqli_num_rows($q) > 0) {
    while ($r = mysqli_fetch_array($q)) {
        $id = $r['id_pengguna'];
        $nim = empty($r['nim']) ? '' : ' - NIM ' . $r['nim'];
        $list_data .= '
		<tr>
            <td></td>
            <td>' . $r['nama_lengkap'] . ' ' . $nim . '</td>
            <td>' . $r['username'] . '</td>
            <td>' . $r['level'] . '</td>
            <td>
                <a href="' . $link_update . '&id=' . $id . '&action=edit" class="btn btn-success btn-xs" title="Ubah">Ubah</a> &nbsp;';
        if ($r['username'] != $_SESSION['username']) {
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
        <h3 class="box-title">Data Pengguna</h3>
        <div class="box-tools">
            <a href="<?php echo $link_update; ?>" class="btn btn-primary btn-sm">Tambah Pengguna</a>
        </div>
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
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Level</th>
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