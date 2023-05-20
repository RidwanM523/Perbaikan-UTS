 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
         <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'users':
                        include "users/index.php";
                        break;
                    case 'artikel':
                        include "artikel/index.php";
                        break;
                    case 'news':
                        include "news/index.php";
                        break;
                    case 'iklan':
                        include "iklan/index.php";
                        break;
                    case 'kategori':
                        include "kategori/index.php";
                        break;
                    case 'menu':
                        include "menu/index.php";
                        break;
                    case 'home':
                        include "home/index.php";
                        break;
                    default:
                        echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                        break;
                }
            } else {
                include "home/index.php";
            }

            ?>
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->