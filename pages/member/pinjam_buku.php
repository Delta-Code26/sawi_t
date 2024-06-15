<?php
// Periksa apakah sesi sudah aktif sebelum memanggil session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login, jika tidak, redirect ke halaman login
if (empty($_SESSION["ses_username"])) {
    header("location: login.php");
    exit;
}

// KONEKSI DB
include "include/koneksi.php";

// Ambil ID buku dari parameter GET
$id_buku = $_GET['id'];

// Query untuk mendapatkan detail buku berdasarkan ID
$query = "SELECT * FROM Buku WHERE id_buku = '$id_buku'";
$result = mysqli_query($koneksi, $query);

// Periksa apakah buku dengan ID yang diminta ada dalam database
if (mysqli_num_rows($result) == 0) {
    echo "Buku tidak ditemukan.";
    exit;
}

// Ambil detail buku dari hasil query
$buku = mysqli_fetch_assoc($result);

// Jika tombol "Pinjam" ditekan
if (isset($_POST['pinjam'])) {
    // Lakukan proses peminjaman buku
    // Misalnya, tambahkan data peminjaman ke dalam tabel Peminjaman
    // Anda bisa menambahkan logika peminjaman buku sesuai dengan kebutuhan aplikasi Anda
    // Contoh:
    $id_member = $_SESSION["ses_id"];
    $tanggal_pinjam = date("Y-m-d");
    $query_pinjam = "INSERT INTO Peminjaman (id_member, id_buku, tanggal_pinjam) VALUES ('$id_member', '$id_buku', '$tanggal_pinjam')";
    mysqli_query($koneksi, $query_pinjam);
    // Setelah berhasil melakukan peminjaman, Anda bisa mengarahkan pengguna ke halaman tertentu, misalnya kembali ke halaman utama atau ke halaman peminjaman buku.
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku</title>
</head>
<body>
    <h1>Pinjam Buku</h1>
    <h2>Detail Buku</h2>
    <p>ID Buku: <?php echo $buku['id_buku']; ?></p>
    <p>Judul Buku: <?php echo $buku['judul_buku']; ?></p>
    <p>Pengarang: <?php echo $buku['pengarang_buku']; ?></p>
    <p>Penerbit: <?php echo $buku['penerbit_buku']; ?></p>
    <p>Tahun Terbit: <?php echo $buku['tahun_terbit']; ?></p>
    
    <form action="" method="post">
        <input type="submit" name="pinjam" value="Pinjam">
    </form>
</body>
</html>
