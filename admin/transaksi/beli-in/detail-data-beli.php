<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
  header('location:../login');
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
  $hari = array(
    1 =>    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split     = explode('-', $tanggal);
  $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

  if ($cetak_hari) {
    $num = date('N', strtotime($tanggal));
    return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}

$no_dokumen = base64_decode($_GET['no_dokumen']);

//proses hapus data
if (isset($_GET['del'])) {
  $user_login   = $_SESSION['user'];
  $datestamp    = date('Y-m-d');
  $waktustamp   = date('H:i:s');

  $no_dokumen   = base64_decode($_GET['del']);

  $barang_query = mysqli_query($con, "SELECT id_barang, jml_beli FROM tsc_beli WHERE no_dokumen='$no_dokumen'");
  while ($barang = mysqli_fetch_array($barang_query)) {
    $min_barang = mysqli_query($con, "UPDATE ref_barang SET jumlah = (SELECT jumlah-$barang[jml_beli] FROM ref_barang WHERE id_barang=$barang[id_barang]) WHERE id_barang=$barang[id_barang]");


    $delete_query = mysqli_query($con, "DELETE FROM tsc_beli WHERE no_dokumen='$no_dokumen'");
    $query_log    = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menghapus data pembelian')");
    if ($min_barang && $delete_query && $query_log) {
      echo "
      <script>
      swal({
          title: 'Sukses',
          text: 'Data berhasil dihapus',
          type: 'success',
          showCancelButton: false,
          cancelButtonText: 'No, Cancel!',
          confirmButtonText: 'Oke',
          closeOnConfirm: true
        }, function(isConfirm){
          window.location='index.php?page=beli'
        });
      </script>";
    } else {
      echo "
      <script>
        swal({
          title: 'Error',
          text: 'Data gagal dihapus',
          type: 'error',
          showCancelButton: false,
          cancelButtonText: 'No, Cancel!',
          confirmButtonText: 'Oke',
          closeOnConfirm: true
        }, function(isConfirm){
          window.location='index.php?page=beli'
        });
      </script>";
    }
  }
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Transkasi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SOSys</a></li>
          <li class="breadcrumb-item active">Data Transkasi</li>
          <li class="breadcrumb-item active">Pembelian (In)</li>
          <li class="breadcrumb-item active">Detail</li>
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
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Detail Pembelian - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <?php
                $sql_beli = mysqli_query($con, "SELECT * FROM view_tsc_beli WHERE no_dokumen='$no_dokumen'") or die(mysqli_error($con));
                $row_beli = mysqli_fetch_array($sql_beli)
                ?>
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> No. Dokumen:&nbsp;<?= $no_dokumen ?>
                    <small class="float-right">Tanggal Pembelian: <?= tanggal_indo($row_beli['tgl_beli'], true) ?></small>
                  </h4>
                </div>
              </div>

              <br>
              <div class="row invoice-info">
                <div class="col-sm-7 invoice-col">
                  <strong class="text-blue">Informasi Program & Kegiatan</strong>
                  <address>
                    <strong>Program:</strong> <?= $row_beli['kode_program'] . " - " . $row_beli['nama_program'] . " (" . $row_beli['tahun'] . ")" ?><br>
                    <strong>Kegiatan:</strong> <?= $row_beli['kode_kegiatan'] . " - " . $row_beli['nama_kegiatan'] ?><br>
                    <strong>Komponen:</strong> <?= $row_beli['kode_komponen'] . " - " . $row_beli['nama_komponen'] ?><br>
                    <strong>Sub Komponen:</strong> <?= $row_beli['kode_subkomponen'] . " - " . $row_beli['nama_subkomponen'] ?><br>
                    <strong>Detail:</strong> <?= $row_beli['kode_detail'] . " - " . $row_beli['nama_detail'] ?><br>
                    <strong>Sub Detail:</strong> <?= $row_beli['kode_subdetail'] . " - " . $row_beli['nama_subdetail'] ?>
                  </address>
                </div>

                <div class="col-sm-5 invoice-col">
                  <strong class="text-blue">Informasi Agen (Distributor)</strong>
                  <address>
                    <strong>Nama Agen:</strong> <?= $row_beli['nama_agen'] ?><br>
                    <strong>Alamat:</strong> <?= $row_beli['alamat'] ?><br>
                    <strong>No. Telepon:</strong> <?= $row_beli['no_tlpn'] ?>
                  </address>
                </div>

              </div>
              <br>

              <div class="col-12 table-responsive">
                <table class="table table-sm">
                  <thead class="thead-light">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th class="text-center align-middle">Kode Barang</th>
                      <th class="text-center align-middle">Nama Barang</th>
                      <th class="text-center align-middle">Harga Satuan</th>
                      <th class="text-center align-middle">Jumlah</th>
                      <th class="text-center align-middle">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql_barang = mysqli_query($con, "SELECT * FROM view_tsc_beli WHERE no_dokumen='$no_dokumen'") or die(mysqli_error($con));

                    $counter = 1;
                    $totalharga = 0;
                    $totalbayar = 0;

                    while ($row_barang = mysqli_fetch_array($sql_barang)) {
                      $totalharga = $row_barang['harga'] * $row_barang['jml_beli'];
                      $totalbayar += $totalharga;
                    ?>
                      <tr>
                        <td class="text-center align-middle"><?= $counter++ ?></td>
                        <td class="text-center align-middle"><?= $row_barang['kode_barang'] ?></td>
                        <td class="align-middle"><?= $row_barang['nama_barang'] ?></td>
                        <td class="text-right align-middle"><?php echo "Rp. " . number_format($row_barang['harga'], 2, ",", "."); ?></td>
                        <td class="text-center align-middle"><?= $row_barang['jml_beli'] . ' ' . $row_barang['nama_satuan'] ?></td>
                        <td class="text-right align-middle"><?php echo "Rp. " . number_format($totalharga, 2, ",", "."); ?></td>
                      </tr>
                    <?php } ?>
                    <tr style="background-color:#6c757d">
                      <td colspan="5" class="text-center align-middle" style="color: #F0FFFF"><b>Harga Total Pembelian</b></td>
                      <td class="text-right align-middle" style="color: #F0FFFF"><b><?php echo "Rp. " . number_format($totalbayar, 2, ",", "."); ?></b></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


          <div class="card-footer clearfix">
            <a href="cetak?page=detail-beli&no_dokumen=<?php echo base64_encode($no_dokumen); ?>" target="_blank" class="btn btn-success float-right"><i class="fas fa-print"></i>&nbsp; Generate PDF</a>
            <button class="btn btn-danger" onClick="confirm_delete('index?page=detail-beli&del=<?php echo base64_encode($no_dokumen); ?>')" data-toggle="modal" data-target="#modal_delete"><i class="fas fa-times"></i>&nbsp; Hapus Data</button>
            <a href="index?page=edit-beli&no_dokumen=<?php echo base64_encode($no_dokumen); ?>"  class="btn btn-primary"><i class="fas fa-edit"></i>&nbsp; Edit Data</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->


<!-- Modal Popup untuk delete-->
<div id="modal_delete" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content bg-warning">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100">Apakah anda yakin ingin menghapus data ini?</h4>
      </div>
      <div class="modal-body">
        <p align="center">Peringatan! data yang telah dihapus tidak dapat dikembalikan.</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fas fa-arrow-left"></i> Kembali</button>
        <a href="#" id="delete_link"><button class="btn btn-outline-dark"><i class="fas fa-trash"></i>&nbsp; Hapus</button></a>
      </div>
    </div>
  </div>
</div>



<!-- Javascript Delete -->
<script>
  function confirm_delete(delete_url) {
    $("#modal_delete").modal('show', {
      backdrop: 'static'
    });
    document.getElementById('delete_link').setAttribute('href', delete_url);
  }
</script>