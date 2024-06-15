<?php

include "include/koneksi.php";
$sql = "SELECT * FROM tb_task";
$result = $conn->query($sql);

$cari_id = mysqli_query($conn, "SELECT id_task FROM tb_task ORDER BY id_task DESC");
if (mysqli_num_rows($cari_id) > 0) {
    $data_id = mysqli_fetch_array($cari_id);
    $kode = $data_id['id_task'];
    $urut = substr($kode, 1, 3);
    $tambah = (int) $urut + 1;

    if (strlen($tambah) == 1) {
        $format_id = "T" . "00" . $tambah;
    } elseif (strlen($tambah) == 2) {
        $format_id = "T" . "0" . $tambah;
    } else {
        $format_id = "T" . $tambah;
    }
} else {
    $format_id = "T001";
}


?>


<!-- <div class="row m-3 mt-2"> -->
<div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-center">Tambah Data Task</h3>
        </div>
        <div class="card-body">
            <form action="" method="post" class="row g-2">
                <!-- 1 id  -->
                <div class="col-md-6">
                    <label for="id_task" class="form-label">ID Task</label>
                    <input type="text" class="form-control" id="id_task" name="id_task" value="<?php echo $format_id; ?>" readonly>
                </div>
                <!-- 2 nama_lengkap  -->
                <div class="col-md-6">
                    <label for="nama_task" class="form-label">Nama Task</label>
                    <input type="text" class="form-control" id="nama_task" name="nama_task" required>
                </div>
                <!--3 nama lengkap -->
                <div class="col-md-6">
                    <label for="total_task" class="form-label">Total Task</label>
                    <input type="number" class="form-control" id="total_task" name="total_task" required>
                </div>
                <!--4 username  -->
                <div class="col-md-6">
                    <label for="thn_tanam" class="form-label">Tahun Tanam</label>
                    <input type="date" class="form-control" id="thn_tanam" name="thn_tanam" required>
                </div>

                <!--6 password  -->
                <div class="col-md-6">
                    <label for="create_time" class="form-label">Tanggal Input Data</label>
                    <input type="date" class="form-control" id="create_time" name="create_time" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary" name="tambah"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['tambah'])) {
    // Simpan data buku ke dalam database
    $sql_simpan = "INSERT INTO tb_task (id_task, nama_task,total_task, thn_tanam, create_time) VALUES (
        '" . $_POST['id_task'] . "',
        '" . $_POST['nama_task'] . "',
        '" . $_POST['total_task'] . "',
        '" . $_POST['thn_tanam'] . "',
        '" . $_POST['create_time'] . "'
    )";
    $query_simpan = mysqli_query($conn, $sql_simpan);

    if ($query_simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'Alhamdulillah'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_task';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Gagal menambah data task', text: '', icon: 'error', confirmButtonText: 'Coba Lagi'}).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=add_tasj';
            }
        })</script>";
    }
}
