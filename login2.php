<?php
session_start();
include 'include/koneksi.php'; // Mengimpor koneksi database

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnLogin'])) {
    // Memastikan variabel $_POST didefinisikan
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Hash password menggunakan SHA-256
    $hashed_password = hash('sha256', $password);

    // Cek di tabel admin
    $query_admin = "SELECT * FROM tb_admin WHERE username = ? AND password = ?";
    $stmt_admin = $conn->prepare($query_admin);
    $stmt_admin->bind_param('ss', $username, $hashed_password);
    // $stmt_admin->bind_param('ss', $username, $password);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $admin = $result_admin->fetch_assoc();
        $_SESSION['ses_id'] = $admin['id_admin'];
        $_SESSION['ses_nama'] = $admin['nama_lengkap'];
        $_SESSION['ses_username'] = $admin['username'];
        $_SESSION['ses_level'] = 'Admin';
        header("Location: index.php");
        exit();
    }

    // Cek di tabel pekerja
    $query_pekerja = "SELECT * FROM tb_pekerja WHERE username = ? AND password = ?";
    $stmt_pekerja = $conn->prepare($query_pekerja);
    $stmt_pekerja->bind_param('ss', $username, $password);
    $stmt_pekerja->execute();
    $result_pekerja = $stmt_pekerja->get_result();

    if ($result_pekerja->num_rows > 0) {
        $pekerja = $result_pekerja->fetch_assoc();
        $_SESSION['ses_id'] = $pekerja['id_pekerja'];
        $_SESSION['ses_nama'] = $pekerja['nama_lengkap'];
        $_SESSION['ses_username'] = $pekerja['username'];
        $_SESSION['ses_level'] = 'Pekerja';
        header("Location: index.php");
        exit();
    }

    // Jika username atau password salah
    echo "<script>alert('Username atau password salah');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="dist/img/logo.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="./vendors/bootstrap-5/css/bootstrap.min.css" rel="stylesheet">
    <link href="./vendors/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Masuk - Sime Darby (Bukit Rona)</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 d-none d-md-block bg-primary vh-100">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <img class="w-75" src="assets/img/logo_kampus.png" alt="Logo">
                </div>
            </div>
            <div class="col-md-8 vh-100">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="p-5 col-md-6">
                        <h3 class="fw-bold mb-4 text-center">LOGIN</h3>
                        <p class="text-center">Silahkan Login Dahulu | <a href='https://simedarby.com/' title='Bukit Rona' target='_blank'>Sime Darby</a></p>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="*******" required>
                            </div>
                            <div class="d-grid mb-4">
                                <button class="btn btn-primary" name="btnLogin" type="submit">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./vendors/jquery/jquery.min.js"></script>
    <script src="./vendors/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="./assets/js/script.js"></script>
</body>

</html>