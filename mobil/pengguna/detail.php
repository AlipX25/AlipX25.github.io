<?php

session_start();
include "utilities/koneksi.php";


if(isset($_SESSION['username'])) {
include "utilities/sessionData.php";
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
        header("Location: detail.php?id=$id");
    } else {
        echo "<script>alert('username atau password Anda salah. Silahkan coba lagi!')</script>";
        echo "<script>window.location='detail.php?id=$id';</script>";
    }
}

if (isset($_POST['btnRegis'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_hp = $_POST['nomor_hp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
 
    if ($password == $cpassword) {
        $sql = "SELECT * FROM tabel_akun WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO tabel_akun (username, nama_lengkap, nomor_hp, email, alamat, password)
                    VALUES ('$username', '$nama_lengkap', '$nomor_hp', '$email', '$alamat', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                echo "<script>window.location='detail.php?id=$id';</script>";
               
            } else {
                echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
        }
         
    } else {
        echo "<script>alert('Password minimal 8 karakter')</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tambahButton'])) {
        $id_akun = $_POST['id_akun'];
        $id_mobil = $_POST['id_mobil'];
        $banyak_unit = $_POST['banyak_unit'];
        $status = '0';
        $jumlah_mobil_hitung = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_mobil FROM tabel_mobil WHERE id='$id_mobil'"))["jumlah_mobil"];
        $harga_mobil_hitung = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM tabel_mobil WHERE id='$id_mobil'"))["harga"];
        
         if($jumlah_mobil_hitung >= $banyak_unit){

        

        $sql = "INSERT INTO tabel_pembelian (id_akun, id_mobil, banyak_unit, status) VALUES ('$id_akun', '$id_mobil', '$banyak_unit', '$status')";
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
            echo "<script>window.location='detail.php?id=$id_mobil';</script>";
        } else if (!$result) {
            echo '<script>alert("Data gagal dibuat");</script>';
            echo "<script>window.location='detail.php?id=$id_mobil';</script>";
        }
      }
      else {
        echo '<script>alert("Mobil Habis atau Pembayaran Kurang");</script>';
        echo "<script>window.location='detail.php?id=$id_mobil';</script>";
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

        
       
        <div class="content">
            
        <div class="konten"><img style="width: 100px;" src="../dealer-mobil/sources/models/merk/gambar/<?php echo $gambar_merk;   ?>" alt=""></div>
        <h1><?php echo $merk; ?> <?php echo $data_mobil[ 'nama']; ?></h1>

        <div class="konten-mobil">
            <img src="../dealer-mobil/sources/models/gambar_mobil/<?php echo $data_mobil['gambar'];   ?>" alt="">
        </div>

        <div class="informasi-mobil">
            <h3>Informasi Mobil</h3>
            <br>
            <p>Merek  : <?php echo $merk ?></p>
            <p>Varian : <?php echo $data_mobil['nama']; ?></p>
            <p>Jenis  : <?php echo $jenis; ?></p>
            <p>Jumlah : <?php echo $data_mobil['jumlah_mobil']; ?></p>
            <p>Harga  : Rp <?php echo number_format($data_mobil     ['harga'],0,',','.'); ?></p>
        </div>

        <h2>Beli Mobil</h2>
        <div class="contact-box">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                
                <label for="id_akun">Nama Pembeli:</label>
                <select id="id_akun" class="select-field" name="id_akun" required>
                    

                    <?php
                    $sql = "SELECT * FROM tabel_akun WHERE id='$sessionId'";
                    $result = mysqli_query($conn, $sql);
                                        
                                        
                    foreach ($result as $row) {
                                            
                    ?>
                        <option selected value='<?php echo $row["id"] ?>'><?php echo $row['nama_lengkap']; ?></option>
                    <?php
                    }
                    ?>
                </select>

                <label style="margin-top:10px;" for="id_akun">Mobil:</label>
               
                <select id="id_mobil" class="select-field" name="id_mobil" required onchange="mobilSelect();">
                    <?php
                    $sql = "SELECT * FROM tabel_mobil WHERE id=$id ORDER BY nama";
                    $result = mysqli_query($conn, $sql);
                                        
                    foreach ($result as $row) {

                        $id_merk = $row['id_merk'];
                        $merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_merk WHERE id='$id_merk'"))["nama"];
                        $mobil = $row['nama'];
                        $jumlah_mobil = $row['jumlah_mobil'];

                        $mobil_merk = "$mobil - $merk";
                                            
                    ?>
                        <option  selected value='<?php echo $row["id"] ?>'><?php echo $mobil_merk; ?></option>
                    <?php
                    }
                    ?>
                </select>        
                <?php
                $sql = "SELECT * FROM tabel_mobil ORDER BY nama";
                $result = mysqli_query($conn, $sql);

                foreach ($result as $row) {

                    $id_merk = $row['id_merk'];
                    $merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_merk WHERE id='$id_merk'"))["nama"];
                    $mobil = $row['nama'];
                    $jumlah_mobil = $row['jumlah_mobil'];
                    $mobil_merk = "$mobil - $merk";
                ?>
                    <input id="<?php echo $row["id"] ?>-harga" value='<?php echo $row["harga"] ?>' disabled style="display: none !important;"></input>
                <?php
                }
                ?>        
                <label style="margin-top:10px;" for="id_akun">Banyak Mobil:</label>
                <input type="number" class="input-field" name="banyak_unit" id="banyak_unit" placeholder="Banyak Mobil" onchange="banyakSelect();" required >
                <label style="margin-top:10px;" for="id_akun">Harga:</label>
                <input type="text" class="input-field" id="harga" value="" disabled>

                <?php if(isset($_SESSION['username'])) 
                {?>
                <button type="submit"  name="tambahButton" id="tambahButton"  class="btn  btn-primary">Pesan</button>
                <?php 
                } else { ?>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Login untuk membeli</button>

                  <?php 
                } ?>
            </form>
        </div>    
           
        </div>
        
            
    </section>


            
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  action="" method="POST">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Username:</label>
            <input name="username" type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Password:</label>
            <input name="password" type="password" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
          <button name="btnLogin" type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <p>Belum punya akun?<a href=""type="button" style="color: blue;"  data-toggle="modal" data-target="#register" data-dismiss="modal" data-whatever="@mdo">Register</a></p>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  action="" method="POST">
          <div class="form-group">
            
            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
          </div>
          <div class="form-group">
            
            <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap">
          </div>
          <div class="form-group">
           
            <input type="number" name="nomor_hp" class="form-control" id="nomoe_hp" placeholder="Nomor HP">
          </div>
          <div class="form-group">
            
            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
          </div>
          <div class="form-group">
            
            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
          </div>
          <div class="form-group">
            
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          </div>
          <div class="form-group">
            
            <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Konfirmasi Password">
          </div>
            
          <button type="submit" name="btnRegis" class="btn btn-primary">Register</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <p>Belum punya akun?<a href=""type="button" style="color: blue;"  data-toggle="modal" data-target="#exampleModal" data-dismiss="modal" data-whatever="@mdo">Register</a></p>
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

    let totalHargaMobil = banyakMobil * hargaMobil;
    let formattedTotalHargaMobil = Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    }).format(totalHargaMobil);

    document.getElementById("harga").value = formattedTotalHargaMobil;
    document.getElementById("bayar").disabled = false;
  };

  

</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 
</body>
</html>