<?php
$soucePath = ".";

session_start();
session_destroy();
echo "<script>window.location='$soucePath/../index.php';</script>";
