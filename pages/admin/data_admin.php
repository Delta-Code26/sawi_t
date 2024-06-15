<?php
include './include/koneksi.php';


// Fungsi untuk mengambil semua data pekerja
function fetchAll($conn, $table)
{
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk mencari data pekerja berdasarkan nama lengkap
function searchData($conn, $table, $column, $keyword)
{
    $sql = "SELECT * FROM $table WHERE $column LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_keyword = "%$keyword%";
    $stmt->bind_param("s", $search_keyword);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Handle search
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $pekerja_data = searchData($conn, 'users', 'nama_lengkap', $keyword);
} else {
    // Fetch all data from users
    $pekerja_data = fetchAll($conn, 'users');
}

// Handle form submission
if (isset($_POST['submit'])) {
    $id_pekerja = mysqli_real_escape_string($conn, $_POST['id_user']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tgl_gabung = mysqli_real_escape_string($conn, $_POST['tgl_gabung']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $team = mysqli_real_escape_string($conn, $_POST['team']);

    // Proses upload foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $foto_path = './assets/uploads/' . basename($foto);

    if (move_uploaded_file($tmp, $foto_path)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan data pekerja ke dalam database menggunakan prepared statements
        $stmt = $conn->prepare("INSERT INTO users (id_user, username, password, nama_lengkap, jk, email, status, tgl_gabung, grade, foto, team) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $id_user, $username, $hashed_password, $nama_lengkap, $jk, $email, $status, $tgl_gabung, $grade, $foto, $team);

        if ($stmt->execute()) {
            echo "<script>
            Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'}).then((result) => {
                if (result.value) { window.location = 'index.php?page=data_user'; }
            })</script>";
        } else {
            echo "<script>
            Swal.fire({title: 'Tambah Data Gagal', text: 'Terjadi kesalahan saat menyimpan data', icon: 'error', confirmButtonText: 'OK'}).then((result) => {
                if (result.value) { window.location = 'index.php?page=add_user'; }
            })</script>";
        }

        $stmt->close();
    } else {
        echo "<script>
        Swal.fire({title: 'Upload Foto Gagal', text: 'Terjadi kesalahan saat mengupload foto', icon: 'error', confirmButtonText: 'OK'}).then((result) => {
            if (result.value) { window.location = 'index.php?page=add_user'; }
        })</script>";
    }
}
?>

<section class="content">
    <div class="row mb-4">
        <div class="col-md-8">
            <!-- Tombol Tambah -->
            <a href="?page=add_admin" class="btn btn-primary"><i class="fas fa-clone"></i> Tambah</a>
        </div>
        <div class="col-md-4">
            <!-- Formulir Pencarian -->
            <form action="" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama" name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="submit" name="search"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <!-- Kepala Tabel -->
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>ID Pekerja</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Tanggal Gabung</th>
                    <th>Status</th>
                    <th>Grade</th>
                    <th>Team</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <!-- Isi Tabel -->
            <tbody>
                <?php foreach ($pekerja_data as $index => $pekerja) : ?>
                    <tr class="text-center">
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($pekerja['id_user']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['username']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['jk']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['email']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['tgl_gabung']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['status']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['grade']); ?></td>
                        <td><?php echo htmlspecialchars($pekerja['team']); ?></td>
                        <td>
                            <?php if (!empty($pekerja['foto'])) : ?>
                                <img src="./assets/uploads/profil/<?php echo htmlspecialchars($pekerja['foto']); ?>" alt="Foto" class="circle" style="width: 40px; height: 40px;">
                            <?php else : ?>
                                Tidak ada foto
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?page=update_pekerja&kode=<?php echo $pekerja['id_user']; ?>" title="Edit pekerja" class="btn btn-success">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="?page=del_pekerja&kode=<?php echo $pekerja['id_user']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus admin ini ?')" title="Hapus Data" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>