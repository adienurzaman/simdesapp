-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2020 at 12:21 AM
-- Server version: 10.1.44-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `senr3879_simdesapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ref_hari`
--

CREATE TABLE `ref_hari` (
  `id_hari` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_hari`
--

INSERT INTO `ref_hari` (`id_hari`, `hari`) VALUES
(1, 'Senin'),
(2, 'Selasa'),
(3, 'Rabu'),
(4, 'Kamis'),
(5, 'Jumat'),
(6, 'Sabtu'),
(7, 'Minggu');

-- --------------------------------------------------------

--
-- Table structure for table `ref_jabatan`
--

CREATE TABLE `ref_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_lokasi`
--

CREATE TABLE `ref_lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `dusun` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_lokasi`
--

INSERT INTO `ref_lokasi` (`id_lokasi`, `dusun`) VALUES
(1, 'Cihaur'),
(2, 'Sindangmangu'),
(3, 'Cihaur Kidul'),
(4, 'Garatengah');

-- --------------------------------------------------------

--
-- Table structure for table `ref_wemos`
--

CREATE TABLE `ref_wemos` (
  `id_wemos` int(11) NOT NULL,
  `wemos` enum('Wemos I','Wemos II') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ref_yandu`
--

CREATE TABLE `ref_yandu` (
  `id_refyandu` int(11) NOT NULL,
  `posyandu` enum('Haurkuning I','Haurkuning II','Haurkuning III','Haurkuning IV') NOT NULL,
  `id_lokasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_yandu`
--

INSERT INTO `ref_yandu` (`id_refyandu`, `posyandu`, `id_lokasi`) VALUES
(1, 'Haurkuning I', 1),
(2, 'Haurkuning II', 2),
(3, 'Haurkuning III', 3),
(4, 'Haurkuning IV', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_gempa`
--

CREATE TABLE `tb_gempa` (
  `id_gempa` int(11) NOT NULL,
  `id_wemos` varchar(11) NOT NULL,
  `t_gempa` date NOT NULL,
  `w_gempa` time NOT NULL,
  `n_gempa` float NOT NULL,
  `s_gempa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_image`
--

CREATE TABLE `tb_image` (
  `id_image` int(11) NOT NULL,
  `gambar` varchar(80) NOT NULL,
  `waktu_upload` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_image`
--

INSERT INTO `tb_image` (`id_image`, `gambar`, `waktu_upload`) VALUES
(1, 'monitor3090.jpg', '2020-02-13 18:15:12');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keamanan`
--

CREATE TABLE `tb_keamanan` (
  `id_keamanan` int(11) NOT NULL,
  `id_wemos` varchar(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `jenis_pesan` enum('kriminal','musibah','lainnya') NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `tgl_keamanan` date NOT NULL,
  `waktu_keamanan` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_keamanan`
--

INSERT INTO `tb_keamanan` (`id_keamanan`, `id_wemos`, `nik`, `jenis_pesan`, `deskripsi`, `tgl_keamanan`, `waktu_keamanan`) VALUES
(1, '', '3210060404970001', 'musibah', 'Terjadi banjir di desa xyz, kec. xyz', '2020-02-29', '07:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kebakaran`
--

CREATE TABLE `tb_kebakaran` (
  `id_kebakaran` int(11) NOT NULL,
  `id_wemos` varchar(11) NOT NULL,
  `t_kebakaran` date NOT NULL,
  `w_kebakaran` time NOT NULL,
  `n_kebakaran` float NOT NULL,
  `s_kebakaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelembaban`
--

CREATE TABLE `tb_kelembaban` (
  `id_kl` int(11) NOT NULL,
  `id_wemos` varchar(11) NOT NULL,
  `tgl_kl` date NOT NULL,
  `w_kl` time NOT NULL,
  `n_kl` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kelembaban`
--

INSERT INTO `tb_kelembaban` (`id_kl`, `id_wemos`, `tgl_kl`, `w_kl`, `n_kl`) VALUES
(1, 'W01', '2020-02-01', '10:00:00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kualitasudara`
--

CREATE TABLE `tb_kualitasudara` (
  `id_ku` int(11) NOT NULL,
  `id_wemos` varchar(11) NOT NULL,
  `tgl_ku` date NOT NULL,
  `w_ku` time NOT NULL,
  `n_ku` float NOT NULL,
  `s_ku` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kualitasudara`
--

INSERT INTO `tb_kualitasudara` (`id_ku`, `id_wemos`, `tgl_ku`, `w_ku`, `n_ku`, `s_ku`) VALUES
(1, 'W01', '2020-02-01', '10:00:00', 30, 'Baik');

-- --------------------------------------------------------

--
-- Table structure for table `tb_push`
--

CREATE TABLE `tb_push` (
  `id_push` int(11) NOT NULL,
  `app_id` varchar(50) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `auth_key` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_push`
--

INSERT INTO `tb_push` (`id_push`, `app_id`, `api_key`, `auth_key`) VALUES
(1, '34322d22-5353-45f0-9212-500c2183cb5a', 'OGE4ZTA5MWUtMjVhOS00NWUwLTlkNWQtYzdjYmU1NjFhOGJh', 'ZDliYTFjMWMtODc1Yy00NWY4LWIyZDQtOTkwNDY1NTQ3MGFj');

-- --------------------------------------------------------

--
-- Table structure for table `tb_riwayat`
--

CREATE TABLE `tb_riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tgl_riwayat` date NOT NULL,
  `riwayat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_riwayat`
--

INSERT INTO `tb_riwayat` (`id_riwayat`, `id_user`, `nik`, `tgl_riwayat`, `riwayat`) VALUES
(28, 0, '1234123412341234', '2020-01-31', 'galer'),
(29, 0, '1234123412341235', '2020-01-31', 'gantel '),
(36, 0, '1234567891234567', '2020-02-03', 'gatel'),
(37, 0, '3210060404970001', '2020-02-03', 'Demam'),
(38, 0, '3210060404970001', '2020-02-03', 'Demam, batuk dan pilek'),
(39, 0, '1234567887654311', '2020-02-04', 'Lieur'),
(40, 0, '1234123412344321', '2020-02-04', 'bentol'),
(41, 0, '1234567887654312', '2020-02-04', 'Lieur'),
(42, 0, '1234567887654311', '2020-02-04', 'Lieur'),
(43, 0, '1234567887654312', '2020-02-04', 'Lieur'),
(45, 0, '1234567887654311', '2020-02-05', 'Lieur'),
(46, 0, '1234567887654311', '2020-02-06', 'Lieur'),
(47, 0, '3210060404970001', '2020-02-11', 'Bisul'),
(48, 0, '1234123412341234', '2020-02-28', 'Demam');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ronda`
--

CREATE TABLE `tb_ronda` (
  `id_ronda` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `id_hari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_ronda`
--

INSERT INTO `tb_ronda` (`id_ronda`, `nik`, `id_hari`) VALUES
(3, '1234123412341234', 7),
(4, '1234123412341234', 7),
(5, '3210060404970001', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_suhu`
--

CREATE TABLE `tb_suhu` (
  `id_suhu` int(11) NOT NULL,
  `id_wemos` varchar(11) NOT NULL,
  `tgl_suhu` date NOT NULL,
  `waktu_suhu` time NOT NULL,
  `nilai_suhu` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_suhu`
--

INSERT INTO `tb_suhu` (`id_suhu`, `id_wemos`, `tgl_suhu`, `waktu_suhu`, `nilai_suhu`) VALUES
(1, 'W01', '2020-02-01', '10:00:00', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(10) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level_user` enum('Warga','Admin','Linmas','Bidan','Dokter') NOT NULL,
  `s_user` enum('Aktif','Non-Aktif') NOT NULL,
  `w_login` time NOT NULL,
  `w_logout` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nik`, `password`, `level_user`, `s_user`, `w_login`, `w_logout`) VALUES
(1, '1234123412341234', '827ccb0eea8a706c4c34a16891f84e7b', 'Warga', 'Aktif', '00:00:00', '00:00:00'),
(19, '3210060404970001', '25f9e794323b453885f5181f1b624d0b', 'Admin', 'Aktif', '00:00:00', '00:00:00'),
(20, '1234123412341235', '25f9e794323b453885f5', 'Warga', 'Aktif', '00:00:00', '00:00:00'),
(24, '3210061810970001', '25f9e794323b453885f5', 'Warga', 'Aktif', '00:00:00', '00:00:00'),
(25, '3210060212160002', '25f9e794323b453885f5', 'Bidan', 'Aktif', '00:00:00', '00:00:00'),
(26, '1234567891234567', '25f9e794323b453885f5', 'Dokter', 'Aktif', '00:00:00', '00:00:00'),
(28, '1234123412341230', '25f9e794323b453885f5', '', 'Aktif', '00:00:00', '00:00:00'),
(29, '1234123412344321', '25f9e794323b453885f5181f1b624d0b', 'Linmas', 'Aktif', '00:00:00', '00:00:00'),
(30, '1234123412341298', '25f9e794323b453885f5', 'Bidan', 'Aktif', '00:00:00', '00:00:00'),
(31, '1234123412345433', '25f9e794323b453885f5', 'Warga', 'Aktif', '00:00:00', '00:00:00'),
(32, '1234123412341276', '25f9e794323b453885f5', 'Warga', 'Aktif', '00:00:00', '00:00:00'),
(35, '1234561234561234', '25f9e794323b453885f5181f1b624d0b', 'Warga', 'Aktif', '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_warga`
--

CREATE TABLE `tb_warga` (
  `id_warga` int(11) NOT NULL,
  `nokk` varchar(16) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `gol_darah` enum('A','AB','B','O') NOT NULL,
  `rt` varchar(3) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `desa` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kabupaten` varchar(50) NOT NULL,
  `agama` enum('Islam','Katolik','Budha','Hindu') NOT NULL,
  `s_perkawinan` enum('Kawin','Belum Kawin') NOT NULL,
  `kewarganegaraan` enum('WNI','WNA') NOT NULL,
  `jabatan` enum('Bidan','Limnas','Warga') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_warga`
--

INSERT INTO `tb_warga` (`id_warga`, `nokk`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jk`, `gol_darah`, `rt`, `rw`, `id_lokasi`, `desa`, `kecamatan`, `kabupaten`, `agama`, `s_perkawinan`, `kewarganegaraan`, `jabatan`) VALUES
(1, '123456', '1234123412341234', 'Egy Agung Frastya', 'Majalengka', '1997-04-18', 'Laki-laki', 'A', '11', '12', 3, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(7, '3210060404970010', '3210060404970001', 'Cecep Roni', 'Majalengka', '1997-04-04', 'Laki-laki', 'A', '002', '001', 2, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(8, '1234123412341231', '1234123412341235', 'Diana Surya Heriyana', 'Majalengka', '1995-12-12', 'Laki-laki', 'A', '002', '001', 3, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(12, '3210061810970020', '3210061810970001', 'Adie Iman Nurzaman', 'Majalengka', '1997-10-18', 'Laki-laki', 'A', '4', '2', 1, 'Cihaur', '45461', 'Majalengka', 'Islam', 'Belum Kawin', 'WNI', 'Warga'),
(13, '3210061810970020', '3210060212160002', 'Adie Iman Nurzaman', 'Majalengka', '1997-10-18', 'Laki-laki', 'A', '4', '2', 1, 'Cihaur', '45461', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(14, '1234567890', '3604152008960001', 'Reyna Indra Maulana', 'Serang', '1996-02-01', 'Laki-laki', 'O', '4', '2', 1, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Belum Kawin', 'WNI', 'Limnas'),
(16, '1234123412341239', '1234123412341230', 'usup', 'majalengka', '1994-01-01', 'Laki-laki', 'A', '1', '2', 4, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(17, '1234123412344322', '1234123412344321', 'Asep Sahidin', 'majalengka', '1997-04-18', 'Laki-laki', 'A', '1', '2', 1, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(18, '1234123412341290', '1234123412341298', 'Doni Susandi', 'majalengka', '1987-01-01', 'Laki-laki', 'A', '1', '2', 2, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(20, '4253274137123436', '1234123412341276', 'Aditya Pamungkas', 'majalengka', '2001-02-01', 'Laki-laki', 'A', '1', '2', 4, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(21, '1234123456785679', '1234123456785670', 'Egy Agung Frastya', 'majalengka', '1997-04-18', 'Laki-laki', 'A', '1', '2', 4, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga'),
(23, '1234123456785679', '1234123456785678', 'Egy Agung Frastya', 'majalengka', '1997-04-18', 'Laki-laki', 'A', '1', '2', 4, 'Cihaur', 'Maja', 'Majalengka', 'Islam', 'Kawin', 'WNI', 'Warga');

-- --------------------------------------------------------

--
-- Table structure for table `tb_yandu`
--

CREATE TABLE `tb_yandu` (
  `id_yandu` int(11) NOT NULL,
  `id_refyandu` int(11) NOT NULL,
  `tgl_yandu` date NOT NULL,
  `waktu_yandu` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_yandu`
--

INSERT INTO `tb_yandu` (`id_yandu`, `id_refyandu`, `tgl_yandu`, `waktu_yandu`) VALUES
(11, 2, '2020-02-10', '09:33:28'),
(12, 2, '2020-03-10', '10:34:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ref_hari`
--
ALTER TABLE `ref_hari`
  ADD PRIMARY KEY (`id_hari`);

--
-- Indexes for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `ref_lokasi`
--
ALTER TABLE `ref_lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `ref_wemos`
--
ALTER TABLE `ref_wemos`
  ADD PRIMARY KEY (`id_wemos`);

--
-- Indexes for table `ref_yandu`
--
ALTER TABLE `ref_yandu`
  ADD PRIMARY KEY (`id_refyandu`);

--
-- Indexes for table `tb_gempa`
--
ALTER TABLE `tb_gempa`
  ADD PRIMARY KEY (`id_gempa`);

--
-- Indexes for table `tb_image`
--
ALTER TABLE `tb_image`
  ADD PRIMARY KEY (`id_image`);

--
-- Indexes for table `tb_keamanan`
--
ALTER TABLE `tb_keamanan`
  ADD PRIMARY KEY (`id_keamanan`);

--
-- Indexes for table `tb_kebakaran`
--
ALTER TABLE `tb_kebakaran`
  ADD PRIMARY KEY (`id_kebakaran`);

--
-- Indexes for table `tb_kelembaban`
--
ALTER TABLE `tb_kelembaban`
  ADD PRIMARY KEY (`id_kl`);

--
-- Indexes for table `tb_kualitasudara`
--
ALTER TABLE `tb_kualitasudara`
  ADD PRIMARY KEY (`id_ku`);

--
-- Indexes for table `tb_push`
--
ALTER TABLE `tb_push`
  ADD PRIMARY KEY (`id_push`);

--
-- Indexes for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indexes for table `tb_ronda`
--
ALTER TABLE `tb_ronda`
  ADD PRIMARY KEY (`id_ronda`);

--
-- Indexes for table `tb_suhu`
--
ALTER TABLE `tb_suhu`
  ADD PRIMARY KEY (`id_suhu`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_warga`
--
ALTER TABLE `tb_warga`
  ADD PRIMARY KEY (`id_warga`);

--
-- Indexes for table `tb_yandu`
--
ALTER TABLE `tb_yandu`
  ADD PRIMARY KEY (`id_yandu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ref_hari`
--
ALTER TABLE `ref_hari`
  MODIFY `id_hari` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_lokasi`
--
ALTER TABLE `ref_lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ref_wemos`
--
ALTER TABLE `ref_wemos`
  MODIFY `id_wemos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_yandu`
--
ALTER TABLE `ref_yandu`
  MODIFY `id_refyandu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_gempa`
--
ALTER TABLE `tb_gempa`
  MODIFY `id_gempa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_image`
--
ALTER TABLE `tb_image`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_keamanan`
--
ALTER TABLE `tb_keamanan`
  MODIFY `id_keamanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kebakaran`
--
ALTER TABLE `tb_kebakaran`
  MODIFY `id_kebakaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kelembaban`
--
ALTER TABLE `tb_kelembaban`
  MODIFY `id_kl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kualitasudara`
--
ALTER TABLE `tb_kualitasudara`
  MODIFY `id_ku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_push`
--
ALTER TABLE `tb_push`
  MODIFY `id_push` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_riwayat`
--
ALTER TABLE `tb_riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tb_ronda`
--
ALTER TABLE `tb_ronda`
  MODIFY `id_ronda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_suhu`
--
ALTER TABLE `tb_suhu`
  MODIFY `id_suhu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tb_warga`
--
ALTER TABLE `tb_warga`
  MODIFY `id_warga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tb_yandu`
--
ALTER TABLE `tb_yandu`
  MODIFY `id_yandu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
