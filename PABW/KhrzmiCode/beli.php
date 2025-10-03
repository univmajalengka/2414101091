<?php
require_once __DIR__ . '/config/db.php';

$produkId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
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

if (!$produk) {
  $conn->close();
  http_response_code(404);
?>
  <!DOCTYPE html>
  <html lang="id">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Error - Khrzmi Code</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="styles.css" />
  </head>

  <body class="flex min-h-screen items-center justify-center bg-[#f6f5f2] text-[#101828]">
    <div class="rounded-3xl bg-white p-10 text-center shadow-lg">
      <h1 class="text-2xl font-semibold">ERRORRRRR</h1>
      <p class="mt-3 text-gray-600">Hayooo Ngapainn luuu.</p>
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
  <title>Form Pembelian - Khrzmi Code</title>
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
        <a href="detail.php?id=<?= urlencode((string) $produkId); ?>" class="inline-flex items-center rounded-full border border-[#ece5d8] px-4 py-2 text-sm text-[#475467] transition hover:bg-[#f2ede5]">
          Kembali
        </a>
      </nav>
    </div>
  </header>

  <main class="mx-auto max-w-[1120px] px-4 py-8">
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

    <div class="space-y-10 mt-6">
      <section class="space-y-6">
        <div class="space-y-4">
          <img src="<?= htmlspecialchars($srcGambar); ?>" alt="<?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?>" class="w-full rounded-3xl border border-[#ece5d8] object-cover" style="aspect-ratio: 16 / 9;" />
          <div class="space-y-3">
            <h2 class="text-2xl font-semibold text-[#101828]"><?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?></h2>
            <p class="text-sm text-[#475467]"><?= htmlspecialchars($produk['subjudul_produk'] ?? 'Deskripsi singkat produk akan ditampilkan di sini.'); ?></p>
          </div>
          <div class="grid gap-3 text-sm text-[#475467]">
            <p><span class="font-semibold text-[#101828]">Kategori:</span> <?= htmlspecialchars($produk['kategori_produk'] ?? '-'); ?></p>
            <p><span class="font-semibold text-[#101828]">Tech Stack:</span> <?= htmlspecialchars(implode(', ', $techStackItems) ?: '-'); ?></p>
            <p><span class="font-semibold text-[#101828]">Update Terakhir:</span> <?= htmlspecialchars($tanggalUpdate ?: '-'); ?></p>
          </div>
          <div class="text-2xl font-semibold text-[#101828]"><?= htmlspecialchars($hargaFormatted); ?></div>
        </div>
      </section>

      <section class="space-y-6">
        <div class="space-y-2">
          <h1 class="text-2xl font-semibold text-[#101828]">Form Pembelian</h1>
          <p class="text-sm text-[#475467]">Isi data kontak Anda. Tim kami akan menghubungi untuk proses pengiriman source code.</p>
        </div>

        <form action="service/BeliProdukService.php" method="post" class="space-y-5">
          <input type="hidden" name="produk_id" value="<?= htmlspecialchars((string) $produkId); ?>" />

          <div class="space-y-2">
            <label for="nama_pembeli" class="text-sm font-medium text-[#101828]">Nama Lengkap</label>
            <input type="text" id="nama_pembeli" name="nama_pembeli" placeholder="Contoh: Muhamad Haisyam Khairizmi" required class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] outline-none transition focus:border-[#d8c9b7]" />
          </div>

          <div class="space-y-2">
            <label for="kontak" class="text-sm font-medium text-[#101828]">Email / No. WhatsApp</label>
            <input type="text" id="kontak" name="kontak" placeholder="Contoh: nama@email.com atau 62812xxxx" required class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] outline-none transition focus:border-[#d8c9b7]" />
          </div>

          <div class="space-y-2">
            <label for="catatan" class="text-sm font-medium text-[#101828]">Catatan Tambahan (Opsional)</label>
            <textarea id="catatan" name="catatan" rows="4" placeholder="Tambahkan catatan khusus atau kebutuhan tambahan." class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] outline-none transition focus:border-[#d8c9b7]"></textarea>
          </div>

          <button type="submit" name="beliProduk" value="1" class="w-full rounded-xl bg-black-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-black-500/90">
            Kirim Pesanan
          </button>
        </form>
        <p class="text-xs text-[#98a2b3]">
          Dengan mengirim pesanan ini, kami akan menghubungi Anda melalui email atau WhatsApp untuk langkah selanjutnya.
        </p>
      </section>
    </div>
  </main>
</body>

</html>