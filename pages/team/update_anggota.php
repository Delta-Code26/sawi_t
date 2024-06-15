<?php
include "include/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = $_POST['id_anggota'];
    $nama_anggota = $_POST['nama_anggota'];
    $jabatan = $_POST['jabatan'];

    // Query untuk memperbarui informasi anggota tim
    $sql_update_member = "UPDATE tb_team_member 
                          SET nama_anggota = '$nama_anggota', jabatan = '$jabatan' 
                          WHERE id_anggota = '$id_anggota'";

    if (mysqli_query($conn, $sql_update_member)) {
        // Redirect atau tindakan lain setelah berhasil memperbarui informasi anggota tim
        header("Location: daftar_anggota.php?id_team=$id_team");
        exit();
    } else {
        echo "Error: " . $sql_update_member . "<br>" . mysqli_error($conn);
    }
}
