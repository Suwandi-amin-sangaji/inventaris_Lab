<?php
$link_data = '?page=peminjaman';
$link_update = '?page=update_peminjaman';

$arr_ket_peminjaman = ['Menunggu', 'Diterima', 'Ditolak'];
$ket_peminjaman = '';
$arr_ket_pengembalian = ['Belum Kembali', 'Sudah Kembali'];
$ket_pengembalian = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];

    $ket_peminjaman = isset($_POST['ket_peminjaman']) ? $_POST['ket_peminjaman'] : 'Diterima';
    $ket_pengembalian = isset($_POST['ket_pengembalian']) ? $_POST['ket_pengembalian'] : 'Belum Kembali';

    if ($action == 'edit') {
        if ($ket_peminjaman == 'Diterima') {
            // update stok
            if ($ket_pengembalian == 'Sudah Kembali') {
                $result = mysqli_query($con, "select * from peminjaman_barang where id_peminjaman='" . $id . "'");
                while ($row = mysqli_fetch_array($result)) {
                    $q = "update barang set jumlah_alat=jumlah_alat+" . $row['jumlah_pinjam'] . " where id_barang='" . $row['id_barang'] . "'";
                    mysqli_query($con, $q);
                }
            } elseif (empty($_POST['ket_pengembalian'])) {
                $result = mysqli_query($con, "select * from peminjaman_barang where id_peminjaman='" . $id . "'");
                while ($row = mysqli_fetch_array($result)) {
                    $q = "update barang set jumlah_alat=jumlah_alat-" . $row['jumlah_pinjam'] . " where id_barang='" . $row['id_barang'] . "'";
                    mysqli_query($con, $q);
                }
            }
            $q = "update peminjaman set ket_peminjaman='" . $ket_peminjaman . "',ket_pengembalian='$ket_pengembalian' where id_peminjaman='" . $id . "'";
        } else {
            $q = "update peminjaman set ket_peminjaman='" . $ket_peminjaman . "',ket_pengembalian=NULL where id_peminjaman='" . $id . "'";
        }
        mysqli_query($con, $q);
        $_SESSION['message'] = 'Data berhasil diubah';
        exit("<script>location.href='" . $link_data . "';</script>");
    }
} else {
    if (empty($_GET['action'])) {
        $action = '';
    } else {
        $action = $_GET['action'];
    }
    if ($action == 'edit') {
        $id = $_GET['id'];
        $q = mysqli_query($con, "select * from peminjaman where id_peminjaman='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $ket_peminjaman = $r['ket_peminjaman'];
        $ket_pengembalian = $r['ket_pengembalian'];
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
            <table class="table table-bordered">
                <tr>
                    <td width="200">Nama Peminjam</td>
                    <td><?= $r['nama_peminjam'] ?></td>
                </tr>
                <tr>
                    <td width="200">NIM</td>
                    <td><?= $r['nim'] ?></td>
                </tr>
                <tr>
                    <td width="200">Tanggal Pinjam</td>
                    <td><?= date('d/m/Y', strtotime($r['tgl_pinjam'])) . ' - ' . date('d/m/Y', strtotime($r['tgl_kembali'])) ?></td>
                </tr>
                <?php if (empty($ket_pengembalian)) : ?>
                    <tr>
                        <td width="200">Keterangan Peminjaman</td>
                        <td>
                            <select name="ket_peminjaman" id="ket_peminjaman" class="form-control" required>
                                <option value="">Pilih...</option>
                                <?php foreach ($arr_ket_peminjaman as $val) : ?>
                                    <option <?= $ket_peminjaman == $val ? 'selected' : '' ?>><?= $val ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td width="200">Keterangan Peminjaman</td>
                        <td><?= $r['ket_peminjaman'] ?></td>
                    </tr>
                    <?php if ($ket_pengembalian == 'Belum Kembali') : ?>
                        <tr>
                            <td width="200">Keterangan Pengembalian</td>
                            <td>
                                <select name="ket_pengembalian" id="ket_pengembalian" class="form-control" required>
                                    <option value="">Pilih...</option>
                                    <?php foreach ($arr_ket_pengembalian as $val) : ?>
                                        <option <?= $ket_pengembalian == $val ? 'selected' : '' ?>><?= $val ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td width="200">Keterangan Pengembalian</td>
                            <td><?= $r['ket_pengembalian'] ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            </table>
        </div>
        <div class="box-footer">
            <div class="text-center col-sm-6">
                <?php if ($ket_pengembalian != 'Sudah Kembali') : ?>
                    <button type="submit" name="save" class="btn btn-success">Simpan</button>
                <?php endif; ?>
                <a href="<?php echo $link_data; ?>" class="btn btn-default">Kembali</a>
            </div>
        </div>
    </form>
</div>