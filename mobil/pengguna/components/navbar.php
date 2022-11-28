

<a href="#"><img src="../dealer-mobil/sources/models/perusahaan/<?php echo "gambar/".$data_perusahaan['gambar'];   ?>" class="logo"></a>
<div class="toggle" onclick="toggleMenu();"></div>
<ul class="navigation">
    <li><a style="text-decoration: none;" href="index.php">Home</a></li>
    <li><a style="text-decoration: none;" href="produk.php">Mobil</a></li>
    <?php if(isset($_SESSION['username'])) 
    {?>
    <li><a style="text-decoration: none;" href="pesanan.php">Pesanan</a></li>
    <li><a style="text-decoration: none;" href="profile.php">Akun</a></li>
    <?php 
    } else { ?>
    <li><a style="text-decoration: none;" href="login.php">login</a></li>
      
    <?php 
    } ?>
</ul>