<?php
include_once("connection.php");
$user = $_GET['username'];
if ($user == null) {
    header('location: login.php');
}


//Data barang
$arrKode = [];
$selectTabelBarang = "SELECT Kode, Nama_Barang, Jumlah FROM tabel_stok_barang WHERE Username = '" . $user . "'";
$result = $con->query($selectTabelBarang);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $arr = array(
            "Kode" => trim($row['Kode']),
            "Nama_Barang" => trim($row['Nama_Barang']),
            "Jumlah" => trim($row['Jumlah']),
            "Username" => trim($user)
        );
        array_push($arrKode, $arr);
    }
} else {
    $info = "";
}
$jum2 = count($arrKode);

$arr1 = [];
$sql = "SELECT Kode, Tanggal_masuk, Nama_Barang, Jumlah FROM tabel_barang_masuk WHERE Username = '" . $user . "'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $arr = array(
            "Kode" => trim($row['Kode']),
            "Nama_Barang" => trim($row['Nama_Barang']),
            "Tanggal_masuk" => trim($row['Tanggal_masuk']),
            "Jumlah" => trim($row['Jumlah']),
            "Username" => trim($user)
        );
        array_push($arr1, $arr);
    }
} else {
    $info = "";
}
$jum = count($arr1);

if (isset($_POST['simpan_btn'])) {
    $nama = $_POST["nama"];
    $jumlah = $_POST["jumlah"];
    $tanggal_masuk = $_POST["tgl_masuk"];
    $conDate = date("Y-m-d", strtotime($tanggal_masuk));
    $kodeLama = $_POST["kodeLama"];
    $kodeBaru = $_POST["kodeBaru"];
    // echo "<script type='text/javascript'>alert('$kodeLama');</script>";
    $arrCariKode = [];
    $sql = "SELECT Kode FROM tabel_stok_barang WHERE Username = '" . $user . "' and Kode = '$kodeLama'";
    $resultCariKode = $con->query($sql);
    // echo "<script type='text/javascript'>alert('$result');</script>";
    if ($resultCariKode->num_rows > 0) {
        while ($row = $resultCariKode->fetch_assoc()) {
            $arr = array(
                "Kode" => trim($row['Kode'])
            );
            array_push($arrCariKode, $arr);
        }
    } else {
        $info = "";
    }
    $jumCariKode = count($arrCariKode);
        if ($arrCariKode[0]['Kode'] == $kodeLama) {
            $arrJumlahLama = [];
            $sqlJumlahLama = "SELECT Jumlah From tabel_stok_barang WHERE Username = '".$user."' and Kode = '$kodeLama'";
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
            // echo "<script type='text/javascript'>alert('$jumLama');</script>";
            $JumlahBaru = $arrJumlahLama[0]['Jumlah'] + $jumlah;
            // echo "<script type='text/javascript'>alert('$JumlahBaru');</script>";
            $sqlUpdate = "update tabel_stok_barang set 
            Jumlah= $JumlahBaru
            where Username = '$user' and Kode='$kodeLama'";
            $sqlInsertTanggal = "insert into table_barang_masuk(Kode, Tanggal_masuk, Nama_barang, Jumlah, Username) values('$kodeLama', '$conDate' , '$nama', $jumlah, '$user')";
            echo "<meta http-equiv='refresh' content='0'>";
            if ($con->query($sqlUpdate) == TRUE && $con->query($sqlInsertTanggal) == TRUE) {
                $info = "data sukses update";
                echo "<script type='text/javascript'>alert('$info');</script>";
            } else {
                $info = "error simpan data " . $con->error;
                $message = "Data gagal diupdate";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }else {
            // $sql2 = "insert into tabel_stok_barang(Kode, Nama_Barang, Jumlah, Username) values('$kodeLama', '$nama', $jumlah, '$user')";
            // // echo "<meta http-equiv='refresh' content='0'>";
            // if ($con->query($sql2) == TRUE) {
            //     $info = "data sukses disimpan";
            //     echo "<script type='text/javascript'>alert('$info');</script>";
            // } else {
            //     $info = "error simpan data " . $con->error;
            //     $message = "Data gagal disimpan";
            //     echo "<script type='text/javascript'>alert('$message');</script>";
            // }
        }
}

// if ($jum > 0) {
//     for ($i = 0; $i < $jum; $i++) {
//         //Edit Barang
//         if (isset($_POST['update_btn' . $i])) {
//             $nama = $_POST["nabar"];
//             $jumlah = $_POST["jumlah"];
//             $kode = $_POST["kode"];

//             $sql = "update tabel_stok_barang set 
//                 Kode='$kode',
//                 Nama_barang='$nama',
//                 Jumlah = '$jumlah' where Username = '$user' and Kode='$kode'";
//             echo "<meta http-equiv='refresh' content='0'>";
//             if ($con->query($sql) == TRUE) {
//                 $info = "data sukses update";
//                 echo "<script type='text/javascript'>alert('$info');</script>";
//             } else {
//                 $info = "error simpan data " . $con->error;
//                 $message = "Data gagal diupdate";
//                 echo "<script type='text/javascript'>alert('$message');</script>";
//             }
//         }

//         //Hapus Barang
//         if (isset($_POST['hapus_btn' . $i])) {
//             $kode = trim($_POST['hapus_data' . $i]);
//             $sql = "delete from tabel_stok_barang where Kode='" . $kode . "' and Username = '$user'";
//             echo "<meta http-equiv='refresh' content='0'>";
//             if ($con->query($sql) == TRUE) {
//                 $info = "data sukses dihapus";
//                 echo "<script type='text/javascript'>alert('$info');</script>";
//             } else {
//                 $info = $con->error;
//                 $message = "Data gagal dihapus";
//                 echo "<script type='text/javascript'>alert('$message');</script>";
//             }
//         }
//     }
// }
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type='text/javascript'>
        $(window).load(function() {
            $("#SelectKode").change(function() {
                console.log($("#SelectKode option:selected").val());
                if ($("#SelectKode option:selected").val() == '') {
                    $('#NamaBarangBaru').prop('hidden', false);
                    $('#JumlahBaru').prop('hidden', false);
                    $('#KodeBarangBaru').prop('hidden', false);
                } else {
                    $('#NamaBarangBaru').prop('hidden', true);
                    $('#JumlahBaru').prop('hidden', true);
                    $('#KodeBarangBaru').prop('hidden', true);
                }
            });
        });
    </script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Component Warehouse</a>
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
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
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
                            <a class='nav-link' href='index.php?username=" . $user . "'>
                                <div class='sb-nav-link-icon'><i class='fas fa-tachometer-alt'></i></div>
                                Dashboard
                            </a>

                            <a class='nav-link' href='tables.php?username=" . $user . "'>
                                <div class='sb-nav-link-icon'><i class='fas fa-table'></i></div>
                                Stok Komponen
                            </a>

                            <a class='nav-link' href='tableMasuk.php?username=" . $user . "'>
                                    <div class='sb-nav-link-icon'><i class='fas fa-table'></i></div>
                                    Barang Masuk
                            </a>
                        </div>";
                    ?>


                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php print $user ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mt-4">Barang Masuk</h1>
                    </div>
                    <form class="form-horizontal" method="POST" action="inputBarangMasuk.php?username=<?php print $user ?>">
                        <div class="modal-body">
                            <div class="form-group">
                                <label style="color: black;">Kode Barang</label>
                                <select name="kodeLama" id="SelectKode" class="form-control" onchange="showData(this.value)" data-live-search="true" title="Pilih Kode Barang">
                                    <option value="">-- Pilih Kode Barang --</option>
                                    <?php
                                    for ($i = 0; $i < $jum2; $i++) {
                                        print "<option value ='" . $arrKode[$i]['Kode'] . "'>" . $arrKode[$i]['Kode'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group" id="KodeBarangBaru">
                                <label style="color:black">Kode Barang</label>
                                <input name="kodeBaru" value="" type="text" class="form-control input-sm" id="nama" placeholder="Kode Barang...">
                            </div>
                            <div class="form-group">
                                <label style="color:black">Tanggal Masuk</label>
                                <input name="tgl_masuk" value="" type="date" class="form-control input-sm" id="nama">
                            </div>
                            <div class="form-group" id="NamaBarangBaru">
                                <label style="color:black">Nama Barang</label>
                                <input name="nama" value="" type="text" class="form-control input-sm" id="nama" placeholder="Nama Barang..." >
                            </div>
                            <div class="form-group" id="JumlahBaru">
                                <label style="color:black">Jumlah</label>
                                <input name="jumlah" type="text" class="form-control" id="jumlah" placeholder="Jumlah...">
                            </div>

                            <div id="txtHint"><b></b></div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-info" value="Simpan" name="simpan_btn">
                        </div>
                    </form>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/popper.js"></script>
    <script>
        function showData(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "getdata.php?kode=" + str, true);
            xmlhttp.send();
        }
    </script>

</body>

</html>