<?php
// Mulai Sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION["ses_username"]) || empty($_SESSION["ses_username"])) {
    // Jika belum login, redirect ke halaman login
    header("location: login.php");
    exit;
}

// Ambil data pengguna dari sesi
$data_id = $_SESSION["ses_id"];
$data_nama = $_SESSION["ses_nama"];
$data_user = $_SESSION["ses_username"];
$data_level = $_SESSION["ses_level"];

// KONEKSI DB
include "include/koneksi.php";
?>

        <!-- Bagian konten -->
        <section>
            <h2 class="text-center">Data Buku yang Dipinjam</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Jatuh Tempo</th>
                            <th scope="col">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Query untuk mengambil data buku yang dipinjam oleh anggota berdasarkan ID pengguna
                        $query = "SELECT tb_buku.judul, tb_peminjaman.tanggal_peminjaman, tb_peminjaman.jatuh_tempo, tb_peminjaman.denda
                                  FROM tb_peminjaman
                                  JOIN tb_buku ON tb_peminjaman.id_buku = tb_buku.id_buku
                                  WHERE tb_peminjaman.id_user = '$data_id'";
                        $result = $koneksi->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $no++ . "</td>
                                        <td>" . $row["judul"] . "</td>
                                        <td>" . $row["tanggal_peminjaman"] . "</td>
                                        <td>" . $row["jatuh_tempo"] . "</td>
                                        <td>" . $row["denda"] . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Tidak ada data buku yang dipinjam.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

