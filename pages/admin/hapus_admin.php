<?php
// Pastikan koneksi sudah didefinisikan
include "include/koneksi.php";

if (isset($_GET['kode'])) {
    // Ambil nilai kode dari URL
    $kode = $_GET['kode'];

    // Buat query untuk menghapus data anggota berdasarkan id
    $sql_hapus = "DELETE FROM tb_admin WHERE id_admin='$kode'";
    $query_hapus = mysqli_query($conn, $sql_hapus); // Gunakan variabel $koneksi untuk koneksi

    // Cek apakah query berhasil dijalankan
    if ($query_hapus) {
        // Redirect ke halaman data anggota jika berhasil menghapus menggunakan JavaScript
        // echo '<script>window.location.href = "index.php?page=data_admin";</script>';
        echo "<script>
        Swal.fire({title: 'Berhasil hapus data admin', text: '', icon: 'error', confirmButtonText: 'Alhamdulilah'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_admin';
            }
        })</script>";
        exit(); // Pastikan tidak ada output lain sebelum melakukan redirect
    } else {
        // Jika query gagal, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika tidak ada kode yang diberikan, tampilkan pesan kesalahan
    echo "Kode tidak ditemukan";
}
