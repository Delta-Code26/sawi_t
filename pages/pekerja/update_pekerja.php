<?php
include './include/koneksi.php';

function fetchById($conn, $table, $column, $id)
{
    $sql = "SELECT * FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateData($conn, $table, $data, $id_column, $id)
{
    $set = '';
    $params = [];
    foreach ($data as $key => $value) {
        $set .= "$key = ?, ";
        $params[] = $value;
    }
    $set = rtrim($set, ', ');
    $params[] = $id;
    $param_types = str_repeat('s', count($params));

    $sql = "UPDATE $table SET $set WHERE $id_column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_types, ...$params);

    return $stmt->execute();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pekerja = fetchById($conn, 'tb_pekerja', 'id_pekerja', $id);
}

if (isset($_POST['update'])) {
    $id_pekerja = $_POST['id_pekerja'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jk = $_POST['jk'];
    $email = $_POST['email'];
    $tgl_gabung = $_POST['tgl_gabung'];
    $status = $_POST['status'];
    $grade = $_POST['grade'];
    $old_foto = $_POST['old_foto'];

    // Hash password only if new password is provided
    if (!empty($password)) {
        $hashed_password = hash('sha256', $password);
    } else {
        $hashed_password = $pekerja['password']; // Use old password if no new password is provided
    }

    // Validasi foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_name = $_FILES['foto']['name'];
        $foto_size = $_FILES['foto']['size'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_type = mime_content_type($foto_tmp);

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
                        window.location = 'index.php?page=data_pekerja';
                    }
                });
                </script>";
            exit; // Hentikan proses lebih lanjut
        }

        // Proses upload foto baru
        $foto_path = './assets/uploads/' . $foto_name;
        if (move_uploaded_file($foto_tmp, $foto_path)) {
            // Hapus foto lama jika ada
            if ($old_foto && file_exists('./assets/uploads/' . $old_foto)) {
                unlink('./assets/uploads/' . $old_foto);
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal mengunggah foto baru.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?page=data_pekerja';
                    }
                });
                </script>";
            exit; // Hentikan proses lebih lanjut
        }
    } else {
        // Jika tidak ada foto baru yang diunggah, gunakan foto lama
        $foto_name = $old_foto;
    }

    $data = [
        'nama_lengkap' => $nama_lengkap,
        'username' => $username,
        'password' => $hashed_password,
        'jk' => $jk,
        'email' => $email,
        'tgl_gabung' => $tgl_gabung,
        'status' => $status,
        'grade' => $grade,
        'foto' => $foto_name
    ];

    if (updateData($conn, 'tb_pekerja', $data, 'id_pekerja', $id_pekerja)) {
        echo "<script>
        Swal.fire({
            title: 'Berhasil Update',
            text: 'Berhasil memperbarui data pekerja.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_pekerja';
            }
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Gagal Update',
            text: 'Gagal memperbarui data pekerja.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_pekerja';
            }
        });
        </script>";
    }
}
?>

<!-- Form Update Pekerja -->
<div class="row">
    <div class="col-md-6">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="id_pekerja" class="form-label">*ID</label>
                    <input type="text" name="id_pekerja" id="id_pekerja" class="form-control" value="<?php echo htmlspecialchars($pekerja['id_pekerja']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($pekerja['nama_lengkap']); ?>">
                </div>

                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jk" name="jk" required>
                        <option value="Laki-laki" <?php if ($pekerja['jk'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if ($pekerja['jk'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($pekerja['email']); ?>">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Profil</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                    <input type="hidden" name="old_foto" value="<?php echo htmlspecialchars($pekerja['foto']); ?>">
                    <small>Upload foto baru jika ingin mengganti</small>
                </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-body">
            <div class="mb-3">
                <label for="tgl_gabung" class="form-label">Tanggal Gabung</label>
                <input type="date" name="tgl_gabung" id="tgl_gabung" class="form-control" value="<?php echo htmlspecialchars($pekerja['tgl_gabung']); ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Aktif" <?php if ($pekerja['status'] == 'Aktif') echo 'selected'; ?>>Aktif</option>
                    <option value="Tidak Aktif" <?php if ($pekerja['status'] == 'Tidak Aktif') echo 'selected'; ?>>Tidak Aktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Grade</label>
                <select class="form-select" id="grade" name="grade" required>
                    <option value="Harian" <?php if ($pekerja['grade'] == 'Harian') echo 'selected'; ?>>Harian</option>
                    <option value="Borong" <?php if ($pekerja['grade'] == 'Borong') echo 'selected'; ?>>Borong</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($pekerja['username']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <small>Input Password baru jika ingin mengganti Password</small>
            </div>
        </div>

        <input type="hidden" name="id_pekerja" value="<?php echo htmlspecialchars($pekerja['id_pekerja']); ?>">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="update" value="Update" class="btn btn-success me-md-2">
            <a href="?page=data_pekerja" class="btn btn-outline-secondary">Batal</a>
        </div>
        </form>
    </div>
</div>