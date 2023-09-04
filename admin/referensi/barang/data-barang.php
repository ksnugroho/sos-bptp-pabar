<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
include '../koneksi/koneksi.php';
// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
  header('location:../login');
}

// proses edit data
if ($_POST['edit_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $edit_id_barang     = $_POST['edit_id_barang'];
  $edit_kd_barang     = mysqli_real_escape_string($con, $_POST['edit_kd_barang']);
  $edit_nm_barang     = mysqli_real_escape_string($con, $_POST['edit_nm_barang']);
  $edit_desc_barang    = mysqli_real_escape_string($con, $_POST['edit_desc_barang']);
  $edit_id_kategori    = mysqli_real_escape_string($con, $_POST['edit_id_kategori']);
  $edit_id_jenis      = mysqli_real_escape_string($con, $_POST['edit_id_jenis']);
  $edit_id_satuan      = mysqli_real_escape_string($con, $_POST['edit_id_satuan']);
  $cek_jenis          = mysqli_query($con, "SELECT * FROM ref_barang WHERE kode_barang='$edit_kd_barang' AND nama_barang='$edit_nm_barang' AND desc_barang='$edit_desc_barang' AND id_kategori=$edit_id_kategori AND id_jenis=$edit_id_jenis AND id_satuan=$edit_id_satuan");
  if (mysqli_num_rows($cek_jenis) > 0) {
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
        window.location='index?page=barang'
      });
      </script>";
  } else {
    $edit_query        = mysqli_query($con, "UPDATE ref_barang SET kode_barang='$edit_kd_barang', nama_barang='$edit_nm_barang', desc_barang='$edit_desc_barang', id_kategori=$edit_id_kategori, id_jenis=$edit_id_jenis, id_satuan=$edit_id_satuan WHERE id_barang=$edit_id_barang");
    $query_log        = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Memperbarui data barang')");
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
        window.location='index?page=barang'
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
        window.location='index?page=barang'
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

  $kd_barang      = mysqli_real_escape_string($con, $_POST['kd_barang']);
  $nm_barang      = mysqli_real_escape_string($con, $_POST['nm_barang']);
  $desc_barang    = mysqli_real_escape_string($con, $_POST['desc_barang']);
  $id_kategori    = mysqli_real_escape_string($con, $_POST['id_kategori']);
  $id_jenis        = mysqli_real_escape_string($con, $_POST['id_jenis']);
  $id_satuan      = mysqli_real_escape_string($con, $_POST['id_satuan']);
  $cek_jenis      = mysqli_query($con, "SELECT * FROM ref_barang WHERE kode_barang='$kd_barang' AND nama_barang='$nm_barang'");
  if (mysqli_num_rows($cek_jenis) > 0) {
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
        window.location='index?page=agen'
      });
      </script>";
  } else {
    $add_query      = mysqli_query($con, "INSERT INTO ref_barang VALUES (NULL, '$kd_barang', $id_kategori, $id_jenis, $id_satuan, '$nm_barang', '$desc_barang', 0)");
    $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menambahkan data barang')");
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
          window.location='index?page=barang'
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
          window.location='index?page=barang'
        });
        </script>";
    }
  }
}

//proses hapus data
if (isset($_GET['id_barang'])) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $id_barang   = base64_decode($_GET['id_barang']);
  $delete_query = mysqli_query($con, "DELETE FROM ref_barang WHERE id_barang='$id_barang'");
  $query_log    = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Menghapus data barang')");
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
          window.location='index.php?page=barang'
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
          window.location='index.php?page=barang'
        });
      </script>";
  }
}

//proses kosongkan table
if ($_POST['truncate_data']) {
  $user_login = $_SESSION['user'];
  $datestamp = date('Y-m-d');
  $waktustamp = date('H:i:s');

  $truncate_query = mysqli_query($con, "TRUNCATE TABLE ref_barang");
  $query_log      = mysqli_query($con, "INSERT INTO log_aktivitas(id_log, tanggal, waktu, user_login, aktivitas) VALUES(null, '$datestamp', '$waktustamp', '$user_login','Mengosongkan tabel data barang')");
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
          window.location='index.php?page=barang'
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
          window.location='index.php?page=barang'
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
          <li class="breadcrumb-item active">Barang</li>
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
            <h3 class="card-title"><span class="oi oi-info"></span>&nbsp; Daftar Barang - BPTP Papua Barat</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="example1" class="table table-hover table-condensed">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center align-middle" width="10px">No</th>
                    <th class="text-center align-middle">Kode Barang</th>
                    <th class="text-center align-middle">Nama Barang</th>
                    <th class="text-center align-middle">Kategori & Jenis</th>
                    <th class="text-center align-middle">Satuan</th>
                    <th class="text-center align-middle">Deskripsi</th>
                    <th class="text-center align-middle" width="100px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = mysqli_query($con, "SELECT * FROM view_barang ORDER BY kode_barang") or die(mysqli_error($con));
                  $counter = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <tr>
                      <td class="text-center"><?= $counter++ ?></td>
                      <td class="text-center"><?= $row['kode_barang'] ?></td>
                      <td><?= $row['nama_barang'] ?></td>
                      <td>
                        Kategori: <?= $row['nama_kategori'] ?><br>
                        Jenis: <?= $row['nama_jenis'] ?>
                      </td>
                      <td class="text-center"><?= $row['nama_satuan'] ?></td>
                      <td><?= $row['desc_barang'] ?></td>
                      <td class="text-center align-middle">
                        <button style="margin-top:2px" href="#" rel="tooltip" data-toggle="modal" data-target="#modal_edit<?php echo $row['id_barang']; ?>" data-placement="top" title="Edit Data" class='btn btn-sm btn-outline-success'><span class="oi oi-pencil"></span></button>
                        <button style="margin-top:2px" onClick="confirm_delete('index?page=barang&id_barang=<?php echo base64_encode($row['id_barang']); ?>')" rel="tooltip" data-toggle="modal" data-target="#modal_delete" data-placement="top" title="Hapus Data" class='btn btn-sm btn-outline-danger'><span class="oi oi-trash"></span></button>
                      </td>
                    </tr>
                    <!-- Modal Popup untuk edit data-->
                    <div id="modal_edit<?php echo $row['id_barang']; ?>" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header text-center bg-primary">
                            <h4 class="modal-title w-100">Edit Data Barang</h4>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12">
                                <form action="" method="post">
                                  <?php
                                  $data_edit = mysqli_query($con, "SELECT * FROM ref_barang WHERE id_barang=$row[id_barang]");
                                  while ($row1 = mysqli_fetch_array($data_edit)) {
                                  ?>
                                    <div class="form-group">
                                      <label for="edit_kd_barang">Kode Barang</label>
                                      <input type="hidden" name="edit_id_barang" class="form-control" value="<?php echo $row1['id_barang']; ?>" />
                                      <input type="text" name="edit_kd_barang" class="form-control" value="<?php echo $row1['kode_barang']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                      <label for="edit_nm_barang">Nama Barang</label>
                                      <input type="text" name="edit_nm_barang" class="form-control" id="edit_nm_barang" value="<?php echo $row1['nama_barang']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                      <label for="edit_desc_barang">Deskripsi Barang</label>
                                      <textarea type="text" name="edit_desc_barang" class="form-control" id="edit_desc_barang" rows="2"><?php echo $row1['desc_barang']; ?></textarea>
                                    </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="edit_id_kategori">Kategori Barang</label>
                                  <select name="edit_id_kategori" class="form-control select2bs4" required>
                                    <option disabled>Pilih Kategori</option>
                                    <?php
                                    $sql_kategori = mysqli_query($con, "SELECT * FROM master_kategori");
                                    while ($data_kategori = mysqli_fetch_array($sql_kategori)) {
                                      if ($data_kategori['nama_kategori'] == $row['nama_kategori']) {
                                        $select = "selected";
                                      } else {
                                        $select = "";
                                      }
                                      echo '<option value="' . $data_kategori['id_kategori'] . '" ' . $select . '>' . $data_kategori['nama_kategori'] . '</option>';
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="edit_id_jenis">Jenis Barang</label>
                                  <select name="edit_id_jenis" class="form-control select2bs4" required>
                                    <option disabled>Pilih Jenis</option>
                                    <?php
                                    $sql_jenis = mysqli_query($con, "SELECT * FROM master_jenis ORDER BY id_jenis");
                                    while ($data_jenis = mysqli_fetch_array($sql_jenis)) {
                                      if ($data_jenis['nama_jenis'] == $row['nama_jenis']) {
                                        $select = "selected";
                                      } else {
                                        $select = "";
                                      }
                                      echo '<option value="' . $data_jenis['id_jenis'] . '" ' . $select . '>' . $data_jenis['nama_jenis'] . '</option>';
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="edit_id_satuan">Satuan Barang</label>
                                  <select name="edit_id_satuan" class="form-control select2bs4" required>
                                    <option disabled>Pilih Satuan</option>
                                    <?php
                                    $sql_satuan = mysqli_query($con, "SELECT * FROM master_satuan ORDER BY id_satuan");
                                    while ($data_satuan = mysqli_fetch_array($sql_satuan)) {
                                      if ($data_satuan['nama_satuan'] == $row['nama_satuan']) {
                                        $select = "selected";
                                      } else {
                                        $select = "";
                                      }
                                      echo '<option value="' . $data_satuan['id_satuan'] . '" ' . $select . '>' . $data_satuan['nama_satuan'] . '</option>';
                                    }
                                    ?>
                                  </select>
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
        <h4 class="modal-title w-100">Tambah Data Barang</h4>
      </div>
      <div class="modal-body">
        <?php
        $kode = mysqli_fetch_array(mysqli_query($con, "SELECT max(kode_barang) as max_kode FROM ref_barang"));
        $max_kode = $kode['max_kode'];

        $urutan_kode = (int)$max_kode;
        $urutan_kode++;

        $kode_barang = sprintf("%05s", $urutan_kode);
        ?>
        <div class="row">
          <div class="col-md-12">
            <form id="add_form" action="" method="post">
              <div class="form-group">
                <label for="kd_barang">Kode Barang</label>
                <input type="text" name="kd_barang" class="form-control" id="kd_barang" value="<?php echo $kode_barang; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="nm_barang">Nama Barang</label>
                <input type="text" name="nm_barang" class="form-control" id="nm_barang" required>
              </div>
              <div class="form-group">
                <label for="desc_barang">Deskripsi Barang</label>
                <textarea type="text" name="desc_barang" class="form-control" id="desc_barang" rows="2"></textarea>
              </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="id_kategori">Kategori Barang</label>
              <select name="id_kategori" id="id_kategori" class="form-control select2bs4" required>
                <option value="">Pilih Kategori</option>
                <?php
                $sql_kategori = mysqli_query($con, "SELECT * FROM master_kategori");
                while ($data_kategori = mysqli_fetch_array($sql_kategori)) {
                  echo "<option value='" . $data_kategori['id_kategori'] . "'>" . $data_kategori['nama_kategori'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="id_jenis">Jenis Barang</label>
              <select name="id_jenis" id="id_jenis" class="form-control select2bs4" required>
                <option value="">Pilih Jenis</option>
                <?php
                $sql_jenis = mysqli_query($con, "SELECT * FROM master_jenis");
                while ($data_jenis = mysqli_fetch_array($sql_jenis)) {
                  echo "<option value='" . $data_jenis['id_jenis'] . "'>" . $data_jenis['nama_jenis'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="id_satuan">Satuan Barang</label>
              <select name="id_satuan" id="id_satuan" class="form-control select2bs4" required>
                <option value="">Pilih Satuan</option>
                <?php
                $sql_satuan = mysqli_query($con, "SELECT * FROM master_satuan");
                while ($data_satuan = mysqli_fetch_array($sql_satuan)) {
                  echo "<option value='" . $data_satuan['id_satuan'] . "'>" . $data_satuan['nama_satuan'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-arrow-left"></i> Kembali</button>
        <button form="add_form" id="add_data" name="add_data" value="add_data" type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp; Simpan</button>
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
          title: 'DAFTAR BARANG - BPTP Papua Barat',
          pageSize: 'A4',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
          },
          customize: function(xlsx) {
            var sheet = xlsx.xl.worksheets['sheet1.xml'];
            $('c[r=A1] t', sheet).text('DAFTAR BARANG - BPTP Papua Barat');
            $('row:first c', sheet).attr('s', '2');
          }
        },
        {
          extend: 'pdf',
          title: 'DAFTAR BARANG - BPTP Papua Barat',
          pageSize: 'A4',
          orientation: 'portrait',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5],
            stripNewlines: false
          },
          customize: function(doc) {
            doc.styles.tableHeader.alignment = 'center';
            doc.content[1].table.widths = ['5%', '15%', '20%', '30%', '10%', '20%'];
          }
        },
        {
          extend: 'print',
          text: '<u>P</u>rint',
          title: 'DAFTAR BARANG - BPTP Papua Barat',
          pageSize: 'A4',
          orientation: 'portrait',
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