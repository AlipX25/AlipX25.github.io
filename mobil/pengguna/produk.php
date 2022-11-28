<?php

session_start();
include "utilities/koneksi.php";

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
    <?php include "components/title.php"; ?>    
    <link rel="stylesheet" href="public/content-style.css">
    <link rel="stylesheet" href="public/content-produk.css">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <style>
        .swiper {
        width: 100%;
        height: 300px;
        }

        .img-logo {
            width : 200px;
        }

        .swiper-slide {
            text-align: center;
        }

        .swiper-slide::-webkit-scrollbar {
           width: 0;
        }
    </style>
</head>

<body>
    <section>
        
        <header>
            
        <?php include "components/navbar.php"; ?>    

        </header>

        
       
        <div class="content">

        <h1 style="width: 100%; padding-top: 60px; font-size: 40px; font-weight: 400; margin-bottom: 40px;">Merek Mobil</h1>

        <div class="swiper">
  <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php
            $sql = "SELECT * FROM tabel_merk ORDER BY nama DESC";
            $result = mysqli_query($conn, $sql);
            $no = 0;
            foreach ($result as $row) {

            ?>
            
            <div class="swiper-slide"><a href="jenis_mobil.php?id=<?php echo $row['id']; ?>"><img class="img-logo" src="../dealer-mobil/sources/models/merk/<?php echo "gambar/".$row['gambar'];   ?>" alt=""> <p style="color: black;"><?php echo $row['nama']; ?></p></a></div>

            <?php
            }
            ?>
            
            ...
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- If we need scrollbar -->
        
        </div>

        
        <!-- <div class="wrapper">

        <?php
        $sql = "SELECT * FROM tabel_merk ORDER BY nama DESC";
        $result = mysqli_query($conn, $sql);
        $no = 0;
        foreach ($result as $row) {

        ?>

            <div class="item"><a href="jenis_mobil.php?id=<?php echo $row['id']; ?>"><img src="../sources/models/merk/<?php echo "gambar/".$row['gambar'];   ?>" alt=""> <p style="color: black;"><?php echo $row['nama']; ?></p></a></div>

        <?php
        }
        ?>
        
        </div> -->

        <h1 style="width: 100%; font-size: 40px; font-weight: 400;">Semua Mobil</h1>

        <?php
        $sql = "SELECT * FROM tabel_mobil ORDER BY nama DESC";
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
                <p>Harga :Rp <?php echo number_format($row['harga'],0,',','.'); ?><br><br>Tahun dibuat : <?php echo $row['tahun'] ?></p>
                <a href="detail.php?id=<?php echo $row['id']; ?>" class="readmore btn">Detail</a>
            </div>
            <?php
            }
            ?>
        </div>
            
    </section>


    <script>

        const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'horizontal',
        slidesPerView: 3,
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        },
        });
    </script>
    
 
</body>
</html>