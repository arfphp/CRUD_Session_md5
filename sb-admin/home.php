<?php 
require("../koneksi.php");

session_start();

if(!isset($_SESSION['id'])){
    $_SESSION['msg'] = 'anda harus log in  untuk mengakses halaman ini';
    header('Location:../index.php');
}
$sesID = $_SESSION['id'];
$sesName = $_SESSION['name'];
$sesLvl = $_SESSION['level'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Halaman Home</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script> -->
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Halaman Home</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="POST">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" id="search" name="search" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">List</div>
                        <a class="nav-link" href="home.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home-alt"></i></div>
                            Home
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as : <?=$sesName?></div>
                    
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Home</h1>
                    <h3 class="mt-4">Selamat Datang <?=$sesName?></h3>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Keseluruhan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Nama Lengkap</th>
                                        <?php if ($sesLvl==1): ?>
                                        <th>Aksi</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Nama Lengkap</th>
                                        <?php if ($sesLvl==1): ?>
                                        <th>Aksi</th>
                                        <?php endif ?>
                                    </tr>
                                </tfoot>
                                <?php 
                                $query = "SELECT * FROM user_detail";
                                $result = mysqli_query($koneksi,$query);
                                $no = 1;
                                while($row = $row = mysqli_fetch_array($result)){
                                    $userMail = $row['user_email'];
                                    $userName = $row['user_fullname'];

                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $userMail; ?></td>
                                            <td><?php echo $userName; ?></td>
                                            <?php if ($sesLvl==1): ?>
                                               <td><a href='#editlogin' data-bs-target='#editlogin<?=$row['id'];?>' id='<?=$row['id'];?>' data-bs-toggle='modal' data-id="<?=$row['id'];?>"><input class='btn btn-success btn-small' type="button" value="Edit"></a>

                                                <a href="../delete.php?id=<?php echo $row['id']; ?>"><input class="btn btn-danger btn-xs"  type="button" value="Delete"></a>
                                            </td> 
                                            <?php endif ?>
                                        </tr>
                                        <div class="modal" id="editlogin<?=$row['id'];?>">
                                          <div class="modal-dialog">
                                            <div class="modal-content">

                                              <!-- Modal Header -->
                                              <div class="modal-header">
                                                <h4 class="modal-title">Modal Heading</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form method="post">
                                                    <input class="form-control" id="inputEmail" type="hidden" name="txt_id" value="<?=$row['id']?>" />
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputEmail" type="email" name="txt_email" placeholder="name@example.com" value="<?=$row['user_email'];?>" />
                                                        <label for="inputEmail">Email address</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" id="inputEmail" type="text" name="txt_nama" value="<?=$row['user_fullname'];?>" />
                                                        <label for="inputEmail">Nama</label>
                                                    </div>
                                                    <div class="mt-4 mb-0">
                                                        <div class="d-grid">
                                                          <button type="submit" name="update" class="btn btn-primary btn-block">
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                            $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-center small">
            <div class="text-muted">Copyright &copy; Akbar Ramadhani Firdaus</div>
        </div>
    </div>
</footer>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#editlogin').on('show.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
      $.ajax({
        type : 'post',
        url : '../edit.php',
        data :  'id='+ id,
        success : function(data){
          $('.fetched-data').html(data);
      }
  });
  });
});
</script>
</body>
<?php 
if(isset($_POST["update"])){

    $userId = $_POST['txt_id'];
    $userMail = $_POST['txt_email'];
    $userName = $_POST['txt_nama'];

    $query = mysqli_query($koneksi, "UPDATE user_detail SET user_fullname='$userName' WHERE id='$userId'");
    echo '<script>window.location.href = "home.php"</script>';
}
?>
<!-- <meta http-equiv="refresh" content="0;URL=home.php" /> -->
</html>
