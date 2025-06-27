-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2025 at 07:44 AM
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
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_stok`
--

INSERT INTO `tbl_stok` (`id_brg`, `nama_brg`, `deskripsi`, `harga`, `stok`, `isi`, `gambar`, `tanggal`, `username`) VALUES
(3, 'Glico Wings Frostbite Mochi Choco Lava 46 ml', 'Nikmati mochi khas Jepang dari Frostbite dengan es krim creamy rasa coklat dan lelehan coklat lezat dibalut mochi kenyal! Frostbite Mochi Choco Lava hadir dalam bites size, hanya beberapa gigitan sehingga cocok untuk snack dan dessert. Mengandung Alergen: Padatan Susu (Susu Skim Bubuk, Whey Bubuk), Ekstrak Malt. Size: 46 ML Cara Penyimpanan: Simpan pada suhu beku di bawah -18C No. BPOM: MD 204210064411', 4000.00, 5, '0', 'mochi.jpg', '2025-06-26 19:39:38', 'Johana'),
(4, 'Glico Wings Haku Es Krim ', 'Es krim taiyaki Jepang dari Glico Wings dengan rasa vanilla dan crispy cokelat. Terinspirasi dari snack khas Jepang yang dapat memberikan keceriaan di tengah keluarga. Mengandung Alergen: Pengemulsi Lesitin Kedelai, Tepung Terigu, Padatan Susu (Susu Skim Bubuk, Bubuk Whey) Cara Penyimpanan: Simpan pada suhu beku di bawah -18C Size: 100 ML No. BPOM: MD 204210052411', 6000.00, 11, '0', 'haku.jpg', '2025-06-26 11:10:45', 'admin'),
(10, 'Wall\'s Magnum Es Krim Stroberi Panna 80 ml', 'Wall\'s Magnum Es Krim Stroberi Panna 80 ml adalah es krim lezat persembahan Wall\'s dengan rasa stroberi panna yang lembut berisi potongan buah stroberi asli, dilapisi dengan cokelat putih tebal khas Magnum. Menghasilkan es krim dengan rasa manis, segar, dan creamy dalam balutan cokelat Belgia premium yang renyah khas Es Krim Wall\'s Magnum.', 20200.00, 14, '0', 'magnum.jpg', '2025-06-26 19:15:15', 'Johana'),
(30, 'Wall\'s Shaky Shake Es Krim Cokelat 140 ml', 'WALL\'S Ice Cream Shaky Shake 140 ml merupakan es krim rasa cokelat dengan saus dan butiran cokelat yang lezat. Dibuat dengan susu asli dengan kualitas terbaik untuk menghasilkan snack es krim lezat yang creamy serta berkualitas. Dessert Ice Cream Wall\'s hadir untuk membuat #SemuaJadiHappy, membuat kebahagian bagi kamu dan orang sekitar!', 10600.00, 13, '0', 'shaky.jpg', '2025-06-26 19:35:34', 'Johana'),
(31, 'Wall\'s Cornetto Es Krim Apple Crumb 108 ml', 'Es krim rasa Apple Crumble yang creamy, dilengkapi dengan topping yang lezat. Dibungkus wafer cone renyah. Pengalaman snack tak terlupakan yang cocok untuk mencairkan suasana. Nikmati berbagai varian Cornetto lainnya seperti Cornetto Coffee Caramel, Cornetto Black & White, dll', 10200.00, 5, '0', 'eskrim.jpg', '2025-06-27 14:43:07', 'Chalida'),
(32, 'Wall\'s Es Krim 3 in 1 Extra Creamy Neopolitana 350 ml', 'Es krim Neopolitana lembut rasa coklat, stroberi, dan vanila yang extra creamy. Terbuat dari susu asli sehingga baik untukmu dan menggunakan wadah yang dapat digunakan kembali sehingga baik juga untuk bumi.', 25000.00, 8, '0', '3rasa.jpg', '2025-06-26 21:51:15', 'Johana'),
(34, 'Paddle Pop', 'Main yuk brareng Paddle Pop Rainbow. Es krim stik warna warni dengan rasa karamel enak. Terbuat dari kebaikan susu dengan gula yang baik untuk anak. Jangan lupa cobain juga varian Paddle Pop lainnya, Paddle Pop Mochi. Tersedia dalam 2 rasa, coklat dan strawberry!', 3000.00, 15, '0', 'paddlepop.jpg', '2025-06-27 14:42:39', 'Chalida');

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
(24, '2025-05-11 15:50:00', 1, 31, 'Wall\'s Cornetto Es Krim Apple Crumb 108 ml', 10200.00, 4, 40800.00),
(25, '2025-05-13 09:05:00', 2, 32, 'Wall\'s Es Krim 3 in 1 Extra Creamy Neopolitana 350 ml', 24500.00, 2, 49000.00),
(41, '2025-01-15 10:45:00', 3, 3, 'Glico Wings Frostbite Mochi Choco Lava 46 ml', 4000.00, 5, 20000.00),
(42, '2025-02-20 14:30:00', 5, 30, 'Wall\'s Shaky Shake Es Krim Cokelat 140 ml', 10600.00, 2, 21200.00),
(43, '2025-03-12 11:10:00', 4, 31, 'Wall\'s Cornetto Es Krim Apple Crumb 108 ml', 10200.00, 3, 30600.00),
(44, '2025-04-05 09:00:00', 5, 10, 'Wall\'s Magnum Es Krim Stroberi Panna 80 ml', 20200.00, 1, 20200.00),
(45, '2025-05-21 17:25:00', 3, 32, 'Wall\'s Es Krim 3 in 1 Extra Creamy Neopolitana 350 ml', 25000.00, 2, 50000.00),
(46, '2025-06-18 13:45:00', 4, 34, 'Paddle Pop', 3000.00, 4, 12000.00),
(47, '2025-02-11 16:20:00', 4, 4, 'Glico Wings Haku Es Krim', 6000.00, 3, 18000.00),
(48, '2025-03-29 08:10:00', 5, 3, 'Glico Wings Frostbite Mochi Choco Lava 46 ml', 4000.00, 6, 24000.00),
(49, '2025-04-10 19:00:00', 3, 31, 'Wall\'s Cornetto Es Krim Apple Crumb 108 ml', 10200.00, 1, 10200.00);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id_brg` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id_trans` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
