<?php
include './include/koneksi.php';
include './include/functions.php';

// Handle search
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $anggota_team = searchData($conn, 'tb_anggota_team', 'nama_member', $keyword);
} else {
    // Fetch all data from tb_pekerja
    $anggota_team = fetchAll($conn, 'tb_anggota_team');
}
?>

<section class="content">
    <div class="row mb-4">
        <div class="col-md-8">
            <!-- Tombol Tambah -->
            <a href="?page=add_pekerja" class="btn btn-primary"><i class="fas fa-clone"></i> Tambah</a>
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
                    <!-- <th>ID Anggota Team</th> -->
                    <th>Nama Team</th>
                    <th>Nama Pekerja</th>
                    <th>Grade</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <!-- Isi Tabel -->
            <tbody>
                <?php foreach ($anggota_team as $index => $data) : ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $data['id_anggota_team']; ?></td>
                        <td><?php echo $data['id_team']; ?></td>
                        <td><?php echo $data['nama_member']; ?></td>
                        <td>
                            <a href="?page=update_pekerja&id=<?php echo $data_id['id_pekerja']; ?>" title="Edit pekerja" class="btn btn-success">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="?page=hapus_pekerja&id=<?php echo $data['id_pekerja']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus pekerja ini ?')" title="Hapus Buku" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>