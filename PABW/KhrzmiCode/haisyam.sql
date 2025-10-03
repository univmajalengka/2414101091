-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 03 Okt 2025 pada 10.35
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
-- Database: `icam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `produk_id` int(10) UNSIGNED NOT NULL,
  `nama_pembeli` varchar(150) NOT NULL,
  `kontak` varchar(150) NOT NULL,
  `catatan` text DEFAULT NULL,
  `link_produk` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `produk_id`, `nama_pembeli`, `kontak`, `catatan`, `link_produk`, `created_at`) VALUES
(1, 2, 'test', '0909', '', 'https://haisyam.com', '2025-10-03 07:28:49'),
(2, 1, 'Haiy', '082', 'anjag', '', '2025-10-03 08:05:41'),
(3, 2, 'asd', 'dsad', '', 'https://haisyam.com', '2025-10-03 08:12:14'),
(4, 2, 'anakaj', 'nii', '', 'https://haisyam.com', '2025-10-03 08:20:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `subjudul_produk` varchar(200) NOT NULL,
  `kategori_produk` enum('Laravel','React','PHP Native','HTML CSS JS') NOT NULL,
  `tech_stack` text NOT NULL,
  `tanggal_update` date NOT NULL,
  `harga_produk` bigint(20) UNSIGNED NOT NULL,
  `gambar_produk` varchar(255) NOT NULL,
  `link_produk` varchar(255) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `subjudul_produk`, `kategori_produk`, `tech_stack`, `tanggal_update`, `harga_produk`, `gambar_produk`, `link_produk`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, '1', '1', 'Laravel', 'Laravel, Vite, Tailwind, MySQL', '2025-10-03', 10000, 'gtp3.png', 'https://anjay.com', '2025-10-03 03:44:46', '2025-10-03 08:07:01'),
(2, 'asfffffffeeeeeeeeee', 'sfasssssssssssssssssss', 'React', 'Laravel, Vite, Tailwind, MySQL', '2025-10-03', 102000, 'quran1.png', 'https://haisyam.com', '2025-10-03 03:55:32', '2025-10-03 07:14:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'haisyam', 'f96be05af8685b6b4d3ff2c86e953fe04c57bdc6966bcff9826c34382c9eeca7', '2025-10-03 08:36:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
