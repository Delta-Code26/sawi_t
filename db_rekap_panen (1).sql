-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2024 pada 19.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rekap_panen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_kinerja`
--

CREATE TABLE `penilaian_kinerja` (
  `id_penilaian` varchar(10) NOT NULL,
  `id_pekerja` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id_absensi` varchar(10) NOT NULL,
  `id_pekerja` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Absen','Sakit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` varchar(10) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jk` enum('laki-laki','perempuan') NOT NULL,
  `email` varchar(50) NOT NULL,
  `tgl_gabung` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama_lengkap`, `username`, `password`, `jk`, `email`, `tgl_gabung`) VALUES
('A002', 'Marno', 'admin', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'laki-laki', 'a@delta.com', '2024-05-24'),
('A003', 'Indana Lazulfa', 'indana', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'perempuan', 'member4@delta.com', '2024-05-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bin`
--

CREATE TABLE `tb_bin` (
  `id_bin` varchar(5) NOT NULL,
  `nama_bin` varchar(10) NOT NULL,
  `create_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gaji`
--

CREATE TABLE `tb_gaji` (
  `id_gaji` varchar(10) NOT NULL,
  `id_pekerja` varchar(10) NOT NULL,
  `bulan` varchar(7) NOT NULL,
  `tahun` int(4) NOT NULL,
  `gaji_pokok` decimal(10,2) NOT NULL,
  `tunjangan` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) DEFAULT NULL,
  `potongan` decimal(10,2) DEFAULT NULL,
  `total_gaji` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_panen`
--

CREATE TABLE `tb_panen` (
  `id_panen` varchar(20) NOT NULL,
  `id_task` varchar(10) DEFAULT NULL,
  `id_team` varchar(10) DEFAULT NULL,
  `tgl_panen` date DEFAULT NULL,
  `total_tandan` int(11) DEFAULT NULL,
  `total_berat` decimal(10,2) DEFAULT NULL,
  `average_berat` decimal(10,2) DEFAULT NULL,
  `id_bin` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_passport`
--

CREATE TABLE `tb_passport` (
  `id_passport` int(10) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `no_passport` varchar(25) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `tgl_pengeluaran` date DEFAULT NULL,
  `tgl_habis_berlaku` date DEFAULT NULL,
  `no_register` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pekerja`
--

CREATE TABLE `tb_pekerja` (
  `id_pekerja` varchar(10) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `jk` enum('laki-laki','perempuan') NOT NULL,
  `email` varchar(50) NOT NULL,
  `tgl_gabung` date DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `grade` enum('Harian','Borongan') NOT NULL DEFAULT 'Harian',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pekerja`
--

INSERT INTO `tb_pekerja` (`id_pekerja`, `nama_lengkap`, `username`, `password`, `jk`, `email`, `tgl_gabung`, `status`, `grade`, `foto`) VALUES
('P000000001', 'Pekerja Satu', 'pekerjasat', '$2y$10$sTt', 'laki-laki', 'delta.private26@gmail.com', '1991-02-06', 'Aktif', 'Harian', 'sd.corp__0-removebg-preview.png'),
('P000000003', 'Pekerja Tiga', 'pekerja3', '$2y$10$CaU', 'laki-laki', 'dosen14@gmail.com', '2024-06-05', 'Aktif', 'Harian', '6669c8ac45979_sd.corp__0-removebg-preview.png'),
('P000000004', 'Pekerja Empat', 'pekerja4', '$2y$10$oaf', 'laki-laki', 'deltastmik@gmail.com', '2024-06-07', 'Aktif', 'Harian', '6669ca87f2096_WhatsApp_Image_2024-05-10_at_18.15.17_1486ba67-removebg-preview.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_task`
--

CREATE TABLE `tb_task` (
  `id_task` varchar(10) NOT NULL,
  `task` text NOT NULL,
  `created_time` datetime DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_team`
--

CREATE TABLE `tb_team` (
  `id_team` varchar(10) NOT NULL,
  `nama_team` varchar(25) NOT NULL,
  `id_leader` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_team`
--

INSERT INTO `tb_team` (`id_team`, `nama_team`, `id_leader`) VALUES
('1', 'Delta 1', 'P001'),
('2', 'Delta 2', 'P002'),
('3', 'Delta 3', 'P003');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `penilaian_kinerja`
--
ALTER TABLE `penilaian_kinerja`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_pekerja_penilaian` (`id_pekerja`);

--
-- Indeks untuk tabel `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `fk_pekerja_absensi` (`id_pekerja`);

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_bin`
--
ALTER TABLE `tb_bin`
  ADD PRIMARY KEY (`id_bin`);

--
-- Indeks untuk tabel `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `fk_pekerja_gaji` (`id_pekerja`);

--
-- Indeks untuk tabel `tb_panen`
--
ALTER TABLE `tb_panen`
  ADD PRIMARY KEY (`id_panen`),
  ADD KEY `id_task` (`id_task`),
  ADD KEY `id_team` (`id_team`),
  ADD KEY `id_bin` (`id_bin`);

--
-- Indeks untuk tabel `tb_passport`
--
ALTER TABLE `tb_passport`
  ADD PRIMARY KEY (`id_passport`);

--
-- Indeks untuk tabel `tb_pekerja`
--
ALTER TABLE `tb_pekerja`
  ADD PRIMARY KEY (`id_pekerja`);

--
-- Indeks untuk tabel `tb_task`
--
ALTER TABLE `tb_task`
  ADD PRIMARY KEY (`id_task`);

--
-- Indeks untuk tabel `tb_team`
--
ALTER TABLE `tb_team`
  ADD PRIMARY KEY (`id_team`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_passport`
--
ALTER TABLE `tb_passport`
  MODIFY `id_passport` int(10) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penilaian_kinerja`
--
ALTER TABLE `penilaian_kinerja`
  ADD CONSTRAINT `penilaian_kinerja_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_pekerja` (`id_pekerja`);

--
-- Ketidakleluasaan untuk tabel `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD CONSTRAINT `tb_absensi_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_pekerja` (`id_pekerja`);

--
-- Ketidakleluasaan untuk tabel `tb_gaji`
--
ALTER TABLE `tb_gaji`
  ADD CONSTRAINT `tb_gaji_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `tb_pekerja` (`id_pekerja`);

--
-- Ketidakleluasaan untuk tabel `tb_panen`
--
ALTER TABLE `tb_panen`
  ADD CONSTRAINT `tb_panen_ibfk_1` FOREIGN KEY (`id_task`) REFERENCES `tb_task` (`id_task`),
  ADD CONSTRAINT `tb_panen_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `tb_team` (`id_team`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
