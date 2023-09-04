<?php
include '../../../koneksi/koneksi.php';

if($_POST['getDetail']) {
    $id = $_POST['getDetail'];
    // echo $id;
    $sql = mysqli_query($con, "SELECT * from view_subdetail where id_subdetail='$id'");
    while ($row = mysqli_fetch_array($sql)){       
?>
<form id="edit_data" action="" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="edit_program">Program*</label>
                    <input type="text" name="edit_program" id="edit_program" parsley-trigger="change" class="form-control" value="<?php echo $row['kode_program'].' - '.$row['nama_program'].' - '.$row['tahun']; ?>" required readonly>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="edit_kegiatan">Kegiatan*</label>
                    <input type="text" name="edit_kegiatan" id="edit_kegiatan" parsley-trigger="change" class="form-control" value="<?php echo $row['kode_kegiatan'].' - '.$row['nama_kegiatan']; ?>" required readonly>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="edit_komponen">Komponen*</label>
                    <input type="text" name="edit_komponen" id="edit_komponen" parsley-trigger="change" class="form-control" value="<?php echo $row['kode_komponen'].' - '.$row['nama_komponen']; ?>" required readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_subkomponen">Pilih Sub Komponen*</label>
                    <select name="edit_subkomponen" id="edit_subkomponen" class="form-control" onchange="changeValue(this.value)">
                        <option disabled selected>Pilih Sub Komponen</option>
                        
                        <?php                  
                        // Buat query untuk menampilkan semua data siswa
                        $sql = mysqli_query($con, "SELECT * FROM view_subkomponen ORDER BY id_subkomponen");
                        $jsArray = "var prdSubKomponen = new Array();\n";

                        while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                            if ($data['nama_subkomponen']==$row['nama_subkomponen']) {
                                $select="selected";
                            }else{
                                $select="";
                            }

                            echo '<option value="' . $data['id_subkomponen'] . '" '.$select.'>' . $data['kode_subkomponen'] .' - ' . $data['nama_subkomponen'] . '</option>'; 
                            $jsArray .= "prdSubKomponen['" . $data['id_subkomponen'] . "'] = {nama_program:'" . addslashes($data['nama_program']) . "', kode_program:'".addslashes($data['kode_program'])."', tahun:'".addslashes($data['tahun'])."', nama_kegiatan:'" . addslashes($data['nama_kegiatan']) . "', kode_kegiatan:'".addslashes($data['kode_kegiatan'])."', nama_komponen:'" . addslashes($data['nama_komponen']) . "', kode_komponen:'".addslashes($data['kode_komponen'])."'};\n";
                        }
                        ?>
                    </select>
                </div>
                <!-- <br> -->
                <div class="form-group">
                    <label for="edit_detail">Pilih Detail*</label>
                    <select name="edit_detail" id="edit_detail" class="form-control" required>
                        <option disabled>Pilih Detail</option>
                        <?php 
                            $sql=mysqli_query($con, "SELECT * FROM view_detail WHERE kode_subkomponen = '$row[kode_subkomponen]' ORDER BY id_detail");
                            while ($data=mysqli_fetch_array($sql)) {
                                if ($data['nama_detail']==$row['nama_detail']) {
                                    $select="selected";
                                }else{
                                    $select="";
                                }
                            
                            echo '<option value="' . $data['id_detail'] . '" '.$select.'>' . $data['kode_detail'] .' - ' . $data['nama_detail'] . '</option>';  
                            }
                        ?>
                    </select>

                    <div id="loading" style="margin-top: 15px;">
                        <img src="../assets/images/loading.gif" width="18"> <small>Loading...</small>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_kd_subdetail">Kode Sub Detail*</label>
                    <input type="hidden" name="edit_id_subdetail" id="edit_id_subdetail" class="form-control" value="<?php echo $row['id_subdetail']; ?>" required>
                    <input type="text" name="edit_kd_subdetail" id="edit_kd_subdetail" class="form-control" value="<?php echo $row['kode_subdetail']; ?>" required>
                    <!-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="ganti_kode" name="ganti_kode" value="ganti">
                        <label class="form-check-label" for="ganti_kode">Silahkan dicentang, jika ingin memperbarui Kode.</label>
                    </div> -->
                </div>
                <div class="form-group">
                    <label for="edit_nama_subdetail">Nama Sub Detail*</label>
                    <input type="text" name="edit_nama_subdetail" id="edit_nama_subdetail" class="form-control" value="<?php echo $row['nama_subdetail']; ?>" required>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-arrow-left"></i>&nbsp; Kembali</button>
        <input type="submit" name="edit_data" value="Simpan" class="btn btn-primary" />                     
    </div> 
</form>
<?php
    }
}
?>

<!-- script select bertingkat -->
<script>
  $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
	// Kita sembunyikan dulu untuk loadingnya
	$("#loading").hide();
	
	$("#edit_subkomponen").change(function(){ // Ketika user mengganti atau memilih data provinsi
		$("#edit_detail").hide(); // Sembunyikan dulu combobox kota nya
		$("#loading").show(); // Tampilkan loadingnya
	
		$.ajax({
			type: "POST", // Method pengiriman data bisa dengan GET atau POST
			url: "referensi/sub-detail/option_detail.php", // Isi dengan url/path file php yang dituju
			data: {subkomponen : $("#edit_subkomponen").val()}, // data yang akan dikirim ke file yang dituju
			dataType: "json",
			beforeSend: function(e) {
				if(e && e.overrideMimeType) {
					e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: function(response){ // Ketika proses pengiriman berhasil
				$("#loading").hide(); // Sembunyikan loadingnya

				// set isi dari combobox kota
				// lalu munculkan kembali combobox kotanya
				$("#edit_detail").html(response.data_detail).show();
			},
			error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(thrownError); // Munculkan alert error
			}
		});
    });
});
</script>

<!-- Autofill form -->
<script type="text/javascript">    
    <?php echo $jsArray; ?>  
    function changeValue(x){  
      document.getElementById('edit_program').value = prdSubKomponen[x].kode_program + " - " +prdSubKomponen[x].nama_program+ " - " +prdSubKomponen[x].tahun;  
    document.getElementById('edit_kegiatan').value = prdSubKomponen[x].kode_kegiatan + " - " +prdSubKomponen[x].nama_kegiatan;  
    document.getElementById('edit_komponen').value = prdSubKomponen[x].kode_komponen + " - " +prdSubKomponen[x].nama_komponen;  
    }; 
</script> 