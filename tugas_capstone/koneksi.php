<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "wisata_haisyam2";

$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
$koneksi->set_charset("utf8mb4");









