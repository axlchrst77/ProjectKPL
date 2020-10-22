-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Feb 2020 pada 05.28
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: 'db_surat1'
--

-- --------------------------------------------------------

--
-- Struktur dari tabel 'disposisi'
--

CREATE TABLE disposisi(
  id_disposisi int NOT NULL,
  id_surat int NOT NULL,
  id_pegawai_pengirim int NOT NULL,
  id_pegawai_penerima int NOT NULL,
  id_jabatan_pengirim int NOT NULL,
  tgl_disposisi timestamp NOT NULL DEFAULT current_timestamp,
  keterangan text NOT NULL,
  catatan varchar NOT NULL,
  file_disposisi text NOT NULL
);

--
-- Dumping data untuk tabel 'disposisi'
--

INSERT INTO disposisi (id_disposisi, id_surat, id_pegawai_pengirim, id_pegawai_penerima, id_jabatan_pengirim, tgl_disposisi, keterangan, catatan, file_disposisi) VALUES
(45, 7, 2, 1, 9, '2020-02-12 04:19:52', 'Sekretaris', 'wq', ''),
(46, 7, 2, 4, 9, '2020-02-12 04:20:08', 'Forward Ke', 's', ''),
(47, 7, 2, 7, 9, '2020-02-12 04:20:36', 'Seluruh Pegawai', 'a', ''),
(48, 7, 1, 7, 1000, '2020-02-12 04:26:01', 'Edarkan', 'asd', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel 'disposisi_memo'
--

CREATE TABLE disposisi_memo (
  id_disposisi int NOT NULL,
  id_memo int NOT NULL,
  id_pegawai_pengirim int NOT NULL,
  id_pegawai_penerima int NOT NULL,
  id_jabatan_pengirim int NOT NULL,
  tgl_disposisi timestamp NOT NULL DEFAULT current_timestamp,
  keterangan text NOT NULL,
  catatan varchar NOT NULL,
  file_disposisi text NOT NULL
);

--
-- Dumping data untuk tabel 'disposisi_memo'
--

INSERT INTO disposisi_memo (id_disposisi, id_memo, id_pegawai_pengirim, id_pegawai_penerima, id_jabatan_pengirim, tgl_disposisi, keterangan, catatan, file_disposisi) VALUES
(16, 10, 2, 1, 9, '2020-02-12 04:24:24', 'Edarkan', 'sad', ''),
(17, 10, 1, 7, 1000, '2020-02-12 04:26:51', 'U/ Dilaksanakan', 'sad', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel 'jabatan'
--

CREATE TABLE jabatan (
  id_jabatan int NOT NULL,
  nama_jabatan varchar NOT NULL,
  level int NOT NULL
);

--
-- Dumping data untuk tabel 'jabatan'
--

INSERT INTO jabatan (id_jabatan, nama_jabatan, level) VALUES
(9, 'Sekretaris', 1),
(1000, ' Branch Manager', 2),
(1100, 'Deputy Branch Manager', 2),
(1110, 'Branch Consumer Lending Head', 2),
(1120, 'Branch Commercial & SME Sales Head', 2),
(1130, 'Branch Consumer Funding Head', 2),
(1200, 'Deputy Service Manager', 2),
(1210, 'Customer Service Head', 2),
(1220, 'Branch Operation Unit Head', 2),
(1230, 'Transaction Processing Head', 2),
(1600, 'Branch Shared Service Unit Head', 2),
(1800, 'Koordinator BKP', 2),
(1801, 'Credit Admin', 2),
(1802, 'BLR', 2),
(1803, 'BSCO', 2),
(1806, 'Branch Collection Coordinator', 2),
(1807, 'Accounting Control Unit Head', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel 'ket_disposisi'
--

CREATE TABLE ket_disposisi (
  id int NOT NULL,
  nama varchar DEFAULT NULL
);

--
-- Dumping data untuk tabel 'ket_disposisi'
--

INSERT INTO ket_disposisi (id, nama) VALUES
(1, 'Teliti'),
(2, 'Edarkan'),
(4, 'Ajukan Pendapat'),
(5, 'Sebagai Pedoman'),
(6, 'Laporkan'),
(7, 'Diproses'),
(8, 'Bicarakan dengan saya'),
(9, 'Perhatian'),
(10, 'Dimonitor'),
(11, 'Dicek/ Konfirmasi'),
(12, 'U/ Dilaksanakan'),
(13, 'U/ Diketahui'),
(14, 'Dihadir'),
(15, 'File'),
(16, 'Copy'),
(17, 'Sekretaris'),
(18, 'Forward Ke'),
(19, 'Seluruh Pegawai');

-- --------------------------------------------------------

--
-- Struktur dari tabel 'memo_keluar'
--

CREATE TABLE memo_keluar (
  id_memo int NOT NULL,
  nomor_memo varchar NOT NULL,
  tgl_kirim date NOT NULL,
  tujuan varchar NOT NULL,
  perihal varchar NOT NULL,
  file_memo text NOT NULL
);

--
-- Dumping data untuk tabel 'memo_keluar'
--

INSERT INTO memo_keluar (id_memo, nomor_memo, tgl_kirim, tujuan, perihal, file_memo) VALUES
(9, '1119/M/Mgl.III/BCFU/XI/2019', '2019-11-28', 'BTN Kantor Wilayah 6', 'Permohonan Ijin Prinsip Spesial Rate Deposito', '1119_permohonan_ijin_prinsip_Spesial_Rate_Deposito.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel 'memo_masuk'
--

CREATE TABLE memo_masuk (
  id_memo int NOT NULL,
  nomor_memo varchar NOT NULL,
  tgl_kirim date NOT NULL,
  tgl_terima date NOT NULL,
  pengirim varchar NOT NULL,
  penerima varchar NOT NULL,
  perihal varchar NOT NULL,
  file_memo text NOT NULL,
  status enum('proses','selesai') NOT NULL DEFAULT 'proses'
);

--
-- Dumping data untuk tabel 'memo_masuk'
--

INSERT INTO memo_masuk (id_memo, nomor_memo, tgl_kirim, tgl_terima, pengirim, penerima, perihal, file_memo, status) VALUES
(10, '10/M/OBSD/CC/II/2020', '2020-02-05', '2020-02-05', 'OBSD', 'Sekretaris', 'Pemberitahuan', '20200206_OBSD_10_M_OBSD_CC_II_2020_--_Monitoring_GL_Kas_Dalam_Perjalanan_ATM_Vendor_Januari_202021.pdf', 'proses');

-- --------------------------------------------------------

--
-- Struktur dari tabel 'pegawai'
--

CREATE TABLE pegawai (
  id_pegawai int NOT NULL,
  nik int NOT NULL,
  nama_pegawai varchar NOT NULL,
  id_jabatan int NOT NULL,
  password text NOT NULL,
  username varchar NOT NULL
);

--
-- Dumping data untuk tabel 'pegawai'
--

INSERT INTO pegawai (id_pegawai, nik, nama_pegawai, id_jabatan, password, username) VALUES
(1, 111, 'Kepala Cabang', 1000, '21232f297a57a5a743894a0e4a801fc3', 'kepalacabang'),
(2, 999, 'Sekretaris', 9, '21232f297a57a5a743894a0e4a801fc3', 'sekretaris'),
(4, 0, 'Bima', 1110, '21232f297a57a5a743894a0e4a801fc3', 'bima'),
(5, 0, 'Yoga', 1600, '21232f297a57a5a743894a0e4a801fc3', 'yoga'),
(6, 0, 'Tiwi', 1130, '21232f297a57a5a743894a0e4a801fc3', 'tiwi'),
(7, 0, 'Rina', 1100, '21232f297a57a5a743894a0e4a801fc3', 'rina'),
(8, 0, 'Yus', 1200, '21232f297a57a5a743894a0e4a801fc3', 'yus');

-- --------------------------------------------------------

--
-- Struktur dari tabel 'surat_keluar'
--

CREATE TABLE surat_keluar (
  id_surat int NOT NULL,
  nomor_surat varchar NOT NULL,
  tgl_kirim date NOT NULL,
  tujuan varchar NOT NULL,
  perihal varchar NOT NULL,
  file_surat text NOT NULL
);

--
-- Dumping data untuk tabel 'surat_keluar'
--

INSERT INTO surat_keluar (id_surat, nomor_surat, tgl_kirim, tujuan, perihal, file_surat) VALUES
(8, '64/S/Mgl.III/CMFU/XI2019', '2019-11-13', 'KSP Bakti Usaha Sejahtera', 'Penawaran Program Gebyar Giro BTN 2019', '64_penawaran_program_gebyar_giro_BTN_2019.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel 'surat_masuk'
--

CREATE TABLE surat_masuk (
  id_surat int NOT NULL,
  nomor_surat varchar NOT NULL,
  tgl_kirim date NOT NULL,
  tgl_terima date NOT NULL,
  pengirim varchar NOT NULL,
  penerima varchar NOT NULL,
  perihal varchar NOT NULL,
  file_surat text NOT NULL,
  status enum('proses','selesai') NOT NULL DEFAULT 'proses'
);

--
-- Dumping data untuk tabel 'surat_masuk'
--

INSERT INTO surat_masuk (id_surat, nomor_surat, tgl_kirim, tgl_terima, pengirim, penerima, perihal, file_surat, status) VALUES
(7, '007/MMS/IX-2018', '2018-09-24', '2018-09-24', 'PT.Merbabu Mandiri Indonesia', 'Sekretaris', 'Permohonan Perpanjangan SP2K', 'pt_merbabu.pdf', 'proses');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel 'disposisi'
--
ALTER TABLE disposisi
  ADD PRIMARY KEY (id_disposisi),
  ADD KEY id_surat (id_surat),
  ADD KEY id_pegawai_penerima (id_pegawai_penerima);

--
-- Indeks untuk tabel 'disposisi_memo'
--
ALTER TABLE disposisi_memo
  ADD PRIMARY KEY (id_disposisi),
  ADD KEY id_pegawai_penerima (id_pegawai_penerima),
  ADD KEY disposisi_memo_ibfk_1 (id_memo);

--
-- Indeks untuk tabel 'jabatan'
--
ALTER TABLE jabatan
  ADD PRIMARY KEY (id_jabatan),
  ADD KEY id_jabatan (id_jabatan);

--
-- Indeks untuk tabel 'ket_disposisi'
--
ALTER TABLE ket_disposisi
  ADD PRIMARY KEY (id);

--
-- Indeks untuk tabel 'memo_keluar'
--
ALTER TABLE memo_keluar
  ADD PRIMARY KEY (id_memo),
  ADD KEY id_surat (id_memo);

--
-- Indeks untuk tabel 'memo_masuk'
--
ALTER TABLE memo_masuk
  ADD PRIMARY KEY (id_memo);

--
-- Indeks untuk tabel 'pegawai'
--
ALTER TABLE pegawai
  ADD PRIMARY KEY (id_pegawai),
  ADD KEY id_pegawai (id_pegawai),
  ADD KEY id_jabatan (id_jabatan);

--
-- Indeks untuk tabel 'surat_keluar'
--
ALTER TABLE surat_keluar
  ADD PRIMARY KEY (id_surat),
  ADD KEY id_surat (id_surat);

--
-- Indeks untuk tabel 'surat_masuk'
--
ALTER TABLE surat_masuk
  ADD PRIMARY KEY (id_surat);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel 'disposisi'
--
ALTER TABLE disposisi
  ALTER COLUMN id_disposisi int NOT NULL;

--
-- AUTO_INCREMENT untuk tabel 'disposisi_memo'
--
ALTER TABLE disposisi_memo
  MODIFY id_disposisi int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel 'jabatan'
--
ALTER TABLE jabatan
  MODIFY id_jabatan int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1808;

--
-- AUTO_INCREMENT untuk tabel 'ket_disposisi'
--
ALTER TABLE ket_disposisi
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel 'memo_keluar'
--
ALTER TABLE memo_keluar
  MODIFY id_memo int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel 'memo_masuk'
--
ALTER TABLE memo_masuk
  MODIFY id_memo int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel 'pegawai'
--
ALTER TABLE pegawai
  MODIFY id_pegawai int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel 'surat_keluar'
--
ALTER TABLE surat_keluar
  MODIFY id_surat int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel 'surat_masuk'
--
ALTER TABLE surat_masuk
  MODIFY id_surat int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel 'disposisi'
--
ALTER TABLE disposisi
  ADD CONSTRAINT disposisi_ibfk_1 FOREIGN KEY (id_surat) REFERENCES surat_masuk (id_surat) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT disposisi_pegawai_id_pegawai_fk FOREIGN KEY (id_pegawai_penerima) REFERENCES pegawai (id_pegawai) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel 'disposisi_memo'
--
ALTER TABLE disposisi_memo
  ADD CONSTRAINT disposisi_memo_ibfk_1 FOREIGN KEY (id_memo) REFERENCES memo_masuk (id_memo) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT disposisi_memo_ibfk_2 FOREIGN KEY (id_pegawai_penerima) REFERENCES pegawai (id_pegawai) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel 'pegawai'
--
ALTER TABLE pegawai
  ADD CONSTRAINT pegawai_jabatan_id_jabatan_fk FOREIGN KEY (id_jabatan) REFERENCES jabatan (id_jabatan) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
