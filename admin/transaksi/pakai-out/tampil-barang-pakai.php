<?php
include '../../../koneksi/koneksi.php';

?>
<div class="table-responsive">
    <table id="example1" class="table table-hover table-condensed">
    <thead class="thead-light">
        <tr>
            <th class="text-center align-middle" width="10px">No</th>
            <th class="text-center align-middle">Kode Barang</th>
            <th class="text-center align-middle">Nama Barang</th>
            <th class="text-center align-middle">Jumlah</th>
            <th class="text-center align-middle" width="100px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = mysqli_query($con, "SELECT * FROM view_sementara_pakai") or die(mysqli_error($con));
            $counter = 1;
            while ($row = mysqli_fetch_array($sql)) {
                $id = $row['id_pakai_sementara'];
        ?>
        <tr <?php if ($row['jumlah_pakai_sementara'] > $row['jumlah_ready']) { echo "class='bg-danger'"; } ?>>
            <td class="text-center align-middle"><?=$counter++?></td>
            <td class="text-center align-middle"><?=$row['kd_barang_pakai_sementara']?></td>
            <td class="align-middle"><div class=text-primary><b><?=$row['nama_barang_pakai_sementara']?></b></div></td>
            <td class="text-center align-middle"><?=$row['jumlah_pakai_sementara']?> <?=$row['nama_pakai_satuan']?></td>
            <td class="text-center align-middle">
                <button id="<?php echo $id; ?>" title="Hapus" class='btn btn-sm <?php if ($row['jumlah_pakai_sementara'] > $row['jumlah_ready']) { echo "btn-secondary"; } else { echo "btn-outline-danger"; } ?>  hapus_data'><span class="oi oi-trash"></span></button>
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
            url: "transaksi/pakai-out/hapus-barang-pakai.php",
            data: {id:id},
            success: function() {
                $('.tampildata').load("transaksi/pakai-out/tampil-barang-pakai.php");
                $('.tampiltombolsimpan').load("transaksi/pakai-out/tampil-tombol-simpan.php");
            }, error: function(response){
                console.log(response.responseText);
            }
        });
    });
</script>