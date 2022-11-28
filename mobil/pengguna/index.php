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
    <?php include "components/title.php" ?>
    <link rel="stylesheet" href="public/index.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <section>
        <div class="circle"></div>
        <header>
        
        <?php include "components/navbar.php"; ?>

        </header>
        <div class="content">
            <div class="textBox">
                <h2>Selamat Datang<br>di <span><?php echo $data_perusahaan['nama']; ?></span></h2>
                <p><?php echo $data_perusahaan['nama']; ?> adalah tempat terbaik untuk membeli mobil baru kalian, karena semua mobil yang ada disini sangat terjamin kualitasnya</p>
                
            </div>
            <div class="imgBox">
                <img src="images/vehicle-1.png" class="ultra">
            </div>
        </div>
        <ul class="thumb">
            <li><img src="images/vehicle-1.png" onclick="imgSlider('images/vehicle-1.png');changeCircleColor('#d91c38')"></li>
            <li><img src="images/vehicle-2.png" onclick="imgSlider('images/vehicle-2.png');changeCircleColor('#6e696a')"></li>
            <li><img src="images/vehicle-3.png" onclick="imgSlider('images/vehicle-3.png');changeCircleColor('#ebbc13')"></li>
        </ul>
        <ul class="sci">
            <li><a href="https://web.facebook.com/profile.php?id=100031645359948&sk=friends"><img src="images/facebook.png"></a></li>
            <li><a href="https://twitter.com/alief_mmm"><img src="images/twitter.png"></a></li>
            <li><a href="https://www.instagram.com/aliefmastari/"><img src="images/instagram.png"></a></li>
        </ul>
    </section>

    

    <script type="text/javascript">
        function imgSlider(anything){
            document.querySelector('.ultra').src = anything;
        }
        function changeCircleColor(color){
            const circle = document.querySelector('.circle');
            circle.style.background = color;
        }
        function toggleMenu(){
            var menuToggle = document.querySelector('.toggle');
            var navigation = document.querySelector('.navigation');
            menuToggle.classList.toggle('active')
            navigation.classList.toggle('active')
        }
    </script>
</body>
</html>