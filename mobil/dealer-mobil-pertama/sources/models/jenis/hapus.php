<?php
$sourcePath = "./../..";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 2, "$sourcePath/../");

if (isset($_SESSION["id"])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM tabel_jenis WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Data berhasil dihapus');</script>";
            echo "<script>window.location='tabel.php';</script>";
        } else if (!$result) {
            echo '<script>alert("Data gagal dihapus");</script>';
        }
    }
}
