<?php
$sessionId = $_SESSION["id"];
$sessionType = $_SESSION["type"];

if ($sessionType == "user") {
    $sql = "SELECT * FROM tabel_user WHERE id='$sessionId'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows != 0) {
        $row = mysqli_fetch_assoc($result);

        $sessionUsername = $row["username"];
        $sessionRole = $row["role"];
        $sessionNamaLengkap = $row['nama_lengkap'];
        $sessionNomorHP = $row['nomor_hp'];
        $sessionEmail = $row['email'];
        $sessionAktif = $row['aktif'];
    }
} else if ($sessionType == "siswa") {
    $sql = "SELECT * FROM tabel_siswa WHERE id='$sessionId'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows != 0) {
        $row = mysqli_fetch_assoc($result);

        $sessionNISN = $row['nisn'];
        $sessionNamaLengkap = $row['nama_lengkap'];
        $sessionTempatLahir = $row['tempat_lahir'];
        $sessionTanggalLahir = $row['tanggal_lahir'];
        $sessionJenisKelamin = $row['jenis_kelamin'];
        $sessionIdTahunMasuk = $row['id_tahun_masuk'];
        $sessionIdTingkat = $row['id_tingkat'];
        $sessionIdJurusan = $row['id_jurusan'];
        $sessionIdRombel = $row['id_rombel'];

        $sessionRole = "siswa";
        $sessionAktif = "1";
    }
}
