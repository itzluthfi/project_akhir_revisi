<?php 
require_once "./init.php";

// Cek apakah ada sesi pengguna yang aktif
if (isset($_SESSION['user_login'])) {
    // Jika ada, arahkan ke halaman dashboard
    header('Location: views/dashboard/dashboard.php');
    exit();
}

// Cek apakah ada cookie untuk user_login
if (isset($_COOKIE['user_login'])) {
    // Jika ada, set sesi dari cookie
    $_SESSION['user_login'] = $_COOKIE['user_login'];

    // Arahkan ke halaman dashboard
    header('Location: views/dashboard/dashboard.php');

    exit();
}

// Jika tidak ada sesi atau cookie, tampilkan halaman login
require_once "views/loginPage.php";
?>