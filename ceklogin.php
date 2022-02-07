<?php
$error = '';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $q = mysqli_query($con, "SELECT * FROM pengguna WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($q) == 0) {
        $error = 'Username dan password salah';
    }
    if (empty($error)) {
        $r = mysqli_fetch_array($q);
        $_SESSION['id_pengguna'] = $r['id_pengguna'];
        $_SESSION['username'] = $r['username'];
        $_SESSION['nama_lengkap'] = $r['nama_lengkap'];
        $_SESSION['nim'] = $r['nim'];
        $_SESSION['level'] = $r['level'];
        header('location:index.php');
    }
}
