<?php
include "include/koneksi.php";
session_start();

if (empty($_SESSION["ses_username"])) {
    header("location: login.php");
    exit;
}

$data_id = htmlspecialchars($_SESSION["ses_id"], ENT_QUOTES, 'UTF-8');
$data_nama = htmlspecialchars($_SESSION["ses_nama"], ENT_QUOTES, 'UTF-8');
$data_user = htmlspecialchars($_SESSION["ses_username"], ENT_QUOTES, 'UTF-8');
$data_level = htmlspecialchars($_SESSION["ses_level"], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="dist/img/logo.png">
    <link href="vendors/bootstrap-5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="vendors/sweetalert/sweetalert.min.js"></script>
    <script src="vendors/jquery/jquery.min.js"></script>
    <script src="vendors/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script defer src="vendors/fontawesome-free/js/all.min.js"></script>

    <?php
    $page = $_GET['page'] ?? '';
    $file = '';
    $title = 'Marno : 362389015 - ';

    if ($data_level === 'Admin') {
        switch ($page) {
            case 'data_admin':
                $file = 'admin/data_admin.php';
                $title .= 'Data Admin';
                break;
            case 'update_admin':
                $file = 'admin/update_admin.php';
                $title .= 'Update Admin';
                break;
            case 'hapus_admin':
                $file = 'admin/hapus_admin.php';
                $title .= 'Hapus Admin';
                break;
            case 'add_admin':
                $file = 'admin/add_admin.php';
                $title .= 'Tambah Admin';
                break;
            case 'data_pekerja':
                $file = 'pekerja/data_pekerja.php';
                $title .= 'Data Pekerja';
                break;
            case 'add_pekerja':
                $file = 'pekerja/add_pekerja.php';
                $title .= 'Tambah Data Pekerja';
                break;
            case 'update_pekerja':
                $file = 'pekerja/update_pekerja.php';
                $title .= 'Update Data Pekerja';
                break;
            case 'del_pekerja':
                $file = 'pekerja/del_pekerja.php';
                $title .= 'Hapus Data Pekerja';
                break;
            case 'data_panen':
                $file = 'panen/data_panen.php';
                $title .= 'Data Panen';
                break;
            case 'add_panen':
                $file = 'panen/add_panen.php';
                $title .= 'Tambah Data Panen';
                break;
            case 'update_panen':
                $file = 'panen/update_panen.php';
                $title .= 'Update Data Panen';
                break;
            case 'del_panen':
                $file = 'panen/del_panen.php';
                $title .= 'Hapus Data Panen';
                break;
            case 'data_task':
                $file = 'task/data_task.php';
                $title .= 'Data Task';
                break;
            case 'add_task':
                $file = 'task/add_task.php';
                $title .= 'Tambah Data Task';
                break;
            case 'update_task':
                $file = 'task/update_task.php';
                $title .= 'Update Data Task';
                break;
            case 'del_task':
                $file = 'task/del_task.php';
                $title .= 'Hapus Data Task';
                break;
            case 'data_gaji':
                $file = 'gaji/data_gaji.php';
                $title .= 'Data Gaji';
                break;
            case 'add_gaji':
                $file = 'gaji/add_gaji.php';
                $title .= 'Tambah Data Gaji';
                break;
            case 'update_gaji':
                $file = 'gaji/update_gaji.php';
                $title .= 'Update Data Gaji';
                break;
            case 'del_gaji':
                $file = 'gaji/del_gaji.php';
                $title .= 'Hapus Data Gaji';
                break;
            case 'profil':
                $file = 'profile.php';
                $title .= 'Profil';
                break;
            default:
                $file = 'admin/dashboard_admin.php';
                $title .= 'Dashboard';
                break;
        }
    } elseif ($data_level === 'Pekerja') {
        switch ($page) {
            case 'dashboard':
                $file = 'admin/pekerja/data_pekerja.php';
                $title .= 'Dashboard';
                break;
            case 'profil':
                $file = 'profile.php';
                $title .= 'Profil';
                break;
            default:
                $file = '404.php';
                $title .= '404 Not Found';
                break;
        }
    } else {
        $file = $data_level === 'Admin' ? 'admin/dashboard_admin.php' : 'pekerja/dashboard_pekerja.php';
        $title .= 'Dashboard';
    }
    ?>
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php include './components/sidebar.php'; ?>
        <!-- Page Content  -->
        <div id="main">
            <!-- Navbar -->
            <?php include './components/navbar.php'; ?>
            <!-- Userinfo -->
            <div class='py-3 px-4 text-center bg-warning text-light fs-5'>
                <i class="fas fa-user"></i>
                Selamat datang di Dashboard <?= htmlspecialchars($data_level, ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <!-- Content -->
            <div id="content">
                <?php
                if (!empty($file)) {
                    include './pages/' . $file;
                }
                ?>
                <!-- End div content -->
            </div>
            <!-- End div main -->
        </div>
        <!-- End div wrapper -->
    </div>
    <!-- Script -->
    <script src="assets/js/script.js"></script>
</body>

</html>