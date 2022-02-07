<?php
switch ($page) {
    case 'laporan':
        include "laporan.php";
        break;
    case 'barang_keluar':
        include "barang_keluar.php";
        break;
    case 'update_barang_keluar':
        include "barang_keluar_update.php";
        break;
    case 'barang_masuk':
        include "barang_masuk.php";
        break;
    case 'update_barang_masuk':
        include "barang_masuk_update.php";
        break;
    case 'stok':
        include "stok.php";
        break;
    case 'peminjaman':
        include "peminjaman.php";
        break;
    case 'update_peminjaman':
        if ($_SESSION['level'] == 'Peminjam') {
            include "peminjaman_update.php";
        } elseif ($_SESSION['level'] == 'Admin') {
            include "peminjaman_update_admin.php";
        }
        break;
    case 'barang_peminjaman':
        include "peminjaman_barang.php";
        break;
    case 'update_barang_peminjaman':
        include "peminjaman_barang_update.php";
        break;
    case 'supplier':
        include "supplier.php";
        break;
    case 'update_supplier':
        include "supplier_update.php";
        break;
    case 'barang':
        include "barang.php";
        break;
    case 'update_barang':
        include "barang_update.php";
        break;
    case 'kategori':
        include "kategori.php";
        break;
    case 'update_kategori':
        include "kategori_update.php";
        break;
    case 'pengguna':
        include "pengguna.php";
        break;
    case 'update_pengguna':
        include "pengguna_update.php";
        break;
    case 'password':
        include "password.php";
        break;

    default:
        include "home.php";
        break;
}
