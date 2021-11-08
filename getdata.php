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
    <body>
    <?php
    include "connection.php";
    $kode=$_GET['kode'];

    $arr1 = [];
    $sql = "select Kode, Nama_barang, Jumlah
            from tabel_stok_barang
            where Kode = '$kode'";
    $result = $con->query($sql);
    if($result->num_rows > 0)
    {
      while($row=$result->fetch_assoc())
        {
          $arr=array("Kode"=>trim($row['Kode']),
          "Nama_barang"=>trim($row['Nama_barang']),
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

    print "<div class='form-group'>
      <label style='color:black'>Nama Barang</label>
      <input name='nama' value='".$arr1[0]['Nama_barang']."' type='text' class='form-control input-sm' id='nama' readonly>
    </div>
    <div class='form-group'>
      <label style='color:black'>Jumlah</label>
      <input name='jumlah' type='text' class='form-control' id='jumlah' placeholder='Jumlah...'>
    </div>";
    ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="js/popper.js"></script>
    </body>
</html>