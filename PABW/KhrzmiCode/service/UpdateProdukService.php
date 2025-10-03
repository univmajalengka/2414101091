<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_produk = intval($_POST['id_produk'] ?? 0);
  $nama = $conn->real_escape_string($_POST['nama_produk'] ?? '');
  $subjudul = $conn->real_escape_string($_POST['subjudul_produk'] ?? '');
  $kategori = $conn->real_escape_string($_POST['kategori_produk'] ?? '');
  $tech_stack = $conn->real_escape_string($_POST['tech_stack'] ?? '');
  $tanggal_update = $conn->real_escape_string($_POST['tanggal_update'] ?? '');
  $link_produk = $conn->real_escape_string($_POST['link_produk'] ?? '');
  $harga = intval($_POST['harga_produk'] ?? 0);

  $gambar = $_FILES['gambar_produk']['name'] ?? '';
  $target_dir = realpath(__DIR__ . '/../assets/produk');
  if ($target_dir === false) {
    $target_dir = __DIR__ . '/../assets/produk';
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0775, true);
    }
  }

  $target_dir = rtrim($target_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
  $namaFileBaru = $gambar !== '' ? basename($gambar) : '';
  $target_file = $namaFileBaru !== '' ? $target_dir . $namaFileBaru : '';

  if ($namaFileBaru !== '') {
    $sqlOld = "SELECT gambar_produk FROM produk WHERE id=$id_produk";
    $resOld = $conn->query($sqlOld);
    $rowOld = $resOld->fetch_assoc();
    $oldImage = $rowOld['gambar_produk'] ?? '';

    if (
      $target_file !== '' &&
      isset($_FILES['gambar_produk']['tmp_name']) &&
      is_uploaded_file($_FILES['gambar_produk']['tmp_name']) &&
      move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $target_file)
    ) {
      $sql = "UPDATE produk
              SET nama_produk='$nama', subjudul_produk='$subjudul', kategori_produk='$kategori',
                  tech_stack='$tech_stack', tanggal_update='$tanggal_update', link_produk='$link_produk',
                  harga_produk=$harga, gambar_produk='$namaFileBaru'
              WHERE id=$id_produk";

      if ($conn->query($sql) === TRUE) {
        if (!empty($oldImage)) {
          $oldPath = $target_dir . basename($oldImage);
          if (file_exists($oldPath)) {
            unlink($oldPath);
          }
        }
        echo "<script>alert('Produk berhasil diperbarui!'); window.location.href='index.php';</script>";
        exit();
      } else {
        echo "Error: " . $conn->error;
      }
    } else {
      echo "Error upload gambar.";
    }
  } else {
    $sql = "UPDATE produk
            SET nama_produk='$nama', subjudul_produk='$subjudul', kategori_produk='$kategori',
                tech_stack='$tech_stack', tanggal_update='$tanggal_update', link_produk='$link_produk',
                harga_produk=$harga
            WHERE id=$id_produk";

    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Produk berhasil diperbarui!'); window.location.href='index.php';</script>";
      exit();
    } else {
      echo "Error: " . $conn->error;
    }
  }
}
