<?php
// Load file koneksi.php
include '../../../koneksi/koneksi.php';

// Ambil data ID Provinsi yang dikirim via ajax post
$id_subkomponen = $_POST['subkomponen'];

// Buat query untuk menampilkan data kota dengan provinsi tertentu (sesuai yang dipilih user pada form)
$sql = mysqli_query($con, "SELECT * FROM ref_detail WHERE id_subkomponen='".$id_subkomponen."' ORDER BY nama_detail");

// Buat variabel untuk menampung tag-tag option nya
// Set defaultnya dengan tag option Pilih
if (mysqli_num_rows($sql)>0) {
   $html = "<option disabled selected>Pilih Detail</option>";

    while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
        $html .= "<option value='".$data['id_detail']."'>".$data['kode_detail']." - ".$data['nama_detail']."</option>"; // Tambahkan tag option ke variabel $html
    }
} else {
    $html = "<option disabled selected>Pilih Detail</option>";
    $html .= "<option disabled>Tidak Ada Detail Pada Sub Komponen Tersebut.</option>"; 
}


$callback = array('data_detail'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

echo json_encode($callback); // konversi varibael $callback menjadi JSON
?>
