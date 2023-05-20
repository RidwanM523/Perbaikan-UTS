<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once("../../config.php");
include('session.php');
define('SITE_ROOT', realpath(dirname(__FILE__)));
// Display selected user data based on id
// Getting id from url
$id = @$_GET['id'];

// Fetech user data based on id
$res_iklan = mysqli_query($mysqli, "SELECT * FROM tb_iklan WHERE id=$id");

while ($iklan = mysqli_fetch_array($res_iklan)) {
  $row_judul_iklan = $iklan['judul_iklan'];
  $row_content_iklan = $iklan['content_iklan'];
  $row_kategori = $iklan['id_kategori'];
}
?>
<?php
// include config connection file
// Check if form is submitted for user update, then redirect to homepage after update
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $created_time = date("Y-m-d H:i:s");
  $user_id = $_SESSION['id'];
  $kategori = @$_POST['kategori'];
  $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST["judul_iklan"])));

  $judul_iklan = @$_POST['judul_iklan'];
  $content_iklan  = @$_POST['content_iklan'];
  $ekstensi_diperbolehkan    = array('png', 'jpg', 'jpeg');
  $nama = $_FILES['file']['name'];
  $x = explode('.', $nama);
  $ekstensi = strtolower(end($x));
  $ukuran    = $_FILES['file']['size'];
  $file_tmp = $_FILES['file']['tmp_name'];
  if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
    if ($ukuran < 1044070) {
      move_uploaded_file($file_tmp, 'image/' . $nama);
      $file_name = $nama;
    } else {
      echo 'UKURAN FILE TERLALU BESAR';
    }
  } else {
    echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
    $file_name = '';
  }
  if (!empty($file_name)) {
    $sql = "SELECT cover FROM tb_iklan WHERE id='$id'";
    $result = mysqli_query($mysqli, $sql);
    if ($result->num_rows ==  0) {
      $row = mysqli_fetch_assoc($result);
      if (file_exists('image/' . $filename)) {
        unlink('image/' . $filename);
        echo 'File ' . $row['cover'] . ' has been deleted';
      } else {
        echo 'Could not delete ' . $row['cover'] . ', file does not exist';
      }
    }
    $file_name = $nama;
    $result = mysqli_query($mysqli, "UPDATE tb_iklan SET cover='$file_name',judul_iklan='$judul_iklan',
    content_iklan='$content_iklan',id_kategori='$kategori',user_id='$user_id',created_time='$created_time'
    WHERE id=$id");
  } else {
    $result = mysqli_query($mysqli, "UPDATE tb_iklan SET judul_iklan='$judul_iklan',
    content_iklan='$content_iklan',id_kategori='$kategori',user_id='$user_id',created_time='$created_time'
    WHERE id=$id");
  }

  // update user data

  // Redirect to homepage to display updated user in list
  header("Location:../dashboard.php?page=iklan");
}
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
    <?php include_once('../template/navbar.php'); ?>
    <?php include_once('../template/sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php include_once('content-header.php'); ?>
      <!-- /.content-header -->
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Iklan</h3>

                  <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <a href="../dashboard.php?page=iklan" class="btn btn-info">Kembali</a>
                  </div>
                  <!-- /.card-tools -->
                </div>

                <div class="card-body">

                  <form action="../../admin/iklan/edit.php?page=iklan" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                      <label for="judul_iklan">Judul Iklan</label>
                      <input type="text" class="form-control" value="<?= $row_judul_iklan ?>" name="judul_iklan" required>
                    </div>

                    <div class="form-group">
                      <label for="content_iklan">Isi Iklan</label>
                      <textarea type="text" class="form-control" name="content_iklan" required><?= $row_content_iklan ?></textarea>
                    </div>
                    <?php
                    $data_kategori = mysqli_query($mysqli, "SELECT * FROM tb_kategori ORDER BY id DESC");
                    ?>
                    <div class="form-group">
                      <label for="kategori">Kategori Iklan</label>
                      <select class="form-control" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <?php while ($d_kategori = mysqli_fetch_array($data_kategori)) { ?>
                          <option value="<?= $d_kategori['id'] ?>" <?php if ($d_kategori['id'] == $row_kategori) { ?> <?= 'selected' ?> <?php } ?>><?= $d_kategori['nama_kategori'] ?></option>
                        <?php } ?>
                        <select>
                    </div>
                    <input type="file" name="file">
                    <button class="btn btn-primary" type="submit" name="update">Simpan</button>

                  </form>


                </div>
                <!-- /.content-wrapper -->

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_once('../template/footer.php'); ?>

  </div>
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
        alert('Data berhasil dihapus');
      } else {
        //action cancelled
        alert('Data batal di hapus');
        return false;

      }
    }
  </script>
</body>

</html>