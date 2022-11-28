<?php

session_start();
include "utilities/koneksi.php";

if(isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tabel_mobil WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $data_mobil = mysqli_fetch_assoc($result);

    $id_merk = $data_mobil['id_merk'];
    $merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_merk WHERE id='$id_merk'"))["nama"];
    $gambar_merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM tabel_merk WHERE id='$id_merk'"))["gambar"];

    $id_jenis = $data_mobil['id_jenis'];
    $jenis = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_jenis WHERE id='$id_jenis'"))["nama"];

    
   
}

 
if (isset($_POST['btnLogin'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
 
    $sql = "SELECT * FROM tabel_akun WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['type'] = "akun";
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['id'];
        header("Location: index.php");
    } else {
        echo "<script>alert('username atau password Anda salah. Silahkan coba lagi!')</script>";
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tambahButton'])) {
        $nama_pembeli = $_POST['nama_pembeli'];
        $alamat = $_POST['alamat'];
        $nomor_hp = $_POST['nomor_hp'];
        $id_mobil = $_POST['id_mobil'];
        $banyak_unit = $_POST['banyak_unit'];
        $bayar = $_POST['bayar'];
        $status = '0';
        $jumlah_mobil_hitung = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_mobil FROM tabel_mobil WHERE id='$id_mobil'"))["jumlah_mobil"];
        $harga_mobil_hitung = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM tabel_mobil WHERE id='$id_mobil'"))["harga"];
        
         if($jumlah_mobil_hitung >= $banyak_unit && $harga_mobil_hitung <= $bayar){

        

        $sql = "INSERT INTO tabel_pembelian (nama_pembeli, alamat, nomor_hp, id_mobil, banyak_unit, bayar, status) VALUES ('$nama_pembeli', '$alamat', '$nomor_hp', '$id_mobil', '$banyak_unit', '$bayar', '$status')";
        $result = mysqli_query($conn, $sql);

        if ($result) {

          // $sql = "SELECT * FROM tabel_pembelian ORDER BY nama_pembeli";
          // $result = mysqli_query($conn, $sql);
          // $data_mobil = mysqli_fetch_assoc($result);
          // $id_mobil = $data_mobil['id_mobil'];

          
          // $jumlah_mobil_dibeli = $data_mobil['banyak_unit'];

          $stok_mobil = $jumlah_mobil_hitung - $banyak_unit;

          $sql = "UPDATE tabel_mobil SET  jumlah_mobil='$stok_mobil' WHERE id='$id_mobil'";
          $result = mysqli_query($conn, $sql);

            echo "<script>alert('Data berhasil dibuat');</script>";
            echo "<script>window.location='detail.php?id=$id';</script>";
        } else if (!$result) {
            echo '<script>alert("Data gagal dibuat");</script>';
        }
      }
      else {
        echo '<script>alert("Mobil Habis atau Pembayaran Kurang");</script>';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include "components/title.php" ?>
    <link rel="stylesheet" href="public/detail-style.css">
</head>
<body>
    <section>
        
        <header>
            
        <?php include "components/navbar.php"; ?>
            
        </header>

        <h3 style="text-align: center;">LOGIN</h3>
     

            <form action="" method="post">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" placeholder="Masukan Username"  />

            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Masukan Password"  />

            </div>
            
            
            <button type="submit" name="btnLogin" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger"><a style="text-decoration: none; color: #fff;" href="register.php">Register</a></button>
            </form>  
        
        
            
    </section>


            




    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>