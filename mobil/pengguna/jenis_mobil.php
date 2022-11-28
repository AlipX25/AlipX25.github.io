<?php

session_start();
include "utilities/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tabel_merk WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $data_merk = mysqli_fetch_assoc($result);
   
}

$sql = "SELECT * FROM tabel_perusahaan";
$result = mysqli_query($conn, $sql);
$data_perusahaan = mysqli_fetch_assoc($result);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "components/title.php" ?>
    <link rel="stylesheet" href="public/content-style.css">
    <link rel="stylesheet" href="public/content-produk.css">
</head>
<body>
    <section>
        
        <header>
        
        <?php include "components/navbar.php"; ?>

        </header>

        
       
        <div class="content">
            <h3 style="width: 100%; padding-top: -70%; font-size: 34px; font-weight: 500;">Jenis Mobil <?php echo $data_merk['nama']; ?></h3>

            <?php
            $sql = "SELECT * FROM tabel_jenis WHERE id_merk='$id' ORDER BY nama ASC";
            $result = mysqli_query($conn, $sql);
            $no = 0;
            foreach ($result as $row) {

            ?>
            <a class="kotak" style="color: black;" href="mobil.php?id=<?php echo $id; ?>&id_jenis=<?php echo $row['id'] ?>"><div class="isi" ><?php echo $row['nama']; ?></div></a>
            <?php
            }
            ?>
        </div>
            
    </section>

    
 
</body>
</html>