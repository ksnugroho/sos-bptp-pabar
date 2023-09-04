<?php
session_start();
include '../../../koneksi/koneksi.php';

$sql = mysqli_query($con, "SELECT * FROM view_sementara_pakai WHERE jumlah_pakai_sementara > jumlah_ready") or die(mysqli_error($con));
    if (mysqli_num_rows($sql)>0) {
    echo "<span class='text-danger'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> &nbsp;Jumlah melebihi stock yang tersedia</span>";
    } else {
    echo '<button form="add_form" id="add_data" name="add_data" value="add_data" type="submit" class="btn btn-success" style="margin-top: 3px;"><i class="fas fa-save"></i>&nbsp; Simpan</button>';
    }
?>