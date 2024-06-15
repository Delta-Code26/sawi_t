<?php
include "include/koneksi.php";

$id_anggota = $_GET['id_anggota']; // Ambil ID anggota tim dari parameter URL

// Query untuk menghapus anggota tim dari tabel tb_team_member
$sql_delete_member = "DELETE FROM tb_team_member WHERE id_anggota = '$id_anggota'";

if (mysqli_query($conn, $sql_delete_member)) {
    // Redirect atau tindakan lain setelah berhasil menghapus anggota tim
    header("Location: daftar_anggota.php?id_team=$id_team");
    exit();
} else {
    echo "Error: " . $sql_delete_member . "<br>" . mysqli_error($conn);
}
