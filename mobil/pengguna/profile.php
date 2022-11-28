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


    if (isset($_POST['ubahDataBtn'])) {

        $username = cek($_POST['username']);
        $nama_lengkap = cek($_POST['nama_lengkap']);
        $nomor_hp = cek($_POST['nomor_hp']);
        $email = cek($_POST['email']);
        $alamat = cek($_POST['alamat']);

        $sql = "UPDATE tabel_akun SET username='$username', nama_lengkap='$nama_lengkap', nomor_hp='$nomor_hp', email='$email', alamat='$alamat' WHERE id='$sessionId'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Data berhasil diubah');</script>";
            echo "<script>window.location='profile.php';</script>";
        } else if (!$result) {
            echo '<script>alert("Data gagal diubah");</script>';
            echo "<script>window.location='profile.php';</script>";
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
    <?php include "components/title.php" ?>
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
            <div class="isi" style="border: 1px solid #b0b0b0; background-color: #d7d9d8; width: 600px; border-radius: 10px;">
                <form action="" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control"   value="<?php echo $sessionUsername; ?>" disabled/>

                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $sessionNamaLengkap; ?>" disabled />

                </div>
                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="number" name="nomor_hp" class="form-control" value="<?php echo $sessionNomorHP;?>" disabled />

                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $sessionEmail; ?>" disabled />

                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?php echo $sessionAlamat; ?>" disabled />

                </div>
                
                
                
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ubahProfil" data-whatever="@mdo">Ubah Data</button>

                
                </form>  
             
            </div>
            
            </div>
           
            
    </section>


    <div class="modal fade" id="ubahProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form  action="" method="POST">
            
                <label for="recipient-name" class="col-form-label">Username:</label>
                <input name="username" type="text" class="form-control" id="recipient-name">

                <label for="recipient-name" class="col-form-label">Nama Lengkap:</label>
                <input name="nama_lengkap" type="text" class="form-control" id="recipient-name">

                <label for="recipient-name" class="col-form-label">Nomor HP:</label>
                <input name="nomor_hp" type="number" class="form-control" id="recipient-name">

                <label for="recipient-name" class="col-form-label">Email:</label>
                <input name="email" type="email" class="form-control" id="recipient-name">

                <label for="recipient-name" class="col-form-label">Alamat:</label>
                <input name="alamat" type="text" class="form-control" id="recipient-name">
           
            <button name="ubahDataBtn" type="submit" class="btn btn-primary">Ubah</button>
            
            </form>
        </div>
        
        </div>
    </div>
    </div>            






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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>