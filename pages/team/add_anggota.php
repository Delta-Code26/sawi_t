<?php
include "include/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_team = $_POST['id_team'];
    $nama_anggota = $_POST['nama_anggota'];
    $jabatan = $_POST['jabatan'];

    // Query untuk menambahkan anggota tim baru ke dalam tabel tb_team_member
    $sql_insert_member = "INSERT INTO tb_team_member (id_team, nama_anggota, jabatan) 
                         VALUES ('$id_team', '$nama_anggota', '$jabatan')";

    if (mysqli_query($conn, $sql_insert_member)) {
        // Redirect atau tindakan lain setelah berhasil menambahkan anggota tim
        header("Location: daftar_anggota.php?id_team=$id_team");
        exit();
    } else {
        echo "Error: " . $sql_insert_member . "<br>" . mysqli_error($conn);
    }
}
