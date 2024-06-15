<?php
include './include/koneksi.php'; // Sesuaikan dengan file koneksi Anda

if (isset($_GET['kode'])) {
    $sql_cek = "SELECT * FROM tb_pekerja WHERE id_pekerja='" . $_GET['kode'] . "'";
    $query_cek = mysqli_query($conn, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>

<div class="row">
    <div class="col-md-6">
        <div class="card-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="id_admin" class="form-label">*ID Admin</label>
                    <input type="text" name="id_admin" id="id_admin" class="form-control" value="<?php echo $data_cek['id_admin']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?php echo $data_cek['nama_lengkap']; ?>">
                </div>

                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jk" name="jk" required>
                        <option value="Laki-laki" <?php if ($data_cek['jk'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if ($data_cek['jk'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E Mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $data_cek['email']; ?>">
                </div>
                <div class="mb-3">
                    <label for="negara" class="form-label">Negara</label>
                    <input type="text" name="negara" id="negara" class="form-control" value="<?php echo $data_cek['negara']; ?>">
                </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="card-body">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo $data_cek['username']; ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" id="password" class="form-control" value="<?php echo $data_cek['password']; ?>">
            </div>
            <div class="mb-3">
                <label for="tgl_gabung" class="form-label">Tanggal Gabung</label>
                <input type="date" name="tgl_gabung" id="tgl_gabung" class="form-control" value="<?php echo $data_cek['tgl_gabung']; ?>">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Aktif" <?php if ($data_cek['status'] == 'Aktif') echo 'selected'; ?>>Aktif</option>
                    <option value="Tidak Aktif" <?php if ($data_cek['status'] == 'Tidak Aktif') echo 'selected'; ?>>Tidak Aktif</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Grade</label>
                <select class="form-select" id="grade" name="grade" required>
                    <option value="Harian" <?php if ($data_cek['grade'] == 'Harian') echo 'selected'; ?>>Harian</option>
                    <option value="Borong" <?php if ($data_cek['grade'] == 'Borong') echo 'selected'; ?>>Borong</option>
                    <option value="Krani" <?php if ($data_cek['grade'] == 'Krani') echo 'selected'; ?>>Krani</option>
                    <option value="Mandor" <?php if ($data_cek['grade'] == 'Mandor') echo 'selected'; ?>>Mandor</option>
                    <!-- <option value="Mandor" <?php if ($data_cek['grade'] == 'Mandor') echo 'selected'; ?>>Mandor</option>
                    <option value="Krani" <?php if ($data_cek['grade'] == 'Krani') echo 'selected'; ?>>Krani</option> -->

                </select>
            </div>
        </div>

        <input type="hidden" name="id_pekerja" value="<?php echo $data_cek['id_pekerja']; ?>">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="update" value="update" class="btn btn-success me-md-2">
            <a href="?page=data_pekerja" class="btn btn-outline-secondary">Batal</a>
        </div>
        </form>
    </div>
</div>
<!-- </div> -->
<!-- </div> -->

<?php

if (isset($_POST['update'])) {
    //mulai proses ubah
    $sql_update = "UPDATE tb_pekerja SET
        username='" . $_POST['username'] . "',
        password='" . $_POST['password'] . "',
        nama_lengkap='" . $_POST['nama_lengkap'] . "',
        jk='" . $_POST['jk'] . "',
        email='" . $_POST['email'] . "',
        negara='" . $_POST['negara'] . "',
        tgl_gabung='" . $_POST['tgl_gabung'] . "',
        status='" . $_POST['status'] . "',
        grade='" . $_POST['grade'] . "'
        WHERE id_pekerja='" . $_POST['id_pekerja'] . "'";
    $query_update = mysqli_query($conn, $sql_update);

    if ($query_update) {
        echo "<script>
        Swal.fire({title: 'Berhasil Update Data',text: '',icon: 'success',confirmButtonText: 'OK'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_pekerja';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_pekerja';
            }
        })</script>";
    }
}

?>