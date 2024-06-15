<?php
include "./include/koneksi.php";
include "./include/functions.php";

$newPanenID = getNewPanenID($conn);
$teams = getTeams($conn);
$tasks = getTasks($conn);
?>

<div class="container">
    <h2>Tambah Data Panen</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="id_panen" class="form-label">ID Panen</label>
            <input type="text" name="id_panen" id="id_panen" class="form-control" readonly value="<?php echo htmlspecialchars($newPanenID); ?>">
        </div>
        <div class="mb-3">
            <label for="tgl_panen" class="form-label">Tanggal Panen</label>
            <input type="date" name="tgl_panen" id="tgl_panen" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="total_tandan" class="form-label">Total Tandan</label>
            <input type="number" name="total_tandan" id="total_tandan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="total_berat" class="form-label">Total Berat (kg)</label>
            <input type="number" step="0.01" name="total_berat" id="total_berat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nama_task" class="form-label">Nama Task</label>
            <select class="form-select" id="nama_task" name="nama_task" required>
                <?php while ($row_task = mysqli_fetch_assoc($tasks)) : ?>
                    <option value="<?php echo htmlspecialchars($row_task['id_task']); ?>"><?php echo htmlspecialchars($row_task['nama_task']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_team" class="form-label">Nama Team</label>
            <select class="form-select" id="nama_team" name="nama_team" required>
                <?php while ($row_team = mysqli_fetch_assoc($teams)) : ?>
                    <option value="<?php echo htmlspecialchars($row_team['id_team']); ?>"><?php echo htmlspecialchars($row_team['nama_team']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-success">Tambah</button>
            <a href="index.php?page=data_panen" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_panen = mysqli_real_escape_string($conn, $_POST['id_panen']);
    $tgl_panen = mysqli_real_escape_string($conn, $_POST['tgl_panen']);
    $total_tandan = mysqli_real_escape_string($conn, $_POST['total_tandan']);
    $total_berat = mysqli_real_escape_string($conn, $_POST['total_berat']);
    $nama_team = mysqli_real_escape_string($conn, $_POST['nama_team']); // Ini adalah id_team, bukan nama_team
    $nama_task = mysqli_real_escape_string($conn, $_POST['nama_task']); // Ini adalah id_task, bukan nama_task

    if (savePanen($conn, $id_panen, $tgl_panen, $total_tandan, $total_berat, $nama_team, $nama_task)) {
        echo "<script>
            Swal.fire({
                title: 'Data Panen Berhasil Ditambah',
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
                title: 'Gagal Menambah Data Panen',
                text: '" . mysqli_real_escape_string($conn, mysqli_error($conn)) . "',
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