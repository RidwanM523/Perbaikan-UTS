<?php
include_once("../config.php");

?>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data News</h3>

            <div class="card-tools">
              <!-- This will cause the card to maximize when clicked -->
              <a href='news/create.php?page=news' class="btn btn-info"><i class="fas fa-plus"></i>Tambah News</a>
            </div>
            <!-- /.card-tools -->
          </div>

          <div class="card-body">

            <table width='100%' id='tabel-simpel' class="table table-bordered">

              <tr>
                <th>No</th>
                <th>Judul News</th>
                <th>Kategori News</th>
                <th>Penulis</th>
                <th>Aksi</th>
              </tr>
              <?php
              $no = 1;
              $result = mysqli_query($mysqli, "SELECT tb_news.*,
                            tb_kategori.nama_kategori,
                            tb_users.nama_operator
                            FROM tb_news
                            INNER JOIN tb_kategori ON tb_news.id_kategori = tb_kategori.id
                            INNER JOIN tb_users ON tb_news.user_id = tb_users.id
                            
                            ORDER BY id DESC");

              while ($data = mysqli_fetch_array($result)) {
              ?>

                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['judul_news'] ?></td>
                  <td><?= $data['nama_kategori'] ?></td>
                  <td><?= $data['nama_operator'] ?></td>
                  <td>
                    <a class="btn btn-success" href='news/edit.php?id=<?= $data['id'] ?>&page=news'>Edit</a>
                    <a class="btn btn-danger" onclick='return confirmDelete()' href='news/delete.php?id=<?= $data['id'] ?>&page=news'>Hapus</a>
                  </td>
                </tr><?php } ?>
            </table>
          </div>
        </div><!-- /.card -->
      </div>

    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>