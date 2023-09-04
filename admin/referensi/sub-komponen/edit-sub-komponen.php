<?php
include '../../../koneksi/koneksi.php';

if($_POST['getDetail']) {
    $id = $_POST['getDetail'];
    // echo $id;
    $sql = mysqli_query($con, "SELECT * from view_subkomponen where id_subkomponen='$id'");
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

            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_kegiatan">Pilih Kegiatan*</label>
                    <select name="edit_kegiatan" id="edit_kegiatan" class="form-control" onchange="changeValue(this.value)">
                        <option disabled selected>Pilih Kegiatan</option>
                        
                        <?php                  
                        // Buat query untuk menampilkan semua data siswa
                        $sql = mysqli_query($con, "SELECT * FROM view_kegiatan ORDER BY id_kegiatan");
                        $jsArray = "var prdProgram = new Array();\n";

                        while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                            if ($data['nama_kegiatan']==$row['nama_kegiatan']) {
                                $select="selected";
                            }else{
                                $select="";
                            }

                            echo '<option value="' . $data['id_kegiatan'] . '" '.$select.'>' . $data['kode_kegiatan'] .' - ' . $data['nama_kegiatan'] . '</option>'; 
                            $jsArray .= "prdProgram['" . $data['id_kegiatan'] . "'] = {nama_program:'" . addslashes($data['nama_program']) . "', kode_program:'".addslashes($data['kode_program'])."', tahun:'".addslashes($data['tahun'])."'};\n";
                        }
                        ?>
                    </select>
                </div>
                <!-- <br> -->
                <div class="form-group">
                    <label for="edit_komponen">Pilih Komponen*</label>
                    <select name="edit_komponen" id="edit_komponen" class="form-control">
                        <option disabled>Pilih Komponen</option>
                        <?php 
                            $sql=mysqli_query($con, "SELECT * FROM view_komponen WHERE kode_kegiatan = '$row[kode_kegiatan]' ORDER BY id_komponen");
                            while ($data=mysqli_fetch_array($sql)) {
                                if ($data['nama_komponen']==$row['nama_komponen']) {
                                    $select="selected";
                                }else{
                                    $select="";
                                }
                            
                            echo '<option value="' . $data['id_komponen'] . '" '.$select.'>' . $data['kode_komponen'] .' - ' . $data['nama_komponen'] . '</option>';  
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
                    <label for="edit_kd_subkomponen">Kode Sub-Komponen*</label>
                    <input type="hidden" name="edit_id_subkomponen" id="edit_id_subkomponen" class="form-control" value="<?php echo $row['id_subkomponen']; ?>" required>
                    <input type="text" name="edit_kd_subkomponen" id="edit_kd_subkomponen" class="form-control" value="<?php echo $row['kode_subkomponen']; ?>" required>
                    <!-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="ganti_kode" name="ganti_kode" value="ganti">
                        <label class="form-check-label" for="ganti_kode">Silahkan dicentang, jika ingin memperbarui Kode.</label>
                    </div> -->
                </div>
                <div class="form-group">
                    <label for="edit_nama_subkomponen">Nama Sub-Komponen*</label>
                    <input type="text" name="edit_nama_subkomponen" id="edit_nama_subkomponen" class="form-control" value="<?php echo $row['nama_subkomponen']; ?>" required>
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
	
	$("#edit_kegiatan").change(function(){ // Ketika user mengganti atau memilih data provinsi
		$("#edit_komponen").hide(); // Sembunyikan dulu combobox kota nya
		$("#loading").show(); // Tampilkan loadingnya
	
		$.ajax({
			type: "POST", // Method pengiriman data bisa dengan GET atau POST
			url: "referensi/sub-komponen/option_komponen.php", // Isi dengan url/path file php yang dituju
			data: {kegiatan : $("#edit_kegiatan").val()}, // data yang akan dikirim ke file yang dituju
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
				$("#edit_komponen").html(response.data_komponen).show();
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
      document.getElementById('edit_program').value = prdProgram[x].kode_program + " - " +prdProgram[x].nama_program+ " - " +prdProgram[x].tahun;  
    }; 
</script> 