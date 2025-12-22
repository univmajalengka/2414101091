<?php

require_once 'koneksi.php';

// Proses hanya jika tombol daftar diklik melalui request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['daftar'])) {

    // Ambil data dari formulir dengan fallback nilai kosong
    $nama = trim($_POST['nama'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $jk = $_POST['jenis_kelamin'] ?? '';
    $agama = $_POST['agama'] ?? '';
    $sekolah = trim($_POST['sekolah_asal'] ?? '');

    // Validasi sederhana untuk memastikan seluruh field terisi
    if ($nama === '' || $alamat === '' || $jk === '' || $agama === '' || $sekolah === '') {
        header('Location: form-daftar.php?status=invalid');
        exit;
    }

    // Gunakan prepared statement agar terhindar dari SQL Injection
    $sql = 'INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal) VALUES (?, ?, ?, ?, ?)';
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        // Tidak dapat mempersiapkan statement
        die('Query gagal disiapkan: ' . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, 'sssss', $nama, $alamat, $jk, $agama, $sekolah);
    $query = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    if ($query) {
        header('Location: index.php?status=sukses');
        exit;
    }

    header('Location: index.php?status=gagal');
    exit;
}

die('Akses dilarang...');

?>
