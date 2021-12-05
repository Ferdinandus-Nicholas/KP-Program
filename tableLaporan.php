<?php
include_once("connection.php");
$user = $_GET['username'];
if ($user == null) {
    header('location: login.php');
}


//Data barang
$arrKode = [];
$selectLaporan = "SELECT Kode, Nama_barang, Jumlah, Tanggal, Status FROM tabel_laporan WHERE Username = '" . $user . "' ORDER BY Kode ASC";
$result = $con->query($selectLaporan);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $arr = array(
            "Kode" => trim($row['Kode']),
            "Nama_barang" => trim($row['Nama_barang']),
            "Jumlah" => trim($row['Jumlah']),
            "Tanggal" => trim($row['Tanggal']),
            "Status" => trim($row['Status']),
            "Username" => trim($user)
        );
        array_push($arrKode, $arr);
    }
} else {
    $info = "";
}
$jum2 = count($arrKode);


//
$arrbarang = [];
$selectbarang = "SELECT Kode FROM tabel_stok_barang WHERE Username = '".$user."' ORDER BY Kode ASC";
$res = $con->query($selectbarang);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $arr = array(
            "Kode" => trim($row['Kode']),
            "Username" => trim($user)
        );
        array_push($arrbarang, $arr);
    }
} else {
    $info = "";
}
$jum2 = count($arrbarang);

// for ($i=0; $i <sizeof($arrKode); $i++) { 
    
//     for ($j=0; $j <sizeof($arrbarang) ; $j++) {
//         if ($arrbarang[$j]['Kode'] == $arrKode[$i]['Kode'] ){

//                     $kembar = $arrKode[$i];
                 
            
//         }
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php print
"<body onload='window.print()'>" ?>
<center><div class="row">
<center><h1>Laporan</h1></center>
<center><h2>CV TEKAD MAJU JAYA</h2></center>
            <div class="col-md-12">
                <div id="mydata_wrapper" class="dataTables_wrapper no-footer">
                    <table border="1px solid" style="width: 500px;">
                        <thead style="font-size:16px">
                            <tr>
                                <th scope="col" style="text-align:center;">No</th>
                                <th scope="col" style="width: 100px;">Kode Barang</th>
                                <th scope="col" style="width: 100px;">Nama Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col" style="width: 100px;">Tanggal</th>
                                <th scope="col" style="width: 100px;">Status</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:16px">
                            <?php
                            for ($i = 0; $i < sizeof($arrKode); $i++) {
                                print "<tr>
                                            <td>" . ($i + 1) . "</td>
                                            <td style='text-align: center;'>" . $arrKode[$i]['Kode'] . "</td>
                                            <td style='text-align: center;'>" . $arrKode[$i]['Nama_barang'] . "</td>
                                            <td style='text-align: center;'>" . $arrKode[$i]['Jumlah'] . "</td>
                                            <td style='text-align: center;'>" . $arrKode[$i]['Tanggal'] . "</td>
                                            <td style='text-align: center;'>" . $arrKode[$i]['Status'] . "</td>
                                         </tr>";
                            };
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div></center>
</body>

</html>