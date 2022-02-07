<?php
$link_data = '?page=stok';
$link_cetak = 'stok_cetak.php';

$list_data = '';
$q = "select * from barang left join kategori on barang.id_kategori=kategori.id_kategori order by id_barang";
$q = mysqli_query($con, $q);
if (mysqli_num_rows($q) > 0) {
    while ($r = mysqli_fetch_array($q)) {
        $id = $r['id_barang'];
        $list_data .= '
		<tr>
            <td></td>
            <td>' . $r['nama_kategori'] . '</td>
            <td>' . $r['nama_alat'] . '</td>
            <td>' . $r['jumlah_alat'] . '</td>
            <td>' . $r['kondisi'] . '</td>
            <td>' . $r['lokasi'] . '</td>
            <td>' . $r['keterangan'] . '</td>
		</tr>';
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Stok Barang</h3>
        <div class="box-tools">
            <a href="<?php echo $link_cetak; ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-print"></i> Cetak</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTables1">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kategori</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $list_data; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>