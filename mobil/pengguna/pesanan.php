<?php

session_start();
include "utilities/koneksi.php";
include "utilities/sessionData.php";

if (!$sessionAktif == 1){
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
            
        <?php include "components/navbar.php"; ?>
            
        </header>

        
       
        <div class="content">

        <h3>Data Pesanan Anda</h3>
            
        <table id="example1" class="table table-bordered table-striped" style="text-align: center;">
                  <thead>
                  <tr>
                      <th class="export">No</th>
                      <th class="export">Mobil</th> 
                      <th class="export">Banyak Unit</th>
                      <th class="export">Dibuat</th>
                      <th class="export">Status</th>
                      
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      $sql = "SELECT * FROM tabel_pembelian WHERE id_akun='$sessionId' ORDER BY dibuat DESC";
                      $result = mysqli_query($conn, $sql);
                      $no = 0;
                      foreach ($result as $row) {
                          $no++;
                          $id_mobil = $row['id_mobil'];
                          $harga = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM tabel_mobil WHERE id='$id_mobil'"))["harga"];
                          $id_merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_merk FROM tabel_mobil WHERE id='$id_mobil'"))["id_merk"];
                          $nama_merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_merk WHERE id='$id_merk'"))["nama"];
                          $nama_mobil =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_mobil WHERE id='$id_mobil'"))["nama"];
                          $harga = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM tabel_mobil WHERE id='$id_mobil'"))["harga"];
                          $bayar = $row['bayar'];

                          $jumlah_mobil_dibeli = $row['banyak_unit'];
                          $hasil= $bayar - $jumlah_mobil_dibeli * $harga;

                          $mobil_nama = "$nama_merk $nama_mobil";

                      ?>
                          <tr>
                              <td><?php echo $no; ?></td>
                             
                              <td><?php echo $mobil_nama; ?></td>
                              <td><?php echo $row['banyak_unit']; ?></td>
                              <td><?php echo $row['dibuat']; ?></td>
                              <td><?php 
                              if($row['status'] == 0){
                                echo "<button class='btn btn-primary'>Belum di Konfirmasi</button>"; 
                              }elseif($row['status'] == 1){
                                echo "<button class='btn btn-success'>Pesanan di terima</button>"; 
                              }elseif($row['status'] == 3){
                                echo "<button class='btn btn-danger'>Pesanan di tolak</button>";
                              }
                               

                              ?></td>
                          </tr>
                      <?php
                      }
                      ?>
                  </tbody>
                </table>

        
           
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
          <div class="form-group">
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

    const totalHargaMobil = banyakMobil * hargaMobil;

    document.getElementById("harga").value = totalHargaMobil;
    document.getElementById("bayar").disabled = false;
  };

  

</script>

 
</body>
</html>