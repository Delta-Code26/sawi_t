<?php
include "include/koneksi.php";
if ($_SESSION['ses_level'] !== 'Pekerja') {
    header("Location: login.php");
    exit();
}


// Menghitung total User
$queryUser = "SELECT COUNT(*) as total_user  FROM users WHERE team = 'Pekerja'";
$resultUser = $conn->query($queryUser);
$dataUser = $resultUser->fetch_assoc();
$totalUser = isset($dataUser['total_user']) ? $dataUser['total_user'] : 0;
// Menghitung total Admin
$data_team = htmlspecialchars($_SESSION["ses_team"], ENT_QUOTES, 'UTF-8');

// Query untuk mendapatkan total pekerja dan daftar nama pekerja berdasarkan nama tim
$sql_total_pekerja = "SELECT COUNT(*) as total_pekerja FROM users WHERE team = ?";
$sql_daftar_pekerja = "SELECT nama_lengkap FROM users WHERE team = ?";

// Prepared statement untuk mendapatkan total pekerja
$stmt_total_pekerja = $conn->prepare($sql_total_pekerja);
$stmt_total_pekerja->bind_param("s", $data_team);
$stmt_total_pekerja->execute();
$result_total_pekerja = $stmt_total_pekerja->get_result();
$total_pekerja = $result_total_pekerja->fetch_assoc()['total_pekerja'];

// Close the first statement and result
$stmt_total_pekerja->close();
$result_total_pekerja->free();

// Prepared statement untuk mendapatkan daftar nama pekerja
$stmt_daftar_pekerja = $conn->prepare($sql_daftar_pekerja);
$stmt_daftar_pekerja->bind_param("s", $data_team);
$stmt_daftar_pekerja->execute();
$result_daftar_pekerja = $stmt_daftar_pekerja->get_result();

// Menghitung total user
// Buat query SQL untuk mengambil total tandan dari tabel tb_panen
$sql_total_tandan = "SELECT total_tandan FROM tb_panen";
$result = mysqli_query($conn, $sql_total_tandan);

// Inisialisasi variabel total tandan
$total_tandan = 0;

// Iterasi melalui hasil query dan menambahkan nilai total tandan
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_tandan += $row['total_tandan'];
    }
}
// Buat query SQL untuk mengambil total berat dari tabel tb_panen
$sql_total_berat = "SELECT total_berat FROM tb_panen";
$result = mysqli_query($conn, $sql_total_berat);

// Inisialisasi variabel total berat
$total_berat = 0;

// Iterasi melalui hasil query dan menambahkan nilai total berat
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_berat += $row['total_berat'];
    }
}
// Buat query SQL untuk mengambil total berat dari tabel tb_panen
$sql_total_average = "SELECT average_berat FROM tb_panen";
$result = mysqli_query($conn, $sql_total_average);

// Inisialisasi variabel total average
$total_average = 0;

// Iterasi melalui hasil query dan menambahkan nilai total average
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_average += $row['average_berat'];
    }
}

// $_SESSION['ses_team'] = $user['team'];
?>

<div class="row mt-3">
    <div class="col">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?php echo htmlspecialchars($total_pekerja, ENT_QUOTES, 'UTF-8'); ?></h3>
                <p class="text-light">Total Pekerja</p>
            </div>
            <i class="icon fas fa-clipboard-list"></i>
        </div>
    </div>

    <div class="col">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>
                    <?= $total_tandan ?>
                </h3>
                <p class="text-light">Total Tandan Bulan ini</p>
            </div>
            <i class="icon fas fa-users"></i>
        </div>
    </div>

    <div class="col">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>
                    <?= $total_berat ?>
                </h3>
                <p class="text-light">Total Berat</p>
            </div>
            <i class="icon fas fa-clone"></i>
        </div>
    </div>

    <div class="col">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>
                    <?= $total_average ?>
                </h3>
                <p class="text-light">Average Berat</p>
            </div>
            <i class="icon fas fa-file-archive"></i>
        </div>
    </div>

    <div class="col">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>
                    <i class="fas fa-user"></i>
                    <?php echo htmlspecialchars($_SESSION['ses_team'], ENT_QUOTES, 'UTF-8'); ?>
                </h3>
                <p class="text-light">Nama Team</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-archive"></i>
            </div>
        </div>
    </div>


</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="text-center">Grafik Panen</h4>
                <div class="card-body">
                    <ul class="list-group">
                        <?php while ($row = $result_daftar_pekerja->fetch_assoc()) : ?>
                            <li class="list-group-item"><?php echo htmlspecialchars($row['nama_lengkap'], ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>


            </div>
        </div>
    </div>
</div>