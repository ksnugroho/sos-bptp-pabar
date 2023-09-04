<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['user'] == '' || $_SESSION['user'] == null) {
    header('location:../login.php');
}


        if(isset($_GET['page'])){
          $page = $_GET['page'];

          switch ($page) {
          
            case 'detail-beli':
              include 'transaksi/beli-in/cetak-detail-data-beli.php';
              break;

            default:
              include "notFound.php";
              break;
          }
        }
?>

