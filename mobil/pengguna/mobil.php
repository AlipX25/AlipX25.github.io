<?php

session_start();
include "utilities/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id_jenis = $_GET['id_jenis'];
   
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


        <h1 style="width: 100%; font-size: 40px; font-weight: 400;">Semua Mobil</h1>

        <?php
        $sql = "SELECT * FROM tabel_mobil WHERE id_merk = $id AND id_jenis = $id_jenis ORDER BY nama DESC";
        $result = mysqli_query($conn, $sql);
        $no = 0;
        foreach ($result as $row) {

            $id_merk = $row['id_merk'];
            $merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_merk WHERE id='$id_merk'"))["nama"];
            $nama = $row['nama'];
            $nama_merk = "$merk $nama";
            

        ?>   
            
            <div class="box">
                <img src="../dealer-mobil/sources/models/gambar_mobil/<?php echo$row['gambar'];   ?>" alt="">
                <h4><?php echo $nama_merk; ?></h4>
                <p>Harga :Rp <?php echo number_format($row['harga'],0,',','.'); ?><br><br>Mantap-mantap Respect</p>
                <a href="detail.php?id=<?php echo $row['id']; ?>" class="readmore btn">Detail</a>
            </div>
            <?php
            }
            ?>
        </div>
            
    </section>

    
 
</body>
</html>