<?php
$host = file_exists("/.dockerenv") ? "db" : "localhost";
$user = "root";
$pass = "";
$db = "slemanclean_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
