<?php
include '../config/db.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

$sql = "SELECT gambar_produk FROM produk WHERE id=$id";
$result = $conn->query($sql);
$row = $result ? $result->fetch_assoc() : null;
$gambar_produk = $row['gambar_produk'] ?? '';

  $sql = "DELETE FROM produk WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    $targetDir = realpath(__DIR__ . '/../assets/produk');
    if ($targetDir === false) {
        $targetDir = __DIR__ . '/../assets/produk';
    }

    $filePath = $targetDir . DIRECTORY_SEPARATOR . basename($gambar_produk);
    if (!empty($gambar_produk) && file_exists($filePath)) {
        unlink($filePath);
    }

    echo "<script>alert('Image deleted successfully.'); window.location.href='index.php';</script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
$conn->close();
