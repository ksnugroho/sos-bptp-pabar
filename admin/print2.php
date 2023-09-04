<?php
include '../koneksi/koneksi.php';
// error_reporting(0);
// $user_email = $_SESSION['user'];
// if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
// {
//     header('location:../login.php');
// }

$program = $_POST['program'];
$tgl_program = $_POST['tgl_program'];
$lap_program = $_POST['lap_program'];

// Program
$query = mysqli_query($con, "SELECT kode_program, nama_program, tahun, SUM(harga) as total_program FROM view_tsc_beli where kode_program = '$program'");
$rows = mysqli_fetch_assoc($query);
$th_program = $rows['tahun'];
$kode_program = $rows['kode_program'];
$nama_program = $rows['nama_program'];
$total_program = $rows['total_program'];

// Kegiatan
$query2 = mysqli_query($con, "SELECT kode_kegiatan, nama_kegiatan, SUM(harga) as total_kegiatan FROM view_tsc_beli where kode_program = '$program'");
while($rows2 = mysqli_fetch_array($query2)){
    $kode_kegiatan = $rows2['kode_kegiatan'];
    $nama_kegiatan = $rows2['nama_kegiatan'];
    $total_kegiatan = $rows2['total_kegiatan'];
}

// Komponen
// $query3 = mysqli_query($con, "SELECT kode_komponen, nama_komponen, SUM(harga) as total_komponen FROM view_tsc_beli where kode_program = '$program' GROUP BY kode_komponen");
// while($rows3 = mysqli_fetch_array($query3)){
//     $kode_komponen = $rows3['kode_komponen'];
//     $nama_komponen = $rows3['nama_komponen'];
//     $total_komponen = $rows3['total_komponen'];
// }


function rupiah($angka){
	$hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
	return $hasil_rupiah;
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
?>
<html moznomarginboxes mozdisallowselectionprint>
<head>
	<title>SOSys | BPTP PAPUA BARAT</title>
	<link rel="shortcut icon" href="../assets/images/bptp-pabar-logo.png">
  	<link href="../assets/images/bptp-pabar-logo.png" rel="apple-touch-icon">
 	<style>
		body {
		  background: rgb(204,204,204);
		}
		page {
		  background: white;
		  display: block;
		  margin: 0 auto;
		  margin-bottom: 0.5cm;
		  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
		    /* background-image: url('../../assets/img/smk450.png') !important; */
		    background-repeat: no-repeat !important;
		    background-position: center !important;
		}
		page[size="A4"] {
		  width: 21cm;
		  height: 29.7cm;
		}
		@page {
		  size: A4;
		  margin: 0;

		}
		@media print {
		  body, page {
		  	-webkit-print-color-adjust: exact !important;

		  	color-adjust: exact;
		    margin: 0;
		    box-shadow: 0;
		  }
		  table {
		    max-height: 100% !important;
		    /* overflow: hidden !important;
		    page-break-after: always; */
		  }

		}
	</style>
    <style type="text/css">
		#tbutama {
		    border-collapse: collapse;
		}
 
		#tbutama{
		    border: 1px solid black;
		}
	</style>
</head>
<body>
<section class="content">
  <page size="A4">
      <table style="font-family:Times; font-size:12pt; margin-left:auto; margin-right:auto; line-height:17pt; width:auto; padding-top: 25;" border="0">
        <tr>
          <td colspan="5">
            <div align="center"><h4>RINCIAN KERTAS KERJA SATKER T.A. <?php echo $th_program; ?></h4></div>
          </td>
        </tr>
        <tr>
            <table style="font-family:Times; font-size:10pt; margin-left: 30;" border="0">
                <tr>
                    <td style="width: 15%;"><b>KEMEN/LEMB</b></td>
                    <td style="width: 10%;">(018)</td>
                    <td style="width: 50%;">KEMENTERIAN PERTANIAN</td>
                </tr>
                <tr>
                    <td style="width: 15%;"><b>UNIT ORG</b></td>
                    <td style="width: 10%;">(09)</td>
                    <td style="width: 50%;">Badan Penelitian dan Pengembangan Pertanian</td>
                </tr>
                <tr>
                    <td style="width: 15%;"><b>UNIT KERJA</b></td>
                    <td style="width: 10%;">(450871)</td>
                    <td style="width: 50%;">BALAI PENGKAJIAN TEKNOLOGI PERTANIAN PAPUA BARAT</td>
                </tr>
            <table>
        </tr>
        <tr>
            <table border="1" id="tbutama" style="font-family:Times; font-size:8pt; width:93%; margin-left: 30;">
                <tr>
                    <td rowspan=2 height="40" align="center" valign=middle style="width:8%"><b>Kode</b></td>
                    <td rowspan=2 align="center" valign=middle style="width:40%"><b>PROGRAM/ AKTIVITAS/ KRO/ RO/ KOMPONEN/SUBKOMP/DETIL</b></td>
                    <td colspan=3 align="center" valign=middle><b>Perhitungan Tahun <?php echo $th_program; ?></b></td>
                    <td rowspan=2 align="center" valign=middle style="width:10%"><b>SD/CP</b></td>
                </tr>
                <tr>
                    <td align="center" valign=middle><b>Volume</b></td>
                    <td align="center" valign=middle><b>Harga Satuan</b></td>
                    <td align="center" valign=middle><b>Jumlah Biaya</b></td>
                    </tr>
                <tr>
                    <td height="20" align="center" valign=middle sdval="1" sdnum="1033;">(1)</td>
                    <td align="center" valign=middle sdval="2" sdnum="1033;">(2)</td>
                    <td align="center" valign=middle sdval="3" sdnum="1033;">(3)</td>
                    <td align="center" valign=middle sdval="4" sdnum="1033;">(4)</td>
                    <td align="center" valign=middle sdval="5" sdnum="1033;">(5)</td>
                    <td align="center" valign=middle sdval="6" sdnum="1033;">(6)</td>
                </tr>
                <tr>
                    <td height="20" align="left">
                        <!-- Program -->
                        <span style="color:blue;"><?php echo $kode_program; ?></span>
                    </td>
                    <td align="left">
                        <!-- Program -->
                        <span style="color:blue;"><?php echo $nama_program; ?></span>
                    </td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="right">
                        <!-- Program -->
                        <span style="color:blue;"><?php echo rupiah($total_program); ?></span>
                    </td>
                    <td align="left">&nbsp;</td>
                </tr>
                <tr>
                    <td height="20" align="left">
                        <!-- Kegiatan -->
                        <span style="color:red;">&nbsp;<?php echo $kode_kegiatan; ?></span>
                    </td>
                    <td align="left">
                        <!-- Kegiatan -->
                        <span style="color:red;"><?php echo $nama_kegiatan; ?></span>
                    </td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="right">
                        <!-- Kegiatan -->
                        <span style="color:red;"><?php echo rupiah($total_kegiatan); ?></span>
                    </td>
                    <td align="left">&nbsp;</td>
                </tr>
                <?php
                    $query3 = mysqli_query($con, "SELECT kode_komponen, nama_komponen, SUM(harga) as total_komponen FROM view_tsc_beli where kode_program = '$program' GROUP BY kode_komponen");
                    while($rows3 = mysqli_fetch_array($query3)){
                        $kode_komponen = $rows3['kode_komponen'];
                        $query4 = mysqli_query($con, "SELECT kode_subkomponen, nama_subkomponen, SUM(harga) as total_subkomponen FROM view_tsc_beli where kode_program = '$program' AND kode_kegiatan='$kode_kegiatan' GROUP BY nama_subkomponen");
                        while($rows4 = mysqli_fetch_array($query4)){
                ?>
                <tr>
                    <td height="20" align="left">
                        <!-- Komponen -->
                        <div>&nbsp;&nbsp;<b><?php echo $rows3['kode_komponen']; ?></b></div>
                        <div>&nbsp;&nbsp;<?php echo $rows4['kode_subkomponen']; ?></div>
                    </td>
                    <td align="left">
                        <!-- komponen -->
                        <div><b><?php echo $rows3['nama_komponen']; ?></b></div>
                        </div><?php echo $rows4['nama_subkomponen']; ?></div>
                    </td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                    <td align="right">
                        <!-- komponen -->
                        <div><b><?php echo rupiah($rows3['total_komponen']); ?></b></div>
                        <div><?php echo rupiah($rows4['total_subkomponen']); ?></div>
                    </td>
                    <td align="left">&nbsp;</td>
                </tr>
                <?php 
                        }
                    } 
                ?>
            </table>
        </tr>
    </table>
  </page>
</section>

</body>
</html>
<!-- <script>
    window.print();
</script> -->


<!-- <script language="JavaScript">
document.addEventListener("contextmenu", function(e){
    e.preventDefault();
}, false);
</script> -->
