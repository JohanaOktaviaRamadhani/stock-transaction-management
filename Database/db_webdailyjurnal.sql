-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2025 at 03:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_webdailyjurnal`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int NOT NULL,
  `judul` text,
  `isi` text,
  `gambar` text,
  `tanggal` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `judul`, `isi`, `gambar`, `tanggal`, `username`) VALUES
(1, 'Teknologi Blockchain untuk Transparansi', 'Blockchain menjadi teknologi revolusioner yang menawarkan transparansi dan keamanan dalam berbagai sektor seperti keuangan, logistik, dan pemerintahan.', 'BLOKCHAIN.jpeg', '2024-12-24 21:00:00', 'admin'),
(3, 'Manfaat Teknologi AI', 'Teknologi kecerdasan buatan (AI) kini menjadi salah satu inovasi terbesar abad ini. AI telah diterapkan di berbagai sektor seperti kesehatan, pendidikan, hingga transportasi, memberikan efisiensi yang lebih baik dalam berbagai aktivitas.', 'AI.jpeg', '2024-12-24 10:00:00', 'admin'),
(4, 'Tips Menjaga Kesehatan Mental', 'Dalam era modern ini, kesehatan mental menjadi isu yang semakin penting. Dengan menjaga pola tidur, berolahraga, dan berbicara dengan orang terdekat, kesehatan mental dapat tetap terjaga.', 'MENTAL HEALTH.jpg', '2024-12-24 11:30:00', 'admin'),
(8, 'Perkembangan Startup di Indonesia', 'Startup di Indonesia terus mengalami perkembangan pesat, terutama di bidang teknologi finansial (fintech). Dukungan pemerintah dan investor asing menjadi pendorong utama pertumbuhan ini.', 'STARTUP.png', '2024-12-24 15:05:00', 'admin'),
(10, 'Kemajuan Teknologi Medis', 'Teknologi medis terus berkembang dengan hadirnya perangkat seperti robot bedah dan telemedicine. Ini memungkinkan pasien mendapatkan perawatan lebih cepat dan akurat.', 'MEDIS.jpg', '2024-12-24 16:50:00', 'admin'),
(12, 'Coinvestasi Most Impactful Figures 2024: Merayakan Para Penggerak Industri Kripto dan Web3 di Indonesia', 'Coinvestasi Most Impactful Figures 2024 kembali hadir sebagai penghargaan tahunan untuk mengapresiasi individu-individu yang telah memberikan kontribusi signifikan dalam membangun fondasi ekosistem kripto dan Web3 yang berkelanjutan di Indonesia.', 'CRIPTO.jpg', '2024-12-24 23:16:31', 'admin'),
(13, 'Jangan Telat! Harga Saham Ini Hanya 81, Tapi Ada Dividen dengan Yield 12,53%', 'Info penting untuk investor saham di Bursa Efek Indonesia (BEI). Di BEI ada salah satu saham dengan harga receh yang siap melakukan pembayaran dividen besar.\r\n\r\nSaham receh itu adalah PT Samcro Hyosung Adilestari Tbk (ACRO). Pada perdagangan Jumat 20 Desember 2024, harga saham ACRO ditutup di level 81.', 'saham.jpg', '2024-12-24 23:19:32', 'admin'),
(16, 'Prospek Cerah Saham Astra (ASII) saat Suku Bunga Murah 2025 ', 'JAKARTA — Saham PT Astra International Tbk. (ASII) terpantau mencatatkan kinerja yang jeblok di sepanjang tahun berjalan. Lantas, seperti apa prospek saham ASII tahun depan? Berdasarkan data Bursa Efek Indonesia (BEI), harga saham ASII memang mencatatkan penguatan pesat 5,4% pada perdagangan kemarin, Senin (25/11/2024), ditutup di level Rp5.175 per lembar. \r\n', 'astra.jpg', '2024-12-25 16:50:10', 'admin'),
(17, 'Anak Usaha Batu Bara Thermal ADRO Mau IPO, Begini Prospeknya!', ' PT Adaro Andalan Indonesia Tbk (AADI), anak usaha Adaro Energy Indonesia Tbk (ADRO) punya bisnis di batu bara thermal bakal segera melantai di Bursa Efek Indonesia (BEI) melalui aksi korporasi Initial Public Offering (IPO).\r\nRencana IPO\r\nDalam penawaran IPO, emiten dengan kode saham AADI ini akan melepas sebanyak 778,68 juta saham dengan nilai nominal Rp3.125 per saham, setara dengan 10% dari total saham perusahaan.', 'adaro.jpeg', '2024-12-25 16:53:49', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `file` text,
  `tipe` enum('gambar','video') NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_gallery`
--

INSERT INTO `tbl_gallery` (`id`, `judul`, `deskripsi`, `file`, `tipe`, `tanggal`) VALUES
(20, 'kedua', '2222222222222222', 'udinus2.jpg', 'gambar', '2024-12-31'),
(21, 'ketiga', '3333333333333333333', 'caro2.jpg', 'gambar', '2024-12-31'),
(36, 'video bengkod', 'apapun videonya yg penting under 1000kb ya', 'video 1.mp4', 'video', '2025-01-12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `foto`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', ''),
(2, 'admin', '0192023a7bbd73250516f069df18b500', 'edit3.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
