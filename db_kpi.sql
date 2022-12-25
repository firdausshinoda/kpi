-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2022 at 03:41 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kpi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL,
  `niy` varchar(20) DEFAULT NULL,
  `nama_admin` varchar(100) DEFAULT NULL,
  `username_admin` varchar(100) DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `agama` varchar(10) DEFAULT NULL,
  `sex` varchar(15) DEFAULT NULL,
  `tgl_lahir` int(2) DEFAULT NULL,
  `bln_lahir` varchar(10) DEFAULT NULL,
  `thn_lahir` int(4) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `golongan_darah` varchar(2) DEFAULT NULL,
  `foto_admin` varchar(100) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bidang_kerja`
--

CREATE TABLE `bidang_kerja` (
  `id_bidang_kerja` int(10) NOT NULL,
  `bidang_kerja` varchar(30) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan_online`
--

CREATE TABLE `bimbingan_online` (
  `id_bimbingan_online` int(10) NOT NULL,
  `id_mahasiswa` int(20) DEFAULT NULL,
  `id_dosen` varchar(20) DEFAULT NULL,
  `isi` longtext DEFAULT NULL,
  `tipe` varchar(10) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `nama_file` varchar(100) DEFAULT NULL,
  `stt_chat` int(1) DEFAULT NULL,
  `stt_r_mhs` int(1) NOT NULL DEFAULT 1,
  `stt_r_dsn` int(1) NOT NULL DEFAULT 1,
  `send_by` varchar(10) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id_dashboard` int(10) NOT NULL,
  `isi` longtext DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_file`
--

CREATE TABLE `dashboard_file` (
  `id_dashboard_file` int(10) NOT NULL,
  `id_dashboard` int(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `tipe` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_img`
--

CREATE TABLE `dashboard_img` (
  `id_dashboard_img` int(10) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deskripsi_kp`
--

CREATE TABLE `deskripsi_kp` (
  `id_deskripsi_kp` int(1) NOT NULL,
  `isi` longtext DEFAULT NULL,
  `cdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` varchar(20) NOT NULL DEFAULT '0',
  `nama_dosen` varchar(50) DEFAULT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `agama` varchar(10) DEFAULT NULL,
  `sex` varchar(15) DEFAULT NULL,
  `tgl_lahir` int(2) DEFAULT NULL,
  `bln_lahir` varchar(10) DEFAULT NULL,
  `thn_lahir` int(4) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `no_wa` varchar(15) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `golongan_darah` varchar(2) DEFAULT NULL,
  `foto_dosen` varchar(100) DEFAULT NULL,
  `stt_login_dosen` int(1) DEFAULT 0,
  `ldate_dosen` datetime DEFAULT NULL,
  `stt_arsip` int(1) DEFAULT 0,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int(10) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `tipe` varchar(5) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kp`
--

CREATE TABLE `kp` (
  `id_kp` varchar(10) NOT NULL DEFAULT '0',
  `create_by` varchar(20) DEFAULT NULL,
  `stt` int(1) DEFAULT NULL,
  `stt_arsip` int(1) DEFAULT 0,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kp_anggota`
--

CREATE TABLE `kp_anggota` (
  `id_kp_anggota` int(10) NOT NULL,
  `id_kp` varchar(10) DEFAULT NULL,
  `id_mahasiswa` int(20) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kp_bimbingan`
--

CREATE TABLE `kp_bimbingan` (
  `id_kp_bimbingan` int(100) NOT NULL,
  `id_pembimbing` int(10) DEFAULT NULL,
  `id_kp` varchar(10) DEFAULT NULL,
  `id_mahasiswa` int(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `ket` longtext DEFAULT NULL,
  `ttd_by` int(10) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kp_harian`
--

CREATE TABLE `kp_harian` (
  `id_kp_harian` int(100) NOT NULL,
  `id_pembimbing` int(10) DEFAULT NULL,
  `id_kp` varchar(10) DEFAULT NULL,
  `id_mahasiswa` int(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `ket` longtext DEFAULT NULL,
  `cdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kp_laporan`
--

CREATE TABLE `kp_laporan` (
  `id_kp_laporan` int(10) NOT NULL,
  `id_kp` varchar(10) DEFAULT NULL,
  `nama_laporan` longtext DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `tipe` varchar(5) DEFAULT NULL,
  `stt` int(1) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kp_perusahaan`
--

CREATE TABLE `kp_perusahaan` (
  `id_kp_perusahaan` int(10) NOT NULL,
  `id_kp` varchar(10) DEFAULT NULL,
  `id_bidang_kerja` int(10) DEFAULT NULL,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `id_wilayah` varchar(50) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `nama_file` varchar(100) DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `tipe` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `id_log_activity` int(100) NOT NULL,
  `id` varchar(50) DEFAULT NULL,
  `ket` varchar(200) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(20) NOT NULL DEFAULT 0,
  `nama_mahasiswa` varchar(50) DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `agama` varchar(10) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `no_wa` varchar(15) DEFAULT NULL,
  `sex` varchar(15) DEFAULT NULL,
  `tgl_lahir` int(2) DEFAULT NULL,
  `bln_lahir` varchar(10) DEFAULT NULL,
  `thn_lahir` int(4) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `golongan_darah` varchar(2) DEFAULT NULL,
  `angkatan` int(4) DEFAULT NULL,
  `foto_mahasiswa` varchar(100) DEFAULT NULL,
  `stt_login_mahasiswa` int(1) DEFAULT 0,
  `ldate_mahasiswa` datetime DEFAULT '0000-00-00 00:00:00',
  `stt_arsip` int(1) DEFAULT 0,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembimbing`
--

CREATE TABLE `pembimbing` (
  `id_pembimbing` int(10) NOT NULL,
  `id_kp` varchar(10) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembimbing_dosen`
--

CREATE TABLE `pembimbing_dosen` (
  `id_pembimbing_dosen` int(10) NOT NULL,
  `id_pembimbing` int(10) DEFAULT NULL,
  `id_dosen` varchar(20) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembimbing_mahasiswa`
--

CREATE TABLE `pembimbing_mahasiswa` (
  `id_pembimbing_mahasiswa` int(10) NOT NULL,
  `id_pembimbing` int(10) DEFAULT NULL,
  `id_mahasiswa` int(20) DEFAULT NULL,
  `id_kp_laporan` int(10) DEFAULT NULL,
  `stt_arsip` int(1) DEFAULT 0,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sosial_link`
--

CREATE TABLE `sosial_link` (
  `id_sosial_link` int(5) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `link` longtext DEFAULT NULL,
  `cdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_ijin_kp`
--

CREATE TABLE `surat_ijin_kp` (
  `id_surat_ijin_kp` int(5) NOT NULL,
  `nomor_surat` longtext DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `jml_hari` int(5) DEFAULT NULL,
  `email_d4` varchar(100) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `nomor_surat_keluar` int(5) NOT NULL DEFAULT 0,
  `tahun_print_terakhir` int(4) NOT NULL DEFAULT 2017
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `id_wilayah` int(10) NOT NULL,
  `wilayah` varchar(30) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `deleted_flage` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `bidang_kerja`
--
ALTER TABLE `bidang_kerja`
  ADD PRIMARY KEY (`id_bidang_kerja`);

--
-- Indexes for table `bimbingan_online`
--
ALTER TABLE `bimbingan_online`
  ADD PRIMARY KEY (`id_bimbingan_online`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id_dashboard`);

--
-- Indexes for table `dashboard_file`
--
ALTER TABLE `dashboard_file`
  ADD PRIMARY KEY (`id_dashboard_file`),
  ADD KEY `id_dashboard` (`id_dashboard`);

--
-- Indexes for table `dashboard_img`
--
ALTER TABLE `dashboard_img`
  ADD PRIMARY KEY (`id_dashboard_img`);

--
-- Indexes for table `deskripsi_kp`
--
ALTER TABLE `deskripsi_kp`
  ADD PRIMARY KEY (`id_deskripsi_kp`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `kp`
--
ALTER TABLE `kp`
  ADD PRIMARY KEY (`id_kp`);

--
-- Indexes for table `kp_anggota`
--
ALTER TABLE `kp_anggota`
  ADD PRIMARY KEY (`id_kp_anggota`),
  ADD KEY `id_kp` (`id_kp`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `kp_bimbingan`
--
ALTER TABLE `kp_bimbingan`
  ADD PRIMARY KEY (`id_kp_bimbingan`),
  ADD KEY `id_pembimbing` (`id_pembimbing`),
  ADD KEY `id_kp` (`id_kp`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `kp_harian`
--
ALTER TABLE `kp_harian`
  ADD PRIMARY KEY (`id_kp_harian`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_pembimbing` (`id_pembimbing`),
  ADD KEY `id_kp` (`id_kp`);

--
-- Indexes for table `kp_laporan`
--
ALTER TABLE `kp_laporan`
  ADD PRIMARY KEY (`id_kp_laporan`),
  ADD KEY `id_kp` (`id_kp`);

--
-- Indexes for table `kp_perusahaan`
--
ALTER TABLE `kp_perusahaan`
  ADD PRIMARY KEY (`id_kp_perusahaan`),
  ADD KEY `id_kp` (`id_kp`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`id_log_activity`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `pembimbing`
--
ALTER TABLE `pembimbing`
  ADD PRIMARY KEY (`id_pembimbing`),
  ADD KEY `id_kp` (`id_kp`);

--
-- Indexes for table `pembimbing_dosen`
--
ALTER TABLE `pembimbing_dosen`
  ADD PRIMARY KEY (`id_pembimbing_dosen`),
  ADD KEY `id_pembimbing` (`id_pembimbing`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indexes for table `pembimbing_mahasiswa`
--
ALTER TABLE `pembimbing_mahasiswa`
  ADD PRIMARY KEY (`id_pembimbing_mahasiswa`),
  ADD KEY `id_pembimbing` (`id_pembimbing`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_kp_laporan` (`id_kp_laporan`);

--
-- Indexes for table `sosial_link`
--
ALTER TABLE `sosial_link`
  ADD PRIMARY KEY (`id_sosial_link`);

--
-- Indexes for table `surat_ijin_kp`
--
ALTER TABLE `surat_ijin_kp`
  ADD PRIMARY KEY (`id_surat_ijin_kp`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id_wilayah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bidang_kerja`
--
ALTER TABLE `bidang_kerja`
  MODIFY `id_bidang_kerja` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bimbingan_online`
--
ALTER TABLE `bimbingan_online`
  MODIFY `id_bimbingan_online` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id_dashboard` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dashboard_file`
--
ALTER TABLE `dashboard_file`
  MODIFY `id_dashboard_file` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dashboard_img`
--
ALTER TABLE `dashboard_img`
  MODIFY `id_dashboard_img` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deskripsi_kp`
--
ALTER TABLE `deskripsi_kp`
  MODIFY `id_deskripsi_kp` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kp_anggota`
--
ALTER TABLE `kp_anggota`
  MODIFY `id_kp_anggota` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kp_bimbingan`
--
ALTER TABLE `kp_bimbingan`
  MODIFY `id_kp_bimbingan` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kp_harian`
--
ALTER TABLE `kp_harian`
  MODIFY `id_kp_harian` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kp_laporan`
--
ALTER TABLE `kp_laporan`
  MODIFY `id_kp_laporan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kp_perusahaan`
--
ALTER TABLE `kp_perusahaan`
  MODIFY `id_kp_perusahaan` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `id_log_activity` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembimbing`
--
ALTER TABLE `pembimbing`
  MODIFY `id_pembimbing` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembimbing_dosen`
--
ALTER TABLE `pembimbing_dosen`
  MODIFY `id_pembimbing_dosen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembimbing_mahasiswa`
--
ALTER TABLE `pembimbing_mahasiswa`
  MODIFY `id_pembimbing_mahasiswa` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sosial_link`
--
ALTER TABLE `sosial_link`
  MODIFY `id_sosial_link` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_ijin_kp`
--
ALTER TABLE `surat_ijin_kp`
  MODIFY `id_surat_ijin_kp` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id_wilayah` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
