-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2025 at 03:09 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_stok` (IN `p_id_brg` INT)   BEGIN
    DELETE FROM tbl_stok WHERE id_brg = p_id_brg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_transaksi` (IN `p_id_trans` INT)   BEGIN
    DELETE FROM tbl_transaksi WHERE id_trans = p_id_trans;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_stok` (IN `p_nama_brg` TEXT, IN `p_deskripsi` TEXT, IN `p_harga` DECIMAL(10,2), IN `p_stok` INT, IN `p_isi` TEXT, IN `p_gambar` TEXT, IN `p_tanggal` DATETIME, IN `p_username` VARCHAR(50))   BEGIN
    INSERT INTO tbl_stok (nama_brg, deskripsi, harga, stok, isi, gambar, tanggal, username)
    VALUES (p_nama_brg, p_deskripsi, p_harga, p_stok, p_isi, p_gambar, p_tanggal, p_username);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_transaksi` (IN `p_tgl_trans` DATETIME, IN `p_id_admin` INT, IN `p_id_brg` INT, IN `p_nama_brg` TEXT, IN `p_harga` DECIMAL(10,2), IN `p_jml_jual` INT, IN `p_subtotal` DECIMAL(10,2))   BEGIN
    INSERT INTO tbl_transaksi (tgl_trans, id_admin, id_brg, nama_brg, harga, jml_jual, subtotal)
    VALUES (p_tgl_trans, p_id_admin, p_id_brg, p_nama_brg, p_harga, p_jml_jual, p_subtotal);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_stok` (IN `p_id_brg` INT, IN `p_nama_brg` TEXT, IN `p_deskripsi` TEXT, IN `p_harga` DECIMAL(10,2), IN `p_stok` INT, IN `p_isi` TEXT, IN `p_gambar` TEXT, IN `p_tanggal` DATETIME, IN `p_username` VARCHAR(50))   BEGIN
    UPDATE tbl_stok 
    SET nama_brg = p_nama_brg,
        deskripsi = p_deskripsi,
        harga = p_harga,
        stok = p_stok,
        isi = p_isi,
        gambar = p_gambar,
        tanggal = p_tanggal,
        username = p_username
    WHERE id_brg = p_id_brg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_transaksi` (IN `p_id_trans` INT, IN `p_id_brg` INT, IN `p_nama_brg` TEXT, IN `p_harga` DECIMAL(10,2), IN `p_jml_jual` INT, IN `p_subtotal` DECIMAL(10,2))   BEGIN
    UPDATE tbl_transaksi
    SET 
        id_brg = p_id_brg,
        nama_brg = p_nama_brg,
        harga = p_harga,
        jml_jual = p_jml_jual,
        subtotal = p_subtotal
    WHERE id_trans = p_id_trans;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int NOT NULL,
  `nama_admin` varchar(100) DEFAULT NULL,
  `password` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `nama_admin`, `password`, `foto`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', ''),
(2, 'admin', '0192023a7bbd73250516f069df18b500', 'edit3.jpeg'),
(3, 'Megan', '0192023a7bbd73250516f069df18b500', ''),
(4, 'Chalida', '0192023a7bbd73250516f069df18b500', ''),
(5, 'Johana', '0192023a7bbd73250516f069df18b500', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lock`
--

CREATE TABLE `tbl_lock` (
  `table_name` varchar(50) NOT NULL,
  `record_id` int NOT NULL,
  `is_locked` tinyint(1) DEFAULT '0',
  `locked_by` varchar(50) DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stok`
--

CREATE TABLE `tbl_stok` (
  `id_brg` int NOT NULL,
  `nama_brg` text,
  `deskripsi` text,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `isi` text,
  `gambar` text,
  `tanggal` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `is_locked` tinyint(1) DEFAULT '0',
  `locked_by` varchar(100) DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_stok`
--

INSERT INTO `tbl_stok` (`id_brg`, `nama_brg`, `deskripsi`, `harga`, `stok`, `isi`, `gambar`, `tanggal`, `username`, `is_locked`, `locked_by`, `locked_at`) VALUES
(37, 'Facetology Triple Care Oil Control Acne Calm Cleanser 100ml', 'Facial Wash yang efektif untuk membantu meredakan tiga jenis jerawat, yaitu Fungal Acne, Jerawat, dan Komedo, tanpa membuat kulit terasa tertarik serta tetap lembab. Diperkaya dengan Zinc Pyrithione, Encapsulated Salicylic Acid, dan Succinic Acid, yang mampu membersihkan kotoran setelah beraktivitas, mengontrol produksi minyak berlebih, serta membantu mengatasi permasalahan jerawat. Terdapat juga calming agent seperti Panthenol, yang menenangkan kulit kemerahan dan membuatnya lebih segar serta nyaman.', 58000.00, 10, '0', 'fw.png', '2025-06-27 22:34:35', 'admin', 0, NULL, NULL),
(38, 'Facetology Brightening Triple Care Sunscreen SPF 40 PA +++ 100ML', 'Diformulasikan dengan HYBRID formulation dengan menggabungkan kedua macam tipe UV Filters baik physical maupun chemical memberikan perlindungan maksimal terhadap paparan sinar UV Matahari. Facetolgy Triple Care Suncreen tidak hanya memberikan 1 manfaat, namun 3 MANFAAT sekaligus! Hybrid UV Filters dan Blue Oleoactif memberikan perlindungan terhadap UV A, UV B & Blue Light Niacinamide, White Ten TM & Tranexamic Acid mencerahkan wajah CICA, Mugwort & SyriCalm menengankan dan sebagai anti inflamation agents.', 155900.00, 10, '0', 'ssgede.png', '2025-06-27 22:36:08', 'admin', 0, NULL, NULL),
(39, 'Facetology Triple Care Lip Protector Sunscreen', 'Menggunakan  Triple Lip Sunscreen Protector Sunscreen SPF 50 PA++++ adalah solusi untuk merawat dan sekaligus melindungi bibirmu. Lip serum kami hadir dengan manfaat triple yaitu, diperkaya Vitamin C dan Squalene untuk melembabkan, mencerahkan dan menjaga agar bibir tetap sehat dan cantik.', 56900.00, 10, '0', 'lip.png', '2025-06-27 22:36:50', 'admin', 0, NULL, NULL),
(40, 'Triple Care Oil Control Acne Calm Moisturizer 35 gr', 'Triple Care Acne Calm Moisturizer membantu meredakan jerawat dalam 2 minggu. Diformulasikan untuk kulit berjerawat, pelembap ringan ini menjaga keseimbangan hidrasi tanpa menyumbat pori-pori dan mencegah kulit kering. Dengan Trikenol, moisturizer ini menenangkan kemerahan, mengontrol minyak berlebih, serta mengatasi jerawat papule/pustule, kemerahan, dan komedo. Teksturnya ringan, cepat meresap, dan tidak lengket.', 69900.00, 10, '0', 'moist.png', '2025-06-27 22:37:49', 'admin', 0, NULL, NULL),
(41, 'Facetology Triple Care Facial Gel Cleanser Calming Sabun Cuci Muka Gentle Low PH', 'Facial Gel Cleanser yang diformulasikan mampu membersihkan, menghilangkan kotoran dan minyak hingga ke dalam pori yang menyumbat serta aman untuk semua jenis kulit dengan memberikan hidrasi yang cukup, lembut, dan menenangkan di wajah, tanpa membuat kulit menjadi terasa. kering, ketarik maupun iritasi serta mampu menjaga kulit dari radikal bebas.', 58000.00, 10, '0', 'fwoat.png', '2025-06-27 22:39:03', 'admin', 0, NULL, NULL),
(42, 'Facetology Triple Care Sunscreen Tinted SPF 50 PA++++ 40ML', 'Facetology Triple Care Sunscreen Tinted tidak hanya memberikan perlindungan terhadap UV-A, UV-B dan blue light, tapi juga memiliki kemampuan untuk membantu mencerahkan dan menenangkan kulit wajah. Sebagai sunscreen hybrid, yang berfungsi sebagai sunscreen & decorative Facetology Triple Care Sunscreen Tinted, juga dapat membantu meratakan warna kulit, menyamarkan pori-pori, membantu menyamarkan Kemerahan, serta menghasilkan natural finish look yang cocok untuk digunakan sehari-hari.', 179800.00, 10, '0', 'Screenshot 2025-06-26 220248.png', '2025-06-27 22:42:01', 'admin', 0, NULL, NULL),
(43, 'Facetology Triple Care Sunscreen For Acne & Oily Skin Sensitive SPF 40 PA+++ 100ML', 'Sunscreen dengan kandungan powder oil absorbent, mampu mengontrol minyak tanpa menyumbat pori pori. Formulanya yang ringan cepat menyerap dengan hasil akhir semi-matte yang nyaman di kulit. Selain itu, bahan seperti mugwort, Centella Asiatica dan Encapsulated Salicylic Acid membantu menenangkan kulit dan mengatasi jerawat dengan aman untuk pengguna sehari hari.', 155900.00, 10, '0', 'tripless.png', '2025-06-27 22:43:46', 'admin', 0, NULL, NULL),
(44, 'Facetology Triple Care Sunscreen For Acne & Oily Skin SPF 40 PA+++ 40ML', 'Sunscreen dengan kandungan powder oil absorbent, mampu mengontrol minyak tanpa menyumbat pori pori. Formulanya yang ringan cepat menyerap dengan hasil akhir semi-matte yang nyaman di kulit. Selain itu, bahan seperti mugwort, Centella Asiatica dan Encapsulated Salicylic Acid membantu menenangkan kulit dan mengatasi jerawat dengan aman untuk pengguna sehari hari.', 75900.00, 10, '0', 'sunscreen.png', '2025-06-27 22:45:13', 'admin', 0, NULL, NULL),
(45, 'Facetology Triple Care Acne Calm Micellar Water 300 ML', 'Dengan Tutup Pump Yang BARU dan FORMULA ADVANCED! Say goodbye to redness and impurities! Dengan kandungan Salicylic Acid, Centella Asiatica dan Witch Hazel, Tea Tree Oil, Micellar Water membantu kulit kamu bebas dari makeup, minyak, dan kotoran, sekaligus meredakan jerawat dan kemerahan. Cukup dalam satu kali usap, kulit jadi tenang, seimbang, dan lembap tanpa khawatir akan menimbulkan iritasi atau munculnya jerawat, khususnya untuk yang memiliki kulit berminyak dan berjerawat.', 49000.00, 10, '0', 'micellar.png', '2025-06-27 22:49:59', 'admin', 0, NULL, NULL),
(46, 'Facetology Triple Care Acne Calm Micellar Water 100ML with Salicylic Acid ', 'Dengan kandungan Salicylic Acid, Centella Asiatica dan Witch Hazel, Tea Tree Oil, Micellar Water membantu kulit kamu bebas dari makeup, minyak, dan kotoran, sekaligus meredakan jerawat dan kemerahan. Cukup dalam satu kali usap, kulit jadi tenang, seimbang, dan lembap tanpa bikin khawatir akan iritasi atau munculnya jerawat, khususnya buat yang punya kulit berminyak dan berjerawat.', 28500.00, 10, '0', 'smallmicellar.png', '2025-06-29 19:36:48', 'Chalida', 0, NULL, NULL),
(48, 'Facetology Triple Care 13.5% Total Acids Purple Ranger Peeling Treatment Serum Brightening', 'Facetology Triple Care 13.5% Total Acids Purple Ranger Peeling Treatment diformulasikan dengan 10% AHA (Glycolic Acid), 0.5% BHA dan 3% PHA yang berfungsi sebagai eksfoliator untuk meluruhkan sel kulit mati secara mendalam, membantu memudarkan bekas jerawat PIE & PIH. Diperkuat dengan kandungan Pure Cica 5% untuk membantu menenangkan kulit.', 83500.00, 1000, '0', 'acneserum.png', '2025-06-29 19:36:01', 'Chalida', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id_trans` int NOT NULL,
  `tgl_trans` datetime NOT NULL,
  `id_admin` int DEFAULT NULL,
  `id_brg` int DEFAULT NULL,
  `nama_brg` text,
  `harga` decimal(10,2) DEFAULT NULL,
  `jml_jual` int DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id_trans`, `tgl_trans`, `id_admin`, `id_brg`, `nama_brg`, `harga`, `jml_jual`, `subtotal`) VALUES
(24, '2025-05-11 15:50:00', 1, 40, 'Triple Care Oil Control Acne Calm Moisturizer 35 gr', 69900.00, 4, 279600.00),
(25, '2025-05-13 09:05:00', 2, 39, 'Facetology Triple Care Lip Protector Sunscreen', 56900.00, 5, 284500.00),
(42, '2025-02-20 14:30:00', 5, 45, 'Facetology Triple Care Acne Calm Micellar Water 300 ML', 49000.00, 8, 392000.00),
(43, '2025-03-12 11:10:00', 4, 44, 'Facetology Triple Care Sunscreen For Acne & Oily Skin SPF 40 PA+++ 40ML', 75900.00, 18, 1366200.00),
(44, '2025-04-05 09:00:00', 5, 41, 'Facetology Triple Care Facial Gel Cleanser Calming Sabun Cuci Muka Gentle Low PH', 58000.00, 6, 348000.00),
(45, '2025-05-21 17:25:00', 3, 38, 'Facetology Brightening Triple Care Sunscreen SPF 40 PA +++ 100ML', 155900.00, 3, 467700.00),
(46, '2025-06-18 13:45:00', 4, 37, 'Facetology Triple Care Oil Control Acne Calm Cleanser 100ml', 58000.00, 4, 232000.00),
(47, '2025-02-11 16:20:00', 4, 46, 'Facetology Triple Care Acne Calm Micellar Water 100ML Pembersih Wajah Salicylic Acid untuk Kulit Berjerawat dan Berminyak', 28500.00, 7, 199500.00),
(48, '2025-03-29 08:10:00', 5, 43, 'Facetology Triple Care Sunscreen For Acne & Oily Skin Sensitive SPF 40 PA+++ 100ML', 155900.00, 5, 779500.00),
(49, '2025-04-10 19:00:00', 3, 42, 'Facetology Triple Care Sunscreen Tinted SPF 50 PA++++ 40ML', 179800.00, 4, 719200.00),
(51, '2025-06-29 18:21:36', 5, 38, 'Facetology Brightening Triple Care Sunscreen SPF 40 PA +++ 100ML', 155900.00, 2, 311800.00),
(52, '2025-06-29 18:21:50', 5, 39, 'Facetology Triple Care Lip Protector Sunscreen', 56900.00, 1, 56900.00),
(53, '2025-06-29 18:22:51', 5, 37, 'Facetology Triple Care Oil Control Acne Calm Cleanser 100ml', 58000.00, 6, 348000.00),
(55, '2025-06-29 19:05:16', 5, 48, 'Facetology Triple Care 13.5% Total Acids Purple Ranger Peeling Treatment Serum Brightening', 83500.00, 1000, 83500000.00);

--
-- Triggers `tbl_transaksi`
--
DELIMITER $$
CREATE TRIGGER `trg_kembalikan_stok_setelah_delete` AFTER DELETE ON `tbl_transaksi` FOR EACH ROW BEGIN
    UPDATE tbl_stok
    SET stok = stok + OLD.jml_jual
    WHERE id_brg = OLD.id_brg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_kurangi_stok_setelah_insert` AFTER INSERT ON `tbl_transaksi` FOR EACH ROW BEGIN
    UPDATE tbl_stok
    SET stok = stok - NEW.jml_jual
    WHERE id_brg = NEW.id_brg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_stok_setelah_update` AFTER UPDATE ON `tbl_transaksi` FOR EACH ROW BEGIN
    -- Kembalikan stok lama
    UPDATE tbl_stok
    SET stok = stok + OLD.jml_jual
    WHERE id_brg = OLD.id_brg;

    -- Kurangi stok baru
    UPDATE tbl_stok
    SET stok = stok - NEW.jml_jual
    WHERE id_brg = NEW.id_brg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trsk_lock`
--

CREATE TABLE `tbl_trsk_lock` (
  `table_name` varchar(50) NOT NULL,
  `record_id` int NOT NULL,
  `is_locked` tinyint(1) DEFAULT '0',
  `locked_by` varchar(50) DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_trsk_lock`
--

INSERT INTO `tbl_trsk_lock` (`table_name`, `record_id`, `is_locked`, `locked_by`, `locked_at`) VALUES
('tbl_transaksi', 50, 0, 'admin', '2025-06-27 22:31:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_lock`
--
ALTER TABLE `tbl_lock`
  ADD PRIMARY KEY (`table_name`,`record_id`);

--
-- Indexes for table `tbl_stok`
--
ALTER TABLE `tbl_stok`
  ADD PRIMARY KEY (`id_brg`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id_trans`),
  ADD KEY `fk_admin` (`id_admin`),
  ADD KEY `fk_barang` (`id_brg`);

--
-- Indexes for table `tbl_trsk_lock`
--
ALTER TABLE `tbl_trsk_lock`
  ADD PRIMARY KEY (`table_name`,`record_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_stok`
--
ALTER TABLE `tbl_stok`
  MODIFY `id_brg` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id_trans` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `tbl_admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barang` FOREIGN KEY (`id_brg`) REFERENCES `tbl_stok` (`id_brg`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
