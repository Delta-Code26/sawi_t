<?php
include "include/koneksi.php";

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
                    <input type="text" class="form-control" placeholder="Cari berdasarkan judul" name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="submit" name="search"><i class="fas fa-search"></i>
                            Cari</button>
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
                    <th>ID Admin</th>
                    <th>Nama Lengkap</th>
                    <!-- <th>Username</th>
                    <th>Password</th> -->
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <!-- Isi Tabel -->
            <tbody>
                <!-- Kode PHP untuk menampilkan data buku dari database -->
                <?php
                $no = 1;
                $sql = $conn->query("SELECT * FROM users WHERE level = 'Admin'");
                while ($data = $sql->fetch_assoc()) {
                ?>
                    <tr>
                        <!-- Kolom Data -->
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo $data['id_user']; ?></td>
                        <td><?php echo $data['nama_lengkap']; ?></td>
                        <!-- <td><?php echo $data['username']; ?></td>
                        <td><?php echo $data['password']; ?></td> -->
                        <td><?php echo $data['jk']; ?></td>
                        <td class="text-center"><?php echo $data['email']; ?></td>
                        <td class="text-center"><?php echo $data['tgl_gabung']; ?></td>
                        <td class="text-center">
                            <!-- Tombol Aksi -->
                            <a href="?page=update_admin&kode=<?php echo $data['id_user']; ?>" title="Edit admin" class="btn btn-success">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="?page=hapus_admin&kode=<?php echo $data['id_user']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus admin ini ?')" title="Hapus Buku" class="btn btn-danger">
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