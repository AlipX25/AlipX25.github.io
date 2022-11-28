<?php
$sessionId = $_SESSION["id"];
$sessionType = $_SESSION["type"];

if ($sessionType == "akun") {
    $sql = "SELECT * FROM tabel_akun WHERE id='$sessionId'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows != 0) {
        $row = mysqli_fetch_assoc($result);

        $sessionUsername = $row["username"];
        $sessionNamaLengkap = $row['nama_lengkap'];
        $sessionNomorHP = $row['nomor_hp'];
        $sessionEmail = $row['email'];
        $sessionAlamat = $row['alamat'];
        $sessionAktif = 1;
    }
}

    

