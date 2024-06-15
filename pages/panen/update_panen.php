<?php
include "./include/koneksi.php";

// Ambil data tim dari tabel tb_team
$sql_team = "SELECT id_team, nama_team FROM tb_team";
$result_team = mysqli_query($conn, $sql_team);

// Ambil data task dari tabel tb_task
$sql_task = "SELECT id_task, nama_task FROM tb_task";
$result_task = mysqli_query($conn, $sql_task);

// Periksa apakah ID panen ada di parameter URL
if (isset($_GET['kode'])) {
    $id_panen = $_GET['kode'];

    // Ambil data panen berdasarkan ID
    $sql_panen = "SELECT * FROM tb_panen WHERE id_panen = '$id_panen'";
    $result_panen = mysqli_query($conn, $sql_panen);

    if (mysqli_num_rows($result_panen) > 0) {
        $data_panen = mysqli_fetch_assoc($result_panen);
    } else {
        echo "<script>
            Swal.fire({
                title: 'Data Tidak Ditemukan',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data_panen';
                }
            });
            </script>";
        exit();
    }
} else {
    echo "<script>
        Swal.fire({
            title: 'ID Panen Tidak Valid',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_panen';
            }
        });
        </script>";
    exit();
}
?>

<div class="container">
    <h2>Edit Data Panen</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="id_panen" class="form-label">ID Panen</label>
            <input type="text" name="id_panen" id="id_panen" class="form-control" readonly value="<?php echo $data_panen['id_panen']; ?>">
        </div>
        <div class="mb-3">
            <label for="tgl_panen" class="form-label">Tanggal Panen</label>
            <input type="date" name="tgl_panen" id="tgl_panen" class="form-control" required value="<?php echo $data_panen['tgl_panen']; ?>">
        </div>
        <div class="mb-3">
            <label for="total_tandan" class="form-label">Total Tandan</label>
            <input type="number" name="total_tandan" id="total_tandan" class="form-control" required value="<?php echo $data_panen['total_tandan']; ?>">
        </div>
        <div class="mb-3">
            <label for="total_berat" class="form-label">Total Berat (kg)</label>
            <input type="number" step="0.01" name="total_berat" id="total_berat" class="form-control" required value="<?php echo $data_panen['total_berat']; ?>">
        </div>
        <div class="mb-3">
            <label for="nama_task" class="form-label">Nama Task</label>
            <select class="form-select" id="nama_task" name="nama_task" required>
                <?php while ($row_task = mysqli_fetch_assoc($result_task)) : ?>
                    <option value="<?php echo $row_task['id_task']; ?>" <?php echo ($row_task['id_task'] == $data_panen['id_task']) ? 'selected' : ''; ?>><?php echo $row_task['nama_task']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_team" class="form-label">Nama Team</label>
            <select class="form-select" id="nama_team" name="nama_team" required>
                <?php while ($row_team = mysqli_fetch_assoc($result_team)) : ?>
                    <option value="<?php echo $row_team['id_team']; ?>" <?php echo ($row_team['id_team'] == $data_panen['id_team']) ? 'selected' : ''; ?>><?php echo $row_team['nama_team']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="index.php?page=data_panen" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_panen = $_POST['id_panen'];
    $tgl_panen = $_POST['tgl_panen'];
    $total_tandan = $_POST['total_tandan'];
    $total_berat = $_POST['total_berat'];
    $nama_team = $_POST['nama_team']; // Ini adalah id_team, bukan nama_team
    $nama_task = $_POST['nama_task']; // Ini adalah id_task, bukan nama_task

    // Hitung berat rata-rata
    if ($total_tandan > 0) {
        $average_berat = $total_berat / $total_tandan;
    } else {
        $average_berat = 0;
    }

    // Update data panen
    $sql_update = "UPDATE tb_panen SET 
                    tgl_panen = '$tgl_panen', 
                    total_tandan = '$total_tandan', 
                    total_berat = '$total_berat', 
                    average_berat = '$average_berat', 
                    id_team = '$nama_team', 
                    id_task = '$nama_task' 
                  WHERE id_panen = '$id_panen'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>
            Swal.fire({
                title: 'Data Panen Berhasil Diupdate',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data_panen';
                }
            });
            </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal Mengupdate Data Panen',
                text: '" . mysqli_error($conn) . "',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data_panen';
                }
            });
            </script>";
    }
}
?>