<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
  header('location:../../../login.php');
}

// proses tambah data
if ($_POST['add_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $subdetail          = mysqli_real_escape_string($con, $_POST['subdetail']);
  $tanggal_conv       = mysqli_real_escape_string($con, $_POST['tanggal']);
  $tanggal            = date('Y-m-d', strtotime($tanggal_conv));
  $nota                = mysqli_real_escape_string($con, $_POST['nota']);
  $buku                = mysqli_real_escape_string($con, $_POST['buku']);

  $cek_tscpakai    = mysqli_query($con, "SELECT * FROM tsc_beli WHERE no_dokumen='$nota'");
  if (mysqli_num_rows($cek_tscpakai) > 0) {
    echo "
      <script>
      swal({
        title: 'Peringatan',
        text: 'Data dengan dokumen tersebut sudah tersedia',
        type: 'warning',
        showCancelButton: false,
        cancelButtonText: 'No, Cancel!',
        confirmButtonText: 'Oke',
        closeOnConfirm: true
      }, function(isConfirm){
        window.location='index?page=add-pakai'
      });
      </script>";
  } else {
    $add_query      = mysqli_query($con, "INSERT INTO tsc_pakai (id_subdetail, no_dokumen, tgl_pakai, no_buku, id_barang, jml_pakai) 
                       (SELECT '$subdetail','$nota', '$tanggal', '$buku', id_barang_pakai_sementara, jumlah_pakai_sementara FROM tb_pakai_barang_sementara)");

    $min_jumlah     = mysqli_query($con, "UPDATE ref_barang, tb_pakai_barang_sementara SET ref_barang.jumlah= ref_barang.jumlah-tb_pakai_barang_sementara.jumlah_pakai_sementara WHERE ref_barang.id_barang=tb_pakai_barang_sementara.id_barang_pakai_sementara");

    $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menambahkan data riwayat pakai')");

    $kosongkan      = mysqli_query($con, "TRUNCATE TABLE tb_pakai_barang_sementara");
    if ($add_query && $query_log && $min_jumlah && $kosongkan) {

      echo "
      <script>
      swal({
        title: 'Sukses',
        text: 'Data berhasil disimpan',
        type: 'success',
        showCancelButton: false,
        cancelButtonText: 'No, Cancel!',
        confirmButtonText: 'Oke',
        closeOnConfirm: true
      }, function(isConfirm){
        window.location='index?page=pakai'
      });
      </script>";
    } else {
      echo "
      <script>
      swal({
        title: 'Error',
        text: 'Data gagal disimpan',
        type: 'error',
        showCancelButton: false,
        cancelButtonText: 'No, Cancel!',
        confirmButtonText: 'Oke',
        closeOnConfirm: true
      }, function(isConfirm){
        window.location='index?page=add-pakai'
      });
      </script>";
    }
  }
}

//proses kosongkan table
if ($_POST['truncate_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE tb_pakai_barang_sementara");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel data barang pakai')");
  if ($truncate_query && $query_log) {
    echo "
      <script>
      swal({
          title: 'Sukses',
          text: 'Tabel berhasil dikosongkan',
          type: 'success',
          showCancelButton: false,
          cancelButtonText: 'No, Cancel!',
          confirmButtonText: 'Oke',
          closeOnConfirm: true
        }, function(isConfirm){
          window.location='index.php?page=add-pakai'
        });
      </script>";
  } else {
    echo "
      <script>
        swal({
          title: 'Error',
          text: 'Tabel gagal dikosongkan',
          type: 'error',
          showCancelButton: false,
          cancelButtonText: 'No, Cancel!',
          confirmButtonText: 'Oke',
          closeOnConfirm: true
        }, function(isConfirm){
          window.location='index.php?page=add-pakai'
        });
      </script>";
  }
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Transaksi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SOSys</a></li>
          <li class="breadcrumb-item active">Data Transkasi</li>
          <li class="breadcrumb-item active">Pemakaian (Out)</li>
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
      <section class="col-lg-5 connectedSortable ui-sortable">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Pilih Barang - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form method="post" class="form-data" id="form-data">
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <!-- <select class="form-control select2bs4" style="width: 100%;" name="barang" id="barang" onchange="changeValue(this.value)"> -->
                    <select class="form-control select2bs4" style="width: 100%;" name="barang" id="barang" onchange="cek_barang()">
                      <option disabled selected>Pilih barang...</option>

                    </select>
                    <div id="loading" name="loading" style="margin-top: 15px;">
                      <img src="../assets/images/loading.gif" width="18"> <small>Loading...</small>
                    </div>
                    <span class="text-danger" id="err_barang"></span>
                    <span class="text-danger" id="err_satuan"></span>
                  </div>
                </div>
                <div class="col-md-2">
                  <input type="text" name="jumlahBarang" id="jumlahBarang" placeholder="Jumlah" class="form-control" maxlength="11" readonly>
                </div>
                <div class="col-md-2">
                  <input type="text" name="satuan" id="satuan" placeholder="Satuan" class="form-control" maxlength="11" readonly>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" name="jumlah" id="jumlah" placeholder="Jumlah Barang" class="form-control" maxlength="11" required>
                    <span class="text-danger" id="err_jumlah"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer clearfix">
              <div class="row">
                <div class="col-md-7">
                  <span class="text-danger" id="err_jumlahbarang"></span>
                </div>
                <div class="col-md-5">
                  <a class="btn btn-primary btn-sm tombol-tambah" name="tambah" style="float: right; color: white;"><i class="fas fa-plus"></i>&nbsp; Tambah</a>
                  <!-- <button class="btn btn-primary btn-sm" name="tambah" id="tambah" style="float: right;"><i class="fas fa-plus"></i>&nbsp; Tambah</button> -->
                </div>
              </div>
            </div>
          </form>
        </div> <!-- Daftar Barang  - BPTP Papua Barat -->

        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; List Referensi - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label for="program">Program</label>
                  <input type="text" name="program" id="program" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <label for="tahun">Tahun</label>
                <input type="text" name="tahun" id="tahun" class="form-control" readonly>
              </div>
              <div class="col-md-12">
                <label for="kegiatan">Kegiatan</label>
                <input type="text" name="kegiatan" id="kegiatan" class="form-control" readonly>
              </div>
              <div class="col-md-12">
                <label for="komponen">Komponen</label>
                <input type="text" name="komponen" id="komponen" class="form-control" readonly>
              </div>
              <div class="col-md-12">
                <label for="sub-komponen">Sub-Komponen</label>
                <input type="text" name="sub-komponen" id="sub-komponen" class="form-control" readonly>
              </div>
              <div class="col-md-12">
                <label for="detail">Detail</label>
                <input type="text" name="detail" id="detail" class="form-control" readonly>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Right column -->
      <section class="col-lg-7 connectedSortable ui-sortable">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Detail Pemakaian - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <div class="card-body">
            <form method="post" action="" id="add_form">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="subdetail">Sub Detail<span class="text-danger"><b> *</b></span></label>
                    <div class="form-group">
                      <select class="form-control select2bs4" name="subdetail" id="subdetail" style="width: 100%;" onchange="changeValue2(this.value)">
                        <option disabled selected>Pilih Sub Detail...</option>
                        <?php
                        // Buat query untuk menampilkan semua data siswa
                        $sql = mysqli_query($con, "SELECT * FROM view_subdetail");
                        $jsArraySubDetail = "var prdSubDetail = new Array();\n";

                        while ($data = mysqli_fetch_array($sql)) { // Ambil semua data dari hasil eksekusi $sql
                          echo "<option value='" . $data['id_subdetail'] . "'>" . $data['kode_subdetail'] . " - " . $data['nama_subdetail'] . "</option>";
                          $jsArraySubDetail .= "prdSubDetail['" . $data['id_subdetail'] . "'] = {kode_program:'" . addslashes($data['kode_program']) . "', nama_program:'" . addslashes($data['nama_program']) . "', tahun:'" . addslashes($data['tahun']) . "', kode_kegiatan:'" . addslashes($data['kode_kegiatan']) . "', nama_kegiatan:'" . addslashes($data['nama_kegiatan']) . "', kode_komponen:'" . addslashes($data['kode_komponen']) . "', nama_komponen:'" . addslashes($data['nama_komponen']) . "', kode_subkomponen:'" . addslashes($data['kode_subkomponen']) . "', nama_subkomponen:'" . addslashes($data['nama_subkomponen']) . "', kode_detail:'" . addslashes($data['kode_detail']) . "', nama_detail:'" . addslashes($data['nama_detail']) . "'};\n";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal">Tanggal<span class="text-danger"><b> *</b></span></label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nota">No Dokumen<span class="text-danger"><b> *</b></span></label>
                    <input type="text" name="nota" id="nota" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <?php
                  $buku = mysqli_fetch_array(mysqli_query($con, "SELECT max(no_buku) as max_buku FROM tsc_pakai"));
                  $max_buku = $buku['max_buku'];

                  $urutan_buku = (int)$max_buku;
                  $urutan_buku++;

                  $no_buku = sprintf("%05s", $urutan_buku);
                  ?>

                  <div class="form-group">
                    <label for="buku">No Buku</label>
                    <input type="text" name="buku" id="buku" class="form-control" value="<?= $no_buku ?>" readonly>
                  </div>
                </div>
              </div>
            </form>
            <div class="tampildata"></div>

          </div>
          <div class="card-footer clearfix">
            <!-- <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_tambah"><i class="fas fa-plus"></i>&nbsp; Tambah Data</button> -->
            <div class="row">
              <div class="col-md-3"><a href="index?page=trun-pakai" class="btn btn-danger" style="margin-top: 3px;"><i class="fas fa-times"></i>&nbsp; Batal</a></div>
              <div class="col-md-3 tampiltombolsimpan"></div>
              <div class="col-md-6"><button class="btn btn-outline-danger" data-toggle="modal" data-target="#modal_truncate" style="margin-top: 3px;"><i class="fas fa-trash"></i> &nbsp; Bersihkan Semua</button></div>
            </div>
          </div>
        </div>
      </section> <!-- class="col-lg-7 connectedSortable ui-sortable" -->

    </div>
  </div>
</section>
<!-- /.content -->

<!-- Modal Popup truncate-->
<div id="modal_truncate" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100">Apakah anda yakin mengosongkan tabel ini?</h4>
      </div>
      <div class="modal-body">
        <p align="center">Anda akan menghapus SELURUH data <b>BARANG</b>. Peringatan! data yang telah dihapus tidak dapat dikembalikan.</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal"><i class="fas fa-arrow-left"></i> Kembali</button>
        <form method="post">
          <button type="submit" name="truncate_data" value="truncate_data" class="btn btn-outline-light"><i class="fas fa-trash"></i> Kosongkan Tabel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- select2 -->
<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>

<!-- Autofill form -->
<script type="text/javascript">
  function cek_barang() {
    var barang = $("#barang").val();
    $.ajax({
      url: 'transaksi/pakai-out/cek_data_barang.php',
      data: "barang=" + barang,
      success: function(data) {
        var json = data,
          obj = JSON.parse(json);
        $('#jumlahBarang').val(obj.jumlah);
        $('#satuan').val(obj.satuan);
      }
    });
  }
</script>

<script type="text/javascript">
  <?php echo $jsArraySubDetail; ?>

  function changeValue2(x) {
    document.getElementById('program').value = prdSubDetail[x].kode_program + " - " + prdSubDetail[x].nama_program;
    document.getElementById('tahun').value = prdSubDetail[x].tahun;
    document.getElementById('kegiatan').value = prdSubDetail[x].kode_kegiatan + " - " + prdSubDetail[x].nama_kegiatan;
    document.getElementById('komponen').value = prdSubDetail[x].kode_komponen + " - " + prdSubDetail[x].nama_komponen;
    document.getElementById('sub-komponen').value = prdSubDetail[x].kode_subkomponen + " - " + prdSubDetail[x].nama_subkomponen;
    document.getElementById('detail').value = prdSubDetail[x].kode_detail + " - " + prdSubDetail[x].nama_detail;
  };
</script>

<!-- javascript add sementara -->
<script type="text/javascript">
  $(document).ready(function() {
    $('.tampildata').load("transaksi/pakai-out/tampil-barang-pakai.php");
    $('.tampiltombolsimpan').load("transaksi/pakai-out/tampil-tombol-simpan.php");
    $(".tombol-tambah").click(function() {
      var data = $('.form-data').serialize();
      var barang = document.getElementById("barang").value;
      var jumlahbrg = document.getElementById("jumlahBarang").value; // placeholder="Jumlah"
      var satuan = document.getElementById("satuan").value;
      var jumlah = document.getElementById("jumlah").value; // placholder="Jumlah Barang"

      if (barang == "") {
        document.getElementById("err_barang").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> &nbsp; Barang Harus Diisi";
      } else {
        document.getElementById("err_barang").innerHTML = "";
      }

      if (satuan == "") {
        document.getElementById("err_satuan").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> &nbsp; Satuan Harus Diisi";
      } else {
        document.getElementById("err_satuan").innerHTML = "";
      }

      if (jumlah == "") {
        document.getElementById("err_jumlah").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> &nbsp; Jumlah Harus Diisi";
      } else {
        document.getElementById("err_jumlah").innerHTML = "";
      }

      if (jumlah > jumlahbrg) {
        document.getElementById("err_jumlahbarang").innerHTML = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> &nbsp; Jumlah barang melebihi stock yang tersedia";
        setTimeout(function() {
          $('#err_jumlahbarang').fadeOut('fast');
          document.getElementById("barang").value = "";
          document.getElementById("jumlahBarang").value = "";
          document.getElementById("satuan").value = "";
          document.getElementById("jumlah").value = "";
        }, 1000);
      } else {
        document.getElementById("err_jumlahbarang").innerHTML = "";
        setTimeout(function() {
          document.getElementById("barang").value = "";
          document.getElementById("jumlahBarang").value = "";
          document.getElementById("satuan").value = "";
          document.getElementById("jumlah").value = "";
        }, 1000);
      }

      if (barang != "" && satuan != "" && jumlah != "") {
        $.ajax({
          type: 'POST',
          url: "transaksi/pakai-out/add-barang-pakai.php",
          data: data,
          success: function() {
            $('.tampildata').load("transaksi/pakai-out/tampil-barang-pakai.php");
            $('.tampiltombolsimpan').load("transaksi/pakai-out/tampil-tombol-simpan.php");
          }
        });
      }
    });
  });
</script>

<!-- select bertingkat subdetail to barang -->
<script>
  $(document).ready(function() { // Ketika halaman sudah siap (sudah selesai di load)
    // Kita sembunyikan dulu untuk loadingnya
    $("#loading").hide();

    $("#subdetail").change(function() { // Ketika user mengganti atau memilih data provinsi
      $("#barang").hide(); // Sembunyikan dulu combobox kota nya
      $("#loading").show(); // Tampilkan loadingnya

      $.ajax({
        type: "POST", // Method pengiriman data bisa dengan GET atau POST
        url: "transaksi/pakai-out/subdetai2barang.php", // Isi dengan url/path file php yang dituju
        data: {
          subdetail: $("#subdetail").val()
        }, // data yang akan dikirim ke file yang dituju
        dataType: "json",
        beforeSend: function(e) {
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response) { // Ketika proses pengiriman berhasil
          $("#loading").hide(); // Sembunyikan loadingnya

          // set isi dari combobox kota
          // lalu munculkan kembali combobox kotanya
          $("#barang").html(response.data_barang).show();
          document.getElementById("jumlahBarang").value = "";
          document.getElementById("satuan").value = "";
          document.getElementById("jumlah").value = "";
        },
        error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
          alert(thrownError); // Munculkan alert error
        }
      });
    });
  });
</script>