<?php
include "include/koneksi.php";
include "include/functions.php"; // Pastikan fungsi sudah di-include

// Inisialisasi variabel pencarian
$keyword = '';
if (isset($_POST['search'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
}

$result_panen = getPanenData($conn, $keyword);
?>

<section class="content">
    <div class="row mb-4">
        <div class="col-md-8">
            <!-- Tombol Tambah -->
            <a href="?page=add_panen" class="btn btn-primary"><i class="fas fa-clone"></i> Tambah</a>
        </div>
        <div class="col-md-4">
            <!-- Formulir Pencarian -->

            <!-- Formulir Pencarian -->
            <form action="" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan judul" name="keyword">
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
                    <th>ID Panen</th>
                    <th>Tanggal</th>
                    <th>Task</th>
                    <th>Team</th>
                    <th>Total Buah</th>
                    <th>Total Berat</th>
                    <th>Rata-rata Berat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <!-- Isi Tabel -->
            <tbody>
                <!-- Kode PHP untuk menampilkan data buku dari database -->
                <?php
                $no = 1;
                while ($row = $result_panen->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- Kolom Data -->
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo $row['id_panen']; ?></td>
                        <td><?php echo $row['tgl_panen']; ?></td>
                        <td><?php echo $row['nama_task']; ?></td>
                        <td><?php echo $row['nama_team']; ?></td>
                        <td class="text-center"><?php echo $row['total_tandan']; ?></td>
                        <td class="text-center"><?php echo $row['total_berat']; ?></td>
                        <td class="text-center"><?php echo $row['average_berat']; ?></td>
                        <td class="text-center">
                            <!-- Tombol Aksi -->
                            <a href="?page=update_panen&kode=<?php echo $row['id_panen']; ?>" title="Edit panen" class="btn btn-success">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="?page=hapus_panen&kode=<?php echo $row['id_panen']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus panen ini ?')" title="Hapus Panen" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
</section>