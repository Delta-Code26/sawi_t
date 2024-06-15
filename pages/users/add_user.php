<?php
include './include/koneksi.php';

$sql = "SELECT * FROM tb_pekerja";
$result = $conn->query($sql);

$cari_id = mysqli_query($conn, "SELECT id_user FROM users ORDER BY id_user DESC");
if (mysqli_num_rows($cari_id) > 0) {
    $data_id_pekerja = mysqli_fetch_array($cari_id);
    $kode = $data_id_pekerja['id_user'];
    $urut = substr($kode, 1); // Mengambil bagian nomor urut tanpa huruf "P"
    $tambah = (int) $urut + 1;
    $format = "P" . str_pad($tambah, 9, "0", STR_PAD_LEFT); // Menghasilkan format ID dengan 9 angka
} else {
    $format = "P000000001"; // Format default jika tidak ada data pekerja
}

if (isset($_POST['submit'])) {
    $id_user = mysqli_real_escape_string($conn, $_POST['id_user']); // Menggunakan id_pekerja sebagai id_user
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tgl_gabung = mysqli_real_escape_string($conn, $_POST['tgl_gabung']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);

    // Proses upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $foto_type = mime_content_type($tmp);
        $allowed_types = array('image/jpeg', 'image/png'); // Tipe file yang diperbolehkan

        // Periksa apakah tipe file yang diunggah diizinkan
        if (!in_array($foto_type, $allowed_types)) {
            echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Tipe file foto tidak valid. Silakan unggah file dengan tipe JPEG atau PNG.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=add_pekerja';
                }
            });
            </script>";
            exit; // Hentikan proses lebih lanjut
        }

        $foto_name = uniqid() . '_' . $foto; // Menghasilkan nama file yang unik
        $foto_path = './assets/uploads/profil' . $foto_name;

        if (move_uploaded_file($tmp, $foto_path)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan data pekerja ke dalam database menggunakan prepared statements
            $stmt = $conn->prepare("INSERT INTO users (id_user, nama_lengkap, username, password, jk, email, tgl_gabung, status, grade, foto, level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pekerja')");
            $stmt->bind_param("ssssssssss", $id_user, $nama_lengkap, $username, $hashed_password, $jk, $email, $tgl_gabung, $status, $grade, $foto_name);

            if ($stmt->execute()) {
                echo "<script>
                Swal.fire({
                    title: 'Tambah Data Berhasil',
                    text: '',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?page=data_user';
                    }
                })
                </script>";
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Tambah Data Gagal',
                    text: 'Terjadi kesalahan saat menyimpan data',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?page=add_user';
                    }
                })
                </script>";
            }

            $stmt->close();
        } else {
            echo "<script>
            Swal.fire({
                title: 'Upload Foto Gagal',
                text: 'Terjadi kesalahan saat mengupload foto',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=add_user';
                }
            })
            </script>";
        }
    } else {
        echo "<script>
        Swal.fire({
            title: 'Upload Foto Gagal',
            text: 'Terjadi kesalahan saat mengupload foto',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=add_user';
            }
        })
        </script>";
    }
}

$sql_team = "SELECT id_team, nama_team FROM tb_team";
$result_team = $conn->query($sql_team);
?>


<div class="card-header">
    <h3 class="card-title text-center">Tambah Data User</h3>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="id_user" class="form-label">*ID User</label>
                    <input type="text" name="id_user" id="id_user" class="form-control" value="<?php echo htmlspecialchars($format); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jk" name="jk" required>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" required>
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
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="grade" class="form-label">Grade</label>
                <select class="form-select" id="grade" name="grade" required>
                    <option value="Harian">Harian</option>
                    <option value="Borongan">Borongan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="team" class="form-label">Team</label>
                <select class="form-select" id="team" name="team" required>
                    <?php
                    if ($result_team->num_rows > 0) {
                        // Output data dari setiap baris
                        while ($row = $result_team->fetch_assoc()) {
                            echo "<option value='" . $row["id_team"] . "'>" . $row["nama_team"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada data</option>";
                    }

                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-select" id="level" name="level" required>
                    <option value="Admin">Admin</option>
                    <option value="Pekerja">Pekerja</option>
                </select>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="submit" value="Tambah" class="btn btn-success me-md-2">
            <a href="?page=data_pekerja" class="btn btn-outline-secondary">Batal</a>
        </div>
        </form>
    </div>
</div>