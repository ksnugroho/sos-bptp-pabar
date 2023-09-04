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
  
  $cek_barang = mysqli_query($con, "SELECT * FROM ref_barang WHERE id_barang='$barang'");
  while ($rowbarang = mysqli_fetch_array($cek_barang)) {
        $id_barang = $rowbarang['id_barang'];
        $jumlah_barang = $rowbarang['jumlah']; 
  }

    if ($jumlah>$jumlah_barang) {
        echo "
            <script>
            swal({
                title: 'Sukses',
                text: 'Tabel berhasil dikosongkanrrr',
                type: 'success',
                showCancelButton: false,
                cancelButtonText: 'No, Cancel!',
                confirmButtonText: 'Oke',
                closeOnConfirm: true
                }, function(isConfirm){
                window.location='index.php?page=add-pakai'
                });
            </script>";
        // echo "Barang Gagal Ditambahkan";
    } else {
        $cek_barangs = mysqli_query($con, "SELECT * FROM tb_pakai_barang_sementara WHERE id_barang_pakai_sementara='$barang'");
        while ($row = mysqli_fetch_array($cek_barangs)) {
                $id_barang_pakai_sementara = $row['id_barang_pakai_sementara']; 
                $kd_barang_pakai_sementara = $row['kd_barang_pakai_sementara']; 
                $nama_barang_pakai_sementara = $row['nama_barang_pakai_sementara']; 
                $jumlah_pakai_sementara = $row['jumlah_pakai_sementara']; 
        }
        $total = $jumlah+$jumlah_pakai_sementara;
    
        if (mysqli_num_rows($cek_barangs)>0) {
            mysqli_query($con, "UPDATE tb_pakai_barang_sementara SET jumlah_pakai_sementara= '$total' WHERE id_barang_pakai_sementara='$barang'");
        }
        else {
            mysqli_query($con, "INSERT INTO tb_pakai_barang_sementara (id_barang_pakai_sementara, kd_barang_pakai_sementara, nama_barang_pakai_sementara, satuan_pakai_sementara, jumlah_pakai_sementara) 
                            (SELECT id_barang, kode_barang, nama_barang, id_satuan, '$jumlah' FROM ref_barang WHERE id_barang='$barang')");
        }
    }

?>