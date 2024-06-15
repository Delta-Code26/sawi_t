<?php

include "include/koneksi.php";

// Query untuk menampilkan semua data buku jika tidak ada pencarian
$sql = "SELECT * FROM tb_users";
$result = $koneksi->query($sql);

$carikode = mysqli_query($koneksi, "SELECT id_user FROM tb_users ORDER BY id_user DESC");
if(mysqli_num_rows($carikode) > 0) {
    $datakode = mysqli_fetch_array($carikode);
    $kode = $datakode['id_user'];
    $urut = substr($kode, 1, 3);
    $tambah = (int) $urut + 1;

    if (strlen($tambah) == 1) {
        $format = "M" . "00" . $tambah;
    } elseif (strlen($tambah) == 2) {
        $format = "M" . "0" . $tambah;
    } else {
        $format = "M" . $tambah;
    }
} else {
    $format = "M001";
}
?>


<!-- <div class="row m-3 mt-2"> -->
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">Tambah Data Member</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" class="row g-2">
                    <!-- 1 id  -->
                    <div class="col-md-6">
                        <label for="id_user" class="form-label">ID Member</label>
                        <input type="text" class="form-control" id="id_user" name="id_user" value="<?php echo $format; ?>" readonly>
                    </div>
                    <!-- 2 alamat  -->
                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <!--3 nama lengkap -->
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <!--4 username  -->
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <!--5 kelamin -->
                    <div class="col-md-6">
                        <label for="jk_user" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jk_user" name="jk_user" required>
                            <option selected disabled value="">Pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <!--6 password  -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <!-- 7hp  -->
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">No. Handphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    <!-- 8level  -->
                    <div class="col-md-6">
                        <label for="level_user" class="form-label">Level</label>
                        <select class="form-select" id="level_user" name="level_user" required>
                            <option selected disabled value="">Pilih Level</option>
                            <option value="Admin">Admin</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                    <!--9 email  -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">E Mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!--10 status  -->
                    <div class="col-md-6">
                        <label for="status_keanggotaan" class="form-label">Status Keanggotaan</label>
                        <select class="form-select" id="status_keanggotaan" name="status_keanggotaan" required>
                            <option selected disabled value="">Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <!--11 tgl lahir -->
                    <div class="col-md-6">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="tambah"><i class="fas fa-save"></i>  Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- </div> -->




<?php
if (isset($_POST['tambah'])) {
    // Simpan data buku ke dalam database
    $sql_simpan = "INSERT INTO tb_users (id_user, nama, jk_user, tgl_lahir, telephone, email, alamat, status_keanggotaan, level_user) VALUES (
        '".$_POST['id_user']."',
        '".$_POST['nama']."',
        '".$_POST['jk_user']."',
        '".$_POST['tgl_lahir']."',
        '".$_POST['telephone']."',
        '".$_POST['email']."',
        '".$_POST['alamat']."',
        '".$_POST['status_keanggotaan']."',
        '".$_POST['level_user']."'
    )";
    $query_simpan = mysqli_query($koneksi, $sql_simpan);

    if ($query_simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_member';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal', text: '', icon: 'error', confirmButtonText: 'OK'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_member';
            }
        })</script>";
    }
}
?>
