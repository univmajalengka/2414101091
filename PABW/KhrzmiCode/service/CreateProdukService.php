
    <?php
    if (isset($_POST['createProduk'])) {
      include '../config/db.php';

      $namaProduk = $_POST['nama_produk'];
      $subjudulProduk = $_POST['subjudul_produk'];
      $kategoriProduk = $_POST['kategori_produk'];
      $techStack = $_POST['tech_stack'];
      $tanggalUpdate = $_POST['tanggal_update'];
      $hargaProduk = $_POST['harga_produk'];
      $linkProduk = $_POST['link_produk'];
      $gambarProduk = $_FILES['gambar_produk']['name'] ?? '';
      $tempGambar = $_FILES['gambar_produk']['tmp_name'] ?? '';
      $errorUpload = $_FILES['gambar_produk']['error'] ?? UPLOAD_ERR_NO_FILE;

      $target_dir = realpath(__DIR__ . '/../assets/produk');
      if ($target_dir === false) {
        $target_dir = __DIR__ . '/../assets/produk';
        if (!is_dir($target_dir)) {
          mkdir($target_dir, 0775, true);
        }
      }

      $target_file = rtrim($target_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . basename($gambarProduk);
      if (!is_writable($target_dir)) {
        echo "Folder tidak upload tidak diizinkan: $target_dir";
        exit;
      }

      if ($errorUpload === UPLOAD_ERR_OK && move_uploaded_file($tempGambar, $target_file)) {
        $sql = "INSERT INTO produk (nama_produk, subjudul_produk, kategori_produk, tech_stack, tanggal_update, harga_produk, gambar_produk, link_produk) VALUES ('$namaProduk', '$subjudulProduk', '$kategoriProduk', '$techStack', '$tanggalUpdate', '$hargaProduk', '$gambarProduk', '$linkProduk')";

        if ($conn->query($sql) === TRUE) {
          echo "<script>alert('Produk berhasil disimpan.'); window.location.href='../admin/index.php';</script>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        echo "Error uploading file: " . $errorUpload;
      }

      $conn->close();
    }
    ?>
