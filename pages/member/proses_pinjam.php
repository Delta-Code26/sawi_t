<?php
// KONEKSI DB
include "include/koneksi.php";

// Ambil data dari form
$idBuku = $_POST['id_buku'];
$judulBuku = $_POST['judul_buku'];
$pengarang = $_POST['pengarang_buku'];
$isbn = $_POST['ISBN'];
$penerbit = $_POST['penerbit_buku'];
$tahunTerbit = $_POST['tahun_terbit'];
$deskbuku = $_POST['deskripsi_buku'];
// Anda mungkin perlu menambahkan data lainnya yang diperlukan untuk peminjaman, seperti ID member, tanggal peminjaman, dll.

// Simpan data peminjaman ke dalam tabel peminjaman
$query = "INSERT INTO Peminjaman (id_buku, judul_buku, pengarang_buku, ISBN , penerbit_buku, tahun_terbit, deskripsi_buku) VALUES ('$idBuku', '$judulBuku', '$pengarang', '$isbn', '$penerbit', '$tahunTerbit', '$deskbuku')";
$result = mysqli_query($koneksi, $query);

// Periksa apakah query berhasil dijalankan
if ($result) {
    // Redirect kembali ke halaman sebelumnya atau halaman sukses
    header("?page=peminjaman_buku");
    exit;
} else {
    // Jika query gagal, tampilkan pesan kesalahan atau redirect ke halaman gagal
    echo "Gagal menyimpan data peminjaman: " . mysqli_error($koneksi);
}
?>
