<?php
require('../assets/plugins/fpdf/fpdf.php');
include '../koneksi/koneksi.php';
 
class PDF extends FPDF
{
    function Header()
    {
        // $this->Ln(10);
        $this->SetFont('Arial','B',14);
        $this->Cell(45);
        $this->cell(0,10,'RINCIAN KERTAS KERJA SATKER T.A. '.DATE('Y'));
        $this->Line(10,20,200,20);
    }

    
    function data_barang(){
        $con = mysqli_connect("localhost","u5471254_penjualan12","penjualan12","u5471254_penjualan12");
        // mysqli_select_db("ex-apk-penjualan");
        $tanggal=$_POST['tgl_laporan'];
        if ($_POST['jenis_laporan']=="perhari") {
            $split1=explode('-',$tanggal);
            $tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
            $query=mysqli_query($con, "SELECT transaksi.id_transaksi, transaksi.tgl_transaksi, transaksi.no_invoice, transaksi.total_bayar, transaksi.nama_pembeli, ( ( barang.harga_jual - barang.harga_beli ) * sub_transaksi.jumlah_beli ) AS laba, USER.username FROM transaksi, barang, sub_transaksi, USER  where sub_transaksi.id_barang = barang.id_barang AND sub_transaksi.id_transaksi = transaksi.id_transaksi AND transaksi.kode_kasir = USER.id AND transaksi.tgl_transaksi LIKE '%$tanggal%' order by transaksi.id_transaksi desc");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query=mysqli_query($con, "SELECT transaksi.id_transaksi, transaksi.tgl_transaksi, transaksi.no_invoice, transaksi.total_bayar, transaksi.nama_pembeli, ( ( barang.harga_jual - barang.harga_beli ) * sub_transaksi.jumlah_beli ) AS laba, USER.username FROM transaksi, barang, sub_transaksi, USER  where sub_transaksi.id_barang = barang.id_barang AND sub_transaksi.id_transaksi = transaksi.id_transaksi AND transaksi.kode_kasir = USER.id AND transaksi.tgl_transaksi LIKE '%$tanggal%' order by transaksi.id_transaksi desc");
        }
        while ($r=  mysqli_fetch_array($query))
                {
                    $hasil[]=$r;
                }
                return $hasil;
                
    }

    function set_table($data){
        $this->SetFont('Arial','B',9);
        $this->Cell(10,7,"KODE",1,"C");
        $this->MultiCell(70,7,"PROGRAM/ AKTIVITAS/ KRO/ RO/ KOMPONEN/ SUBKOMP/ DETIL",1,"C");
        $this->Cell(20,7,"VOLUME",1,"C");
        $this->Cell(40,7,"HARGA SATUAN",1,"C");
        $this->Cell(40,7,"JUMLAH BIAYA",1,"C");
        $this->Cell(10,7,"SD/CP",1,"C");

        $this->Ln();

        $this->SetFont('Arial','',9);
        $no=1;
        $grandTotal=0;
        $laba=0;
        foreach($data as $row)
        {
            // $grandTotal += $row['total_bayar'];
            $this->Cell(10,7,$no++,1);
            $this->Cell(40,7,$row['no_invoice'],1);
            $this->Cell(20,7,$row['username'],1);
            $this->Cell(40,7,$row['nama_pembeli'],1);
            $this->Cell(40,7,date("d-m-Y h:i:s",strtotime($row['tgl_transaksi'])),1);
            $this->Cell(40,7,"Rp. ".number_format($row['total_bayar']),1);
            $this->Ln();
        }

        foreach($data as $value)
        {
            $grandTotal += $value['total_bayar'];
            $laba += $value['laba'];
        }
        $this->Cell(150,7,"Total Pembayaran",1);
        $this->Cell(40,7,"Rp. ".number_format($grandTotal),1);

        $this->Ln();
        $this->Cell(150,7,"Laba Penjualan",1);
        $this->Cell(40,7,"Rp. ".number_format($laba),1);
    }

}

$pdf = new PDF();
$pdf->SetTitle('Cetak Data Barang');

$data = $pdf->data_barang();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->set_table($data);
// $pdf->Output('','JUALO/Barang/'.date("d-m-Y").'.pdf');
 
#output file PDF
$pdf->Output();
?>