<?php
include '../../../koneksi/koneksi.php';

if($_POST['getDetail']) {
    $id = $_POST['getDetail'];
    // echo $id;
    $sql = mysqli_query($con, "SELECT * from view_detail where id_detail='$id'");
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

            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_komponen">Pilih Komponen*</label>
                    <select name="edit_komponen" id="edit_komponen" class="form-control" onchange="changeValue(this.value)">
                        <option disabled selected>Pilih Komponen</option>
                        
                        <?php                  
                        // Buat query untuk menampilkan semua data siswa
                        $sql = mysqli_query($con, "SELECT * FROM view_komponen ORDER BY id_komponen");
                        $jsArray = "var prdKomponen = new Array();\n";

                        while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                            if ($data['nama_komponen']==$row['nama_komponen']) {
                                $select="selected";
                            }else{
                                $select="";
                            }

                            echo '<option value="' . $data['id_komponen'] . '" '.$select.'>' . $data['kode_komponen'] .' - ' . $data['nama_komponen'] . '</option>'; 
                            $jsArray .= "prdKomponen['" . $data['id_komponen'] . "'] = {nama_program:'" . addslashes($data['nama_program']) . "', kode_program:'".addslashes($data['kode_program'])."', tahun:'".addslashes($data['tahun'])."', nama_kegiatan:'" . addslashes($data['nama_kegiatan']) . "', kode_kegiatan:'".addslashes($data['kode_kegiatan'])."'};\n";
                        }
                        ?>
                    </select>
                </div>
                <!-- <br> -->
                <div class="form-group">
                    <label for="edit_subkomponen">Pilih Sub Komponen*</label>
                    <select name="edit_subkomponen" id="edit_subkomponen" class="form-control" required>
                        <option disabled>Pilih Sub Komponen</option>
                        <?php 
                            $sql=mysqli_query($con, "SELECT * FROM view_subkomponen WHERE kode_komponen = '$row[kode_komponen]' ORDER BY id_subkomponen");
                            while ($data=mysqli_fetch_array($sql)) {
                                if ($data['nama_subkomponen']==$row['nama_subkomponen']) {
                                    $select="selected";
                                }else{
                                    $select="";
                                }
                            
                            echo '<option value="' . $data['id_subkomponen'] . '" '.$select.'>' . $data['kode_subkomponen'] .' - ' . $data['nama_subkomponen'] . '</option>';  
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
                    <label for="edit_kd_detail">Kode Detail*</label>
                    <input type="hidden" name="edit_id_detail" id="edit_id_detail" class="form-control" value="<?php echo $row['id_detail']; ?>" required>
                    <input type="text" name="edit_kd_detail" id="edit_kd_detail" class="form-control" value="<?php echo $row['kode_detail']; ?>" required>
                    <!-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="ganti_kode" name="ganti_kode" value="ganti">
                        <label class="form-check-label" for="ganti_kode">Silahkan dicentang, jika ingin memperbarui Kode.</label>
                    </div> -->
                </div>
                <div class="form-group">
                    <label for="edit_nama_detail">Nama Detail*</label>
                    <input type="text" name="edit_nama_detail" id="edit_nama_detail" class="form-control" value="<?php echo $row['nama_detail']; ?>" required>
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
	
	$("#edit_komponen").change(function(){ // Ketika user mengganti atau memilih data provinsi
		$("#edit_subkomponen").hide(); // Sembunyikan dulu combobox kota nya
		$("#loading").show(); // Tampilkan loadingnya
	
		$.ajax({
			type: "POST", // Method pengiriman data bisa dengan GET atau POST
			url: "referensi/detail/option_subkomponen.php", // Isi dengan url/path file php yang dituju
			data: {komponen : $("#edit_komponen").val()}, // data yang akan dikirim ke file yang dituju
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
				$("#edit_subkomponen").html(response.data_subkomponen).show();
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
      document.getElementById('edit_program').value = prdKomponen[x].kode_program + " - " +prdKomponen[x].nama_program+ " - " +prdKomponen[x].tahun;  
    document.getElementById('edit_kegiatan').value = prdKomponen[x].kode_kegiatan + " - " +prdKomponen[x].nama_kegiatan;  
    }; 
</script> 