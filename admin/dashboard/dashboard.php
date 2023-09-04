<?php
  include '../koneksi/koneksi.php';
?>
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">SOSys (Stock Opname System) </a></li>
              <li class="breadcrumb-item active">BPTP</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<section class="content">
  <div class="container-fluid">
    <!-- <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="nav-icon fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Program</span>
            <span class="info-box-number">
              <?php
                $sql1 = mysqli_query($con, "SELECT * FROM anggota");
                $jumlah1 = mysqli_num_rows($sql1);
                echo $jumlah1." Orang";
              ?>
            
            </span>
          </div>

        </div>

      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-lime elevation-1"><i class="fa fa-star"></i></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Pangkat Anggota</span>
            <?php
                $sql2 = mysqli_query($con, "SELECT * FROM pangkat");
                $jumlah2 = mysqli_num_rows($sql2);
              ?>
            <span class="info-box-number"><?=$jumlah2?> Pangkat</span>
          </div>

        </div>

      </div>


      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fa fa-certificate"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Jabatan Anggota</span>
            <?php
                $sql3 = mysqli_query($con, "SELECT * FROM jabatan");
                $jumlah3 = mysqli_num_rows($sql3);
              ?>
            <span class="info-box-number"><?=$jumlah3?> Jabatan</span>
          </div>

        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-tags"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Kategori Senjata</span>
            <?php
                $sql4 = mysqli_query($con, "SELECT * FROM kategori_senjata");
                $jumlah4 = mysqli_num_rows($sql4);
              ?>
            <span class="info-box-number"><?=$jumlah4?> kategori</span>
          </div>

        </div>
      </div>
    </div> -->

    <!-- <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-navy elevation-1"><i class="nav-icon fas fa-rocket"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Jenis Senjata</span>
            <span class="info-box-number">
              <?php
                $sql1 = mysqli_query($con, "SELECT * FROM jenis_senjata");
                $jumlah1 = mysqli_num_rows($sql1);
                echo $jumlah1." Jenis";
              ?>
            </span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shield-alt"></i></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Senjata</span>
            <?php
                $sql2 = mysqli_query($con, "SELECT * FROM senjata");
                $jumlah2 = mysqli_num_rows($sql2);
              ?>
            <span class="info-box-number"><?=$jumlah2?> Senjata</span>
          </div>
        </div>
      </div>


      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-orange elevation-1"><i class="fas fa-user-shield"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Peminjam Senjata</span>
            <?php
                $sql3 = mysqli_query($con, "SELECT * FROM peminjaman_senjata");
                $jumlah3 = mysqli_num_rows($sql3);
              ?>
            <span class="info-box-number"><?=$jumlah3?> orang</span>
          </div>

        </div>

      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-maroon elevation-1"><i class="fas fa-id-badge"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Pemegang Senjata</span>
            <?php
                $sql4 = mysqli_query($con, "SELECT * FROM pemegang_senjata");
                $jumlah4 = mysqli_num_rows($sql4);
              ?>
            <span class="info-box-number"><?=$jumlah4?> Pemegang</span>
          </div>
        </div>
      </div>

    </div> -->

    <div class="row">
      <div class="col-12 col-sm-12 col-md-12">
        <!-- BAR CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><span class="oi oi-info"></span>&nbsp;Grafik Pembelian & Pemakaian</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      </div>
    </div>


  </div><!--/. container-fluid -->
</section>

<!-- SQL Graphic or Chart -->
<?php
  $sqlChart1 = mysqli_query($con, "SELECT *, COUNT(tgl_pinjam) AS jumlah FROM peminjaman_senjata GROUP BY month(tgl_pinjam)");
  $sqlChart2 = mysqli_query($con, "SELECT *, COUNT(tgl_kembali) AS jumlah FROM peminjaman_senjata GROUP BY month(tgl_kembali)");

  $nama_af1= "";
  $jumlah1=null;

  $nama_af2= "";
  $jumlah2=null;

  while ($label1 = mysqli_fetch_array($sqlChart1)) {
        $af         = date('F', strtotime($label1['tgl_pinjam']));
        $nama_af1 .= "'$af'". ", ";

        $jum1     =$label1['jumlah'];
        $jumlah1 .= "$jum1". ", ";
    }

  while ($label2 = mysqli_fetch_array($sqlChart2)) {
      $af2         = date('F', strtotime($label2['tgl_kembali']));
      $nama_af2 .= "'$af2'". ", ";

      $jum2     =$label2['jumlah'];
      $jumlah2 .= "$jum2". ", ";
  }
?>

<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    
    var areaChartData = {
      labels  : [<?php echo $nama_af1; ?>],
      datasets: [
        {
          label               : 'Pembelian',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $jumlah1; ?>]
        },
        {
          label               : 'Pemakaian',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $jumlah2; ?>]
        },
      ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    // var temp1 = areaChartData.datasets[1]
    // barChartData.datasets[0] = temp1
    // barChartData.datasets[1] = temp0
    barChartData.datasets[0] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      scales: {
          yAxes: [{
              ticks: {
                  beginAtZero:true
              }
          }]
      }
    }
    

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })


  })
</script>