
<?php
include '../koneksi/koneksi.php';
require('../assets/plugins/fpdf/fpdf.php');

// session_start();
error_reporting(0);
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null)
{
    header('location:../login/login.php');
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
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
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}

$no_dokumen = base64_decode($_GET['no_dokumen']);
$sql_beli = mysqli_query($con, "SELECT * FROM view_tsc_beli WHERE no_dokumen='$no_dokumen'") or die(mysqli_error($con));
$row_beli = mysqli_fetch_array($sql_beli);

$pdf = new FPDF('P','mm','A4');
$pdf->SetMargins(10,15,10);

$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',18); 
$pdf->Cell(0,10,'TRANSAKSI PEMBELIAN',0,1,'C');
$pdf->SetFont('Arial','B',16); 
$pdf->Cell(0,3,$no_dokumen,0,1,'C');
$pdf->SetFont('Arial','B',13); 
$pdf->Cell(0,10,tanggal_indo($row_beli['tgl_beli'], true),0,1,'C');

$pdf->Cell(0,15,'',0,1); //space

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,'Program & Kegiatan:',0,1,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5,$row_beli['kode_program'].' - '.$row_beli['nama_program']. ' ('.$row_beli['tahun'].')',0,1,'L');
$pdf->Cell(0,5,$row_beli['kode_kegiatan'].' - '.$row_beli['nama_kegiatan'],0,1,'L');
$pdf->Cell(0,5,$row_beli['kode_komponen'].' - '.$row_beli['nama_komponen'],0,1,'L');
$pdf->Cell(0,5,$row_beli['kode_subkomponen'].' - '.$row_beli['nama_subkomponen'],0,1,'L');
$pdf->Cell(0,5,$row_beli['kode_detail'].' - '.$row_beli['nama_detail'],0,1,'L');
$pdf->Cell(0,5,$row_beli['kode_subdetail'].' - '.$row_beli['nama_subdetail'],0,1,'L');
$pdf->Cell(0,5,'',0,1); //space
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,'Agen (Distributor):',0,1,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5,$row_beli['nama_agen'].' ('.$row_beli['no_tlpn'].')',0,1,'L');
$pdf->Cell(0,5,$row_beli['alamat'],0,1,'L');
$pdf->Cell(0,5,'',0,1); //space

$pdf->setFillColor(230,230,230); 
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,'Daftar Pembelian:',0,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(8,7,'#',1,0,'C',1);
$pdf->Cell(30,7,'Kode Barang',1,0,'C',1);
$pdf->Cell(63,7,'Nama Barang',1,0,'C',1);
$pdf->Cell(30,7,'Harga Satuan',1,0,'C',1);
$pdf->Cell(15,7,'Jumlah',1,0,'C',1);
$pdf->Cell(45,7,'Total',1,1,'C',1);

$pdf->SetFont('Arial','',8);
$sql_barang = mysqli_query($con, "SELECT * FROM view_tsc_beli WHERE no_dokumen='$no_dokumen'") or die(mysqli_error($con));
$jumlah_barang = mysqli_num_rows($sql_barang);

$counter = 1;
$totalharga = 0;
$totalbayar = 0;

while ($row_barang = mysqli_fetch_array($sql_barang)) {
	$totalharga = $row_barang['harga']*$row_barang['jml_beli'];
	$totalbayar += $totalharga;
	$pdf->Cell(8,5,$counter++,1,0,'C');
	$pdf->Cell(30,5,$row_barang['kode_barang'],1,0,'C');
	$pdf->Cell(63,5,$row_barang['nama_barang'],1,0,'L');
	$pdf->Cell(30,5,'Rp '.number_format($row_barang['harga'], 2, ",", "."),1,0,'R');
	$pdf->Cell(15,5,$row_barang['jml_beli'] . ' ' . $row_barang['nama_satuan'],1,0,'C');
	$pdf->Cell(45,5,'Rp '.number_format($totalharga, 2, ",", "."),1,1,'R');
}
$pdf->SetFont('Arial','B',8);
$pdf->Cell(146,5,'Total Pembelian',1,0,'C');
$pdf->Cell(45,5,'Rp '.number_format($totalbayar, 2, ",", "."),1,1,'R');

$pdf->SetFont('Arial','',9);
$pdf->Cell(146,8,'*Jumlah pembelian barang: '.$jumlah_barang,0,1,'L');

$pdf->Cell(0,8,'',0,1); //space
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,8, 'PDF digenerate dari Stock Opname System pada ' . date('d-M-Y h:i:s A'),0,1,'');

$pdf->Output('I', 'Transaksi Pembelian ' . $no_dokumen .'.pdf');

$pdf->Output();

?>


