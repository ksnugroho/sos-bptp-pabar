<?php
// Load file koneksi.php
include '../../../koneksi/koneksi.php';

// Ambil data ID Provinsi yang dikirim via ajax post
$id_komponen = $_POST['komponen'];

// Buat query untuk menampilkan data kota dengan provinsi tertentu (sesuai yang dipilih user pada form)
$sql = mysqli_query($con, "SELECT * FROM ref_subkomponen WHERE id_komponen='".$id_komponen."' ORDER BY nama_subkomponen");

// Buat variabel untuk menampung tag-tag option nya
// Set defaultnya dengan tag option Pilih
if (mysqli_num_rows($sql)>0) {
   $html = "<option disabled selected>Pilih Sub Komponen</option>";

    while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
        $html .= "<option value='".$data['id_subkomponen']."'>".$data['kode_subkomponen']." - ".$data['nama_subkomponen']."</option>"; // Tambahkan tag option ke variabel $html
    }
} else {
    $html = "<option disabled selected>Pilih Sub Komponen</option>";
    $html .= "<option disabled>Tidak Ada Sub Komponen Pada Komponen Tersebut.</option>"; 
}


$callback = array('data_subkomponen'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

echo json_encode($callback); // konversi varibael $callback menjadi JSON
