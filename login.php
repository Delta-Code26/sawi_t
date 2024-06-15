<?php
include 'include/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnLogin'])) {
    $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');

    // Cek di tabel users
    $query_user = "SELECT * FROM users WHERE username = ?";
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bind_param('s', $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
        // Membandingkan password yang di-hash dari database dengan password yang diinput oleh pengguna
        if (password_verify($password, $user['password'])) {
            $_SESSION['ses_id'] = $user['id_user'];
            $_SESSION['ses_nama'] = $user['nama_lengkap'];
            $_SESSION['ses_username'] = $user['username'];
            $_SESSION['ses_foto'] = $user['foto'];
            $_SESSION['ses_level'] = $user['level'];
            $_SESSION['ses_team'] = $user['team'];

            // Redirect berdasarkan level pengguna
            // if ($user['level'] == 'Admin') {
            //     header("Location: index.php");
            // } else {
            //     header("Location: index.php");
            // }
            if ($user['level'] == 'Admin') {
                header("Location: index.php");
            } else if ($user['level'] == 'Pekerja') {
                header("Location: index.php");
            } else {
                header("Location: login.php");
            }
            exit();
        }
    }

    // Tampilkan pesan kesalahan jika username atau password salah
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Username atau password salah',
                confirmButtonText: 'Coba Lagi'
            });
        });
    </script>";
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
    <link href="vendors/bootstrap-5/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendors/fontawesome-free/css/all.min.css" rel="stylesheet">
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