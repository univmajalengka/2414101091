<?php
require_once __DIR__ . '/config/Database.php';

$database = new Config\Database();
$koneksi = $database->getConnection();
