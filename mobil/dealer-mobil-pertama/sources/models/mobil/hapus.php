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

        $sql = "SELECT * FROM tabel_mobil WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
    }
   
        if (isset($_POST['delete_data'])) {
            $id = $_POST['delete_id'];
            $delete_image = $_POST['delete_gambar'];

            $sql = "DELETE FROM tabel_mobil WHERE id='$id' ";
            $result = mysqli_query($conn, $sql);
        
            if($result)
            {
                unlink("../gambar_mobil/".$delete_image);
                echo "<script>alert('data berhasil dihapus');</script>";
                echo "<script>window.location='tabel.php';</script>";
            }
            else
            {
                echo "<script>alert('data gagal dihapus);</script>";
                echo "<script>window.location='tabel.php';</script>";
            }
    }
}
