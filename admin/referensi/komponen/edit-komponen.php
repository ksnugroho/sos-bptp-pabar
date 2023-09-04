<?php
include '../../../koneksi/koneksi.php';

if($_POST['getDetail']) {
    $id = $_POST['getDetail'];
    // echo $id;
    $sql = mysqli_query($con, "SELECT * from view_komponen where id_komponen='$id'");
    while ($row = mysqli_fetch_array($sql)){       
?>
<form id="edit_data" action="" method="post">
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label for="edit_program">Pilih Program*</label>
            <select name="edit_program" id="edit_program" class="form-control select2bs4">
                <option disabled>Pilih Program</option>
                <?php 
                    $sql=mysqli_query($con, "SELECT * FROM ref_program ORDER BY id_program");
                    while ($data=mysqli_fetch_array($sql)) {
                        if ($data['nama_program']==$row['nama_program']) {
                            $select="selected";
                        }else{
                            $select="";
                        }
                    
                    echo '<option value="' . $data['id_program'] . '" '.$select.'>' . $data['kode_program'] .' - ' . $data['nama_program'] . '</option>';  
                    }
                ?>
            </select>
            </div>
            <div class="form-group">
            <label for="edit_kegiatan">Pilih Kegiatan*</label>
            <select name="edit_kegiatan" id="edit_kegiatan" class="form-control select2bs4">
                <option disabled>Pilih kegiatan</option>
                <?php 
                    $sql=mysqli_query($con, "SELECT * FROM view_kegiatan WHERE kode_program = '$row[kode_program]' ORDER BY id_kegiatan");
                    while ($data=mysqli_fetch_array($sql)) {
                        if ($data['nama_kegiatan']==$row['nama_kegiatan']) {
                            $select="selected";
                        }else{
                            $select="";
                        }
                    
                    echo '<option value="' . $data['id_kegiatan'] . '" '.$select.'>' . $data['kode_kegiatan'] .' - ' . $data['nama_kegiatan'] . '</option>';  
                    }
                ?>
            </select>

            <div id="loading" style="margin-top: 15px;">
                <img src="../assets/images/loading.gif" width="18"> <small>Loading...</small>
            </div>
            </div>
        </div>
        <div class="col-md-6">
        <form id="add_form" action="" method="post">
            <div class="form-group">
            <label for="edit_kd_komponen">Kode Komponen*</label>
            <input type="hidden" name="edit_id_komponen" id="edit_id_komponen" class="form-control" value="<?php echo $row['id_komponen']; ?>" required>
            <input type="text" name="edit_kd_komponen" id="edit_kd_komponen" class="form-control" value="<?php echo $row['kode_komponen']; ?>" required>
            </div>
            <div class="form-group">
            <label for="edit_komponen">Nama Komponen*</label>
            <input type="text" name="edit_komponen" id="edit_komponen" class="form-control" value="<?php echo $row['nama_komponen']; ?>" required>
            </div>
        </div>
    </div>
    
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-arrow-left"></i>&nbsp; Kembali</button>
    <!-- <button form="edit_form" id="edit_data" name="edit_data" value="edit_data" type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbspSimpan</button>   -->
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
	
	$("#edit_program").change(function(){ // Ketika user mengganti atau memilih data provinsi
		$("#edit_kegiatan").hide(); // Sembunyikan dulu combobox kota nya
		$("#loading").show(); // Tampilkan loadingnya
	
		$.ajax({
			type: "POST", // Method pengiriman data bisa dengan GET atau POST
			url: "referensi/komponen/option_kegiatan.php", // Isi dengan url/path file php yang dituju
			data: {program : $("#edit_program").val()}, // data yang akan dikirim ke file yang dituju
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
				$("#edit_kegiatan").html(response.data_kegiatan).show();
			},
			error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(thrownError); // Munculkan alert error
			}
		});
    });
});
</script>

  <!-- select2 -->
  <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>