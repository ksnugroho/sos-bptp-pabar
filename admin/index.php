<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
  header('location:../login');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "structure/head.php" ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <?php include "structure/top-nav.php"; ?>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="../assets/images/bptp-pabar-logo.png" alt="UWG Logo" class="brand-image img-circle">
        <span class="brand-text font-weight-light">Stock Opname System</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin Conference</a>
        </div>
      </div> -->

        <!-- Sidebar Menu -->
        <?php include 'structure/sidebar-nav.php'; ?>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <!-- <section class="content"> -->
      <?php

      if (isset($_GET['page'])) {
        $page = $_GET['page'];
        //----------START ADMIN PAGE----------//
        switch ($page) {
          case 'dashboard':
            include 'dashboard/dashboard.php';
            break;

            // ---- master ----//
          case 'kategori':
            include 'master/kategori/data-kategori.php';
            break;
          case 'jenis':
            include 'master/jenis/data-jenis.php';
            break;
          case 'satuan':
            include 'master/satuan/data-satuan.php';
            break;
            // ---- END master ----//

            // ---- refrensi ----//
          case 'program':
            include 'referensi/program/data-program.php';
            break;
          case 'kegiatan':
            include 'referensi/kegiatan/data-kegiatan.php';
            break;
          case 'komponen':
            include 'referensi/komponen/data-komponen.php';
            break;
          case 'sub-komponen':
            include 'referensi/sub-komponen/data-sub-komponen.php';
            break;
          case 'detail':
            include 'referensi/detail/data-detail.php';
            break;
          case 'sub-detail':
            include 'referensi/sub-detail/data-sub-detail.php';
            break;
          case 'agen':
            include 'referensi/agen/data-agen.php';
            break;
          case 'barang':
            include 'referensi/barang/data-barang.php';
            break;
            // ---- END refrensi ----//

            // ---- Transaksi ----//
          case 'beli':
            include 'transaksi/beli-in/data-beli.php';
            break;
          case 'detail-beli':
            include 'transaksi/beli-in/detail-data-beli.php';
            break;
          case 'add-beli':
            include 'transaksi/beli-in/add-data-beli.php';
            break;
          case 'trun-beli':
            include 'transaksi/beli-in/trun-add-barang-beli.php';
            break;
          case 'edit-beli':
            include 'transaksi/beli-in/edit-beli-in/edit-beli-form.php';
            break;

            // --- Rekap Pembelian ---//  
          case 'rekap-beli':
            include 'transaksi/rekap-beli-in/rekap-data-beli.php';
            break;

          case 'pakai':
            include 'transaksi/pakai-out/data-pakai.php';
            break;
          case 'detail-pakai':
            include 'transaksi/pakai-out/detail-data-pakai.php';
            break;
          case 'add-pakai':
            include 'transaksi/pakai-out/add-data-pakai.php';
            break;
          case 'trun-pakai':
            include 'transaksi/pakai-out/trun-add-barang-pakai.php';
            break;

            // --- Rekap Pemakaian ---//  
          case 'rekap-pakai':
            include 'transaksi/rekap-pakai-out/rekap-data-pakai.php';
            break;

            // ---- END Transaksi ----//

            // ---- stok barang ----//
          case 'stok-barang':
            include 'stok-barang/data-stok-barang.php';
            break;
          case 'jenis':
            // ---- END stok barang ----//

          case 'laporan':
            include 'laporan/laporan.php';
            break;

            // case 'log-aktiv':
            //   include 'logAktivitas/logaktivitas.php';
            //   break;

          default:
            include "notFound.php";
            break;
        }
      } else {
        include "dashboard/dashboard.php";
      }
      //----------END ADMIN PAGE----------//

      ?>
      <!-- </section> -->
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include 'structure/footer.php'; ?>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <?php include 'structure/jquery.php'; ?>
</body>

</html>