<?php
$sourcePath = "./../..";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 3, "$sourcePath/../");

if (isset($_SESSION["id"])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT aktif FROM tabel_user WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row["aktif"] == 1) {
                $sql = "UPDATE tabel_user SET aktif='0' WHERE id='$id'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<script>alert('User berhasil dimatikan');</script>";
                    echo "<script>window.location='tabel.php';</script>";
                } else if (!$result) {
                    echo '<script>alert("User gagal dimatikan");</script>';
                }
            } else if ($row["aktif"] == 0) {
                $sql = "UPDATE tabel_user SET aktif='1' WHERE id='$id'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<script>alert('User berhasil diaktifkan');</script>";
                    echo "<script>window.location='tabel.php';</script>";
                } else if (!$result) {
                    echo '<script>alert("User gagal diaktifkan");</script>';
                }
            }
        }
    }
}
