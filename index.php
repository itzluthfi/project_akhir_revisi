<?php 
require_once "./init.php";

// Cek apakah ada sesi pengguna yang aktif
if (isset($_SESSION['user_login'])) {
    // Jika ada, arahkan ke halaman role_list
    header('Location: /project_akhir/views/dashboard/dashboard.php');
    exit();
}

// Cek apakah ada cookie untuk user_login
if (isset($_COOKIE['user_login'])) {
    // Jika ada, set sesi dari cookie
    $_SESSION['user_login'] = $_COOKIE['user_login'];

    // Arahkan ke halaman role_list
    header('Location: /project_akhir/views/dashboard/dashboard.php');
    exit();
}

// Jika tidak ada sesi atau cookie, tampilkan halaman login
require_once "views/loginPage.php";
?>

<!-- 
<?php 
require_once "./init.php";

// Cek apakah ada sesi pengguna yang aktif
if (isset($_SESSION['user_login'])) {
    // Jika ada sesi untuk ghost, arahkan ke halaman dashboard
    header('Location: /project_akhir/views/dashboard/dashboard.php');
    exit();
} elseif (isset($_SESSION['member_login'])) {
    // Jika ada sesi untuk member, arahkan ke halaman member
    header('Location: /project_akhir/views/warkop_ui/login_member.php');
    exit();
}

// Cek apakah ada cookie untuk user_login
if (isset($_COOKIE['user_login'])) {
    // Jika ada, set sesi dari cookie
    $_SESSION['user_login'] = $_COOKIE['user_login'];
    // Arahkan ke halaman dashboard
    header('Location: /project_akhir/views/dashboard/dashboard.php');
    exit();
} elseif (isset($_COOKIE['member_login'])) {
    // Jika ada, set sesi dari cookie
    $_SESSION['member_login'] = $_COOKIE['member_login'];
    // Arahkan ke halaman member
    header('Location: /project_akhir/views/warkop_ui/login_member.php');
    exit();
}

// Jika tidak ada sesi atau cookie, tampilkan halaman login
require_once "views/loginPage.php";
?> -->