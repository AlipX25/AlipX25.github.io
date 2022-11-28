<?php

include "pengguna/utilities/koneksi.php";

$sql = "SELECT * FROM tabel_perusahaan";
$result = mysqli_query($conn, $sql);
$data_perusahaan = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="dealer-mobil/sources/models/perusahaan/gambar/<?php echo $data_perusahaan['gambar'];   ?>" type="image/icon-type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat datang</title>
</head>
<body>
    <div class="content">
        <h1>Selamat Datang di <span><?php echo $data_perusahaan['nama']; ?></span></h1>

        <div class="link">
            <div class="kanan">
                <a href="dealer-mobil">Dashboard</a>
            </div>
            <div class="kiri">
                <a href="pengguna">Pengguna</a>
            </div>
        </div>
    </div>
</body>
</html>