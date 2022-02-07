<?php
$link_data = '?page=laporan';

$tgl1 = '';
$tgl2 = '';
$laporan = '';
$arr_laporan = ['Peminjaman', 'Barang Masuk', 'Barang Keluar'];

if (isset($_POST['cetak'])) {
    $tgl1 = $_POST['tgl1'];
    $tgl2 = $_POST['tgl2'];
    $laporan = $_POST['laporan'];

    if ($laporan == 'Peminjaman') {
        $url = "laporan_peminjaman.php?tgl1=" . $tgl1 . "&tgl2=" . $tgl2;
        exit("<script>location.href='" . $url . "';</script>");
    } elseif ($laporan == 'Barang Masuk') {
        $url = "laporan_barang_masuk.php?tgl1=" . $tgl1 . "&tgl2=" . $tgl2;
        exit("<script>location.href='" . $url . "';</script>");
    } elseif ($laporan == 'Barang Keluar') {
        $url = "laporan_barang_keluar.php?tgl1=" . $tgl1 . "&tgl2=" . $tgl2;
        exit("<script>location.href='" . $url . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Laporan</h3>
    </div>
    <form class="form-horizontal" action="<?php echo $link_data; ?>" method="post" target="_blank">
        <div class="box-body">
            <div class="form-group">
                <label for="tgl1" class="col-sm-2 control-label">Dari Tanggal</label>
                <div class="col-sm-2">
                    <input name="tgl1" id="tgl1" class="form-control" required type="date" value="<?php echo $tgl1; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tgl2" class="col-sm-2 control-label">Sampai Tanggal</label>
                <div class="col-sm-2">
                    <input name="tgl2" id="tgl2" class="form-control" required type="date" value="<?php echo $tgl2; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="laporan" class="col-sm-2 control-label">Laporan</label>
                <div class="col-sm-4">
                    <select name="laporan" id="laporan" class="form-control" required>
                        <option value="">Pilih...</option>
                        <?php foreach ($arr_laporan as $val) : ?>
                            <option value="<?= $val ?>" <?= $laporan == $val ? 'selected' : '' ?>><?= $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center col-sm-6">
                <button type="submit" name="cetak" class="btn btn-success"><i class="fa fa-print"></i> Cetak</button>
            </div>
        </div>
    </form>
</div>