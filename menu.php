<?php
$page = isset($_GET['page']) ? $_GET['page'] : '';
?>
<li <?php if ($page == "") echo 'class="active"'; ?>><a href="./"><i class="fa fa-home"></i> <span>Home</span></a></li>

<?php if ($_SESSION['level'] == 'Admin') : ?>
    <li <?php if ($page == "kategori" || $page == "update_kategori") echo 'class="active"'; ?>><a href="?page=kategori"><i class="fa fa-tags"></i> <span>Kategori</span></a></li>
    <li <?php if ($page == "barang" || $page == "update_barang") echo 'class="active"'; ?>><a href="?page=barang"><i class="fa fa-wrench"></i> <span>Barang</span></a></li>
    <li <?php if ($page == "supplier" || $page == "update_supplier") echo 'class="active"'; ?>><a href="?page=supplier"><i class="fa fa-phone"></i> <span>Supplier</span></a></li>
    <li <?php if ($page == "peminjaman" || $page == "update_peminjaman" || $page == "barang_peminjaman" || $page == "update_barang_peminjaman") echo 'class="active"'; ?>><a href="?page=peminjaman"><i class="fa fa-exchange"></i> <span>Peminjaman</span></a></li>
    <li <?php if ($page == "barang_masuk" || $page == "update_barang_masuk") echo 'class="active"'; ?>><a href="?page=barang_masuk"><i class="fa fa-download"></i> <span>Barang Masuk</span></a></li>
    <li <?php if ($page == "barang_keluar" || $page == "update_barang_keluar") echo 'class="active"'; ?>><a href="?page=barang_keluar"><i class="fa fa-upload"></i> <span>Barang Keluar</span></a></li>
    <li <?php if ($page == "laporan") echo 'class="active"'; ?>><a href="?page=laporan"><i class="fa fa-print"></i> <span>Laporan</span></a></li>
    <li <?php if ($page == "stok") echo 'class="active"'; ?>><a href="?page=stok"><i class="fa fa-check"></i> <span>Stok Barang</span></a></li>
    <li <?php if ($page == "pengguna" || $page == "update_pengguna") echo 'class="active"'; ?>><a href="?page=pengguna"><i class="fa fa-user"></i> <span>Pengguna</span></a></li>

<?php elseif ($_SESSION['level'] == 'Peminjam') : ?>
    <li <?php if ($page == "peminjaman" || $page == "update_peminjaman" || $page == "barang_peminjaman" || $page == "update_barang_peminjaman") echo 'class="active"'; ?>><a href="?page=peminjaman"><i class="fa fa-exchange"></i> <span>Peminjaman</span></a></li>
    <li <?php if ($page == "stok") echo 'class="active"'; ?>><a href="?page=stok"><i class="fa fa-check"></i> <span>Stok Barang</span></a></li>
<?php endif; ?>

<li <?php if ($page == "password") echo 'class="active"'; ?>><a href="?page=password"><i class="fa fa-unlock-alt"></i> <span>Ubah Password</span></a></li>
<li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>