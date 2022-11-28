<?php

session_start();
include "utilities/koneksi.php";
include "utilities/sessionData.php";

if (!$sessionAktif == 1){
  header("Location: index.php");
}

function cek($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_SESSION["id"])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM tabel_akun WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
    }

    
}   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $id = $_GET['id'];

        $username = cek($_POST['username']);
        $nama_lengkap = cek($_POST['nama_lengkap']);
        $nomor_hp = cek($_POST['nomor_hp']);
        $email = cek($_POST['email']);
        $alamat = cek($_POST['alamat']);

        $sql = "UPDATE tabel_jenis SET id_merk='$id_merk', nama='$nama' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Data berhasil diubah');</script>";
            echo "<script>window.location='ubah.php?id=$id';</script>";
        } else if (!$result) {
            echo '<script>alert("Data gagal diubah");</script>';
        }
    }
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
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Diaond car</title>
    <link rel="stylesheet" href="public/detail-style.css">
</head>
<body>
    <section>
        
        <header>
            <a href="#"><img src="../dealer-mobil/sources/models/perusahaan/<?php echo "gambar/".$data_perusahaan['gambar'];   ?>" class="logo"></a>
            <div class="toggle" onclick="toggleMenu();"></div>
            <ul class="navigation">
                <li><a style="text-decoration: none;" style="text-decoration: none;" href="index.php">Home</a></li>
                <li><a style="text-decoration: none;" href="produk.php">Mobil</a></li>
                <?php if(isset($_SESSION['username'])) 
                {?>
                <li><a style="text-decoration: none;" href="pesanan.php">Pesanan</a></li>
                <li><a style="text-decoration: none; color: red;" href="logout.php">Logout</a></li>
                <?php 
                } else { ?>
                <li><a style="text-decoration: none;" href="login.php">login</a></li>
      
                <?php 
                } ?>
            </ul>

            
        </header>

        
       
        <h3 style="text-align: center;">Akun Anda</h3>
            <div style="display: flex; justify-content: center;">
            <div class="isi" style="border: 1px solid #b0b0b0; background-color: #d7d9d8; width: 600px;">
                <form action="" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control"   value="<?php echo $sessionUsername; ?>"/>

                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $sessionNamaLengkap; ?>" />

                </div>
                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="number" name="nomor_hp" class="form-control" value="<?php echo $sessionNomorHP;?>" />

                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $sessionEmail; ?>" />

                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?php echo $sessionAlamat; ?>" />

                </div>
                
                
                
                <button type="submit" id='update' name='update' class="btn btn-primary">Ubah</button>
                
                </form>  
             
            </div>
            </div>
           
            
    </section>


            






<script>
  function mobilSelect() {
    document.getElementById("banyak_unit").value = null;
    document.getElementById("harga").value = null;
    document.getElementById("bayar").disabled = true;

    document.getElementById("banyak_unit").disabled = false;
  };

  function banyakSelect() {
    const idMobil = parseInt(document.getElementById("id_mobil").value);
    const banyakMobil = parseInt(document.getElementById("banyak_unit").value);
    const hargaMobil = parseInt(document.getElementById(`${idMobil}-harga`).value);

    const totalHargaMobil = banyakMobil * hargaMobil;

    document.getElementById("harga").value = totalHargaMobil;
    document.getElementById("bayar").disabled = false;
  };

  

</script>

 
</body>
</html>