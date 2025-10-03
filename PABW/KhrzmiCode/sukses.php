<?php
require_once __DIR__ . '/config/db.php';

$produkId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$namaPembeli = trim($_GET['nama'] ?? '');
$kontakPembeli = trim($_GET['kontak'] ?? '');
$produk = null;

if ($produkId > 0) {
  $stmt = $conn->prepare('SELECT id, nama_produk, subjudul_produk, kategori_produk, tech_stack, tanggal_update, harga_produk, gambar_produk, link_produk FROM produk WHERE id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $produkId);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc() ?: null;
    $stmt->close();
  }
}

$conn->close();

if (!$produk) {
  http_response_code(404);
?>
  <!DOCTYPE html>
  <html lang="id">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk Tidak Ditemukan - Khrzmi Code</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="styles.css" />
  </head>

  <body class="flex min-h-screen items-center justify-center bg-[#f6f5f2] text-[#101828]">
    <div class="rounded-3xl bg-white p-10 text-center shadow-lg">
      <h1 class="text-2xl font-semibold">Produk tidak ditemukan</h1>
      <p class="mt-3 text-gray-600">Pesanan tidak dapat ditemukan atau tautan tidak valid.</p>
      <a href="index.php" class="mt-6 inline-flex items-center rounded-full bg-black-500 px-5 py-2 text-sm font-semibold text-white transition hover:bg-black-500/90">Kembali ke Beranda</a>
    </div>
  </body>

  </html>
<?php
  exit();
}

$gambarProduk = $produk['gambar_produk'] ?? '';
$srcGambar = !empty($gambarProduk)
  ? 'assets/produk/' . $gambarProduk
  : 'anjay';
$techStackItems = array_filter(array_map('trim', explode(',', $produk['tech_stack'] ?? '')));
$hargaFormatted = 'Rp ' . number_format((float) ($produk['harga_produk'] ?? 0), 0, ',', '.');
$tanggalUpdate = $produk['tanggal_update'] ?? '';

if ($tanggalUpdate !== '') {
  $datetime = DateTime::createFromFormat('Y-m-d', $tanggalUpdate);
  if ($datetime) {
    $tanggalUpdate = $datetime->format('d F Y');
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesanan Selesai - Khrzmi Code</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="styles.css" />
  <style type="text/tailwindcss">
    @theme {
      --color-black-500: #101828;
      --color-white: #fdfbf7;
    }
  </style>
</head>

<body class="min-h-screen bg-[#f6f5f2] text-[#101828]">
  <div class="pointer-events-none fixed inset-0 -z-10 bg-ornament" aria-hidden="true">
    <div class="blob"></div>
    <div class="grid-overlay"></div>
  </div>

  <header class="sticky top-0 z-50 border-b border-black-500/10 bg-white/80 backdrop-blur">
    <div class="mx-auto max-w-[1120px] px-4">
      <nav class="flex items-center justify-between gap-4 py-4">
        <h1 class="flex items-center gap-3 text-black-500">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="h-8 w-8" fill="currentColor">
            <path d="M392.8 65.2C375.8 60.3 358.1 70.2 353.2 87.2L225.2 535.2C220.3 552.2 230.2 569.9 247.2 574.8C264.2 579.7 281.9 569.8 286.8 552.8L414.8 104.8C419.7 87.8 409.8 70.1 392.8 65.2zM457.4 201.3C444.9 213.8 444.9 234.1 457.4 246.6L530.8 320L457.4 393.4C444.9 405.9 444.9 426.2 457.4 438.7C469.9 451.2 490.2 451.2 502.7 438.7L598.7 342.7C611.2 330.2 611.2 309.9 598.7 297.4L502.7 201.4C490.2 188.9 469.9 188.9 457.4 201.4zM182.7 201.3C170.2 188.8 149.9 188.8 137.4 201.3L41.4 297.3C28.9 309.8 28.9 330.1 41.4 342.6L137.4 438.6C149.9 451.1 170.2 451.1 182.7 438.6C195.2 426.1 195.2 405.8 182.7 393.3L109.3 320L182.6 246.6C195.1 234.1 195.1 213.8 182.6 201.3z" />
          </svg>
          <span class="text-lg font-semibold">Khrzmi Code</span>
        </h1>
        <a href="index.php" class="inline-flex items-center rounded-full border border-[#ece5d8] px-4 py-2 text-sm text-[#475467] transition hover:bg-[#f2ede5]">
          Kembali
        </a>
      </nav>
    </div>
  </header>

  <main class="mx-auto max-w-[1120px] px-4 py-12">
    <div class="space-y-12">
      <section class="text-center space-y-4">
        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100">
          <svg class="h-12 w-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <h1 class="text-3xl font-semibold text-[#101828]">Pesanan Berhasil!</h1>
        <p class="text-sm text-[#475467]">Terima kasih, <?= htmlspecialchars($namaPembeli ?: 'Pembeli'); ?>. Detail produk dan instruksi pembayaran telah dikirim ke kontak Anda.</p>
      </section>

      <section class="grid gap-10 lg:grid-cols-2">
        <div class="space-y-4">
          <h2 class="text-xl font-semibold text-[#101828]">Ringkasan Produk</h2>
          <div class="space-y-3">
            <img src="<?= htmlspecialchars($srcGambar); ?>" alt="<?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?>" class="w-full rounded-3xl border border-[#ece5d8] object-cover" style="aspect-ratio: 16 / 9;" />
            <h3 class="text-lg font-semibold text-[#101828]"><?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?></h3>
            <p class="text-sm text-[#475467]">Kategori: <?= htmlspecialchars($produk['kategori_produk'] ?? '-'); ?></p>
            <p class="text-sm text-[#475467]">Harga: <?= htmlspecialchars($hargaFormatted); ?></p>
            <div class="space-y-1 text-sm text-[#475467]">
              <p class="font-semibold text-[#101828]">Tech Stack:</p>
              <?php if (!empty($techStackItems)): ?>
                <p><?= htmlspecialchars(implode(', ', $techStackItems)); ?></p>
              <?php else: ?>
                <p>-</p>
              <?php endif; ?>
            </div>
            <p class="text-sm text-[#475467]">Update Terakhir: <?= htmlspecialchars($tanggalUpdate ?: '-'); ?></p>
          </div>
        </div>

        <div class="space-y-8">
          <div class="space-y-3">
            <h2 class="text-xl font-semibold text-[#101828]">Kontak Anda</h2>
            <div class="space-y-2 text-sm text-[#475467]">
              <p><span class="font-semibold text-[#101828]">Nama</span><br><?= htmlspecialchars($namaPembeli ?: '-'); ?></p>
              <p><span class="font-semibold text-[#101828]">Kontak</span><br><?= htmlspecialchars($kontakPembeli ?: '-'); ?></p>
            </div>
          </div>

          <div class="space-y-4">
            <h2 class="text-xl font-semibold text-[#101828]">Aksi Cepat</h2>
            <p class="text-sm text-[#475467]">Unduh file source code atau salin tautan produk untuk dibagikan.</p>
            <div class="grid gap-3 sm:grid-cols-2">
              <?php if (!empty($produk['link_produk'])): ?>
                <a href="<?= htmlspecialchars($produk['link_produk']); ?>" class="inline-flex items-center justify-center rounded-full bg-black-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-black-500/90" target="_blank">
                  Download Source Code
                </a>
                <button type="button" onclick="copyProdukUrl('<?= htmlspecialchars($produk['link_produk']); ?>')" class="inline-flex items-center justify-center rounded-full border border-[#d8c9b7] px-4 py-3 text-sm font-semibold text-[#475467] transition hover:bg-[#f2ede5]">
                  Salin URL Produk
                </button>
              <?php else: ?>
                <span class="text-sm text[#475467]">Link produk belum tersedia.</span>
              <?php endif; ?>
            </div>
            <p id="copyNotice" class="hidden text-xs text-emerald-600">Tautan produk berhasil disalin ke clipboard.</p>
          </div>
        </div>
      </section>

      <section class="flex flex-col sm:flex-row gap-3">
        <a href="index.php" class="inline-flex flex-1 items-center justify-center rounded-full border border-[#d8c9b7] px-4 py-3 text-sm font-semibold text-[#475467] transition hover:bg-[#f2ede5]">
          Kembali ke Beranda
        </a>
      </section>
    </div>
  </main>

  <script>
    function copyProdukUrl(url) {
      navigator.clipboard.writeText(url).then(function() {
        document.getElementById('copyNotice').classList.remove('hidden');
        setTimeout(function() {
          document.getElementById('copyNotice').classList.add('hidden');
        }, 2500);
      });
    }
  </script>
</body>

</html>