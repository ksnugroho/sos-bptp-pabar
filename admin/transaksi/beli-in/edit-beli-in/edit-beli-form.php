<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
  header('location:../../../login');
}

// proses tambah data
if ($_POST['add_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $subdetail          = mysqli_real_escape_string($con, $_POST['subdetail']);
  $tanggal_conv       = mysqli_real_escape_string($con, $_POST['tanggal']);
  $tanggal            = date('Y-m-d', strtotime($tanggal_conv));
  $agen               = mysqli_real_escape_string($con, $_POST['agen']);
  $nota               = mysqli_real_escape_string($con, $_POST['nota']);
  $buku               = mysqli_real_escape_string($con, $_POST['buku']);

  $cek_subdetail    = mysqli_query($con, "SELECT * FROM tsc_beli WHERE no_dokumen='$nota'");
  if (mysqli_num_rows($cek_subdetail) > 0) {
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
        window.location='index?page=add-beli'
      });
      </script>";
  } else {
    // cek id_agen
    $id_agen  = mysqli_query($con, "SELECT id_agen FROM ref_agen WHERE id_agen='$agen'");
    $cek_id_agen = mysqli_num_rows($id_agen);

    if ($cek_id_agen == 0) {
      // add new agen
      $kode = mysqli_fetch_array(mysqli_query($con, "SELECT max(kode_agen) as max_kode FROM ref_agen"));
      $max_kode = $kode['max_kode'];

      $urutan_kode = (int)$max_kode;
      $urutan_kode++;

      $kode_agen = sprintf("%05s", $urutan_kode);
      $add_agen = mysqli_query($con, "INSERT INTO ref_agen VALUES (NULL, '$kode_agen', '$agen', '-', '-')");

      $new_id_agen = mysqli_fetch_array(mysqli_query($con, "SELECT id_agen FROM ref_agen WHERE kode_agen='$kode_agen'"));
      $add_new_id_agen = $new_id_agen['id_agen'];

      $add_query      = mysqli_query($con, "INSERT INTO tsc_beli (id_subdetail, no_dokumen, tgl_beli, no_buku, id_barang, id_agen, jml_beli, harga) 
                      (SELECT '$subdetail','$nota', '$tanggal', '$buku', id_barang_sementara, '$add_new_id_agen', jumlah_sementara, harga_sementara FROM tb_barang_sementara)");
    } else {
      $add_query      = mysqli_query($con, "INSERT INTO tsc_beli (id_subdetail, no_dokumen, tgl_beli, no_buku, id_barang, id_agen, jml_beli, harga) 
      (SELECT '$subdetail','$nota', '$tanggal', '$buku', id_barang_sementara, '$agen', jumlah_sementara, harga_sementara FROM tb_barang_sementara)");
    }


    $add_jumlah     = mysqli_query($con, "UPDATE ref_barang, tb_barang_sementara SET ref_barang.jumlah= ref_barang.jumlah+tb_barang_sementara.jumlah_sementara WHERE ref_barang.id_barang=tb_barang_sementara.id_barang_sementara");

    $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menambahkan data riwayat beli')");

    $kosongkan      = mysqli_query($con, "TRUNCATE TABLE tb_barang_sementara");
    if ($add_query && $query_log && $add_jumlah && $kosongkan) {
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
        window.location='index?page=beli'
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
        window.location='index?page=add-beli'
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

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE tb_barang_sementara");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel data barang beli')");
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
          window.location='index.php?page=add-beli'
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
          window.location='index.php?page=add-beli'
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
          <li class="breadcrumb-item active">Pembelian (In)</li>
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
                    <select class="form-control select2bs4" style="width: 100%;" name="barang" id="barang" onchange="changeValue(this.value)">
                      <option disabled selected>Pilih Barang</option>
                      <?php
                      // Buat query untuk menampilkan semua data siswa
                      $sql = mysqli_query($con, "SELECT * FROM view_barang");
                      $jsArray = "var prdBarang = new Array();\n";

                      while ($data = mysqli_fetch_array($sql)) { // Ambil semua data dari hasil eksekusi $sql
                        echo "<option value='" . $data['id_barang'] . "'>" . $data['kode_barang'] . " - " . $data['nama_barang'] . "</option>";
                        $jsArray .= "prdBarang['" . $data['id_barang'] . "'] = {nama_satuan:'" . addslashes($data['nama_satuan']) . "', jumlah:'" . addslashes($data['jumlah']) . "'};\n";
                      }
                      ?>
                    </select>
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
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" name="harga" id="harga" placeholder="Harga Satuan" class="form-control" required>
                    <span class="text-danger" id="err_harga"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer clearfix">
              <div class="row">
                <div class="col-md-7">

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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Detail Pembelian - BPTP Papua Barat</h3>
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
                        <option disabled selected>Pilih Sub Detail</option>
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

                  <div class="form-group">
                    <label for="agen">Agen</label>
                    <div class="form-group">
                      <select class="form-control select2bs4" name="agen" id="agen" style="width: 100%;">
                        <option disabled selected>Pilih agen...</option>
                        <?php
                        // Buat query untuk menampilkan semua data siswa
                        $sql = mysqli_query($con, "SELECT * FROM ref_agen");

                        while ($data = mysqli_fetch_array($sql)) { // Ambil semua data dari hasil eksekusi $sql
                          echo "<option value='" . $data['id_agen'] . "'>" . $data['kode_agen'] . " - " . $data['nama_agen'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nota">No Dokumen<span class="text-danger"><b> *</b></span></label>
                    <input type="text" name="nota" id="nota" class="form-control" required>
                  </div>

                  <?php
                  $buku = mysqli_fetch_array(mysqli_query($con, "SELECT max(no_buku) as max_buku FROM tsc_beli"));
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
            <a href="index?page=trun-beli" class="btn btn-danger"><i class="fas fa-times"></i>&nbsp; Batal</a>
            <button form="add_form" id="add_data" name="add_data" value="add_data" type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp; Simpan</button>
            <button class="btn btn-outline-danger float-right" data-toggle="modal" data-target="#modal_truncate"><i class="fas fa-trash"></i> &nbsp; Bersihkan Semua</button>
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
      theme: 'bootstrap4',
      tags: true
    })
  })
</script>

<!-- Autofill form -->
<script type="text/javascript">
  <?php echo $jsArray; ?>

  function changeValue(x) {
    document.getElementById('satuan').value = prdBarang[x].nama_satuan;
    document.getElementById('jumlahBarang').value = prdBarang[x].jumlah;
  };
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
    $('.tampildata').load("transaksi/beli-in/tampil_barang.php");
    $(".tombol-tambah").click(function() {
      var data = $('.form-data').serialize();
      var barang = document.getElementById("barang").value;
      var satuan = document.getElementById("satuan").value;
      var jumlah = document.getElementById("jumlah").value;
      var harga = document.getElementById("harga").value;

      if (barang == "") {
        document.getElementById("err_barang").innerHTML = "Barang Harus Diisi";
      } else {
        document.getElementById("err_barang").innerHTML = "";
      }
      if (satuan == "") {
        document.getElementById("err_satuan").innerHTML = "Satuan Harus Diisi";
      } else {
        document.getElementById("err_satuan").innerHTML = "";
      }
      if (jumlah == "") {
        document.getElementById("err_jumlah").innerHTML = "Jumlah Harus Diisi";
      } else {
        document.getElementById("err_jumlah").innerHTML = "";
      }
      if (harga == "") {
        document.getElementById("err_harga").innerHTML = "Harga Harus Diisi";
      } else {
        document.getElementById("err_harga").innerHTML = "";
      }

      if (barang != "" && satuan != "" && jumlah != "" && harga != "") {
        $.ajax({
          type: 'POST',
          url: "transaksi/beli-in/add_barang.php",
          data: data,
          success: function() {
            $('.tampildata').load("transaksi/beli-in/tampil_barang.php");
          }
        });
      }
    });
  });
</script>

<!-- mask uang -->
<script type="text/javascript">
  var rupiah2 = document.getElementById("harga");
  rupiah2.addEventListener("keyup", function(e) {
    rupiah2.value = convertRupiah(this.value, "Rp. ");
  });
  rupiah2.addEventListener('keydown', function(event) {
    return isNumberKey(event);
  });

  function convertRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
  }

  function isNumberKey(evt) {
    key = evt.which || evt.keyCode;
    if (key != 188 // Comma
      &&
      key != 8 // Backspace
      &&
      key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
      &&
      (key < 48 || key > 57) // Non digit
    ) {
      evt.preventDefault();
      return;
    }
  }
</script>