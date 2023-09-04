<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../../../login.php');
}
  
    $truncate_query = mysqli_query($con, "TRUNCATE TABLE tb_barang_sementara");
    if ($truncate_query) {
        header('Location: index?page=beli');
    }
?>