<?php
// Load file koneksi.php
include '../../../koneksi/koneksi.php';

// Ambil data ID Provinsi yang dikirim via ajax post
$id_program = $_POST['program'];

// Buat query untuk menampilkan data kota dengan provinsi tertentu (sesuai yang dipilih user pada form)
$sql = mysqli_query($con, "SELECT * FROM ref_kegiatan WHERE id_program='".$id_program."' ORDER BY nama_kegiatan");

// Buat variabel untuk menampung tag-tag option nya
// Set defaultnya dengan tag option Pilih
if (mysqli_num_rows($sql)>0) {
   $html = "<option disabled selected>Pilih Kegiatan</option>";

    while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
        $html .= "<option value='".$data['id_kegiatan']."'>".$data['kode_kegiatan']." - ".$data['nama_kegiatan']."</option>"; // Tambahkan tag option ke variabel $html
    }
} else {
    $html = "<option disabled selected>Pilih Kegiatan</option>";
    $html .= "<option disabled>Tidak Ada Kegiatan Pada Program Tersebut.</option>"; 
}


$callback = array('data_kegiatan'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota

echo json_encode($callback); // konversi varibael $callback menjadi JSON
?>
