<div class="row">
  <div class="col-12 col-md-6">
      <a class="btn btn-primary" href="/"><i class="fa fa-arrow-left"></i> Kembali</a>
  </div>
</div>
<?php
  $success = false;
  $error = false;
  $successFoto = false;
  $errorFoto = false;
  $errorFotoText = "";

//   $query = "SELECT * tb_users WHERE id_user = '" . $_SESSION['ses_id'] . "'";
//   $result = $koneksi->query($query);
//   $users = $result->fetch_assoc();
    $sql = $koneksi->query("SELECT * FROM tb_users");
    $data = $sql->fetch_assoc(); 

  
  if(isset($_POST['simpan'])) {
    $query = "UPDATE tb_users SET ";
    $query .= "nama='". $_POST['nama'] ."', ";
    $query .= "jk_user='". $_POST['jk_user'] ."', ";
    $query .= "alamat='". $_POST['alamat'] ."', ";
    $query .= "tgl_lahir='". $_POST['tgl_lahir'] ."', ";
    // $query .= "golongan_darah='". $_POST['golongan_darah'] ."', ";
    // $query .= "agama='". $_POST['agama'] ."', ";
    // $query .= "alamat='". $_POST['alamat'] ."', ";
    $query .= "telephone='". $_POST['telephone'] ."'";
    $query .= "email='". $_POST['email'] ."'";
    $query .= "status_keanggotaan='". $_POST['status_keanggotaan'] ."'";
    $query .= "WHERE id_user='" . $_SESSION['id_user'] . "'";
    $result = $koneksi->query($query);
    if ($result) {
        $success = true;
        $_SESSION['nama'] = $_POST['nama'];
    } else {
        $error = true;
    }
  }

?>
<div class="row">
    
   <div class="col-md-5 border-right">
      <div class="p-3">
         <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">PROFIL</h4>
         </div>
         <?php if ($success) {?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-check bi flex-shrink-0 me-2" width="24" height="24"></i>
            <div><strong>Berhasil!</strong> Biodata berhasil diperbarui</div>
        </div>
        <?php } ?>
         <?php if ($error) {?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle bi flex-shrink-0 me-2" width="24" height="24"></i>
            <div><strong>Gagal!</strong> Biodata gagal diperbarui</div>
        </div>
        <?php } ?>
         <div class="d-flex justify-content-between align-items-center">
            <h6 class="text-right">Biodata Diri</h6>
         </div>
         <form method="POST">
            <div class="row mt-2">
                <div class="col-md-12 mb-2">
                <label class="labels">
                <?php 
                    if ($_SESSION['ses_level'] == 'Admin') {
                        echo "Username";
                    } else if ($_SESSION['ses_level'] == 'Member'){
                        echo "NIM";
                    } else {
                        echo "NIP";
                    }
                ?>
                </label>
                <input type="text" class="form-control" placeholder="Username" value="<?= $data['username'] ?>" readonly>
                </div>
                <div class="col-md-12 mb-2">
                <label class="labels">Nama Lengkap</label>
                <input type="text" class="form-control" placeholder="Nama Lengkap" name='nama' value="<?= $data['nama'] ?>">
                </div>
                <div class="col-md-12 mb-2">
                <label class="labels">Jenis Kelamin</label>
                <select class="form-select" aria-label="jk_user Kelamin" name='jk_user'>
                    <option>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" <?php if ($data['jk_user'] == 0) echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($data['jk_user'] == 1) echo 'selected'; ?>>Perempuan</option>
                </select>
                </div>
                
                <div class="col-md-12 mb-2">
                <label class="labels">Alamat</label>
                <textarea class="form-control" id="alamat" rows="3" name='alamat'><?= $data['alamat'] ?></textarea>
                </div>

                <div class="col-md-6 mb-2">
                <label class="labels">Tanggal Lahir</label>
                <input type="date" class="form-control" placeholder="Tanggal Lahir" name='tgl_lahir' value="<?= $data['tgl_lahir'] ?>">
                </div>
                
                <div class="col-md-6 mb-2">
                <label class="labels">E Mail</label>
                <input type="email" class="form-control" placeholder="E Mail" name='email' value="<?= $data['email'] ?>">
                </div>
                
                <div class="col-md-12 mb-4">
                <label class="labels">No Telepon</label>
                <input type="text" class="form-control" placeholder="Nomor Telepon" name="telephone" value="<?= $data['telephone'] ?>">
                </div>
            </div>
            <?php
                if ($_SESSION['ses_level'] == 'Member') {
            ?>
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="text-right">Informasi Akademik</h6>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 mb-2">
                <label class="labels">Fakultas</label>
                <input type="text" class="form-control" placeholder="Fakultas" value="<?= $user['nama_fakultas'] ?>" readonly>
                </div>
                <div class="col-md-12 mb-2">
                <label class="labels">Program Studi</label>
                <input type="text" class="form-control" placeholder="Prodi" value="<?= $user['level_user'] ?>" readonly>
                </div>
                <div class="col-md-12 mb-3">
                <label class="labels">Status Mahasiswa</label>
                <input type="text" class="form-control" placeholder="Status Mahasiswa" value="<?= ($user['status_keanggotaan'] == 1) ? "Aktif" : "Tidak Aktif" ?>" readonly>
                </div>
            </div>
            <?php
                }
            ?>
            <div class="text-right">
                <button class="btn btn-primary profile-button" type="submit" name='simpan'>Simpan Perubahan</button>
            </div>
         </form>
      </div>
   </div>
   <?php
      $errorPass = false;    
      $errorText = "";
      $successPass = false;
      if(isset($_POST['updatePassword'])) {
          $passwordLama = md5($_POST['password_lama']);
          $passwordBaru = md5($_POST['password_baru']);
          $konfirmasiPasswordBaru = md5($_POST['konfirmasi_password_baru']);
          if ($passwordLama == '') {
            $errorPass = true;
            $errorText = 'Password lama tidak boleh kosong';
          } else if ($passwordBaru == '') { 
            $errorPass = true;
            $errorText = 'Password baru tidak boleh kosong';
          } else if ($passwordBaru != $konfirmasiPasswordBaru) {
            $errorPass = true;
            $errorText = 'Konfirmasi password tidak sama';
          } else {
              $errorPass = false;
              $query = "SELECT * tb_users WHERE id='" . $_SESSION['id_user'] . "' AND password='". $passwordLama ."'";
              $result = $connect->query($query);
              if ($result->num_rows > 0) {
                  $query = "UPDATE tb_users SET password='". $passwordBaru ."' WHERE id='". $_SESSION['id_user'] ."'";
                  $result = $connect->query($query);
                  if ($result) {
                    $successPass = true;
                  } else {
                    $errorPass = true;
                    $errorText = "Gagal memperbarui password";
                  }
              } else {
                  $errorPass = true;
                  $errorText = "Password lama salah";
              }
          }
      }
   ?>
   <div class="col-md-4 mt-5">
      <div class="p-3">
         <?php if ($successPass) { ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-check bi flex-shrink-0 me-2" width="24" height="24"></i>
            <div><strong>Berhasil!</strong> Password berhasil diperbarui</div>
        </div>
        <?php } ?>
         <?php if ($errorPass) { ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle bi flex-shrink-0 me-2" width="24" height="24"></i>
            <div><strong>Gagal!</strong> <?= $errorText ?></div>
        </div>
        <?php } ?>
         <div class="d-flex justify-content-between align-items-center fw-bold mb-3">
           <span>Ubah Password Login</span>
         </div>
         <form method='POST'>
            <div class="col-md-12 mb-2">
                <label class="labels">Password Lama</label>
                <input type="password" class="form-control" placeholder="Password lama" name='password_lama' value="">
            </div>
            <div class="col-md-12 mb-2">
                <label class="labels">Password Baru</label>
                <input type="password" class="form-control" placeholder="Password lama" name='password_baru' value="">
            </div>
            <div class="col-md-12 mb-3">
                <label class="labels">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" placeholder="Password lama" name='konfirmasi_password_baru' value=''>
            </div>
            <div class="text-right">
                <button class="btn btn-primary profile-button" name='updatePassword' type="submit">Update Password</button>
            </div>
        </form>
      </div>
   </div>
</div>