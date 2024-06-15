<?php
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
// $dbname = "mybase";  // Ganti dengan nama database Anda
$dbname = "db_rekap_panen";  // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/rekap_panen2/');
}
