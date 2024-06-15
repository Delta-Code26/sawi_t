<?php
include "./include/koneksi.php";

if(isset($_GET['kode'])){
    $sql_cek = "SELECT * FROM tb_users WHERE id_user='".$_GET['kode']."'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek,MYSQLI_ASSOC);
}
?>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ubah Buku</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="id_user" class="form-label">ID User</label>
                            <input type="text" name="id_user" id="id_user" class="form-control" value="<?php echo $data_cek['id_user']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data_cek['nama']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?php echo $data_cek['username']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" name="password" id="password" class="form-control" value="<?php echo $data_cek['password']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E Mail</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $data_cek['email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="level_user" class="form-label">Level</label>
                            <select name="level_user" id="level_user" class="form-control">
                                <option value="Admin" <?php if ($data_cek['level_user'] == "Admin") echo "selected"; ?>>Admin</option>
                                <option value="Member" <?php if ($data_cek['level_user'] == "Member") echo "selected"; ?>>Member</option>
                            </select>
                        </div>

                        <div class="card-footer">
                            <input type="hidden" name="id_user" value="<?php echo $data_cek['id_user']; ?>">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <input type="submit" name="Ubah" value="Ubah" class="btn btn-success me-md-2">
                            <a href="?page=data_buku" class="btn btn-outline-secondary">Batal</a>
                        </div>
            </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data_cek['kategori']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control" value="<?php echo $data_cek['stok']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Buku</label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?php echo $data_cek['deskripsi']; ?>">
                        </div>
                </div>
            </form>
        </div>
    </div> -->
    
    </div>
</div>

<?php

if (isset ($_POST['Ubah'])){
    //mulai proses ubah
    $sql_ubah = "UPDATE tb_users SET
        nama='".$_POST['nama']."',
        username='".$_POST['username']."',
        password='".$_POST['password']."',
        email='".$_POST['email']."',
        level_user='".$_POST['level_user']."'
        WHERE id_user='".$_POST['id_user']."'";
    $query_ubah = mysqli_query($koneksi, $sql_ubah);

    if ($query_ubah) {
        echo "<script>
        Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_member';
            }
        })</script>";
        }else{
        echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_member';
            }
        })</script>";
    }
}

?>
