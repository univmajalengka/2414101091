<?php
session_start();
require_once __DIR__ . "/koneksi.php";

const HARGA_PENGINAPAN = 1000000;
const HARGA_TRANSPORTASI = 1200000;
const HARGA_MAKAN = 500000;

$paket_id = isset($_POST["paket_id"]) ? (int) $_POST["paket_id"] : 0;
$nama = trim($_POST["nama_pemesan"] ?? "");
$no_hp = trim($_POST["no_hp"] ?? "");
$tanggal = $_POST["tanggal_pesan"] ?? "";
$lama = isset($_POST["lama_perjalanan"]) ? (int) $_POST["lama_perjalanan"] : 0;
$peserta = isset($_POST["jumlah_peserta"]) ? (int) $_POST["jumlah_peserta"] : 0;
$layanan = $_POST["layanan"] ?? [];

$errors = [];
if ($paket_id <= 0) {
    $errors[] = "Paket wisata belum dipilih.";
}
if ($nama === "") {
    $errors[] = "Nama pemesan wajib diisi.";
}
if ($no_hp === "") {
    $errors[] = "Nomor HP/Telp wajib diisi.";
}
if ($tanggal === "") {
    $errors[] = "Tanggal pesan wajib diisi.";
}
if ($lama <= 0) {
    $errors[] = "Waktu pelaksanaan harus lebih dari 0 hari.";
}
if ($peserta <= 0) {
    $errors[] = "Jumlah peserta harus lebih dari 0.";
}

$layanan_penginapan = in_array("penginapan", $layanan, true) ? 1 : 0;
$layanan_transportasi = in_array("transportasi", $layanan, true) ? 1 : 0;
$layanan_makan = in_array("makan", $layanan, true) ? 1 : 0;

$harga_paket = ($layanan_penginapan ? HARGA_PENGINAPAN : 0)
    + ($layanan_transportasi ? HARGA_TRANSPORTASI : 0)
    + ($layanan_makan ? HARGA_MAKAN : 0);
$jumlah_tagihan = $harga_paket * $lama * $peserta;

if (!empty($errors)) {
    $_SESSION["form_errors"] = $errors;
    $_SESSION["form_old"] = $_POST;
    header("Location: pemesanan.php?paket_id=" . $paket_id);
    exit();
}

$stmt = $koneksi->prepare(
    "INSERT INTO pesanan (paket_id, nama_pemesan, no_hp, tanggal_pesan, lama_perjalanan, layanan_penginapan, layanan_transportasi, layanan_makan, jumlah_peserta, harga_paket, jumlah_tagihan)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param(
    "isssiiiiiii",
    $paket_id,
    $nama,
    $no_hp,
    $tanggal,
    $lama,
    $layanan_penginapan,
    $layanan_transportasi,
    $layanan_makan,
    $peserta,
    $harga_paket,
    $jumlah_tagihan
);

if ($stmt->execute()) {
    $new_id = $stmt->insert_id;
    $_SESSION["flash_success"] = "Pesanan berhasil disimpan.";
    header("Location: sukses.php?id=" . $new_id);
    exit();
}

$_SESSION["form_errors"] = ["Gagal menyimpan pesanan. Silakan coba lagi."];
$_SESSION["form_old"] = $_POST;
header("Location: pemesanan.php?paket_id=" . $paket_id);









