<?php
if ($sessionAktif == 0) {
    session_destroy();

    echo "<script>alert('Akun tidak aktif');</script>";
    echo "<script>window.location='$sourcePath/login.php';</script>";
};
