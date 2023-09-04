<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../login/login.php');
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
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
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}

$no_dokumen = base64_decode($_GET['no_dokumen']);

//proses hapus data
if(isset($_GET['del'])){
  $user_login   = $_SESSION['user'];
  $datestamp    = date('Y-m-d');
  $waktustamp   = date('H:i:s');

  $no_dokumen 	= base64_decode($_GET['del']);
  $delete_query = mysqli_query($con, "DELETE FROM tsc_pakai WHERE no_dokumen='$no_dokumen'");
  $query_log    = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menghapus data pemakaian')");
  if ($delete_query && $query_log) {
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
          <li class="breadcrumb-item active">Pemakaian (Out)</li>
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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Detail Pemakaian  - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
          <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
              <?php
                $sql_beli = mysqli_query($con, "SELECT * FROM view_tsc_pakai WHERE no_dokumen='$no_dokumen'") or die(mysqli_error($con));
                $row_beli = mysqli_fetch_array($sql_beli)
              ?>
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> No. Dokumen:&nbsp;<?=$no_dokumen?>
                    <small class="float-right">Tanggal Pemakaian: <?=tanggal_indo($row_beli['tgl_pakai'], true)?></small>
                  </h4>
                </div>
              </div>

              <br>
              <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                  <strong class="text-blue">Informasi Program & Kegiatan</strong>
                  <address>
                    <strong>Program:</strong> <?=$row_beli['nama_program'] . " (" . $row_beli['tahun'] . ")"?><br>
                    <strong>Kegiatan:</strong> <?=$row_beli['nama_kegiatan']?><br>
                    <strong>Komponen:</strong> <?=$row_beli['nama_komponen']?><br>
                    <strong>Sub Komponen:</strong> <?=$row_beli['nama_subkomponen']?><br>
                    <strong>Detail:</strong> <?=$row_beli['nama_detail']?><br>
                    <strong>Sub Detail:</strong> <?=$row_beli['nama_subdetail']?>
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
                      <th class="text-center align-middle">Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      $sql_barang = mysqli_query($con, "SELECT * FROM view_tsc_pakai WHERE no_dokumen='$no_dokumen'") or die(mysqli_error($con));
                      $counter = 1;
                      while ($row_barang = mysqli_fetch_array($sql_barang)) {
                    ?>
                  <tr>
                    <td class="text-center align-middle"><?=$counter++?></td>
                    <td class="text-center align-middle"><?=$row_barang['kode_barang']?></td>
                    <td class="align-middle"><?=$row_barang['nama_barang']?></td>
                    <td class="text-center align-middle"><?=$row_barang['jml_pakai'] . ' ' . $row_barang['nama_satuan']?></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>  
          

          <div class="card-footer clearfix">
            <button class="btn btn-success float-right" data-toggle="modal" data-target="#modal_tambah"><i class="fas fa-print"></i>&nbsp; Generate PDF</button>
            <button class="btn btn-danger" onClick="confirm_delete('index?page=detail-beli&del=<?php echo base64_encode($no_dokumen);?>')" data-toggle="modal" data-target="#modal_delete"><i class="fas fa-times"></i>&nbsp; Hapus Data</button>
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
        <a href="#" id="delete_link"><button class="btn btn-outline-dark"><i
              class="fas fa-trash"></i>&nbsp; Hapus</button></a>
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