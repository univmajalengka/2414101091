<?php
require_once __DIR__ . '/config/db.php';

$produkId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$produk = null;

if ($produkId > 0) {
  $stmt = $conn->prepare('SELECT id, nama_produk, subjudul_produk, kategori_produk, tech_stack, tanggal_update, harga_produk, gambar_produk FROM produk WHERE id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $produkId);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc() ?: null;
    $stmt->close();
  }
}

if (!$produk) {
  $conn->close();
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
      <p class="mt-3 text-gray-600">Produk yang Anda cari sudah tidak tersedia atau tautan tidak valid.</p>
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

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($produk['nama_produk'] ?? 'Detail Produk'); ?> - Khrzmi Code</title>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="styles.css" />

  <style type="text/tailwindcss">
    @theme {
      --color-black-500: #101828;
      --color-white: #fdfbf7;
    }
  </style>
</head>

<body class="h-full bg-white text-gray-900 antialiased">
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

  <main>
    <section class="mx-auto max-w-[1120px] px-4 py-8">
      <nav class="text-sm text-gray-500">
        <ol class="flex flex-wrap items-center gap-2">
          <li>
            <a href="index.php" class="flex items-center gap-1 text-gray-600 transition hover:text-black-500">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
                <path d="M12 3.1 2.6 10.6c-.5.4-.6 1.1-.2 1.6.2.3.6.5 1 .5H6v5.3c0 .9.7 1.6 1.6 1.6H10v-4.3c0-.3.2-.5.5-.5h3c.3 0 .5.2.5.5v4.3h2.4c.9 0 1.6-.7 1.6-1.6V12.7h2.5c.6 0 1.1-.5 1.1-1.1 0-.3-.1-.6-.4-.8L12 3.1Z" />
              </svg>
              Beranda
            </a>
          </li>
          <li class="text-gray-400">/</li>
          <li>
            <a href="#" class="transition hover:text-black-500"><?= htmlspecialchars($produk['kategori_produk'] ?? '-'); ?></a>
          </li>
          <li class="text-gray-400">/</li>
          <li class="max-w-[200px] truncate text-black-500 font-medium sm:max-w-none">
            <?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?>
          </li>
        </ol>
      </nav>

      <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,580px)_minmax(0,1fr)]">
        <div class="space-y-4">
          <div class="relative overflow-hidden rounded-3xl border border-white/50 shadow-sm">
            <img src="<?= htmlspecialchars($srcGambar); ?>" alt="<?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?>" class="w-full object-cover" style="aspect-ratio: 16 / 9;" />
          </div>
        </div>

        <div class="space-y-6">
          <div class="space-y-3">
            <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.25em] text-gray-500">
              <span><?= htmlspecialchars($produk['kategori_produk'] ?? '-'); ?></span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
              <h1 class="text-3xl font-semibold text-black-500 md:text-4xl">
                <?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?>
              </h1>
            </div>
            <p class="text-sm text-gray-600">by Khrzmi Code Studio</p>
          </div>

          <div class="text-3xl font-semibold text-black-500">
            <?= htmlspecialchars($hargaFormatted); ?>
          </div>

          <div class="space-y-5 border-t border-gray-200 pt-6">
            <div class="grid gap-4 text-sm text-gray-600 sm:grid-cols-2">
              <div class="space-y-1">
                <p class="font-semibold text-black-500">Kategori</p>
                <p><?= htmlspecialchars($produk['kategori_produk'] ?? '-'); ?></p>
              </div>
              <div class="space-y-1">
                <p class="font-semibold text-black-500">Tech Stack</p>
                <p>
                  <?php if (!empty($techStackItems)): ?>
                    <?= htmlspecialchars(implode(', ', $techStackItems)); ?>
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </p>
              </div>
              <div class="space-y-1">
                <p class="font-semibold text-black-500">Update Terakhir</p>
                <p><?= htmlspecialchars($tanggalUpdate ?: '-'); ?></p>
              </div>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
              <a href="beli.php?id=<?= urlencode((string) $produkId); ?>" class="w-full rounded-xl bg-black-500 px-4 py-3 text-sm font-semibold text-white text-center transition hover:bg-black-500/90">
                Beli Sekarang
              </a>
            </div>
          </div>

          <div class="space-y-4 border-t border-gray-200 pt-6">
            <h2 class="text-lg font-semibold text-black-500">
              Deskripsi Produk
            </h2>
            <div class="space-y-2 text-sm text-gray-600">
              <?php if (!empty($produk['subjudul_produk'])): ?>
                <p><?= nl2br(htmlspecialchars($produk['subjudul_produk'])); ?></p>
              <?php else: ?>
                <p>Detail lengkap sedang disiapkan. Silakan hubungi kami untuk informasi lebih lanjut.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>

</html>