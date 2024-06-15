<?php
include "include/koneksi.php";

?>

<section class="content">

    <div class="row mb-4">
        <div class="col-md-8">
            <!-- Tombol Tambah -->
            <a href="?page=add_task" class="btn btn-primary"><i class="fas fa-clone"></i> Tambah</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <!-- Kepala Tabel -->
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>ID Task</th>
                    <th>Nama Block</th>
                    <th>Total Task</th>
                    <th>Tahun Tanam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <!-- Isi Tabel -->
            <tbody>
                <!-- Kode PHP untuk menampilkan data buku dari database -->
                <?php
                $no = 1;
                $sql = $conn->query("SELECT * FROM tb_task");
                while ($data = $sql->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- Kolom Data -->
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo $data['id_task']; ?></td>
                        <td><?php echo $data['nama_task']; ?></td>
                        <td><?php echo $data['total_task']; ?></td>
                        <td><?php echo $data['thn_tanam']; ?></td>
                        <td class="text-center">
                            <!-- Tombol Aksi -->
                            <a href="?page=update_task&kode=<?php echo $data['id_task']; ?>" title="Edit task" class="btn btn-success">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="?page=del_task&kode=<?php echo $data['id_task']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus task ini ?')" title="Hapus Buku" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                } ?>
            </tbody>
        </table>
    </div>
    <!-- </div>
    </div> -->
</section>