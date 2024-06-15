<?php

include "include/koneksi.php";

$query = "SELECT denda FROM tb_peminjaman WHERE id_user = '" . $_SESSION['ses_id'] . "'";
$result = $koneksi->query($query);
$denda = $result->fetch_assoc();

$query = "SELECT * FROM tb_peminjaman WHERE id_user = '" . $_SESSION['ses_id'] . "'";
$result = $koneksi->query($query);
$jadwal_kuliah = $result->num_rows;
?>

<div class="row mt-3">
  <div class="col">
    <div class="small-box bg-primary">
      <div class="inner">
          <h3><?= $jadwal_kuliah ?></h3>
          <p class="text-light">Buku Dipinjam</p>
      </div>
      <i class="icon fas fa-clipboard-list"></i>
    </div>
  </div>

  <div class="col">
    <div class="small-box bg-warning">
      <div class="inner">
          <h3><?= isset($denda['denda']) ? $denda['denda'] : 'Belum ada data' ?></h3>
          <p class="text-light">Denda</p>
      </div>
      <i class="icon fas fa-bookmark"></i>
    </div>
  </div>
</div>

<div class="row mt-3">
  <div class="col-12">
    <div class="card h-100">
      <div class="card-header"><h4>Pengumuman Terbaru</h4></div>
      <div class="card-body">
        <?php
        $query = "SELECT * FROM tb_peminjaman WHERE id_user = '" . $_SESSION['ses_id'] . "'";
        $result = $koneksi->query($query);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>                     
        
        <div class="border-bottom mb-4">
          <h5>ID Buku : <?= $row['id_buku'] ?></h5>
          <p> Akan jatuh tempo pada tanggal : <?= $row['jatuh_tempo'] ?></p>
        </div>

        <?php        
          }   
        } else {
        ?>
        <h5>Tidak ada pengumuman</h5>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
