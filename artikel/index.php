<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include("config.php");

$no = 1;
$allNews = mysqli_query($mysqli, "SELECT tb_news.*,
                            tb_kategori.nama_kategori,
                            tb_users.nama_operator
                            FROM tb_news
                            INNER JOIN tb_kategori ON tb_news.id_kategori = tb_kategori.id
                            INNER JOIN tb_users ON tb_news.user_id = tb_users.id
                            ORDER BY id DESC
                            ");
$batas = 2;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$previous = $halaman - 1;
$next = $halaman + 1;
$jumlah_data = $allNews->num_rows;
$total_halaman = ceil($jumlah_data / $batas);

$new_news = mysqli_query($mysqli, "SELECT tb_news.*,
                            tb_kategori.nama_kategori,
                            tb_users.nama_operator
                            FROM tb_news
                            INNER JOIN tb_kategori ON tb_news.id_kategori = tb_kategori.id
                            INNER JOIN tb_users ON tb_news.user_id = tb_users.id
                            LIMIT $halaman_awal, $batas
                           ");
$iklan = mysqli_query($mysqli, "SELECT tb_iklan.*,
                            tb_kategori.nama_kategori,
                            tb_users.nama_operator
                            FROM tb_iklan
                            INNER JOIN tb_kategori ON tb_iklan.id_kategori = tb_kategori.id
                            INNER JOIN tb_users ON tb_iklan.user_id = tb_users.id
                            ORDER BY id DESC
                            limit 4
                            ");


$kategori = mysqli_query($mysqli, "SELECT * from tb_kategori");
$menu = mysqli_query($mysqli, "SELECT * from tb_menu");
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.101.0">
  <title>Blog Website</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/blog/">

  <!-- Bootstrap core CSS -->
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .jumbotron-image {
      background-position: center center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <!-- Custom styles for this template -->
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="blog.css" rel="stylesheet">
</head>

<body>

  <div class="container">
    <header class="blog-header py-3">
      <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
          <a class="text-muted" href="#"></a>
        </div>
        <div class="col-4 text-center">
          <a class="blog-header-logo text-dark" href="admin/dashboard.php?page=news">News</a>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
          <a class="text-muted" href="#" aria-label="Search">
          </a>
        </div>
      </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
      <nav class="nav d-flex justify-content-between">
        <?php
        while ($data_menu = mysqli_fetch_array($menu)) {
        ?>
          <a class="p-2 text-muted" href="admin/dashboard.php?page=home"><?= $data_menu['nama_menu'] ?></a>
        <?php } ?>
      </nav>
    </div>

    <main role="main" class="container">

      <div class="row">

        <div class="col-md-8 blog-main">
          <?php
          while ($dataNews = mysqli_fetch_array($new_news)) {
          ?>

            <div class="blog-post">
              <h2 class="blog-post-title">
                <?= $dataNews['judul_news'] ?>

              </h2>
              <p class="blog-post-meta"><?= date('d-M-Y', strtotime($dataNews['created_time'])) ?> by <a href="#"><?= $dataNews['nama_operator'] ?></a></p>
              <p class="text-justify"><?= $dataNews['content_news'] ?></p>
            </div><!-- /.blog-post -->
          <?php } ?>
          <nav class="blog-pagination">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" <?php if ($halaman > 1) {
                                        echo "href='?halaman=$previous'";
                                      } ?>>Sebelumnya</a>
              </li>
              <?php
              for ($x = 1; $x <= $total_halaman; $x++) {
              ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $x ?>"><?= $x; ?></a></li>
              <?php
              }
              ?>
              <li class="page-item">
                <a class="page-link" <?php if ($halaman < $total_halaman) {
                                        echo "href='?halaman=$next'";
                                      } ?>>Selanjutnya</a>
              </li>
            </ul>
          </nav>

        </div><!-- /.row -->
        <aside class="col-md-4 blog-sidebar">
          <div class="p-4 mb-3 bg-light rounded">
            <h4 class="font-italic">About</h4>
            <p class="mb-0">News atau berita adalah segala laporan mengenai peristiwa, kejadian, gagasan, fakta yang menarik perhatian dan penting untuk disampaikan atau dimuat dalam media massa agar diketahui atau menjadi kesadaran umum.</p>
          </div>

        </aside><!-- /.blog-sidebar -->

    </main><!-- /.container -->

    <h3 class="col-p-4 mb-4 border-bottom text-center">
      <a class="blog-header-logo text-dark" href="admin/dashboard.php?page=iklan">Iklan</a>
    </h3>

    <main role="main" class="container">

      <div class="row">

        <div class="col-md-8 blog-main">
          <?php
          while ($dataIklan = mysqli_fetch_array($iklan)) {
          ?>

            <div class="blog-post">
              <h2 class="blog-post-title">
                <?= $dataIklan['judul_iklan'] ?>

              </h2>
              <p class="text-justify"><?= $dataIklan['content_iklan'] ?></p>
              <img width="50%" class="rounded" src="admin/iklan/image/<?= $dataIklan['cover'] ?>" alt="">

            </div><!-- /.blog-post -->
          <?php } ?>
        </div>
    </main>

    <footer class="blog-footer">
      <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>

</body>

</html>