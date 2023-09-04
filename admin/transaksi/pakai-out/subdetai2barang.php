<?php
include '../../../koneksi/koneksi.php';
session_start();
// error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../../../login.php');
}

    $id_subdetail = $_POST["subdetail"];
    $sql = mysqli_query($con, "SELECT * FROM view_brng_subdetail_out WHERE id_subdetail='$id_subdetail' ORDER BY id_barang DESC");
    // $jsArray = "var prdBarang = new Array();\n";

    $html = "<option disabled selected>Pilih barang...</option>";

    while ($data = mysqli_fetch_array($sql)) {
       $html .= "<option value='".$data['id_barang']."'>". $data['kode_barang']." - ". $data['nama_barang']."</option>";
    }

$callback = array('data_barang'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota
echo json_encode($callback); // konversi varibael $callback menjadi JSON

?>