<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../login/login.php');
}

// proses edit data
if ($_POST['edit_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $edit_id_jenis = $_POST['edit_id_jenis'];
  $edit_jenis	  = mysqli_real_escape_string($con, $_POST['edit_jenis']);
  $cek_jenis			= mysqli_query($con, "SELECT * FROM master_jenis WHERE nama_jenis='$edit_jenis'");
  if (mysqli_num_rows($cek_jenis)>0) {
    echo "
      <script>
      swal({
        title: 'Peringatan',
        text: 'Data sudah tersedia',
        type: 'warning',
        showCancelButton: false,
        cancelButtonText: 'No, Cancel!',
        confirmButtonText: 'Oke',
        closeOnConfirm: true
      }, function(isConfirm){
        window.location='index?page=jenis'
      });
      </script>";
  } else {
    $edit_query			  = mysqli_query($con, "UPDATE master_jenis SET nama_jenis='$edit_jenis' WHERE id_jenis=$edit_id_jenis");
    $query_log        = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Memperbarui data jenis')");
    if ($edit_query && $query_log) {
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
        window.location='index?page=jenis'
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
        window.location='index?page=jenis'
      });
      </script>";
    }
  }
}

// proses tambah data
if ($_POST['add_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $jenis	     	  = mysqli_real_escape_string($con, $_POST['jenis']);
  $cek_jenis			= mysqli_query($con, "SELECT * FROM master_jenis WHERE nama_jenis='$jenis'");
  if (mysqli_num_rows($cek_jenis)>0) {
    echo "
      <script>
      swal({
        title: 'Peringatan',
        text: 'Data sudah tersedia',
        type: 'warning',
        showCancelButton: false,
        cancelButtonText: 'No, Cancel!',
        confirmButtonText: 'Oke',
        closeOnConfirm: true
      }, function(isConfirm){
        window.location='index?page=jenis'
      });
      </script>";
  } else {
    $add_query			= mysqli_query($con, "INSERT INTO master_jenis VALUES (NULL, '$jenis')");
      $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menambahkan data jenis')");
      if ($add_query && $query_log) {
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
          window.location='index?page=jenis'
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
          window.location='index?page=jenis'
        });
        </script>";
      }
  }
}

//proses hapus data
if(isset($_GET['id_jenis'])){
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $id_jenis 	= base64_decode($_GET['id_jenis']);
  $delete_query = mysqli_query($con, "DELETE FROM master_jenis WHERE id_jenis='$id_jenis'");
  $query_log    = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menghapus data jenis')");
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
          window.location='index.php?page=jenis'
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
          window.location='index.php?page=jenis'
        });
      </script>";
  }
}

//proses kosongkan table
if ($_POST['truncate_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE master_jenis");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel data jenis')");
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
          window.location='index.php?page=jenis'
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
          window.location='index.php?page=jenis'
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
        <h1>Data Master</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SOSys</a></li>
          <li class="breadcrumb-item active">Data Master</li>
          <li class="breadcrumb-item active">Jenis</li>
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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Daftar Jenis  - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="example1" class="table table-hover table-condensed">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center align-middle" width="10px">No</th>
                    <th class="text-center align-middle">Nama Jenis</th>
                    <th class="text-center align-middle" width="100px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      $sql = mysqli_query($con, "SELECT * FROM master_jenis") or die(mysqli_error($con));
                      $counter = 1;
                      while ($row = mysqli_fetch_array($sql)) {
                    ?>
                  <tr>
                    <td class="text-center align-middle"><?=$counter++?></td>
                    <td class="align-middle"><?=$row['nama_jenis']?></td>
                    <td class="text-center align-middle">
                      <button style="margin-top:2px" href="#" rel="tooltip" data-toggle="modal" data-target="#modal_edit<?php echo $row['id_jenis'];?>" data-placement="top" title="Edit Data" class='btn btn-sm btn-outline-success'><span class="oi oi-pencil"></span></button>
                      <button style="margin-top:2px" onClick="confirm_delete('index?page=jenis&id_jenis=<?php echo base64_encode($row['id_jenis']);?>')" rel="tooltip" data-toggle="modal" data-target="#modal_delete" data-placement="top" title="Hapus Data" class='btn btn-sm btn-outline-danger'><span class="oi oi-trash"></span></button>
                    </td>
                  </tr>
                  <!-- Modal Popup untuk edit data-->
                  <div id="modal_edit<?php echo $row['id_jenis'];?>" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header text-center bg-primary">
                          <h4 class="modal-title w-100">Edit Data Jenis</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <form action="" method="post">
                              <?php
                                $data_edit = mysqli_query($con, "SELECT * FROM master_jenis WHERE id_jenis=$row[id_jenis]");
                                while ($row1 = mysqli_fetch_array($data_edit)) {
                              ?>
                                <div class="form-group">
                                  <label for="edit_jenis">Nama Jenis</label>
                                  <input type="hidden" name="edit_id_jenis" class="form-control" value="<?php echo $row1['id_jenis']; ?>" />
                                  <input type="text" name="edit_jenis" class="form-control" value="<?php echo $row1['nama_jenis'];?>" required>
                                </div>
                            </div>
                                <?php } ?>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-arrow-left"></i>&nbsp; Kembali</button>
                          <!-- <button form="edit_form" id="edit_data" name="edit_data" value="edit_data" type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbspSimpan</button>   -->
                          <input type="submit" name="edit_data" value="Simpan" class="btn btn-primary" />                     
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </tbody>
                </table>
            </div>
          </div>
          <div class="card-footer clearfix">
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_tambah"><i class="fas fa-plus"></i>&nbsp; Tambah Data</button>
            <button class="btn btn-danger" data-toggle="modal" data-target="#modal_truncate"><i class="fas fa-times"></i>&nbsp; Kosongkan Tabel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->

<!-- Modal Popup untuk tambah data-->
<div id="modal_tambah" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center bg-primary">
        <h4 class="modal-title w-100">Tambah Data Jenis</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form id="add_form" action="" method="post">
              <div class="form-group">
                <label for="jenis">Nama Jenis</label>
                <input type="text" name="jenis" class="form-control" id="jenis" required>
              </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-arrow-left"></i> Kembali</button>
        <button form="add_form" id="add_data" name="add_data" value="add_data" type="submit"
          class="btn btn-primary"><i class="fas fa-save"></i>&nbsp; Simpan</button>
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
        <a href="#" id="delete_link"><button class="btn btn-outline-dark"><i
              class="fas fa-trash"></i>&nbsp; Hapus</button></a>
      </div>
    </div>
  </div>
</div>

<!-- Modal Popup truncate-->
<div id="modal_truncate" class="modal fade" >
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <div class="modal-header text-center">
      <h4 class="modal-title w-100">Apakah anda yakin mengosongkan tabel ini?</h4>
      </div>
      <div class="modal-body">
        <p align="center">Anda akan menghapus SELURUH data <b>JENIS</b>. Peringatan! data yang telah dihapus tidak dapat dikembalikan.</p>
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
      buttons: [
        {
        extend: 'excel',
        title: 'DAFTAR JENIS - BPTP Papua Barat',
        pageSize: 'A4',
        exportOptions: {
          columns: [0, 1]
        },
        customize: function ( xlsx ){
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
            $('c[r=A1] t', sheet).text( 'DAFTAR JENIS - BPTP Papua Barat' );
            $('row:first c', sheet).attr( 's', '2' );
        }
      },
      {
        extend: 'pdf',
        title: 'DAFTAR JENIS - BPTP Papua Barat',
        pageSize: 'A4',
        orientation: 'portrait',
        exportOptions: {
          columns: [0, 1]
        },
        customize : function(doc){
          doc.styles.tableHeader.alignment = 'center';
          doc.content[1].table.widths = ['5%', '95%']; 
        }
      },
      {
        extend: 'print',
        text: '<u>P</u>rint',
        title: 'DAFTAR JENIS - BPTP Papua Barat',
        pageSize: 'A4',
        orientation: 'portrait',
        exportOptions: {
          columns: [0, 1]
        },
        key: {
          key: 'p',
          ctrlkey: true
        },
        customize: function (win) {
          $(win.document.body).find('table').addClass('display').css('font-size', '12px');
          $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
            $(this).css('background-color','#D0D0D0');
          });
          $(win.document.body).find('h1').css('text-align','center');
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

<!-- Javascript Delete -->
<script>
  function confirm_delete(delete_url) {
    $("#modal_delete").modal('show', {
      backdrop: 'static'
    });
    document.getElementById('delete_link').setAttribute('href', delete_url);
  }
</script>