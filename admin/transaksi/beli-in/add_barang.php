<?php
session_start();
include '../../../koneksi/koneksi.php';

error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../../../login.php');
}

  $barang = mysqli_real_escape_string($con, $_POST['barang']);
  $jumlah = mysqli_real_escape_string($con, $_POST['jumlah']);
  $harga_form = mysqli_real_escape_string($con, $_POST['harga']);
  $harga_form1 = str_replace(".", "", $harga_form);
  $harga = str_replace("Rp", "", $harga_form1);
  

  $cek_barang = mysqli_query($con, "SELECT * FROM tb_barang_sementara WHERE id_barang_sementara='$barang'");
  while ($row = mysqli_fetch_array($cek_barang)) {
        $id_barang_sementara = $row['id_barang_sementara']; 
        $kd_barang_sementara = $row['kd_barang_sementara']; 
        $nama_barang_sementara = $row['nama_barang_sementara']; 
        $jumlah_sementara = $row['jumlah_sementara']; 
  }
  $total = $jumlah+$jumlah_sementara;

  if (mysqli_num_rows($cek_barang)>0) {
    mysqli_query($con, "UPDATE tb_barang_sementara SET jumlah_sementara= '$total' WHERE id_barang_sementara='$barang'");
  }
  else {
    mysqli_query($con, "INSERT INTO tb_barang_sementara (id_barang_sementara, kd_barang_sementara, nama_barang_sementara, satuan_sementara, jumlah_sementara, harga_sementara) 
                      (SELECT id_barang, kode_barang, nama_barang, id_satuan, '$jumlah', '$harga' FROM ref_barang WHERE id_barang='$barang')");
  }

?>