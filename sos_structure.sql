CREATE TABLE `master_kategori` (
  `id_kategori` int PRIMARY KEY AUTO_INCREMENT,
  `nama_kategori` varchar(255)
);

CREATE TABLE `master_jenis` (
  `id_jenis` int PRIMARY KEY AUTO_INCREMENT,
  `nama_jenis` varchar(255)
);

CREATE TABLE `master_satuan` (
  `id_satuan` int PRIMARY KEY AUTO_INCREMENT,
  `nama_satuan` varchar(255),
  `desc_satuan` varchar(255)
);

CREATE TABLE `ref_barang` (
  `id_barang` int PRIMARY KEY AUTO_INCREMENT,
  `kode_barang` varchar(255),
  `id_kategori` int,
  `id_jenis` int,
  `id_satuan` int,
  `nama_barang` varchar(255),
  `desc_barang` varchar(255),
  `jumlah` int
);

CREATE TABLE `ref_program` (
  `id_program` int PRIMARY KEY AUTO_INCREMENT,
  `nama_program` varchar(255),
  `desc_program` text
);

CREATE TABLE `ref_kegiatan` (
  `id_kegiatan` int PRIMARY KEY AUTO_INCREMENT,
  `kode_kegiatan` varchar(255),
  `id_program` int,
  `nama_kegiatan` varchar(255),
  `tgl_kegiatan` date,
  `desc_kegiatan` text
);

CREATE TABLE `ref_agen` (
  `id_agen` int PRIMARY KEY AUTO_INCREMENT,
  `kode_agen` varchar(255),
  `nama_agen` varchar(255),
  `alamat` text
);

CREATE TABLE `tsc_beli` (
  `id_beli` int PRIMARY KEY AUTO_INCREMENT,
  `id_kegiatan` int,
  `no_dokumen` varchar(255),
  `tgl_beli` date,
  `no_buku` varchar(255),
  `id_barang` int,
  `id_agen` int,
  `jml_beli` int,
  `harga` int
);

CREATE TABLE `tsc_pakai` (
  `id_pakai` int PRIMARY KEY AUTO_INCREMENT,
  `id_kegiatan` int,
  `tgl_pakai` date,
  `id_barang` int,
  `jml_pakai` int
);
