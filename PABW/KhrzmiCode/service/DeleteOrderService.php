<?php
require_once '../config/db.php';

if (!isset($_GET['id'])) {
  header('Location: ../admin/orders.php');
  exit();
}

$orderId = (int) $_GET['id'];
if ($orderId <= 0) {
  header('Location: ../admin/orders.php');
  exit();
}

$stmt = $conn->prepare('DELETE FROM orders WHERE id = ?');
if ($stmt) {
  $stmt->bind_param('i', $orderId);
  $stmt->execute();
  $stmt->close();
}

$conn->close();

echo "<script>alert('Pesanan berhasil dihapus.'); window.location.href='../admin/orders.php';</script>";
exit();
