<?php

include "include/koneksi.php";

// Query untuk menampilkan semua data buku jika tidak ada pencarian
$sql = "SELECT * FROM tb_admin";
$result = $conn->query($sql);

$carikode = mysqli_query($conn, "SELECT id_admin FROM tb_admin ORDER BY id_admin DESC");
if (mysqli_num_rows($carikode) > 0) {
    $datakode = mysqli_fetch_array($carikode);
    $kode = $datakode['id_admin'];
    $urut = substr($kode, 1, 3);
    $tambah = (int) $urut + 1;

    if (strlen($tambah) == 1) {
        $format = "A" . "00" . $tambah;
    } elseif (strlen($tambah) == 2) {
        $format = "A" . "0" . $tambah;
    } else {
        $format = "A" . $tambah;
    }
} else {
    $format = "A001";
}
?>


<!-- <div class="row m-3 mt-2"> -->
<div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-center">Tambah Data Admin</h3>
        </div>
        <div class="card-body">
            <form action="" method="post" class="row g-2">
                <!-- 1 id  -->
                <div class="col-md-6">
                    <label for="id_admin" class="form-label">ID Admin</label>
                    <input type="text" class="form-control" id="id_admin" name="id_admin" value="<?php echo $format; ?>" readonly>
                </div>
                <!-- 2 nama_lengkap  -->
                <div class="col-md-6">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                </div>
                <!--3 nama lengkap -->
                <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <!--4 username  -->
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>
                <!--5 kelamin -->
                <div class="col-md-6">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jk" name="jk" required>
                        <option selected disabled value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <!--6 password  -->
                <div class="col-md-6">
                    <label for="tgl_gabung" class="form-label">Tanggal Gabung</label>
                    <input type="date" class="form-control" id="tgl_gabung" name="tgl_gabung" required>
                </div>
                <!--9 email  -->
                <div class="col-md-6">
                    <label for="email" class="form-label">E Mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" name="tambah"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- </div> -->




<?php
if (isset($_POST['tambah'])) {
    // Simpan data buku ke dalam database
    $sql_simpan = "INSERT INTO tb_admin (id_admin, nama_lengkap,username, password, jk, email, tgl_gabung) VALUES (
        '" . $_POST['id_admin'] . "',
        '" . $_POST['nama_lengkap'] . "',
        '" . $_POST['username'] . "',
        '" . $_POST['password'] . "',
        '" . $_POST['jk'] . "',
        '" . $_POST['email'] . "',
        '" . $_POST['tgl_gabung'] . "'
    )";
    $query_simpan = mysqli_query($conn, $sql_simpan);

    if ($query_simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'Baiklah'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_admin';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Gagal menambah data admin', text: '', icon: 'error', confirmButtonText: 'Coba Lagi'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=add_admin';
            }
        })</script>";
    }
}
?>