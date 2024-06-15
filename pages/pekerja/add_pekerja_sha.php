<?php

include "./include/koneksi.php";

// Query untuk menampilkan semua data pekerja jika tidak ada pencarian
$sql = "SELECT * FROM tb_pekerja";
$result = $conn->query($sql);

$cari_id_pekerja = mysqli_query($conn, "SELECT id_pekerja FROM tb_pekerja ORDER BY id_pekerja DESC");
if (mysqli_num_rows($cari_id_pekerja) > 0) {
    $data_id_pekerja = mysqli_fetch_array($cari_id_pekerja);
    $kode = $data_id_pekerja['id_pekerja'];
    $urut = substr($kode, 1, 3);
    $tambah = (int) $urut + 1;

    if (strlen($tambah) == 1) {
        $format = "P" . "00" . $tambah;
    } elseif (strlen($tambah) == 2) {
        $format = "P" . "0" . $tambah;
    } else {
        $format = "P" . $tambah;
    }
} else {
    $format = "P001";
}
?>

<div class="card-header">
    <h3 class="card-title text-center">Tambah Data Pekerja</h3>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="id_pekerja" class="form-label">*ID</label>
                    <input type="text" name="id_pekerja" id="id_pekerja" class="form-control" value="<?php echo $format; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jk" name="jk" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E Mail</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="negara" class="form-label">Negara</label>
                    <input type="text" name="negara" id="negara" class="form-control" required>
                </div>
        </div>
    </div>

    <div class="col-md-6">

        <div class="card-body">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tgl_gabung" class="form-label">Tanggal Gabung</label>
                <input type="date" name="tgl_gabung" id="tgl_gabung" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Grade</label>
                <select class="form-select" id="grade" name="grade" required>
                    <option value="Pemotong">Pemotong</option>
                    <option value="Penyusun">Penyusun</option>
                    <option value="Biji">Biji</option>
                    <option value="Harian">Harian</option>
                    <option value="Mandor">Mandor</option>
                    <option value="Krani">Krani</option>
                </select>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="tambah" value="Tambah" class="btn btn-success me-md-2">
            <a href="?page=data_pekerja" class="btn btn-outline-secondary">Batal</a>
        </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['tambah'])) {
    // Hash password menggunakan SHA-256
    $hashed_password = hash('sha256', $_POST['password']);

    // Simpan data pekerja ke dalam database
    $sql_simpan = "INSERT INTO tb_pekerja (id_pekerja, username, password, nama_lengkap, negara, jk, email, status, tgl_gabung, grade) VALUES (
        '" . $_POST['id_pekerja'] . "',
        '" . $_POST['username'] . "',
        '" . $hashed_password . "',
        '" . $_POST['nama_lengkap'] . "',
        '" . $_POST['negara'] . "',
        '" . $_POST['jk'] . "',
        '" . $_POST['email'] . "',
        '" . $_POST['status'] . "',
        '" . $_POST['tgl_gabung'] . "',
        '" . $_POST['grade'] . "'
    )";
    $query_simpan = mysqli_query($conn, $sql_simpan);

    if ($query_simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'}).then((result) => {
            if (result.value) { window.location = 'index.php?page=data_pekerja'; }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal', text: '', icon: 'error', confirmButtonText: 'OK'}).then((result) => {
            if (result.value) { window.location = 'index.php?page=add_pekerja'; }
        })</script>";
    }
}
?>