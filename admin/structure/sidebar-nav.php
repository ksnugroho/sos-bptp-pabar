<?php
error_reporting(0);
$hal = $_GET['page'];
// $current_page = '/index.php';

?>
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="index?page=dashboard" class="nav-link <?php if ($hal == 'dashboard') {
                                                        echo 'active';
                                                      } elseif (empty($hal)) {
                                                        echo 'active';
                                                      } ?>">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Beranda
        </p>
      </a>
    </li>

    <li class="nav-item has-treeview <?php if ($hal == 'kategori') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'jenis') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'satuan') {
                                        echo 'menu-open';
                                      } ?>">
      <a href="" class="nav-link <?php if ($hal == 'kategori') {
                                    echo 'active';
                                  } elseif ($hal == 'jenis') {
                                    echo 'active';
                                  } elseif ($hal == 'satuan') {
                                    echo 'active';
                                  } ?> ">
        <i class="nav-icon fas fa-database"></i>
        <p>
          Data Master
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="index?page=kategori" class="nav-link <?php if ($hal == 'kategori') {
                                                          echo 'active';
                                                        } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Kategori</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index?page=jenis" class="nav-link <?php if ($hal == 'jenis') {
                                                        echo 'active';
                                                      } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Jenis</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index?page=satuan" class="nav-link <?php if ($hal == 'satuan') {
                                                        echo 'active';
                                                      } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Satuan</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item has-treeview <?php if ($hal == 'program') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'kegiatan') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'komponen') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'sub-komponen') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'detail') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'sub-detail') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'agen') {
                                        echo 'menu-open';
                                      } elseif ($hal == 'barang') {
                                        echo 'menu-open';
                                      } ?>">
      <a href="" class="nav-link <?php if ($hal == 'program') {
                                    echo 'active';
                                  } elseif ($hal == 'kegiatan') {
                                    echo 'active';
                                  } elseif ($hal == 'komponen') {
                                    echo 'active';
                                  } elseif ($hal == 'sub-komponen') {
                                    echo 'active';
                                  } elseif ($hal == 'detail') {
                                    echo 'active';
                                  } elseif ($hal == 'sub-detail') {
                                    echo 'active';
                                  } elseif ($hal == 'agen') {
                                    echo 'active';
                                  } elseif ($hal == 'barang') {
                                    echo 'active';
                                  } ?> ">
        <i class="nav-icon fas fa-briefcase"></i>
        <p>
          Data Referensi
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="index?page=program" class="nav-link <?php if ($hal == 'program') {
                                                          echo 'active';
                                                        } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Program</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index?page=kegiatan" class="nav-link <?php if ($hal == 'kegiatan') {
                                                          echo 'active';
                                                        } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Kegiatan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index?page=komponen" class="nav-link <?php if ($hal == 'komponen') {
                                                          echo 'active';
                                                        } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Komponen</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="index?page=sub-komponen" class="nav-link <?php if ($hal == 'sub-komponen') {
                                                              echo 'active';
                                                            } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Sub Komponen</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index?page=detail" class="nav-link <?php if ($hal == 'detail') {
                                                        echo 'active';
                                                      } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Detail</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index?page=sub-detail" class="nav-link <?php if ($hal == 'sub-detail') {
                                                            echo 'active';
                                                          } ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Sub Detail</p>
          </a>
        </li>

    </li>
    <li>
      <hr style="margin-top: 0.8em;margin-bottom: 0.8em;width:85%;background-color:gray;">
    </li>
    <li class="nav-item">
      <a href="index?page=agen" class="nav-link <?php if ($hal == 'agen') {
                                                  echo 'active';
                                                } ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Agen (Distributor)</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="index?page=barang" class="nav-link <?php if ($hal == 'barang') {
                                                    echo 'active';
                                                  } ?>">
        <i class="far fa-circle nav-icon"></i>
        <p>Barang</p>
      </a>
    </li>
  </ul>
  </li>

  <li class="nav-item">
    <a href="index?page=stok-barang" class="nav-link <?php if ($hal == 'stok-barang') {
                                                        echo 'active';
                                                      } ?>">
      <i class="nav-icon fa fa-cubes"></i>
      <p>
        Data Stok Barang
        <span class="badge badge-success right">
          <?php
          include '../koneksi/koneksi.php';
          $sql = mysqli_query($con, "SELECT * FROM view_stok_barang") or die(mysqli_error($con));
          $jumlah_barang = mysqli_num_rows($sql);
          echo $jumlah_barang;
          ?>
        </span>
      </p>
    </a>
  </li>

  <li class="nav-item has-treeview <?php if ($hal == 'beli') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'pakai') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'add-pakai') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'add-beli') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'detail-beli') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'detail-pakai') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'edit-beli') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'rekap-beli') {
                                      echo 'menu-open';
                                    } elseif ($hal == 'rekap-pakai') {
                                      echo 'menu-open';
                                    } ?>">
    <a href="" class="nav-link <?php if ($hal == 'beli') {
                                  echo 'active';
                                } elseif ($hal == 'pakai') {
                                  echo 'active';
                                } elseif ($hal == 'add-pakai') {
                                  echo 'active';
                                } elseif ($hal == 'add-beli') {
                                  echo 'active';
                                } elseif ($hal == 'detail-beli') {
                                  echo 'active';
                                } elseif ($hal == 'detail-pakai') {
                                  echo 'active';
                                } elseif ($hal == 'edit-beli') {
                                  echo 'active';
                                } elseif ($hal == 'rekap-beli') {
                                  echo 'active';
                                } elseif ($hal == 'rekap-pakai') {
                                  echo 'active';
                                } ?>">
      <i class="nav-icon fas fa-shopping-cart"></i>
      <p>
        Data Transaksi
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="index?page=beli" class="nav-link <?php if ($hal == 'beli') {
                                                    echo 'active';
                                                  } elseif ($hal == 'add-beli') {
                                                    echo 'active';
                                                  } elseif ($hal == 'detail-beli') {
                                                    echo 'active';
                                                  } elseif ($hal == 'edit-beli') {
                                                    echo 'active';
                                                  } ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Pembelian (In)</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="index?page=pakai" class="nav-link <?php if ($hal == 'pakai') {
                                                      echo 'active';
                                                    } elseif ($hal == 'add-pakai') {
                                                      echo 'active';
                                                    } elseif ($hal == 'detail-pakai') {
                                                      echo 'active';
                                                    } ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Pemakaian (Out)</p>
        </a>
      </li>
      <li>
        <hr style="margin-top: 0.8em;margin-bottom: 0.8em;width:85%;background-color:gray;">
      </li>
      <li class="nav-item">
        <a href="index?page=rekap-beli" class="nav-link <?php if ($hal == 'rekap-beli') {
                                                          echo 'active';
                                                        } ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Rekap Pembelian (In)</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="index?page=rekap-pakai" class="nav-link <?php if ($hal == 'rekap-pakai') {
                                                            echo 'active';
                                                          } ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Rekap Pemakaian (Out)</p>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a href="index?page=laporan" class="nav-link <?php if ($hal == 'laporan') {
                                                    echo 'active';
                                                  } ?>">
      <i class="nav-icon fa fa-file"></i>
      <p>
        Laporan
      </p>
    </a>
  </li>

  <hr>

  <!-- <li class="nav-item">
            <a href="index?page=log-aktiv" class="nav-link <?php if ($hal == 'log-aktiv') {
                                                              echo 'active';
                                                            } ?>">
              <i class="nav-icon fa fa-history"></i>
              <p>
                Log Aktivitas
              </p>
            </a>
          </li>
          <hr> -->
  <li class="nav-item">
    <a href="../login" class="nav-link">
      <i class="nav-icon fas fa-sign-out-alt"></i>
      <p>
        Keluar
      </p>
    </a>
  </li>
  </ul>
</nav>