-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jul 2025 pada 08.35
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
-- Database: `pengumpulantugas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_modul` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `judul_laporan` varchar(255) DEFAULT NULL,
  `file_laporan` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT NULL,
  `status` enum('sudah','belum') DEFAULT 'belum',
  `nilai` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_modul`, `id_user`, `judul_laporan`, `file_laporan`, `tanggal_upload`, `status`, `nilai`, `feedback`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '20230140204', '1751554319_UJIAN AKHIR SEMESTER PDW.pdf', '2025-07-03 21:51:59', 'sudah', 100, '', '2025-07-03 14:51:59', '2025-07-03 15:28:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul`
--

CREATE TABLE `modul` (
  `id` int(11) NOT NULL,
  `id_praktikum` int(11) NOT NULL,
  `judul_modul` varchar(255) NOT NULL,
  `file_materi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `modul`
--

INSERT INTO `modul` (`id`, `id_praktikum`, `judul_modul`, `file_materi`, `created_at`) VALUES
(3, 6, 'test', 'SoalUcp02KelasE (1).pdf', '2025-07-03 18:37:43'),
(5, 6, 'ujian Akhir', 'UJIAN AKHIR SEMESTER PDW.pdf', '2025-07-03 21:45:30'),
(6, 6, 'ujian akhir', 'UJIAN AKHIR SEMESTER PDW.pdf', '2025-07-03 21:49:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta_praktikum`
--

CREATE TABLE `peserta_praktikum` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_praktikum` int(11) NOT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peserta_praktikum`
--

INSERT INTO `peserta_praktikum` (`id`, `id_user`, `id_praktikum`, `tanggal_daftar`) VALUES
(2, 1, 6, '2025-07-03 21:25:40'),
(3, 1, 7, '2025-07-03 23:35:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `praktikum`
--

CREATE TABLE `praktikum` (
  `id` int(11) NOT NULL,
  `nama_praktikum` varchar(100) NOT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `dosen_pengampu` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `praktikum`
--

INSERT INTO `praktikum` (`id`, `nama_praktikum`, `semester`, `dosen_pengampu`, `created_at`) VALUES
(6, 'PRAKTIKUM DESAIN WEB', '4', 'PAK ASRONI', '2025-07-03 15:59:40'),
(7, 'PRAKTIKUM PABD', '4', 'BU APRIL', '2025-07-03 21:27:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','asisten') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'HANIFATUL NADIVA', 'hanifatulnadiva@gmail.com', '$2y$10$ffF4pdJWdjLi22.KFz0CGeQ5dlQQyMRkUqbtOAXde0QQ2W61SqO3K', 'mahasiswa', '2025-07-02 08:54:12'),
(2, 'HANIFATUL NADIVA', 'hanifatulnadiva1@gmail.com', '$2y$10$7.SqvN8NJ7q4L0EwU7WliOJs7jGXx6L6T5utjFw0h2rhmoFMF3IIq', 'asisten', '2025-07-02 08:55:41'),
(3, 'HANIFATUL NADIVA', 'hanifatulnadiva123@gmail.com', '$2y$10$WPrd0fRTjgHMVTypxwwJlOqU5O/sDT7IzMcRkMPa.inKfnKpRXrim', 'mahasiswa', '2025-07-02 16:31:59'),
(4, 'muhammad rafif al faqri', 'superadmin@admin.com', '$2y$10$0HKMTS2AyK1vqnZfAi94ZOChcmNMjSbsJyUXoItjAvB41KN3BePjS', 'mahasiswa', '2025-07-02 17:47:25'),
(5, 'HANIFATUL NADIVA', 'superadmin1@admin.com', '$2y$10$tPT9316E/xoWGMwbiTjAkuyjgWm0RsQjDW1baicSsTRKngVRF4Ob6', 'asisten', '2025-07-02 17:58:41'),
(9, 'HANIFATUL NADIVA', 'superadmin411235@admin.com', '$2y$10$JTyAcgCyGQ7ruYY7c0n6qeIrMzeM3pFxq7SO0oMkXJelaPnelXdBu', 'asisten', '2025-07-03 09:12:19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_modul` (`id_modul`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_praktikum` (`id_praktikum`);

--
-- Indeks untuk tabel `peserta_praktikum`
--
ALTER TABLE `peserta_praktikum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_praktikum` (`id_praktikum`);

--
-- Indeks untuk tabel `praktikum`
--
ALTER TABLE `praktikum`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `modul`
--
ALTER TABLE `modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `peserta_praktikum`
--
ALTER TABLE `peserta_praktikum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `praktikum`
--
ALTER TABLE `praktikum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_modul`) REFERENCES `modul` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`id_praktikum`) REFERENCES `praktikum` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peserta_praktikum`
--
ALTER TABLE `peserta_praktikum`
  ADD CONSTRAINT `peserta_praktikum_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peserta_praktikum_ibfk_2` FOREIGN KEY (`id_praktikum`) REFERENCES `praktikum` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
