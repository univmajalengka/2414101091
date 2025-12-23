<?php
session_start();
require_once __DIR__ . "/koneksi.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
if ($id > 0) {
    $stmt = $koneksi->prepare("DELETE FROM pesanan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION["flash_success"] = "Pesanan berhasil dihapus.";
}

header("Location: modifikasi_pesanan.php");









