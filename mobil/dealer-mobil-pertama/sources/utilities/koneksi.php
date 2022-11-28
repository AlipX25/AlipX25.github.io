<?php
$host = 'localhost';
$user = 'root';
$password = 'admin123';
$database = 'db_dealer_mobil';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("gagal tersambung ke database");
};
