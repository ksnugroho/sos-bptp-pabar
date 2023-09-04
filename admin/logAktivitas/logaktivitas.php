<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../login.php');
}

function tgl_indo($tanggal){
	$bulan = array (
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
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

//proses kosongkan table
if ($_POST['truncate_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE log_aktivitas");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel log aktivitas')");
  if ($truncate_query) {
    if ($query_log) {
  } 
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
          window.location='index.php?page=log-aktiv'
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
          window.location='index.php?page=log-aktiv'
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
            <h1>Aktivitas Pengguna SOSys</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">SOSys</a></li>
              <li class="breadcrumb-item active">Log Aktivitas</li>
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
              <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Aktivitas Pengguna Aplikasi SOSys - BPTP Papua Barat</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="card-box table-responsive">
                  <table id="example1" class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                      <th class="text-center align-middle" width="10px">No</th>
                      <th class="text-center align-middle">User Login</th>
                      <th class="text-center align-middle">Tanggal & Waktu</th>
                      <th class="text-center align-middle">Aktivitas</th>
                    </tr>
                    </thead>
                    <tbody>
                   
                    <?php
                        $sql = mysqli_query($con, "SELECT * FROM log_aktivitas ORDER BY id_log DESC") or die(mysqli_error($con));
                          $counter = 1;
                          while ($row = mysqli_fetch_assoc($sql)) {
                    ?>
                    <tr>
                      <td class="text-center"><?=$counter++?></td>
                      <td><?=$row['user_login']?></td>
                      <td>
                        <b>Tanggal Akses</b> : <?php date_default_timezone_set("Asia/Jakarta"); $tgl_akses = date('Y-m-d', strtotime($row['tanggal'])); echo tgl_indo($tgl_akses); echo "<br><b>Waktu</b> : ".date('H:i:s', strtotime($row['waktu']));?>
                      </td>
                      <td><?=$row['aktivitas']?> </td>
                    </tr>
                    <?php
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer clearfix">
            <button class="btn btn-danger" data-toggle="modal" data-target="#modal_truncate"><i class="fas fa-times"></i>&nbsp; Kosongkan Tabel</button>
          </div>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<!-- Modal Popup truncate-->
<div id="modal_truncate" class="modal fade" >
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <div class="modal-header text-center">
      <h4 class="modal-title w-100">Apakah anda yakin mengosongkan tabel ini?</h4>
      </div>
      <div class="modal-body">
        <p align="center">Anda akan menghapus SELURUH data <b>LOG AKTIVITAS</b>. Peringatan! data yang telah dihapus tidak dapat dikembalikan.</p>
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
  $(function () {
    $("#example1").DataTable({
      'info': true,
      'lengthMenu': [[5, 10, 15, -1], [5, 10, 15, "All"]],
      'ordering': false,
      'pageLength': 5,
      dom: 'lBfrtip',
      // buttons: [
      //   'excel', 'pdf', 'print',
      // ],
      buttons: [{
          extend: 'excel',
          title: 'DAFTAR AKUN ANGGOTA - BRIGIF 24/BC',
          pageSize: 'A4',
          exportOptions: {
            columns: [0, 1, 2]
          },
          customize: function (xlsx) {
            var sheet = xlsx.xl.worksheets['sheet1.xml'];
            $('c[r=A1] t', sheet).text('DAFTAR AKUN ANGGOTA - BRIGIF 24/BC');
            $('row:first c', sheet).attr('s', '2');
          }
        },
        {
          extend: 'pdf',
          title: 'DAFTAR AKUN ANGGOTA - BRIGIF 24/BC',
          pageSize: 'A4',
          orientation: 'portrait',
          exportOptions: {
            columns: [0, 1, 2]
          },
          customize: function (doc) {
            doc.styles.tableHeader.alignment = 'center';
            doc.content[1].table.widths = ['5%', '40%', '55%'];
          }
        },
        {
          extend: 'print',
          text: '<u>P</u>rint',
          title: 'DAFTAR AKUN ANGGOTA - BRIGIF 24/BC',
          pageSize: 'A4',
          orientation: 'portrait',
          exportOptions: {
            columns: [0, 1, 2]
          },
          key: {
            key: 'p',
            ctrlkey: true
          },
          customize: function (win) {
            $(win.document.body).find('table').addClass('display').css('font-size', '12px');
            $(win.document.body).find('tr:nth-child(odd) td').each(function (index) {
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

  $('#example1').on('mouseover', 'tr', function () {
    $('[rel="tooltip"]').tooltip({
      trigger: 'hover',
      html: true
    });
  });
</script>