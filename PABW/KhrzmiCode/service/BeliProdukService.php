<?php
if (!isset($_POST['beliProduk'])) {
  header('Location: ../index.php');
  exit();
}

require_once __DIR__ . '/../config/db.php';

$produkId = isset($_POST['produk_id']) ? (int) $_POST['produk_id'] : 0;
$namaPembeli = trim($_POST['nama_pembeli'] ?? '');
$kontak = trim($_POST['kontak'] ?? '');
$catatan = trim($_POST['catatan'] ?? '');

if ($produkId <= 0 || $namaPembeli === '' || $kontak === '') {
  $conn->close();
  echo "<script>alert('Data tidak lengkap.'); window.history.back();</script>";
  exit();
}

$stmtProduk = $conn->prepare('SELECT link_produk FROM produk WHERE id = ?');
if (!$stmtProduk) {
  $conn->close();
  echo "<script>alert('Terjadi kesalahan.'); window.history.back();</script>";
  exit();
}

$stmtProduk->bind_param('i', $produkId);
$stmtProduk->execute();
$resultProduk = $stmtProduk->get_result();
$dataProduk = $resultProduk->fetch_assoc();
$stmtProduk->close();

if (!$dataProduk) {
  $conn->close();
  echo "<script>alert('Produk tidak ditemukan.'); window.location.href='../index.php';</script>";
  exit();
}

$linkProduk = $dataProduk['link_produk'] ?? '';

$stmtOrder = $conn->prepare('INSERT INTO orders (produk_id, nama_pembeli, kontak, catatan, link_produk) VALUES (?, ?, ?, ?, ?)');
if (!$stmtOrder) {
  $conn->close();
  echo "<script>alert('Gagal menyimpan pesanan.'); window.history.back();</script>";
  exit();
}

$stmtOrder->bind_param('issss', $produkId, $namaPembeli, $kontak, $catatan, $linkProduk);

if ($stmtOrder->execute()) {
  $stmtOrder->close();
  $conn->close();
  $query = http_build_query([
    'id' => $produkId,
    'nama' => $namaPembeli,
    'kontak' => $kontak
  ]);
  header('Location: ../sukses.php?' . $query);
  exit();
}

$stmtOrder->close();
$conn->close();

echo "<script>alert('Gagal menyimpan pesanan.'); window.history.back();</script>";
exit();
