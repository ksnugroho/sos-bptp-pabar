<?php
include '../../koneksi/koneksi.php';
session_start();
$_SESSION['usertype'];
$user_email = $_SESSION['user'];
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
    header('location:../../login/login.php');
}

$get_id = $_GET['id'];
$query = mysqli_query($con, "SELECT * FROM upload_document where id = '$get_id'");
$rows = mysqli_fetch_assoc($query);
$email = $rows['user_email'];
$paymentStatus = $rows['payment_status'];
$conf_id = $rows['conf_id'];

$sql = mysqli_query($con,"select * from conference_tb where id = '$conf_id'");
$conf_row = mysqli_fetch_assoc($sql);

$fee_query = mysqli_query($con, "select * from upload_document where conf_id ='$conf_id' and email='$user_email' and id = '$get_id'");
$data = mysqli_fetch_assoc($fee_query);

$get_pay = mysqli_query($con,"select * from user_tb where email='$user_email'");
$data_pay = mysqli_fetch_assoc($get_pay);

$get_user = mysqli_query($con,"select * from user_profile where email='$user_email'");
$data_user = mysqli_fetch_assoc($get_user);

function rupiah($angka){

	$hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
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
</head>
<body>
<section class="content">
  <page size="A4">
      <table style="font-family:Times; font-size:12pt; margin-left:auto; margin-right:auto; line-height:17pt; width:auto; padding-top: 25;" border="0">
        <tr>
          <td colspan="5">
            <div align="center"><h4>RINCIAN KERTAS KERJA SATKER T.A. <?php echo date('Y'); ?></h4></div>
          </td>
        </tr>
        <tr>
        	<td colspan="5">
            	<div align="center">&nbsp;</div>
          	</td>
        </tr>

        <tr>
            <td width="120px">&nbsp;</td>
            <td width="75px">Nomor</td>
            <td width="15x">:</td>
            <td width="1500px"><?=$data['id']?>/UWG/CIASTECH-20/XII/2020</td>
            <td width="120px">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Lampiran</td>
            <td>:</td>
            <td>-</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Perihal</td>
            <td>:</td>
            <td><b>Notifikasi Penerimaan (<i>Letter of Acceptance</i>)</b></td>
            <td>&nbsp;</td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td colspan="3"><br><br>
                Kepada<br>Yth. Bpk./Ibu/Sdr. <?=$data_user['fullname']?>
            </td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td colspan="3"><br><br>
                <div style="text-align: justify;">
                Dengan hormat diberitahukan bahwa tim reviewer telah melakukan penilaian terhadap artikel dengan : <br>
                    <table border="0">
                        <tr>
                            <td valign="top">Judul</td>
                            <td valign="top">:</td>
                            <td valign="top">"<?php $kecil = strtoupper($data['subsTitle']); echo $kecil; ?>"</td>
                        </tr>
                        <tr>
                            <td valign="top">Penulis</td>
                            <td valign="top">:</td>
                            <td valign="top">
                              <?php
                                $text = $data['penulis'];
                                $a = str_replace(";",",",$text);
                                echo $a;
                              ?>
                            </td>
                        </tr>
                    </table><br>
                Berdasarkan hasil rekomendasi tim reviewer, maka artikel tersebut dinyatakan <b>diterima</b> untuk dipresentasikan pada Seminar Nasional “<i>The 3nd Conference on Innovation and Application of Science and Technology (CIASTECH 2020)</i>” pada tanggal 
                    <?php 
                    $tgl_conf = date('Y-m-d', strtotime($conf_row['conf_date']));
                    echo tgl_indo($tgl_conf); 
                    ?>.<br><br>
                    
                Demikian pemberitahuan ini, kami ucapkan selamat dan terimakasih atas partisipasinya.
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="left" width="250px">
                <br><br>
                <table border="0">
                    <tr>
                        <td width="400px">&nbsp;</td>
                        <td width="250px">
                            Malang, <?php echo tgl_indo(date('Y-m-d')); ?><br>Ketua<br>
                            <img src="../../assets/dist/img/ttd-Stempel-ketua-ciastech-2020.png" width="100%">
                        	<br>
                            <b><u>Aviv Yuniar Rahman, ST.,MT.</u></b>
                        </td>
                    </tr>
                </table> 
              </td>
            <td>&nbsp;</td>
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
