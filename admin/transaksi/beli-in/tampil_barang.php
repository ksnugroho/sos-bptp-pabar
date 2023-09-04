<?php
include '../../../koneksi/koneksi.php';

// error_reporting(0);
// if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
// {
//     header('location:../../../login.php');
// }

?>
<div class="table-responsive">
    <table id="example1" class="table table-hover table-condensed">
    <thead class="thead-light">
        <tr>
        <th class="text-center align-middle" width="10px">No</th>
        <th class="text-center align-middle">Kode Barang</th>
        <th class="text-center align-middle">Nama Barang</th>
        <th class="text-center align-middle">Jumlah</th>
        <th class="text-center align-middle">Harga</th>
        <th class="text-center align-middle">Total</th>
        <th class="text-center align-middle" width="100px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = mysqli_query($con, "SELECT * FROM view_sementara") or die(mysqli_error($con));
            $counter = 1;
            while ($row = mysqli_fetch_array($sql)) {
                $id = $row['id_sementara'];
        ?>
        <tr>
        <td class="text-center align-middle"><?=$counter++?></td>
        <td class="text-center align-middle"><?=$row['kd_barang_sementara']?></td>
        <td class="align-middle"><div class=text-primary><b><?=$row['nama_barang_sementara']?></b></div></td>
        <td class="text-center align-middle"><?=$row['jumlah_sementara']?> <?=$row['nama_satuan']?></td>
        <td class="text-center align-middle"><?php echo "Rp. " . number_format($row['harga_sementara'], 2, ",", ".");?></td>
        <td class="text-center align-middle"><?php $totalharga = $row['harga_sementara']*$row['jumlah_sementara']; echo "Rp. " . number_format($totalharga, 2, ",", ".");?></td>
        <td class="text-center align-middle">
            <button id="<?php echo $id; ?>" title="Hapus" class='btn btn-sm btn-outline-danger hapus_data'><span class="oi oi-trash"></span></button>
        </td>
        </tr>
        <?php } ?>
    </tbody>
    </table>
</div>

<script>
$(document).on('click', '.hapus_data', function(){
        var id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: "transaksi/beli-in/hapus_barang.php",
            data: {id:id},
            success: function() {
                $('.tampildata').load("transaksi/beli-in/tampil_barang.php");
            }, error: function(response){
                console.log(response.responseText);
            }
        });
    });
</script>