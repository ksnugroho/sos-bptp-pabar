<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
  header('location:../login/login.php');
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


//proses hapus data
if (isset($_GET['no_dokumen'])) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $no_dokumen   = base64_decode($_GET['no_dokumen']);
  $delete_query = mysqli_query($con, "DELETE FROM tsc_beli WHERE no_dokumen='$no_dokumen'");
  $query_log    = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menghapus data pembelian')");
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

//proses kosongkan table
if ($_POST['truncate_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE tsc_beli");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel data pembelian')");
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
          window.location='index.php?page=beli'
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
        <h1>Data Transaksi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SOSys</a></li>
          <li class="breadcrumb-item active">Data Transkasi</li>
          <li class="breadcrumb-item active">Rekapitulasi Pemakaian (Out)</li>
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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Rekapitulasi Pemakaian - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="example1" class="table table-sm table-hover table-condensed">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center align-middle" width="10px">No</th>
                    <th class="text-center align-middle">Nomor Dokumen</th>
                    <th class="text-center align-middle">Nomor Buku</th>
                    <th class="text-center align-middle">Tanggal Pemakaian</th>
                    <th class="text-center align-middle">Sub Detail</th>
                    <th class="text-center align-middle">Kode Barang</th>
                    <th class="text-center align-middle">Nama Barang</th>
                    <th class="text-center align-middle">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = mysqli_query($con, "SELECT * FROM view_tsc_pakai") or die(mysqli_error($con));
                  $counter = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <tr>
                      <td class="text-center"><?= $counter++ ?></td>
                      <td class="text-center"><?= $row['no_dokumen'] ?></td>
                      <td class="text-center"><?= $row['no_buku'] ?></td>
                      <td><?= tanggal_indo($row['tgl_pakai']) ?></td>
                      <td><?= $row['kode_subkomponen'] ?></td>
                      <td><?= $row['kode_barang'] ?></td>
                      <td><?= $row['nama_barang'] ?></td>
                      <td class="text-center align-middle"><?= $row['jml_pakai'] . ' ' . $row['nama_satuan'] ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- <div class="card-footer clearfix">
            <a href="index?page=add-beli" class="btn btn-primary float-right"><i class="fas fa-plus"></i>&nbsp; Tambah Data</a>
            <button class="btn btn-danger" data-toggle="modal" data-target="#modal_truncate"><i class="fas fa-times"></i>&nbsp; Kosongkan Tabel</button>
          </div> -->
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

<!-- Modal Popup truncate-->
<div id="modal_truncate" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100">Apakah anda yakin mengosongkan tabel ini?</h4>
      </div>
      <div class="modal-body">
        <p align="center">Anda akan menghapus SELURUH data <b>PEMBELIAN (IN)</b>. Peringatan! data yang telah dihapus tidak dapat dikembalikan.</p>
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

<script>
  $(function() {
    $("#example1").DataTable({
      'info': true,
      'lengthMenu': [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      'ordering': false,
      'pageLength': 5,
      dom: 'lBfrtip',
      // buttons: [
      //   'excel', 'pdf', 'print',
      // ],
      buttons: [{
          extend: 'excel',
          title: 'DAFTAR PEMBELIAN (IN) - BPTP Papua Barat',
          pageSize: 'A4',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
          },
          customize: function(xlsx) {
            var sheet = xlsx.xl.worksheets['sheet1.xml'];
            $('c[r=A1] t', sheet).text('DAFTAR PEMBELIAN (IN) - BPTP Papua Barat');
            $('row:first c', sheet).attr('s', '2');
          }
        },
        {
          extend: 'pdf',
          title: 'DAFTAR PEMBELIAN (IN) - BPTP Papua Barat',
          pageSize: 'A4',
          orientation: 'landscape',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5],
            stripNewlines: false
          },
          customize: function(doc) {
            doc.styles.tableHeader.alignment = 'center';
            doc.content[1].table.widths = ['5%', '15%', '10%', '10%', '10%', '50%'];
          }
        },
        {
          extend: 'print',
          text: '<u>P</u>rint',
          title: 'DAFTAR PEMBELIAN (IN) - BPTP Papua Barat',
          pageSize: 'A4',
          orientation: 'landscape',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5],
            stripHtml: false
          },
          key: {
            key: 'p',
            ctrlkey: true
          },
          customize: function(win) {
            $(win.document.body).find('table').addClass('display').css('font-size', '12px');
            $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
              $(this).css('background-color', '#D0D0D0');
            });
            $(win.document.body).find('h1').css('text-align', 'center');
          }
        },
      ],
      fixedHeader: {
        header: true,
        footer: true
      },
      'language': {
        'emptyTable': 'Tidak ada data yang tersedia pada tabel ini',
        'info': 'Menampilkan _START_ hingga _END_ dari _TOTAL_ data',
        'infoEmpty': 'Menampilkan 0 hingga 0 dari 0 data',
        'infoFiltered': '(dicari dari total _MAX_ data)',
        'search': 'Pencarian data:',
        'lengthMenu': 'Menampilkan _MENU_ data',
        'zeroRecords': 'Tidak ditemukan data yang cocok',
        'paginate': {
          'first': 'Pertama',
          'last': 'Terakhir',
          'next': 'Selanjutnya',
          'previous': 'Sebelumnya'
        },
      },

    });
  });

  $('#example1').on('mouseover', 'tr', function() {
    $('[rel="tooltip"]').tooltip({
      trigger: 'hover',
      html: true
    });
  });
</script>

<!-- Javascript Delete -->
<script>
  function confirm_delete(delete_url) {
    $("#modal_delete").modal('show', {
      backdrop: 'static'
    });
    document.getElementById('delete_link').setAttribute('href', delete_url);
  }
</script>