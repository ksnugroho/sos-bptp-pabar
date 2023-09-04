<?php
include 'koneksi/koneksi.php';
error_reporting(0);
session_start();

//alert
$_SESSION['user'] = $_SESSION['usertype'] = $_SESSION['nrp'] = '';


//proses
$message = " ";
if (isset($_POST['loginBtn'])) {
    $username = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5(mysqli_real_escape_string($con, $_POST['password']));
    if (empty($username) || empty($password))
    {
        // echo "<script>alert('Username or Password Field can not be empty')</script>";
        $message = "<div class='alert alert-danger text-center' role='alert'>Username / Password <br>Tidak Boleh Kosong</div>";
    }
    else
    {
        if ($username =='admin@admin.com' and $password == 'd4a0acca009982fca1d3391052fcaa71') {
            $_SESSION['user'] = $username;
            $_SESSION['usertype'] = 'admin';
            header('location:admin/index');
        }

        else{
            $queryAnggota = mysqli_query($con, "SELECT * FROM v_akun_pengguna WHERE nrp ='$username' AND password = '$password' AND hak_akses = 'Prajurit'");
            $queryGudang = mysqli_query($con, "select * from login where nrp ='$username' and password = '$password' AND hak_akses = 2");
            $queryKomandan = mysqli_query($con, "select * from login where nrp ='$username' and password = '$password' AND hak_akses = 3");

            // $rowView=mysql_fetch_row($result);
            if (mysqli_num_rows($queryAnggota)>0) {
                $checkAnggota = mysqli_fetch_assoc($queryAnggota);
                $_SESSION['user'] = $checkAnggota['nama_anggota'];
                $_SESSION['nrp'] = $checkAnggota['nrp'];
                $_SESSION['usertype'] = $checkAnggota['hak_akses'];
                if ($_SESSION['usertype'] == $checkAnggota['hak_akses']) {
                    header('location:anggota/index');
                }
                else{
                     $message = "<div class='alert alert-danger' role='alert'>OOPS! Pengguna Tidak Terdaftar</div>";
                }

            }
            elseif (mysqli_num_rows($queryGudang)>0) {
              $checkGudang = mysqli_fetch_assoc($queryGudang);
                $_SESSION['user'] = $username;
                $_SESSION['usertype'] = $checkGudang['hak_akses'];
                if ($_SESSION['usertype'] == $checkGudang['hak_akses']) {
                     header('location:gudang/index');
                }
                else{
                     $message = "<div class='alert alert-danger' role='alert'>OOPS! Pengguna Tidak Terdaftar</div>";
                }
            }
            elseif (mysqli_num_rows($queryKomandan)>0) {
              $checkKomandan = mysqli_fetch_assoc($queryKomandan);
                $_SESSION['user'] = $username;
                $_SESSION['usertype'] = $checkKomandan['hak_akses'];
                if ($_SESSION['usertype'] == $checkKomandan['hak_akses']) {
                     header('location:komandan/index');
                }
                else{
                     $message = "<div class='alert alert-danger' role='alert'>OOPS! Pengguna Tidak Terdaftar</div>";
                }
            }
            else{
                 $message = "<div class='alert alert-danger' role='alert'>OOPS! Pengguna Tidak Terdaftar</div>";
            }

        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SOSys | BPTP PAPUA BARAT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../assets/dist/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="shortcut icon" href="../assets/images/bptp-pabar-logo.png">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="../assets/images/bptp-pabar-logo.png" width="90px"><br>
    <b><h5>Balai Pengkajian Teknologi Pertanian</h5>Papua Barat</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="text-blue login-box-msg">Stock Opname System</p>
      <?php
          echo $message;
      ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
             <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="loginBtn" type="submit">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google mr-2"></i> Sign in using Google
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="../../register.php" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <p class="text-muted" style="font-size: 12px; text-align: center; margin-top: -8px;">Copyright © <?php echo date("Y"); ?>.</p>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>

</body>
</html>
