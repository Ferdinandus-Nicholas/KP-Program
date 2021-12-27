<?php
include_once("connection.php");
$user = $_GET['username'];
if ($user == null){
    header('location: login.php');
}


//Data barang
$arrKode = [];
$selectTabelBarang = "SELECT Kode, Nama_Barang, Jumlah FROM tabel_stok_barang WHERE Username = '".$user."'";
$result = $con->query($selectTabelBarang);
if($result->num_rows > 0)
{
  while($row=$result->fetch_assoc())
    {
      $arr=array("Kode"=>trim($row['Kode']),
      "Nama_Barang"=>trim($row['Nama_Barang']),
      "Jumlah"=>trim($row['Jumlah']),
      "Username"=>trim($user));
      array_push($arrKode,$arr); 
    }
}
else
{
  $info = "";
}
$jum2 = count($arrKode);

$arr1 = [];
$sql = "SELECT id, Kode, Tanggal_masuk, Nama_Barang, Jumlah FROM tabel_barang_masuk WHERE Username = '".$user."'";
$result = $con->query($sql);
if($result->num_rows > 0)
{
  while($row=$result->fetch_assoc())
    {
      $arr=array("id"=>trim($row['id']),
      "Kode"=>trim($row['Kode']),
      "Nama_Barang"=>trim($row['Nama_Barang']),
      "Tanggal_masuk"=>trim($row['Tanggal_masuk']),
      "Jumlah"=>trim($row['Jumlah']),
      "Username"=>trim($user));
      array_push($arr1,$arr); 
    }
}
else
{
  $info = "";
}
$jum = count($arr1);

if($jum > 0)
    {
        for($i=0;$i<$jum;$i++)
        {
            //Edit Barang
            // if(isset($_POST['update_btn'.$i]))
            // {
            //     $nama=$_POST["nabar"];
            //     $jumlah=$_POST["jumlah"];
            //     $kode=$_POST["kode"];

            //     $sql="update tabel_barang_masuk set
            //     Nama_barang='$nama',
            //     Jumlah = '$jumlah' where Username = '$user' and Kode='$kode'";
            //     echo "<meta http-equiv='refresh' content='0'>";
            //     if($con->query($sql)==TRUE)
            //     {
            //         $info= "data sukses update";
            //         echo "<script type='text/javascript'>alert('$info');</script>";
            //     }
            //     else
            //     {
            //         $info= "error simpan data ".$con->error;
            //         $message = "Data gagal diupdate";
            //         echo "<script type='text/javascript'>alert('$message');</script>";
            //     }
            // }

            //Hapus Barang
            if(isset($_POST['hapus_btn'.$i]))
            {
                $kode=trim($_POST['hapus_data'.$i]);
                $jumlah=$_POST["jumlah"];
                $id=$_POST["id"];
                $arrJumlahLama = [];
                $sqlJumlahLama = "SELECT Jumlah From tabel_stok_barang WHERE Username = '".$user."' and Kode = '$kode'";
                $resultCariJumlahLama = $con->query($sqlJumlahLama);
                if ($resultCariJumlahLama->num_rows > 0) {
                    while ($row = $resultCariJumlahLama->fetch_assoc()) {
                        $arr = array(
                            "Jumlah" => trim($row['Jumlah'])
                        );
                        array_push($arrJumlahLama, $arr);
                    }
                } else {
                    $info = "";
                }
                $jumLama = count($arrJumlahLama);
                $JumlahBaru = $arrJumlahLama[0]['Jumlah'] - $jumlah;
                $sqlUpdate = "update tabel_stok_barang set 
                Jumlah= $JumlahBaru where Username = '$user' and Kode='$kode'";
                $sql="delete from tabel_barang_masuk where Kode='".$kode."' and Username = '$user' and id = '$id'";
                echo "<meta http-equiv='refresh' content='0'>";
                if($con->query($sql)==TRUE && $con->query($sqlUpdate)==TRUE)
                {
                    $info= "data sukses dihapus";
                    echo "<script type='text/javascript'>alert('$info');</script>";
                }
                else
                {
                    $info= $con->error;
                    $message = "Data gagal dihapus";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Component Warehouse</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3">Component Warehouse</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search -->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div> -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><?php print"<a class='dropdown-item' target = '_blank' href='tableLaporan.php?username=".$user."'>Laporan</a>" ?></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <?php
                        print
                           "<div class='nav'>
                            <div class='sb-sidenav-menu-heading'>Menu</div>
                            <a class='nav-link' href='index.php?username=".$user."'>
                                <div class='sb-nav-link-icon'><i class='fas fa-tachometer-alt'></i></div>
                                Dashboard
                            </a>

                            <a class='nav-link' href='tables.php?username=".$user."'>
                                <div class='sb-nav-link-icon'><i class='fas fa-table'></i></div>
                                Stok Komponen
                            </a>

                            <a class='nav-link' href='tableMasuk.php?username=".$user."'>
                                <div class='sb-nav-link-icon'><i class='fas fa-table'></i></div>
                                Barang Masuk
                            </a>
                            <a class='nav-link' href='tableKeluar.php?username=".$user."'>
                                <div class='sb-nav-link-icon'><i class='fas fa-table'></i></div>
                                Barang Keluar
                            </a>
                            <a class='nav-link' href='tableRetur.php?username=".$user."'>
                                <div class='sb-nav-link-icon'><i class='fas fa-table'></i></div>
                                Barang Retur
                            </a>
                        </div>";
                        ?>
                        
                        
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php print $user?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mt-4">Barang Masuk</h1>
                        <div class="nav justify-content-end">
                            <?php
                                print "<a href='inputBarangMasuk.php?username=".$user."' class='btn btn-sm btn-success' >";
                            ?>         
                                   <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg> Barang Masuk
                            </a>
                        </div>

                        </div>
                        
                        <div class="card mb-4">
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        for($i=0;$i<$jum;$i++){
                                            print "<tr>
                                                <td>".$arr1[$i]['Kode']."</td>
                                                <td>".$arr1[$i]['Tanggal_masuk']."</td>
                                                <td>".$arr1[$i]['Nama_Barang']."</td>
                                                <td>".$arr1[$i]['Jumlah']."</td>
                                                <td>       
                                                    <a href='#' style='font-size: 10px;' class='btn btn-danger btn-xs' data-bs-toggle='modal'data-bs-target='#modalHapus".$i."'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                                        <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                                    </svg> HAPUS
                                                    </a>
                                                </td>"
                                                ;
                                        };
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Component Warehouse 2021</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

<!-- FUNCTION EDIT -->
<?php
    for($i=0;$i<$jum;$i++){
        print "<div id='modalEdit".$i."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='modalEditLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='modalEditLabel'>Edit Barang</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <form class='form-horizontal' method='post' action='tables.php?username=".$user."'>
                        <div class='modal-body'>
                            <div class='form-group'>
                                <label style='color:black;text-align:right'>Kode Barang</label>
                                <input name='kode' type='text' class='form-control' value='".$arr1[$i]['Kode']."' placeholder='".$arr1[$i]['Kode']."' style='width:465px;' required readonly>
                            </div>

                            <div class='form-group'>
                                <label style='color:black;text-align:right'>Nama Barang</label>
                                <input name='nabar' type='text' class='form-control' value='".$arr1[$i]['Nama_Barang']."' placeholder='".$arr1[$i]['Nama_Barang']."' style='width:465px;' required readonly>
                            </div>

                            <div class='form-group'>
                                <label style='color:black;text-align:right'>Stok</label>
                                <input name='jumlah' class='form-control' type='number' value='".$arr1[$i]['Jumlah']."' placeholder='Jumlah Barang...' style='width:465px;' required>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <input type='submit' class='btn btn-info ' value='Simpan' name='update_btn".$i."'>
                        </div>
                    </form>
                </div>
            </div>
        </div>";                             
    }
?>

<!-- FUNCTION HAPUS -->
<?php
    for($i=0;$i<$jum;$i++){
        print "<div id='modalHapus".$i."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='modalHapusLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='modalHapusLabel'>Hapus Barang</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <form class='form-horizontal' method='post'action='tableMasuk.php?username=".$user."'>
                        <div class='modal-body'>
                            <div class='form-group'>
                                <label style='color:black;text-align:right'>Yakin ingin menghapus barang ini ?</label>
                            </div>
                            <input type='hidden' name='hapus_data".$i."' value='".$arr1[$i]['Kode']."'>
                            <input type='hidden' name='id' value='".$arr1[$i]['id']."'>
                            <input name='jumlah' class='form-control' type='hidden' value='".$arr1[$i]['Jumlah']."' placeholder='Jumlah Barang...' style='width:465px;'>
                        </div>
                        <div class='modal-footer'>
                            <input type='submit' class='btn btn-danger' value='Hapus' name='hapus_btn".$i."'>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
    }
?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="js/popper.js"></script>

        
    </body>
</html>
