<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("../../config.php");
include('session.php');

if (isset($_POST['submit'])) {
  $judul_iklan = @$_POST['judul_iklan'];
  $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST["judul_iklan"])));
  $created_time = date("Y-m-d H:i:s");
  $user_id = $_SESSION['id'];
  $kategori = @$_POST['kategori'];
  $content_iklan  = @$_POST['content_iklan'];
  $sql = "SELECT * FROM tb_iklan WHERE judul_iklan='$judul_iklan'";
  $ekstensi_diperbolehkan    = array('png', 'jpeg', 'jpg');
  $nama = $_FILES['file']['name'];
  $x = explode('.', $nama);
  $ekstensi = strtolower(end($x));
  $ukuran    = $_FILES['file']['size'];
  $file_tmp = $_FILES['file']['tmp_name'];
  if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
    if ($ukuran < 1044070) {
      move_uploaded_file($file_tmp, 'image/' . $nama);
      $file_name = $nama;

      $result = mysqli_query($mysqli, "INSERT INTO tb_iklan(judul_iklan, created_time, user_id, id_kategori, content_iklan,cover)
      VALUES('$judul_iklan','$created_time','$user_id','$kategori','$content_iklan','$file_name')");

      if ($result) {
        echo 'FILE BERHASIL DI UPLOAD';
      } else {
        echo 'GAGAL MENGUPLOAD GAMBAR';
      }
    } else {
      echo 'UKURAN FILE TERLALU BESAR';
    }
  } else {
    echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
  }
}
// 
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include('../template/navbar.php'); ?>
    <?php include('../template/sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php include('content-header.php'); ?>
      <!-- /.content-header -->
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">

              <div class="card">

                <div class="card-header">
                  <h3 class="card-title">Data Iklan
                  </h3>

                  <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <a href="../dashboard.php?page=iklan" class="btn btn-info">Kembali</a>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <form action="../iklan/create.php?page=iklan" method="post" enctype="multipart/form-data">

                  <div class="card-body">

                    <div class="form-group">
                      <label for="judul_iklan">Judul Iklan</label>
                      <input type="text" class="form-control" name="judul_iklan" required>
                    </div>
                    <div class="form-group">
                      <label for="content_iklan">Isi Iklan</label>
                      <textarea type="text" class="form-control" name="content_iklan" required></textarea>
                    </div>
                    <?php
                    $kategori = mysqli_query($mysqli, "SELECT * FROM tb_kategori ORDER BY id DESC");
                    ?>
                    <div class="form-group">
                      <label for="content_iklan">Kategori Iklan</label>
                      <select class="form-control" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <?php while ($data = mysqli_fetch_array($kategori)) { ?>
                          <option value="<?= $data['id'] ?>"><?= $data['nama_kategori'] ?></option>
                        <?php } ?>
                        <select>
                    </div>

                  </div>
                  <div class="card-footer">
                    <input type="file" name="file">
                    <button class="btn btn-primary" type="submit" name="submit">Simpan</button>
                  </div>
                </form>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->


    <?php include('../template/footer.php'); ?>

  </div>
</body>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<script>
  function confirmDelete() {
    if (confirm('Anda yakin menghapus data?')) {
      //action confirmed
    } else {
      //action cancelled
      alert('Data batal di hapus');
      return false;

    }
  }
</script>
</body>

</html>