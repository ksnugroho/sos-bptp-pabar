<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../login.php');
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Laporan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SOSys</a></li>
          <li class="breadcrumb-item active">Laporan</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-4">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Based On Program - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form name="form1" id="form1" method="post" action="print1.php" target="_blank">
          <div class="card-body">
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                        <label for="program">Program</label>
                        <div class="form-group">
                            <select class="form-control select2bs4" name="program" id="program" style="width: 100%;" required>
                            <option disabled selected>Pilih Program...</option>
                            <?php                  
                                // Buat query untuk menampilkan semua data tabel program
                                $sql = mysqli_query($con, "SELECT * FROM ref_program");

                                while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                                echo "<option value='".$data['kode_program']."'>".$data['kode_program']." - ".$data['nama_program']." - ".$data['tahun']."</option>";
                                }
                            ?>
                            </select>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="tgl_program">Tanggal</label>
                      <input type="date" name="tgl_program" id="tgl_program" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="lap_program">Jenis Laporan</label>
                        <select class="form-control" name="lap_program" id="lap_program" style="width: 100%;" required>
                          <option disabled selected>Pilih Kriteria ...</option>
                          <option value="1">[1] Pembelian</option>
                          <option value="2">[2] Pemakaian</option>
                        </select>
                    </div>
                  </div>
              </div>
          </div>
          <div class="card-footer clearfix">
            <button form="form1" type="submit" class="btn btn-primary float-right"><i class="fas fa-print"></i>&nbsp; Cetak</button>
          </div>
          </form>
          <!-- form end -->
        </div>
      </div>
      <!-- End left column -->

      <!-- center column -->
      <div class="col-md-4">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Based On Komponen - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form name="form2" id="form2" method="post" action="print2.php" target="_blank">
          <div class="card-body">
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                      <label for="komponen">Komponen</label>
                      <div class="form-group">
                          <select class="form-control select2bs4" name="komponen" id="komponen" style="width: 100%;">
                          <option disabled selected>Pilih Komponen...</option>
                          <?php                  
                              // Buat query untuk menampilkan semua data siswa
                              $sql = mysqli_query($con, "SELECT * FROM view_komponen");

                              while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                              echo "<option value='".$data['id_komponen']."'>".$data['kode_komponen']." - ".$data['nama_komponen']."</option>";
                              }
                          ?>
                          </select>
                      </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="tgl_komponen">Tanggal</label>
                      <input type="date" name="tgl_komponen" id="tgl_komponen" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="lap_komponen">Jenis Laporan</label>
                        <select class="form-control" name="lap_komponen" id="lap_komponen" style="width: 100%;">
                          <option disabled selected>Pilih Kriteria ...</option>
                          <option value="1">[1] Pembelian</option>
                          <option value="2">[2] Pemakaian</option>
                        </select>
                    </div>
                  </div>
              </div>
          </div>
          <div class="card-footer clearfix">
            <button form="form2" type="submit" class="btn btn-primary float-right"><i class="fas fa-print"></i>&nbsp; Cetak</button>
          </div>
          </form>
          <!-- form end -->
        </div>
      </div>
      <!-- End center column -->
      
      <!-- right column -->
      <div class="col-md-4">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Based On Sub-Detail - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form name="form3" id="form3" method="post" action="print3.php" target="_blank">
          <div class="card-body">
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                      <label for="subdetail">Sub Detail</label>
                      <div class="form-group">
                          <select class="form-control select2bs4" name="subdetail" id="subdetail" style="width: 100%;">
                          <option disabled selected>Pilih Sub Detail...</option>
                          <?php                  
                              // Buat query untuk menampilkan semua data siswa
                              $sql = mysqli_query($con, "SELECT * FROM view_subdetail");

                              while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                              echo "<option value='".$data['id_subdetail']."'>".$data['kode_subdetail']." - ".$data['nama_subdetail']."</option>";
                              }
                          ?>
                          </select>
                      </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="tgl_subdetail">Tanggal</label>
                      <input type="date" name="tgl_subdetail" id="tgl_subdetail" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="lap_komponen">Jenis Laporan</label>
                        <select class="form-control" name="lap_komponen" id="lap_komponen" style="width: 100%;">
                          <option disabled selected>Pilih Kriteria ...</option>
                          <option value="1">[1] Pembelian</option>
                          <option value="2">[2] Pemakaian</option>
                        </select>
                    </div>
                  </div>
              </div>
          </div>
          <div class="card-footer clearfix">
            <button form="form3" type="submit" class="btn btn-primary float-right"><i class="fas fa-print"></i>&nbsp; Cetak</button>
          </div>
          </form>
          <!-- form end -->
        </div>
      </div>
      <!-- End right column -->
    </div>
  </div>
</section>
<!-- /.content -->


<!-- script select bertingkat -->
<script>
  $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
	// Kita sembunyikan dulu untuk loadingnya
	$("#loading").hide();
	
	$("#subkomponen").change(function(){ // Ketika user mengganti atau memilih data provinsi
		$("#detail").hide(); // Sembunyikan dulu combobox kota nya
		$("#loading").show(); // Tampilkan loadingnya
	
		$.ajax({
			type: "POST", // Method pengiriman data bisa dengan GET atau POST
			url: "referensi/sub-detail/option_detail.php", // Isi dengan url/path file php yang dituju
			data: {subkomponen : $("#subkomponen").val()}, // data yang akan dikirim ke file yang dituju
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
				$("#detail").html(response.data_detail).show();
			},
			error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(thrownError); // Munculkan alert error
			}
		});
    });
});
</script>

<!-- script edit data -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#modal_edit').on('show.bs.modal', function (e) {
            var getDetail = $(e.relatedTarget).data('id');
            /* fungsi AJAX untuk melakukan fetch data */
            $.ajax({
                type : 'POST',
                url : 'referensi/sub-detail/edit-sub-detail.php',
                /* detail per identifier ditampung pada berkas detail.php yang berada di folder application/view */
                data :  'getDetail='+ getDetail,
                /* memanggil fungsi getDetail dan mengirimkannya */
                success : function(data){
                $('.modal-data').html(data);
                /* menampilkan data dalam bentuk dokumen HTML */
                }
            });
         });
    });
</script>

<script type="text/javascript">    
    <?php echo $jsArraySubDetail; ?>  
    function changeValue2(x){  
      document.getElementById('program').value = prdSubDetail[x].kode_program + " - " +prdSubDetail[x].nama_program; 
      document.getElementById('tahun').value = prdSubDetail[x].tahun;
      document.getElementById('kegiatan').value = prdSubDetail[x].kode_kegiatan + " - " +prdSubDetail[x].nama_kegiatan;  
      document.getElementById('komponen').value = prdSubDetail[x].kode_komponen + " - " +prdSubDetail[x].nama_komponen;  
      document.getElementById('sub-komponen').value = prdSubDetail[x].kode_subkomponen + " - " +prdSubDetail[x].nama_subkomponen;  
      document.getElementById('detail').value = prdSubDetail[x].kode_detail + " - " +prdSubDetail[x].nama_detail;  
    }; 
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