<?php
include '../../../koneksi/koneksi.php';
$barang = mysqli_fetch_array(mysqli_query($con, "SELECT * from view_brng_subdetail_out where id_barang='$_GET[barang]'"));
$data_barang = array('jumlah'   	=>  $barang['jumlah'],
              		'satuan'  	=>  $barang['nama_satuan'],);
 echo json_encode($data_barang);

 ?>