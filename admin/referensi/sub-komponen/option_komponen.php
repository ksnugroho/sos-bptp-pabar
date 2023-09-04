<?php
// Load file koneksi.php
include '../../../koneksi/koneksi.php';

// Ambil data ID Provinsi yang dikirim via ajax post
$id_kegiatan = $_POST['kegiatan'];

// Buat query untuk menampilkan data kota dengan provinsi tertentu (sesuai yang dipilih user pada form)
$sql = mysqli_query($con, "SELECT * FROM ref_komponen WHERE id_kegiatan='".$id_kegiatan."' ORDER BY nama_komponen");

// Buat variabel untuk menampung tag-tag option nya
// Set defaultnya dengan tag option Pilih
if (mysqli_num_rows($sql)>0) {
   $html = "<option disabled selected>Pilih Komponen</option>";

    while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
        $html .= "<option value='".$data['id_komponen']."'>".$data['kode_komponen']." - ".$data['nama_komponen']."</option>"; // Tambahkan tag option ke variabel $html
    }
} else {
    $html = "<option disabled selected>Pilih Komponen</option>";
    $html .= "<option disabled>Tidak Ada Komponen Pada Kegiatan Tersebut.</option>"; 
}


$callback = array('data_komponen'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

echo json_encode($callback); // konversi varibael $callback menjadi JSON
?>
