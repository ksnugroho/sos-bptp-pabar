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
          <li class="breadcrumb-item active">Rekapitulasi Pembelian (In)</li>
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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Rekapitulasi Pembelian - BPTP Papua Barat</h3>
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
                    <th class="text-center align-middle">Tanggal Pembelian</th>
                    <th class="text-center align-middle">Sub Detail</th>
                    <th class="text-center align-middle">Agen</th>
                    <th class="text-center align-middle">Kode Barang</th>
                    <th class="text-center align-middle">Nama Barang</th>
                    <th class="text-center align-middle">Harga Satuan</th>
                    <th class="text-center align-middle">Jumlah</th>
                    <th class="text-center align-middle">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = mysqli_query($con, "SELECT * FROM view_tsc_beli") or die(mysqli_error($con));
                  $counter = 1;
                  $totalharga = 0;
                  $totalbayar = 0;
                  while ($row = mysqli_fetch_array($sql)) {
                    $totalharga = $row['harga'] * $row['jml_beli'];
                    $totalbayar += $totalharga;
                  ?>
                    <tr>
                      <td class="text-center"><?= $counter++ ?></td>
                      <td class="text-center"><?= $row['no_dokumen'] ?></td>
                      <td class="text-center"><?= $row['no_buku'] ?></td>
                      <td class="text-center"><?= date('d/m/Y', strtotime($row['tgl_beli'])); ?></td>
                      <td class="text-center"><?= $row['kode_subkomponen'] . '.' . $row['kode_detail'] . '.' . $row['kode_subdetail'] ?></td>
                      <td><?= $row['nama_agen'] ?></td>
                      <td class="text-center"><?= $row['kode_barang'] ?></td>
                      <td><?= $row['nama_barang'] ?></td>
                      <td class="text-right align-middle"><?php echo "Rp. " . number_format($row['harga'], 2, ",", "."); ?></td>
                      <td class="text-center align-middle"><?= $row['jml_beli'] . ' ' . $row['nama_satuan'] ?></td>
                      <td class="text-right align-middle"><?php echo "Rp. " . number_format($totalharga, 2, ",", "."); ?></td>
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


  <script type="text/javascript">
    //fungsi untuk filtering data berdasarkan tanggal 
    var start_date;
    var end_date;
    var DateFilterFunction = (function(oSettings, aData, iDataIndex) {
      var dateStart = parseDateValue(start_date);
      var dateEnd = parseDateValue(end_date);
      //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
      //nama depan = 0
      //nama belakang = 1
      //tanggal terdaftar =2
      var evalDate = parseDateValue(aData[3]);
      if ((isNaN(dateStart) && isNaN(dateEnd)) ||
        (isNaN(dateStart) && evalDate <= dateEnd) ||
        (dateStart <= evalDate && isNaN(dateEnd)) ||
        (dateStart <= evalDate && evalDate <= dateEnd)) {
        return true;
      }
      return false;
    });

    // fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
    function parseDateValue(rawDate) {
      var dateArray = rawDate.split("/");
      var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[0]); // -1 because months are from 0 to 11   
      return parsedDate;
    }



    $(document).ready(function() {
      //konfigurasi DataTable pada tabel dengan id example dan menambahkan  div class dateseacrhbox dengan dom untuk meletakkan inputan daterangepicker
      var $dTable = $('#example1').DataTable({
        "dom": "<'row'<'col-sm-6'lB><'col-sm-3' <'datesearchbox'>><'col-sm-3'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>> ",
        'info': true,
        'lengthMenu': [
          [10, 15, 20, -1],
          [10, 15, 20, "All"]
        ],
        'ordering': false,
        'pageLength': 10,
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
        buttons: [{
            extend: 'excel',
            title: 'REKAPITULASI PEMBELIAN (IN) - BPTP Papua Barat',
            pageSize: 'A4',
            exportOptions: {
              columns: [0, 1, 3, 4, 6, 7, 8, 9, 10],
            },
            customize: function(xlsx) {
              var sheet = xlsx.xl.worksheets['sheet1.xml'];
              $('c[r=A1] t', sheet).text('REKAPITULASI PEMBELIAN (IN) - BPTP Papua Barat');
              $('row:first c', sheet).attr('s', '2');
            }
          },
          {
            extend: 'pdf',
            title: 'REKAPITULASI PEMBELIAN (IN) - BPTP Papua Barat',
            pageSize: 'A4',
            orientation: 'landscape',
            exportOptions: {
              columns: [0, 1, 3, 4, 6, 7, 8, 9, 10],
              stripNewlines: false
            },
            customize: function(doc) {
              doc.styles.tableHeader.alignment = 'center';
              doc.content[1].table.widths = ['5%', '11%', '10%', '10%', '10%', '20%', '12%', '10%', '12%'];
            }
          },
          {
            extend: 'print',
            text: '<u>P</u>rint',
            title: 'REKAPITULASI PEMBELIAN (IN) - BPTP Papua Barat',
            pageSize: 'A4',
            orientation: 'landscape',
            exportOptions: {
              columns: [0, 1, 3, 4, 6, 7, 8, 9, 10],
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
      });

      //menambahkan daterangepicker di dalam datatables
      $("div.datesearchbox").html('<div class="input-group input-group-sm"> <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span> </div><input type="text" class="form-control pull-right" id="datesearch" placeholder="Filter berdasarkan tanggal"> </div>');


      document.getElementsByClassName("datesearchbox")[0].style.textAlign = "right";

      //konfigurasi daterangepicker pada input dengan id datesearch
      $('#datesearch').daterangepicker({
          autoUpdateInput: false,
          ranges: {
            'Hari ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
            '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          locale: {
            "customRangeLabel": "Rentang Waktu Tertentu",
          },

        },

        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      );

      //menangani proses saat apply date range
      $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        start_date = picker.startDate.format('DD/MM/YYYY');
        end_date = picker.endDate.format('DD/MM/YYYY');
        $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
        $dTable.draw();
      });

      $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        start_date = '';
        end_date = '';
        $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
        $dTable.draw();
      });
    });
  </script>

  <script>
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