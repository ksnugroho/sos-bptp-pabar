<?php
session_start();
include '../../../koneksi/koneksi.php';

  $id = mysqli_real_escape_string($con, $_POST['id']);
  
  mysqli_query($con, "DELETE FROM tb_pakai_barang_sementara WHERE id_pakai_sementara='$id'");

?>