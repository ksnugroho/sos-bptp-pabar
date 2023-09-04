<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../../login.php');
}

// proses edit data
if ($_POST['edit_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $edit_komponen          = mysqli_real_escape_string($con, $_POST['edit_komponen']);
  $edit_id_subkomponen	  = mysqli_real_escape_string($con, $_POST['edit_id_subkomponen']);
  $edit_kd_subkomponen	  = mysqli_real_escape_string($con, $_POST['edit_kd_subkomponen']);
  $edit_nama_subkomponen	= mysqli_real_escape_string($con, $_POST['edit_nama_subkomponen']);
  
  $cek_subkomponen_val	  = mysqli_query($con, "SELECT * FROM ref_subkomponen WHERE nama_subkomponen='$edit_nama_subkomponen'");
  while ($row_val = mysqli_fetch_array($cek_subkomponen_val)) {
    $id_komponen      = $row_val['id_komponen'];
    $kode_subkomponen = $row_val['kode_subkomponen'];
    $nama_subkomponen = $row_val['nama_subkomponen'];
  }
  
  if (($id_komponen==$edit_komponen) AND ($nama_subkomponen==$edit_nama_subkomponen) AND ($kode_subkomponen!=$edit_kd_subkomponen)) {
    $cek_subkomponen			  = mysqli_query($con, "SELECT * FROM ref_subkomponen WHERE kode_subkomponen='$edit_kd_subkomponen'");
  }
  elseif(($id_komponen==$edit_komponen) AND ($nama_subkomponen!=$edit_nama_subkomponen) AND ($kode_subkomponen==$edit_kd_subkomponen)) {
    $cek_subkomponen			  = mysqli_query($con, "SELECT * FROM ref_subkomponen WHERE nama_subkomponen='$edit_nama_subkomponen'");
  }
  elseif(($id_komponen!=$edit_komponen) AND ($nama_subkomponen==$edit_nama_subkomponen) AND ($kode_subkomponen==$edit_kd_subkomponen)) {
    $cek_subkomponen			  = mysqli_query($con, "SELECT * FROM ref_subkomponen WHERE id_komponen='$edit_komponen' AND kode_subkomponen='$edit_kd_subkomponen' AND nama_subkomponen='$edit_nama_subkomponen'");
  }
  elseif(($id_komponen==$edit_komponen) AND ($nama_subkomponen==$edit_nama_subkomponen) AND ($kode_subkomponen==$edit_kd_subkomponen)) {
    $cek_subkomponen			  = mysqli_query($con, "SELECT * FROM ref_subkomponen WHERE kode_subkomponen='$edit_kd_subkomponen' OR nama_subkomponen='$edit_nama_subkomponen'");
  }
  

  if (mysqli_num_rows($cek_subkomponen)>0) {
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
        window.location='index?page=sub-komponen'
      });
      </script>";
  } else {
    $edit_query			  = mysqli_query($con, "UPDATE ref_subkomponen SET id_komponen='$edit_komponen', kode_subkomponen='$edit_kd_subkomponen', nama_subkomponen='$edit_nama_subkomponen' WHERE id_subkomponen=$edit_id_subkomponen");
    $query_log        = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Memperbarui data sub komponen')");
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
        window.location='index?page=sub-komponen'
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
        window.location='index?page=sub-komponen'
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

  // $id_kegiatan	     	= mysqli_real_escape_string($con, $_POST['kegiatan']);
  // $cek_kd_kegiatan    = mysqli_query($con, "SELECT * FROM ref_kegiatan WHERE id_kegiatan='$id_kegiatan'");
  // while ($rowKeg  = mysqli_fetch_array($cek_kd_kegiatan)) { 
  //       $kd_keg   = $rowKeg['kode_kegiatan'];
  // }

  $id_komponen	     	= mysqli_real_escape_string($con, $_POST['komponen']);
  // $cek_kd_komponen    = mysqli_query($con, "SELECT * FROM ref_komponen WHERE id_komponen='$id_komponen'");
  // while ($rowKomp   = mysqli_fetch_array($cek_kd_komponen)) { 
  //       $kd_komp    = $rowKomp['kode_komponen'];
  // }

  $kd_subkomponen	    = mysqli_real_escape_string($con, $_POST['kd_subkomponen']);
  $subkomponen	      = mysqli_real_escape_string($con, $_POST['subkomponen']);

  // $kode_subkomponen = $kd_keg.".".$kd_komp.".".$kd_subkomponen;



  // $cek_subkomponen		= mysqli_query($con, "SELECT * FROM ref_subkomponen WHERE kode_subkomponen='$kd_subkomponen' OR nama_subkomponen='$subkomponen'");
  // if (mysqli_num_rows($cek_subkomponen)>0) {
  //   echo "
  //     <script>
  //     swal({
  //       title: 'Peringatan',
  //       text: 'Data sudah tersedia',
  //       type: 'warning',
  //       showCancelButton: false,
  //       cancelButtonText: 'No, Cancel!',
  //       confirmButtonText: 'Oke',
  //       closeOnConfirm: true
  //     }, function(isConfirm){
  //       window.location='index?page=sub-komponen'
  //     });
  //     </script>";
  // } else {
    $add_query			= mysqli_query($con, "INSERT INTO ref_subkomponen VALUES (NULL, '$id_komponen', '$kd_subkomponen', '$subkomponen')");
    $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menambahkan data sub komponen')");
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
          window.location='index?page=sub-komponen'
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
          window.location='index?page=sub-komponen'
        });
        </script>";
      }
  // }
}

//proses hapus data
if(isset($_GET['id_subkomponen'])){
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $id_subkomponen 	= base64_decode($_GET['id_subkomponen']);
  $delete_query = mysqli_query($con, "DELETE FROM ref_subkomponen WHERE id_subkomponen='$id_subkomponen'");
  $query_log    = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menghapus data sub komponen')");
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
          window.location='index.php?page=sub-komponen'
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
          window.location='index.php?page=sub-komponen'
        });
      </script>";
  }
}

//proses kosongkan table
if ($_POST['truncate_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE ref_subkomponen");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel data sub komponen')");
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
          window.location='index.php?page=sub-komponen'
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
          window.location='index.php?page=sub-komponen'
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
          <li class="breadcrumb-item active">Sub Komponen</li>
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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Daftar Sub Komponen  - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="example1" class="table table-hover table-condensed">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center align-middle" width="10px">No</th>
                    <th class="text-center align-middle">Kode Sub Komponen</th>
                    <th class="text-center align-middle">Nama Sub Komponen</th>
                    <th class="text-center align-middle" width="100px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      $sql = mysqli_query($con, "SELECT * FROM view_subkomponen") or die(mysqli_error($con));
                      $counter = 1;
                      while ($row = mysqli_fetch_array($sql)) {
                    ?>
                  <tr>
                    <td class="text-center"><?=$counter++?></td>
                    <td class="text-center"><?=$row['kode_kegiatan'].".".$row['kode_komponen'].".".$row['kode_subkomponen']?></td>
                    <td class="align-middle">
                        <div class=text-primary><b><?=$row['nama_subkomponen']?></b></div><br>
                        <div class=text-muted>
                        <b>Program : </b><?=$row['kode_program']. " - " .$row['nama_program']?> (<?=$row['tahun']?>)<br>
                        <b>Kegiatan : </b> <?=$row['kode_kegiatan']. " - " .$row['nama_kegiatan']?><br>
                        <b>Komponen : </b> <?=$row['kode_komponen']. " - " .$row['nama_komponen']?>
                        </div>
                    </td>
                    <td class="text-center align-middle">
                      <button style="margin-top:2px" rel="tooltip" data-toggle="modal" data-id="<?=$row['id_subkomponen']?>" data-target="#modal_edit" data-placement="top" title="Edit Data" class='btn btn-sm btn-outline-success'><span class="oi oi-pencil"></span></button>

                      <button style="margin-top:2px" onClick="confirm_delete('index?page=sub-komponen&id_subkomponen=<?php echo base64_encode($row['id_subkomponen']);?>')" rel="tooltip" data-toggle="modal" data-target="#modal_delete" data-placement="top" title="Hapus Data" class='btn btn-sm btn-outline-danger'><span class="oi oi-trash"></span></button>
                    </td>
                  </tr>
                  
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

<!-- Modal Popup untuk edit data-->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center bg-primary">
        <h4 class="modal-title w-100">Edit Data SubKomponen</h4>
      </div>
        <div class="modal-data"></div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Popup untuk tambah data-->
<div id="modal_tambah" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center bg-primary">
        <h4 class="modal-title w-100">Tambah Data Sub-Komponen</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form id="add_form" action="" method="post">
              <div class="form-group">
                <label for="program">Program*</label>
                <input type="text" name="program" id="program" parsley-trigger="change" class="form-control" required readonly>
              </div>
          </div>

          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="kegiatan">Pilih Kegiatan*</label>
                  <select name="kegiatan" id="kegiatan" class="form-control select2bs4" onchange="changeValue(this.value)">
                    <option disabled selected>Pilih Kegiatan</option>
                    
                    <?php                  
                      // Buat query untuk menampilkan semua data siswa
                      $sql = mysqli_query($con, "SELECT * FROM view_kegiatan");
                      $jsArray = "var prdProgram = new Array();\n";

                      while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
                        echo "<option value='".$data['id_kegiatan']."'>".$data['kode_kegiatan']." - ".$data['nama_kegiatan']."</option>";
                        $jsArray .= "prdProgram['" . $data['id_kegiatan'] . "'] = {nama_program:'" . addslashes($data['nama_program']) . "', kode_program:'".addslashes($data['kode_program'])."', tahun:'".addslashes($data['tahun'])."'};\n";
                      }
                    ?>
                  </select>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="komponen">Pilih Komponen*</label>
                  <select name="komponen" id="komponen" class="form-control select2bs4">
                    <option value="">Pilih komponen</option>
                  </select>

                  <div id="loading" style="margin-top: 15px;">
                    <img src="../assets/images/loading.gif" width="18"> <small>Loading...</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <form id="add_form" action="" method="post">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="kd_subkomponen">Kode Sub-Komponen*</label>
                      <input type="text" name="kd_subkomponen" id="kd_subkomponen" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="subkomponen">Nama Sub-Komponen*</label>
                      <input type="text" name="subkomponen" id="subkomponen" class="form-control" required>
                    </div>  
                </div>
              </div>
            </div>

            <!-- <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="kd_detail">Kode Detail*</label>
                      <input type="text" name="kd_detail" id="kd_detail" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="detail">Nama Detail*</label>
                      <input type="text" name="detail" id="detail" class="form-control" required>
                    </div>  
                </div>
              </div>
              <hr>
            </div>

            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="kd_subdetail">Kode Sub-Detail*</label>
                      <input type="text" name="kd_subdetail" id="kd_subdetail[]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="subdetail">Nama Sub-Detail*</label>
                      <input type="text" name="subdetail" id="subdetail[]" class="form-control" required>
                    </div>  
                </div>
              </div>
            </div>
            
            <div class="col-md-12">
              <div id="insert-form"></div>
            </div> -->
          </form>
          <!-- <input type="hidden" id="jumlah-form" value="1"> -->

        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-arrow-left"></i> Kembali</button>
        <!-- <div style="text-align:right">
          <button type="button" id="btn-tambah-form" class="btn btn-primary"> Tambah Sub-Detail </button>
          <button type="button" id="btn-reset-form" class="btn btn-primary">Reset</button>
         </div> -->
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
        <p align="center">Anda akan menghapus SELURUH data <b>SUB KOMPONEN</b>. Peringatan! data yang telah dihapus tidak dapat dikembalikan.</p>
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
        title: 'DAFTAR SUB KOMPONEN - BPTP Papua Barat',
        pageSize: 'A4',
        exportOptions: {
          columns: [0, 1, 2]
        },
        customize: function ( xlsx ){
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
            $('c[r=A1] t', sheet).text( 'DAFTAR SUB KOMPONEN - BPTP Papua Barat' );
            $('row:first c', sheet).attr( 's', '2' );
        }
      },
      {
        extend: 'pdf',
        title: 'DAFTAR SUB KOMPONEN - BPTP Papua Barat',
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
        title: 'DAFTAR SUB KOMPONEN - BPTP Papua Barat',
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

<!-- script select bertingkat -->
<script>
  $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
	// Kita sembunyikan dulu untuk loadingnya
	$("#loading").hide();
	
	$("#kegiatan").change(function(){ // Ketika user mengganti atau memilih data provinsi
		$("#komponen").hide(); // Sembunyikan dulu combobox kota nya
		$("#loading").show(); // Tampilkan loadingnya
	
		$.ajax({
			type: "POST", // Method pengiriman data bisa dengan GET atau POST
			url: "referensi/sub-komponen/option_komponen.php", // Isi dengan url/path file php yang dituju
			data: {kegiatan : $("#kegiatan").val()}, // data yang akan dikirim ke file yang dituju
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
				$("#komponen").html(response.data_komponen).show();
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
                url : 'referensi/sub-komponen/edit-sub-komponen.php',
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

<!-- Autofill form -->
<script type="text/javascript">    
    <?php echo $jsArray; ?>  
    function changeValue(x){  
      document.getElementById('program').value = prdProgram[x].kode_program + " - " +prdProgram[x].nama_program+ " - " +prdProgram[x].tahun;  
    }; 
</script> 

<!-- Add form -->
<!-- <script type="text/javascript">
  $(document).ready(function(){
  $("#btn-tambah-form").click(function(){
    var jumlah = parseInt($("#jumlah-form").val());
    var nextform = jumlah + 1;

    $("#insert-form").append($(
        "<div class='row'>" +
          "<div class='col-md-6'>" +
              "<div class='form-group'>" +
                "<label for='kd_subdetail'>Kode Sub-Detail*</label>" +
                "<input type='text' name='kd_subdetail' id='kd_subdetail[]' class='form-control' required>" +
              "</div>" +
          "</div>" +
          "<div class='col-md-6'>" +
              "<div class='form-group'>" +
                "<label for='subdetail'>Nama Sub-Detail*</label>" +
                "<input type='text' name='subdetail' id='subdetail[]' class='form-control' required>" +
              "</div>" + 
          "</div>" +
        "</div>"));

    $("#jumlah-form").val(nextform);
  });

  // Buat fungsi untuk mereset form ke semula
  $("#btn-reset-form").click(function(){
    $("#insert-form").html("");
    $("#jumlah-form").val("1");
  });
});
</script> -->

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