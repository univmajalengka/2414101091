<?php
require_once __DIR__ . '/config/db.php';

$sqlProduk = "SELECT id, nama_produk, subjudul_produk, kategori_produk, tech_stack, tanggal_update, harga_produk, gambar_produk FROM produk ORDER BY dibuat_pada DESC";
$produks = $conn->query($sqlProduk);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Khrzmi Code | Source Code</title>

  <!-- tailwind cdn -->
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
  <div
    class="pointer-events-none fixed inset-0 -z-10 bg-ornament"
    aria-hidden="true">
    <div class="blob"></div>
    <div class="grid-overlay"></div>
  </div>

  <header
    class="sticky top-0 z-50 border-b border-black-500/10 bg-white/80 backdrop-blur">
    <div class="mx-auto max-w-[1120px] px-4">
      <nav class="flex items-center justify-between gap-4 py-4">
        <h1 class="flex items-center text-black-500">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 640 640"
            class="block h-10 w-10 md:hidden"
            fill="currentColor">
            <path
              d="M392.8 65.2C375.8 60.3 358.1 70.2 353.2 87.2L225.2 535.2C220.3 552.2 230.2 569.9 247.2 574.8C264.2 579.7 281.9 569.8 286.8 552.8L414.8 104.8C419.7 87.8 409.8 70.1 392.8 65.2zM457.4 201.3C444.9 213.8 444.9 234.1 457.4 246.6L530.8 320L457.4 393.4C444.9 405.9 444.9 426.2 457.4 438.7C469.9 451.2 490.2 451.2 502.7 438.7L598.7 342.7C611.2 330.2 611.2 309.9 598.7 297.4L502.7 201.4C490.2 188.9 469.9 188.9 457.4 201.4zM182.7 201.3C170.2 188.8 149.9 188.8 137.4 201.3L41.4 297.3C28.9 309.8 28.9 330.1 41.4 342.6L137.4 438.6C149.9 451.1 170.2 451.1 182.7 438.6C195.2 426.1 195.2 405.8 182.7 393.3L109.3 320L182.6 246.6C195.1 234.1 195.1 213.8 182.6 201.3z" />
          </svg>
          <span class="hidden text-2xl font-semibold md:inline">Khrzmi Code</span>
        </h1>
        <div class="relative mx-5">
          <input
            type="text"
            placeholder="Search..."
            id="searchInput"
            class="w-full h-12 pl-12 pr-4 text-base text-gray-700 placeholder:text-gray-400 bg-white/80 border border-[#ece5d8] rounded-2xl outline-none transition-colors focus:bg-white focus:border-[#d8c9b7]" />
          <div
            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5 text-[#b8ad9c]"
              viewBox="0 0 640 640"
              fill="currentColor">
              <path
                d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z" />
            </svg>
          </div>
        </div>
        <div class="bg-black-500 rounded-xl">
          <a
            href="auth/login.php"
            class="flex items-center gap-2 px-5 py-3 text-base text-gray-100 leading-none">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 512 512"
              class="h-4 w-4"
              fill="currentColor">
              <path
                d="M352 96l64 0c17.7 0 32 14.3 32 32l0 256c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0c53 0 96-43 96-96l0-256c0-53-43-96-96-96l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32zm-9.4 182.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L242.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z" />
            </svg>
            <span>Login</span>
          </a>
        </div>
      </nav>
    </div>
  </header>
  <main>
    <section class="mx-auto max-w-[1120px] px-4 py-1 md:py-1">
      <div
        class="flex min-h-[calc(100vh-5rem)] flex-col md:min-h-[calc(100vh-6rem)]">
        <div
          class="flex flex-1 flex-col items-center justify-center gap-12 md:flex-row md:items-center md:justify-between">
          <div class="text-center md:text-left">
            <h2
              class="text-4xl font-semibold tracking-tight text-black-500 sm:text-5xl md:text-6xl">
              Khrzmi Code
            </h2>
            <p
              class="mt-6 max-w-2xl text-base leading-relaxed text-gray-700 sm:text-lg md:text-xl">
              Source code website siap pakai, mudah diubah sesuai kebutuhan
              bisnis, tugas kuliah dan portofolio anda.
            </p>
          </div>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 640 640"
            class="mx-auto h-24 w-24 shrink-0 text-black-500 sm:h-32 sm:w-32 md:h-40 md:w-40"
            fill="currentColor">
            <path
              d="M392.8 65.2C375.8 60.3 358.1 70.2 353.2 87.2L225.2 535.2C220.3 552.2 230.2 569.9 247.2 574.8C264.2 579.7 281.9 569.8 286.8 552.8L414.8 104.8C419.7 87.8 409.8 70.1 392.8 65.2zM457.4 201.3C444.9 213.8 444.9 234.1 457.4 246.6L530.8 320L457.4 393.4C444.9 405.9 444.9 426.2 457.4 438.7C469.9 451.2 490.2 451.2 502.7 438.7L598.7 342.7C611.2 330.2 611.2 309.9 598.7 297.4L502.7 201.4C490.2 188.9 469.9 188.9 457.4 201.4zM182.7 201.3C170.2 188.8 149.9 188.8 137.4 201.3L41.4 297.3C28.9 309.8 28.9 330.1 41.4 342.6L137.4 438.6C149.9 451.1 170.2 451.1 182.7 438.6C195.2 426.1 195.2 405.8 182.7 393.3L109.3 320L182.6 246.6C195.1 234.1 195.1 213.8 182.6 201.3z" />
          </svg>
        </div>
        <div class="mt-auto flex items-center gap-4 pt-16 md:justify-end">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 64 64"
            class="h-10 w-10 text-black-500"
            fill="none"
            stroke="currentColor"
            stroke-width="2">
            <path d="M20 8L8 20L20 32" />
            <path d="M44 8L56 20L44 32" />
            <path d="M24 44l-8 12" />
            <path d="M40 44l8 12" />
            <rect x="20" y="20" width="24" height="24" rx="6" />
          </svg>
          <div class="h-px flex-1 bg-black-500/20"></div>
        </div>
      </div>
    </section>
    <section id="produk" class="mx-auto max-w-[1120px] px-4 py-5">
      <div class="flex flex-col gap-8">
        <div class="max-w-2xl text-left">
          <p
            class="text-xs font-semibold uppercase tracking-[0.3em] text-black-500/70">
            Katalog Produk
          </p>
          <h2
            class="mt-2 text-2xl font-semibold tracking-tight text-black-500 sm:text-3xl md:text-4xl">
            Source Code
          </h2>
          <p class="mt-3 text-sm leading-relaxed text-gray-600 sm:text-base">
            Koleksi template source code website siap pakai untuk mempercepat
            pengembangan website Anda.
          </p>
        </div>
        <div class="flex flex-wrap gap-3 md:gap-4">
          <button
            type="button"
            class="flex items-center rounded-xl bg-black-500 px-5 py-2 text-sm font-medium text-white transition hover:bg-black-500/90 sm:px-6 sm:py-3 sm:text-base">
            HTML
          </button>
          <button
            type="button"
            class="flex items-center rounded-xl bg-black-500 px-5 py-2 text-sm font-medium text-white transition hover:bg-black-500/90 sm:px-6 sm:py-3 sm:text-base">
            Tailwind
          </button>
          <button
            type="button"
            class="flex items-center rounded-xl bg-black-500 px-5 py-2 text-sm font-medium text-white transition hover:bg-black-500/90 sm:px-6 sm:py-3 sm:text-base">
            React
          </button>
          <button
            type="button"
            class="flex items-center rounded-xl bg-black-500 px-5 py-2 text-sm font-medium text-white transition hover:bg-black-500/90 sm:px-6 sm:py-3 sm:text-base">
            Laravel
          </button>
        </div>
      </div>
    </section>
    <section class="mx-auto max-w-[1120px] px-4 py-5">
      <div class="grid gap-6 pt-4 sm:grid-cols-2 xl:grid-cols-4">
        <?php if ($produks && $produks->num_rows > 0): ?>
          <?php while ($produk = $produks->fetch_assoc()): ?>
            <?php
            $gambarProduk = $produk['gambar_produk'] ?? '';
            $srcGambar = !empty($gambarProduk)
              ? 'assets/produk/' . $gambarProduk
              : 'anjay';
            $kategori = $produk['kategori_produk'] ?? '-';
            $subjudul = $produk['subjudul_produk'] ?? '';
            $harga = isset($produk['harga_produk']) ? number_format((float) $produk['harga_produk'], 0, ',', '.') : '0';
            $techStackItems = array_filter(array_map('trim', explode(',', $produk['tech_stack'] ?? '')));
            $produkId = (int) ($produk['id'] ?? 0);
            ?>
            <article class="group block rounded-3xl bg-white shadow-sm ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-md">
              <div class="relative overflow-hidden rounded-xl rounded-b-none">
                <img src="<?= htmlspecialchars($srcGambar); ?>" alt="<?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?>" class="h-48 w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
              </div>
              <div class="space-y-4 px-4 py-4">
                <div class="space-y-3">
                  <span class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500"><?= htmlspecialchars($kategori); ?></span>
                  <h3 class="text-lg font-semibold text-black-500"><?= htmlspecialchars($produk['nama_produk'] ?? '-'); ?></h3>
                  <?php if (!empty($subjudul)): ?>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($subjudul); ?></p>
                  <?php endif; ?>
                  <?php if (!empty($techStackItems)): ?>
                    <div class="flex flex-wrap gap-2">
                      <?php foreach ($techStackItems as $stack): ?>
                        <span class="inline-flex items-center rounded-full border border-gray-200 bg-gray-50 px-2.5 py-0.5 text-[11px] font-medium text-gray-600"><?= htmlspecialchars($stack); ?></span>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="flex items-baseline gap-3">
                  <span class="text-xl md:text-lg font-semibold text-black-500">Rp<?= htmlspecialchars($harga); ?></span>
                </div>
                <div class="flex gap-3 pt-2">
                  <a
                    href="detail.php?id=<?= urlencode((string) $produkId); ?>"
                    class="inline-flex flex-1 items-center justify-center rounded-full border border-[#d8c9b7] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#475467] transition hover:bg-[#f2ede5]">
                    Detail
                  </a>
                  <a
                    href="beli.php?id=<?= urlencode((string) $produkId); ?>"
                    class="inline-flex flex-1 items-center justify-center rounded-full bg-black-500 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white transition hover:bg-black-500/90">
                    Beli
                  </a>
                </div>
              </div>
            </article>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="sm:col-span-2 xl:col-span-4 text-center text-sm text-gray-600">Produk belum ditambahkan!</p>
        <?php endif; ?>
      </div>
    </section>
    <section id="faq" class="mx-auto max-w-[1120px] px-4 py-12">
      <div class="space-y-8">
        <div class="space-y-3">
          <p
            class="text-xs font-semibold uppercase tracking-[0.3em] text-black-500/70">
            FAQ & Dukungan
          </p>
          <h2
            class="text-2xl font-semibold tracking-tight text-black-500 sm:text-3xl">
            Pertanyaan Umum
          </h2>
          <p class="text-sm text-gray-600 sm:text-base">
            Temukan jawaban atas pertanyaan yang sering diajukan seputar
            pembelian source code dan dukungan dari tim kami.
          </p>
        </div>
        <div
          class="divide-y divide-black-500/10 border-y border-black-500/10">
          <details class="group py-6 text-sm text-gray-600">
            <summary
              class="flex cursor-pointer items-center justify-between gap-4 text-left text-base font-medium text-black-500 marker:hidden">
              Apakah saya mendapatkan update setelah membeli?
              <span class="text-xl transition group-open:rotate-45">+</span>
            </summary>
            <div class="mt-3 leading-relaxed">
              Ya, setiap pembelian mencakup update minor gratis. Kami akan
              mengirim pemberitahuan update melalui email yang Anda daftarkan
              saat checkout.
            </div>
          </details>
          <details class="group py-6 text-sm text-gray-600">
            <summary
              class="flex cursor-pointer items-center justify-between gap-4 text-left text-base font-medium text-black-500 marker:hidden">
              Apakah ada dokumentasi instalasi yang lengkap?
              <span class="text-xl transition group-open:rotate-45">+</span>
            </summary>
            <div class="mt-3 leading-relaxed">
              Setiap paket dilengkapi dokumentasi setup dan panduan deployment
              langkah demi langkah agar Anda bisa menjalankan proyek dengan
              cepat.
            </div>
          </details>
          <details class="group py-6 text-sm text-gray-600">
            <summary
              class="flex cursor-pointer items-center justify-between gap-4 text-left text-base font-medium text-black-500 marker:hidden">
              Apakah lisensi bisa digunakan untuk proyek klien?
              <span class="text-xl transition group-open:rotate-45">+</span>
            </summary>
            <div class="mt-3 leading-relaxed">
              Tentu. Anda dapat menggunakan kode untuk proyek personal atau
              klien selama tidak mendistribusikan ulang paket asli secara
              massal.
            </div>
          </details>
          <details class="group py-6 text-sm text-gray-600">
            <summary
              class="flex cursor-pointer items-center justify-between gap-4 text-left text-base font-medium text-black-500 marker:hidden">
              Bagaimana jika saya membutuhkan kustomisasi tambahan?
              <span class="text-xl transition group-open:rotate-45">+</span>
            </summary>
            <div class="mt-3 leading-relaxed">
              Anda bisa menghubungi kami untuk layanan kustomisasi. Tim kami
              siap membantu menyesuaikan fitur sesuai kebutuhan Anda.
            </div>
          </details>
          <details class="group py-6 text-sm text-gray-600">
            <summary
              class="flex cursor-pointer items-center justify-between gap-4 text-left text-base font-medium text-black-500 marker:hidden">
              Apakah ada garansi bantuan teknis setelah pembelian?
              <span class="text-xl transition group-open:rotate-45">+</span>
            </summary>
            <div class="mt-3 leading-relaxed">
              Kami menyediakan dukungan teknis gratis selama 30 hari setelah
              pembelian. Hubungi kami kapan saja jika menemukan kendala.
            </div>
          </details>
        </div>
      </div>
    </section>
  </main>
  <footer class="border-t border-black-500/10 bg-white">
    <div class="mx-auto max-w-[1120px] px-4 py-10">
      <div
        class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-4 text-black-500">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 640 640"
            class="h-10 w-10"
            fill="currentColor">
            <path
              d="M392.8 65.2C375.8 60.3 358.1 70.2 353.2 87.2L225.2 535.2C220.3 552.2 230.2 569.9 247.2 574.8C264.2 579.7 281.9 569.8 286.8 552.8L414.8 104.8C419.7 87.8 409.8 70.1 392.8 65.2zM457.4 201.3C444.9 213.8 444.9 234.1 457.4 246.6L530.8 320L457.4 393.4C444.9 405.9 444.9 426.2 457.4 438.7C469.9 451.2 490.2 451.2 502.7 438.7L598.7 342.7C611.2 330.2 611.2 309.9 598.7 297.4L502.7 201.4C490.2 188.9 469.9 188.9 457.4 201.4zM182.7 201.3C170.2 188.8 149.9 188.8 137.4 201.3L41.4 297.3C28.9 309.8 28.9 330.1 41.4 342.6L137.4 438.6C149.9 451.1 170.2 451.1 182.7 438.6C195.2 426.1 195.2 405.8 182.7 393.3L109.3 320L182.6 246.6C195.1 234.1 195.1 213.8 182.6 201.3z" />
          </svg>
          <div>
            <p class="text-lg font-semibold">Khrzmi Code</p>
            <p class="text-sm text-gray-600">
              Source code website siap pakai, mudah diubah sesuai kebutuhan
              bisnis, tugas kuliah dan portofolio anda.
            </p>
          </div>
        </div>
        <div
          class="flex flex-wrap items-center justify-center gap-4 text-sm text-gray-600 md:justify-start">
          <a href="#" class="transition hover:text-black-500">Beranda</a>
          <span class="hidden h-3 w-px bg-gray-200 md:inline"></span>
          <a href="#produk" class="transition hover:text-black-500">Produk</a>
          <span class="hidden h-3 w-px bg-gray-200 md:inline"></span>
          <a href="#faq" class="transition hover:text-black-500">FAQ</a>
        </div>
      </div>
      <div
        class="mt-6 flex flex-col items-center gap-4 text-sm text-gray-500 md:flex-row md:items-center">
        <p>© 2025 Khrzmi Code. All rights reserved.</p>
      </div>
    </div>
  </footer>
  <?php
  if ($produks instanceof mysqli_result) {
    $produks->free();
  }
  $conn->close();
  ?>
</body>

</html>