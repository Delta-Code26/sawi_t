<?php
include "include/koneksi.php";

if ($_SESSION['ses_level'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Menghitung total User
$querypekerja = "SELECT COUNT(*) as total_pekerja FROM tb_pekerja";
$resultpekerja = $conn->query($querypekerja);
$datapekerja = $resultpekerja->fetch_assoc();
$totalpekerja = isset($datapekerja['total_pekerja']) ? $datapekerja['total_pekerja'] : 0;

// Menghitung total Admin
$queryAdmin = "SELECT COUNT(*) as total_admin FROM tb_admin";
$resultAdmin = $conn->query($queryAdmin);
$dataAdmin = $resultAdmin->fetch_assoc();
$totalAdmin = isset($dataAdmin['total_admin']) ? $dataAdmin['total_admin'] : 0;

// Buat query SQL untuk mengambil total tandan dari tabel tb_panen

// Ambil semua nilai total_tandan dari tabel tb_panen
$sql_total_tandan = "SELECT total_tandan FROM tb_panen";
$result = mysqli_query($conn, $sql_total_tandan);

// Inisialisasi variabel untuk menyimpan jumlah total tandan
$total_tandan_sample = 0;

// Loop melalui hasil query dan jumlahkan total_tandan
while ($row = mysqli_fetch_assoc($result)) {
    $total_tandan_sample += $row['total_tandan'];
}

// Format jumlah total tandan
$total_tandan = number_format($total_tandan_sample, 0, ',', '.');

// Iterasi melalui hasil query dan menambahkan nilai total tandan
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_tandan += $row['total_tandan'];
    }
}



// Buat query SQL untuk mengambil total berat dari tabel tb_panen
$sql_total_berat = "SELECT total_berat FROM tb_panen";
$result = mysqli_query($conn, $sql_total_berat);
$total_berat_sampel = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $total_berat_sampel += $row['total_berat'];
}
$total_berat = number_format($total_berat_sampel, 0, ',', '.');

// Iterasi melalui hasil query dan menambahkan nilai total berat
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_berat += $row['total_berat'];
    }
}


// Buat query SQL untuk mengambil total berat dari tabel tb_panen
$sql_total_average = "SELECT average_berat FROM tb_panen";
$result = mysqli_query($conn, $sql_total_average);
$total_average = 0;

// Iterasi melalui hasil query dan menambahkan nilai total average
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_average += $row['average_berat'];
    }
}

?>


<div class="row mt-3">
    <div class="col">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $totalpekerja ?></h3>
                <p class="text-light">Total Pekerja</p>
            </div>
            <i class="icon fas fa-users"></i>
        </div>
    </div>

    <div class="col">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>
                    <?= $total_tandan ?>
                </h3>
                <p class="text-light">Total Buah ( Tandan )</p>
            </div>
            <i class="icon fas fa-clipboard-list"></i>
            <!-- <i class="icon fas fa-users"></i> -->
        </div>
    </div>

    <div class="col">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>
                    <?= $total_berat ?>
                </h3>
                <p class="text-light">Total Berat ( Kg )</p>
            </div>
            <i class="icon fas fa-clone"></i>
        </div>
    </div>

    <div class="col">
        <div class="small-box bg-info">
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
        <div class="small-box bg-info">
            <div class="inner">
                <h3>
                    <?= $totalAdmin ?>
                </h3>
                <p class="text-light">Total Admin</p>
            </div>
            <i class="icon fas fa-user"></i>
        </div>
    </div>


    <div class="row mt-3">
        <!-- <div class="col-12"> -->
        <!-- <div class="card h-100"> -->
        <div class="card-header">
            <h4 class="text-center">Grafik Panen</h4>
        </div>
        <div class="card-body">
            <?php include "include/grafik_panen.php"; ?>

        </div>
        <!-- </div> -->
        <!-- </div> -->
    </div>