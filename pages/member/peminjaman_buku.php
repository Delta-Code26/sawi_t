<?php
// Periksa apakah sesi sudah aktif sebelum memanggil session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login, jika tidak, redirect ke halaman login
if (empty($_SESSION["ses_username"])) {
    header("location: login.php");
    exit;
} else {
    $data_id = $_SESSION["ses_id"];
    $data_nama = $_SESSION["ses_nama"];
    $data_user = $_SESSION["ses_username"];
    $data_level = $_SESSION["ses_level"];
}

// KONEKSI DB
include "include/koneksi.php";

// Tangkap data yang dikirim melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_buku = $_POST['id_buku']; // ID Buku yang dipinjam
    $id_user = $data_id; // ID Member yang melakukan peminjaman (sesuai dengan data member yang sedang login)
    $tanggal_peminjaman = date("Y-m-d"); // Tanggal peminjaman (diambil dari tanggal saat ini)
    $tanggal_pengembalian = date("Y-m-d", strtotime("+7 days")); // Tanggal pengembalian (diambil dari tanggal saat ini dan ditambah 7 hari)
    $status_peminjaman = 'Dipinjam'; // Status peminjaman awal adalah 'Dipinjam'

    // Query untuk memasukkan data peminjaman buku ke dalam tabel tb_peminjaman
    $sql_insert_peminjaman = "INSERT INTO tb_peminjaman (id_buku, id_user, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman)
    VALUES ('$id_buku', '$id_user', '$tanggal_peminjaman', '$tanggal_pengembalian', '$status_peminjaman')";
    
    // Eksekusi query
    if (mysqli_query($koneksi, $sql_insert_peminjaman)) {
        // Redirect ke halaman data peminjaman
        header("Location: ./home/member.php");
        exit;
    } else {
        echo "Error: " . $sql_insert_peminjaman . "<br>" . mysqli_error($koneksi);
    }
}

// Query untuk mendapatkan data buku yang tersedia
$query = "SELECT * FROM tb_buku WHERE status_buku = 'Tersedia'";
$result = mysqli_query($koneksi, $query);
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Peminjaman Buku</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Bahasa</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?php echo $row['judul']; ?></td>
                                    <td><?php echo $row['penulis']; ?></td>
                                    <td><?php echo $row['penerbit']; ?></td>
                                    <td><?php echo $row['bahasa']; ?></td>
                                    <td><?php echo $row['status_buku']; ?></td>
                                    <td>
                                        <!-- Form untuk memproses peminjaman buku -->
                                        <form action="" method="post">
                                            <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                                            <input type="submit" class="btn btn-primary" value="Pinjam">
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
