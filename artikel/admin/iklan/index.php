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
            <h3 class="card-title">Data Iklan</h3>

            <div class="card-tools">
              <!-- This will cause the card to maximize when clicked -->
              <a href='iklan/create.php?page=iklan' class="btn btn-info"><i class="fas fa-plus"></i>Tambah Iklan</a>
            </div>
            <!-- /.card-tools -->
          </div>

          <div class="card-body">

            <table width='100%' id='tabel-simpel' class="table table-bordered">

              <tr>
                <th>No</th>
                <th>Judul Iklan</th>
                <th>Kategori Iklan</th>

                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
              <?php
              $no = 1;
              $result = mysqli_query($mysqli, "SELECT tb_iklan.*,
                            tb_kategori.nama_kategori
                            
                            FROM tb_iklan
                            INNER JOIN tb_kategori ON tb_iklan.id_kategori = tb_kategori.id
                            
                            ORDER BY id DESC");

              while ($data = mysqli_fetch_array($result)) {
              ?>

                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $data['judul_iklan'] ?></td>
                  <td><?= $data['nama_kategori'] ?></td>
                  <td><img width="200px" src="iklan/image/<?php echo $data['cover']; ?>"></td>

                  <td>
                    <a class="btn btn-success" href='iklan/edit.php?id=<?= $data['id'] ?>&page=iklan'>Edit</a>
                    <a class="btn btn-danger" onclick='return confirmDelete()' href='iklan/delete.php?id=<?= $data['id'] ?>&page=iklan'>Hapus</a>
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