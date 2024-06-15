<?php
include "include/koneksi.php";
?>


            <div class="card-body">
                <div class="col-md-4 mb-4">
                    <a href="?page=add_member" class="btn btn-primary"><i class="fas fa-user-plus"></i> Tambah</a>
                </div>
                <!-- Tabel untuk menampilkan data buku -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" 
                    $sql = "SELECT tb_buku.*, tb_penulis.nama_penulis 
                    FROM tb_buku 
                    INNER JOIN tb_penulis ON tb_buku.id_penulis = tb_penulis.id_penulis >
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>ID Member</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Handphone</th>
                                <th>E Mail</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Kode PHP untuk menampilkan data buku dari database -->
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * from tb_users");
                            while ($data= $sql->fetch_assoc()) {
                            ?>
                                <tr>
							<td>
								<?php echo $no++; ?>
							</td>
							<td>
								<?php echo $data['id_user']; ?>
							</td>
							<td>
								<?php echo $data['nama']; ?>
							</td>
							<td>
								<?php echo $data['jk_user']; ?>
							</td>
							<td>
								<?php echo $data['tgl_lahir']; ?>
							</td>
							<td>
								<?php echo $data['telephone']; ?>
							</td>
							<td>
								<?php echo $data['email']; ?>
							</td>
							<td>
								<?php echo $data['alamat']; ?>
							</td>
							<td>
								<?php echo $data['status_keanggotaan']; ?>
							</td>
							<td>
								<?php echo $data['level_user']; ?>
							</td>

							<td class="text-center">
                                <a href="?page=edit_user&kode=<?php echo $data['id_user']; ?>" title="Edit Member" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="?page=del_user&kode=<?php echo $data['id_user']; ?>" onclick="return confirm('Yakin Hapus Data Ini ?')" title="Hapus" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
						</tr>
						<?php
                        }
                        ?>
					</tbody>
                    </table>
                </div>
            </div>

