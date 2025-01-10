<?php


// Cek apakah user sudah login melalui session atau cookie
if (!isset($_SESSION['user_login'])) {
    if (isset($_COOKIE['user_login'])) {
        // Set session dari cookie jika cookie ada
        $_SESSION['user_login'] = $_COOKIE['user_login'];
    } else {
        // Redirect ke login jika tidak ada sesi atau cookie
        header('Location: /project_akhir/');
        exit();
    }
}

?>