<?php
session_start();

if (empty($_SESSION['is_login'])) {
  header('Location: ../auth/login.php');
  exit();
}

include '../config/db.php'; // koneksi database

// --- Navigasi Sidebar ---
$menuNavigasi = [
  ['label' => 'Produk', 'href' => 'index.php'],
  ['label' => 'Update Produk', 'href' => 'updateProduk.php', 'active' => true],
  ['label' => 'Pesanan', 'href' => 'orders.php'],
];

$judulSidebar = 'Khrzmi Admin';

// --- Ambil detail produk berdasarkan ID ---
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $sql = "SELECT * FROM produk WHERE id=$id";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $detailProduk = $result->fetch_assoc();
  } else {
    die("Produk tidak ditemukan.");
  }
} else {
  die("ID produk tidak diberikan.");
}

// --- Proses Update Produk ---
require_once '../service/UpdateProdukService.php';

function pilihKategori(string $kategori, string $nilai): string
{
  return strtolower($kategori) === strtolower($nilai) ? 'selected' : '';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk - Khrzmi Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../styles.css">
</head>

<body class="bg-[#f6f5f2] text-[#101828]">
  <div class="flex min-h-screen bg-[#f6f5f2] lg:gap-6 xl:gap-8">
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <main class="flex-1">
      <div class="w-full px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-4xl space-y-6">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
              <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#101828]/60">Produk</p>
              <h1 class="mt-2 text-2xl font-semibold text-[#101828]">Edit Produk</h1>
              <p class="mt-1 text-sm text-[#475467]">Perbarui informasi produk agar katalog selalu up-to-date.</p>
            </div>
            <a
              href="detailProduk.php?id=<?php echo urlencode((string) ($detailProduk['id'] ?? '')); ?>"
              class="inline-flex items-center gap-2 rounded-full border border-[#d8c9b7] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#475467] transition hover:bg-[#f2ede5]">
              Lihat Produk
            </a>
          </div>

          <div class="grid gap-4 rounded-2xl border border-[#ece5d8] bg-white p-6 shadow-sm sm:grid-cols-[220px_1fr] sm:p-8">
            <div class="space-y-4 text-center sm:text-left">
              <p class="text-sm font-medium text-[#101828]">Gambar Saat Ini</p>
              <div class="overflow-hidden rounded-2xl border border-[#ece5d8]">
                <?php
                $gambarAktif = $detailProduk['gambar_produk'] ?? '';
                $srcGambar = !empty($gambarAktif)
                  ? '../assets/produk/' . basename($gambarAktif)
                  : 'anjay';
                ?>
                <img
                  src="<?php echo htmlspecialchars($srcGambar); ?>"
                  alt="Gambar produk saat ini"
                  class="h-40 w-full object-cover" />
              </div>
              <p class="text-xs text-[#98a2b3]">Anda dapat mengganti gambar dengan mengunggah file baru di bawah.</p>
            </div>

            <form
              action=""
              method="POST"
              enctype="multipart/form-data"
              class="space-y-8">
              <input type="hidden" name="id_produk" value="<?php echo htmlspecialchars((string) ($detailProduk['id'] ?? '')); ?>" />

              <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-2">
                  <label for="nama_produk" class="text-sm font-medium text-[#101828]">Nama Produk</label>
                  <input
                    type="text"
                    id="nama_produk"
                    name="nama_produk"
                    required
                    value="<?php echo htmlspecialchars($detailProduk['nama_produk'] ?? ''); ?>"
                    class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828]" />
                </div>

                <div class="space-y-2">
                  <label for="subjudul_produk" class="text-sm font-medium text-[#101828]">Subtitle</label>
                  <input
                    type="text"
                    id="subjudul_produk"
                    name="subjudul_produk"
                    required
                    value="<?php echo htmlspecialchars($detailProduk['subjudul_produk'] ?? ''); ?>"
                    class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828]" />
                </div>

                <div class="space-y-2">
                  <label for="kategori_produk" class="text-sm font-medium text-[#101828]">Kategori</label>
                  <select
                    id="kategori_produk"
                    name="kategori_produk"
                    required
                    class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828]">
                    <option value="" disabled>Pilih kategori</option>
                    <option value="Laravel" <?php echo pilihKategori($detailProduk['kategori_produk'] ?? '', 'Laravel'); ?>>Laravel</option>
                    <option value="React" <?php echo pilihKategori($detailProduk['kategori_produk'] ?? '', 'React'); ?>>React</option>
                    <option value="PHP Native" <?php echo pilihKategori($detailProduk['kategori_produk'] ?? '', 'PHP Native'); ?>>PHP Native</option>
                    <option value="HTML CSS JS" <?php echo pilihKategori($detailProduk['kategori_produk'] ?? '', 'HTML CSS JS'); ?>>HTML CSS JS</option>
                  </select>
                </div>

                <div class="space-y-2">
                  <label for="tech_stack" class="text-sm font-medium text-[#101828]">Tech Stack</label>
                  <input
                    type="text"
                    id="tech_stack"
                    name="tech_stack"
                    required
                    value="<?php echo htmlspecialchars($detailProduk['tech_stack'] ?? ''); ?>"
                    class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828]" />
                  <p class="text-xs text-[#98a2b3]">Pisahkan setiap teknologi dengan koma.</p>
                </div>

                <div class="space-y-2">
                  <label for="tanggal_update" class="text-sm font-medium text-[#101828]">Update Terakhir</label>
                  <input
                    type="date"
                    id="tanggal_update"
                    name="tanggal_update"
                    required
                    value="<?php echo htmlspecialchars($detailProduk['tanggal_update'] ?? ''); ?>"
                    class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828]" />
                </div>

                <div class="space-y-2">
                  <label for="harga_produk" class="text-sm font-medium text-[#101828]">Harga</label>
                  <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-semibold text-[#475467]">Rp</span>
                    <input
                      type="number"
                      min="0"
                      step="1000"
                      id="harga_produk"
                      name="harga_produk"
                      required
                      value="<?php echo htmlspecialchars((string) ($detailProduk['harga_produk'] ?? '')); ?>"
                      class="w-full rounded-xl border border-[#ece5d8] bg-white px-12 py-3 text-sm text-[#101828]" />
                  </div>
                </div>
              </div>

              <div class="space-y-2">
                <label for="link_produk" class="text-sm font-medium text-[#101828]">Link Download Produk</label>
                <input
                  type="text"
                  id="link_produk"
                  name="link_produk"
                  required
                  value="<?php echo htmlspecialchars($detailProduk['link_produk'] ?? ''); ?>"
                  class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828]" />
              </div>

              <div class="space-y-3">
                <label for="gambar_produk" class="text-sm font-medium text-[#101828]">Ganti Gambar Produk</label>
                <div class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-dashed border-[#d8c9b7] bg-[#fdfbf7] px-6 py-8 text-center" data-area-upload>
                  <input type="file" accept="image/*" id="gambar_produk" name="gambar_produk" class="hidden" data-input-gambar />
                  <label
                    for="gambar_produk"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-full bg-[#101828] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#fdfbf7]">
                    Unggah Gambar Baru
                  </label>
                  <p class="text-xs font-medium text-[#101828]" data-teks-file>
                    <?php echo htmlspecialchars(basename($detailProduk['gambar_produk'] ?? 'Belum ada file dipilih')) ?: 'Belum ada file dipilih'; ?>
                  </p>
                  <p class="text-xs text-[#98a2b3]">Format JPG, PNG, atau WEBP. Ukuran maksimum 5MB.</p>
                </div>
              </div>

              <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a
                  href="index.php"
                  class="inline-flex items-center justify-center rounded-xl border border-[#d8c9b7] px-5 py-3 text-sm font-semibold text-[#475467]">
                  Batal
                </a>
                <button
                  type="submit"
                  class="inline-flex items-center justify-center rounded-xl bg-[#101828] px-5 py-3 text-sm font-semibold text-[#fdfbf7] shadow-sm">
                  Simpan Perubahan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-input-gambar]').forEach(function(inputEl) {
      var infoEl = inputEl.closest('[data-area-upload]')?.querySelector('[data-teks-file]');
      if (!infoEl) return;

      inputEl.addEventListener('change', function() {
        var namaFile = inputEl.files && inputEl.files.length > 0 ? inputEl.files[0].name : 'Belum ada file dipilih';
        infoEl.textContent = namaFile;
      });
    });
  });
</script>

</html>