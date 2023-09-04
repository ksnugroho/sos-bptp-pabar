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

  $edit_id_kegiatan = $_POST['edit_id_kegiatan'];
  $edit_program     = mysqli_real_escape_string($con, $_POST['edit_program']);
  $edit_kd_kegiatan	= mysqli_real_escape_string($con, $_POST['edit_kd_kegiatan']);
  $edit_kegiatan	  = mysqli_real_escape_string($con, $_POST['edit_kegiatan']);
  $cek_kegiatan			= mysqli_query($con, "SELECT * FROM ref_kegiatan WHERE nama_kegiatan='$edit_kegiatan' OR nama_kegiatan='$kegiatan'");
  if (mysqli_num_rows($cek_kegiatan)>0) {
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
        window.location='index?page=kegiatan'
      });
      </script>";
  } else {
    $edit_query			  = mysqli_query($con, "UPDATE ref_kegiatan SET id_program=$edit_program, kode_kegiatan='$edit_kd_kegiatan', nama_kegiatan='$edit_kegiatan' WHERE id_kegiatan=$edit_id_kegiatan");
    $query_log        = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Memperbarui data kegiatan')");
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
        window.location='index?page=kegiatan'
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
        window.location='index?page=kegiatan'
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

  $id_program         = mysqli_real_escape_string($con, $_POST['program']);
  $kd_kegiatan	     	= mysqli_real_escape_string($con, $_POST['kd_kegiatan']);
  $kegiatan	          = mysqli_real_escape_string($con, $_POST['kegiatan']);
  $cek_kegiatan			  = mysqli_query($con, "SELECT * FROM ref_kegiatan WHERE kode_kegiatan='$kd_kegiatan' AND nama_kegiatan='$kegiatan'");
  if (mysqli_num_rows($cek_kegiatan)>0) {
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
        window.location='index?page=kegiatan'
      });
      </script>";
  } else {
    $add_query			= mysqli_query($con, "INSERT INTO ref_kegiatan VALUES (NULL, $id_program , '$kd_kegiatan', '$kegiatan')");
      $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menambahkan data kegiatan')");
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
          window.location='index?page=kegiatan'
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
          window.location='index?page=kegiatan'
        });
        </script>";
      }
  }
}

//proses hapus data
if(isset($_GET['id_kegiatan'])){
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $id_kegiatan 	= base64_decode($_GET['id_kegiatan']);
  $delete_query = mysqli_query($con, "DELETE FROM ref_kegiatan WHERE id_kegiatan='$id_kegiatan'");
  $query_log    = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menghapus data kegiatan')");
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
          window.location='index.php?page=kegiatan'
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
          window.location='index.php?page=kegiatan'
        });
      </script>";
  }
}

//proses kosongkan table
if ($_POST['truncate_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE ref_kegiatan");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel data kegiatan')");
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
          window.location='index.php?page=kegiatan'
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
          window.location='index.php?page=kegiatan'
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
        <h1>Data Referensi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SOSys</a></li>
          <li class="breadcrumb-item active">Data Referensi</li>
          <li class="breadcrumb-item active">Kegiatan</li>
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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Daftar Kegiatan  - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="example1" class="table table-hover table-condensed">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center align-middle" width="10px">No</th>
                    <th class="text-center align-middle">Kode Kegiatan</th>
                    <th class="text-center align-middle">Nama Kegiatan</th>
                    <th class="text-center align-middle" width="100px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      $sql = mysqli_query($con, "SELECT * FROM view_kegiatan") or die(mysqli_error($con));
                      $counter = 1;
                      while ($row = mysqli_fetch_array($sql)) {
                    ?>
                  <tr>
                    <td class="text-center"><?=$counter++?></td>
                    <td class="text-center"><?=$row['kode_kegiatan']?></td>
                    <td class="align-middle">
                    <div class=text-primary><b><?=$row['nama_kegiatan']?></b></div><br>
                      <div class=text-muted>
                      <b>Program: </b><?=$row['kode_program']. " - " .$row['nama_program']?> (</b><?=$row['tahun']?>)</td>
                      </di>
                    <td class="text-center align-middle">
                      <button style="margin-top:2px" href="#" rel="tooltip" data-toggle="modal" data-target="#modal_edit<?php echo $row['id_kegiatan'];?>" data-placement="top" title="Edit Data" class='btn btn-sm btn-outline-success'><span class="oi oi-pencil"></span></button>
                      <button style="margin-top:2px" onClick="confirm_delete('index?page=kegiatan&id_kegiatan=<?php echo base64_encode($row['id_kegiatan']);?>')" rel="tooltip" data-toggle="modal" data-target="#modal_delete" data-placement="top" title="Hapus Data" class='btn btn-sm btn-outline-danger'><span class="oi oi-trash"></span></button>
                    </td>
                  </tr>
                  <!-- Modal Popup untuk edit data-->
                  <div id="modal_edit<?php echo $row['id_kegiatan'];?>" class="modal fade">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header text-center bg-primary">
                          <h4 class="modal-title w-100">Edit Data Kegiatan</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <form action="" method="post">
                              <?php
                                $data_edit = mysqli_query($con, "SELECT * FROM ref_kegiatan WHERE id_kegiatan=$row[id_kegiatan]");
                                while ($row1 = mysqli_fetch_array($data_edit)) {
                              ?>
                                <div class="form-group">
                                  <label for="edit_program">Pilih Program</label>
                                  <select name="edit_program" class="form-control select2bs4" required>
                                    <option disabled>Pilih Program</option>
                                      <?php 
                                        $sql_program=mysqli_query($con, "SELECT * FROM ref_program ORDER BY id_program");
                                        while ($data_program=mysqli_fetch_array($sql_program)) {
                                          if ($data_program['nama_program']==$row['nama_program']) {
                                            $select="selected";
                                          }else{
                                            $select="";
                                          }
                                            echo '<option value="' . $data_program['id_program'] . '" '.$select.'>' . $data_program['kode_program'] .' - ' . $data_program['nama_program'] . '</option>';  
                                          }
                                      ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="edit_kd_kegiatan">Kode Kegiatan</label>
                                  <input type="hidden" name="edit_id_kegiatan" class="form-control" value="<?php echo $row1['id_kegiatan']; ?>" />
                                  <input type="text" name="edit_kd_kegiatan" class="form-control" value="<?php echo $row1['kode_kegiatan'];?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="edit_kegiatan">Nama Kegiatan</label>
                                  <input type="text" name="edit_kegiatan" class="form-control" value="<?php echo $row1['nama_kegiatan'];?>" required>
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
        <h4 class="modal-title w-100">Tambah Data Kegiatan</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form id="add_form" action="" method="post">
              <div class="form-group">
                <label for="program">Pilih Program</label>
                <select name="program" id="program" class="form-control select2bs4" required>
                  <option value="">Pilih Program</option>
                  <?php
                  $sql_program = mysqli_query($con, "SELECT * FROM ref_program");
                  while($data_program = mysqli_fetch_array($sql_program)){
                    echo "<option value='".$data_program['id_program']."'>".$data_program['kode_program']." - ".$data_program['nama_program']."</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="kd_kegiatan">Kode Kegiatan*</label>
                <input type="text" name="kd_kegiatan" id="kd_kegiatan" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="kegiatan">Nama Kegiatan*</label>
                <input type="text" name="kegiatan" id="kegiatan" class="form-control" required>
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
        <p align="center">Anda akan menghapus SELURUH data <b>KEGIATAN</b>. Peringatan! data yang telah dihapus tidak dapat dikembalikan.</p>
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
        title: 'DAFTAR KEGIATAN - BPTP Papua Barat',
        pageSize: 'A4',
        exportOptions: {
          columns: [0, 1, 2]
        },
        customize: function ( xlsx ){
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
            $('c[r=A1] t', sheet).text( 'DAFTAR KEGIATAN - BPTP Papua Barat' );
            $('row:first c', sheet).attr( 's', '2' );
        }
      },
      {
        extend: 'pdf',
        title: 'DAFTAR KEGIATAN - BPTP Papua Barat',
        pageSize: 'A4',
        orientation: 'portrait',
        exportOptions: {
          columns: [0, 1, 2],
          stripNewlines: false
        },
        customize : function(doc){
          doc.styles.tableHeader.alignment = 'center';
          doc.content[1].table.widths = ['5%', '20%', '75%']; 
        }
      },
      {
        extend: 'print',
        text: '<u>P</u>rint',
        title: 'DAFTAR KEGIATAN - BPTP Papua Barat',
        pageSize: 'A4',
        orientation: 'portrait',
        exportOptions: {
          columns: [0, 1, 2],
          stripHtml: false
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