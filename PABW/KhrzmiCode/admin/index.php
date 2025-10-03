<?php
session_start();

if (empty($_SESSION['is_login'])) {
  header('Location: ../auth/login.php');
  exit();
}

require_once '../config/db.php';

$menuNavigasi = [
  ['label' => 'Produk', 'href' => 'index.php', 'active' => true],
  ['label' => 'Pesanan', 'href' => 'orders.php'],
];

$judulSidebar = 'Khrzmi Admin';

$sqlProduk = "SELECT id, nama_produk, subjudul_produk, kategori_produk, tech_stack, tanggal_update, harga_produk, gambar_produk, link_produk FROM produk ORDER BY id DESC";
$hasilProduk = $conn->query($sqlProduk);
$daftarProduk = [];

if ($hasilProduk instanceof mysqli_result) {
  while ($row = $hasilProduk->fetch_assoc()) {
    $daftarProduk[] = $row;
  }
  $hasilProduk->free();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Dashboard Produk - Khrzmi Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../styles.css">
</head>

<body class="bg-[#f6f5f2] text-[#101828]">
  <div class="flex min-h-screen bg-[#f6f5f2] lg:gap-6 xl:gap-8">
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <main class="flex-1">
      <div class="w-full px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto flex max-w-6xl flex-col gap-6">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#101828]/60">Produk</p>
            <h1 class="mt-2 text-2xl font-semibold text-[#101828]">Daftar Produk</h1>
            <p class="mt-1 text-sm text-[#475467]">Pantau stok dan status produk yang tersedia di toko Anda.</p>
          </div>

          <div class="overflow-hidden rounded-2xl border border-[#ece5d8] bg-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#ece5d8] px-4 py-4 sm:px-6">
              <div class="text-sm font-medium text-[#101828]">Ringkasan Produk</div>
              <a
                href="createProduk.php"
                class="inline-flex items-center gap-2 rounded-full bg-[#101828] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#fdfbf7] transition hover:bg-[#101828]/90">
                + Tambah Produk
              </a>
            </div>

            <div class="space-y-2 p-4 sm:p-6">
              <!-- Versi Desktop: tabel -->
              <div class="hidden md:block overflow-x-auto">
                <table class="w-full divide-y divide-[#ece5d8]">
                  <thead class="bg-[#f9f6f0]">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Produk</th>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Kategori</th>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Tech Stack</th>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Update Terakhir</th>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Link</th>
                      <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Harga</th>
                      <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-[#f2eadd] bg-white text-sm text-[#101828]">
                    <?php if (!empty($daftarProduk)): ?>
                      <?php foreach ($daftarProduk as $produk): ?>
                        <?php
                        $namaProduk = $produk['nama_produk'] ?? '-';
                        $kategoriProduk = $produk['kategori_produk'] ?? '-';
                        $techStack = $produk['tech_stack'] ?? '-';
                        $tanggalUpdate = $produk['tanggal_update'] ?? '-';
                        $hargaProduk = isset($produk['harga_produk']) ? number_format((float)$produk['harga_produk'], 0, ',', '.') : '-';
                        $gambarProduk = $produk['gambar_produk'] ?? '';
                        $lokasiGambar = !empty($gambarProduk) ? '../assets/produk/' . $gambarProduk : 'anjay';
                        ?>
                        <tr>
                          <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                              <img src="<?= htmlspecialchars($lokasiGambar) ?>" alt="<?= htmlspecialchars($namaProduk) ?>" class="h-14 w-20 rounded-lg object-cover" />
                              <div>
                                <div class="font-semibold text-[#101828]"><?= htmlspecialchars($namaProduk) ?></div>
                                <div class="text-xs text-[#475467]"><?= htmlspecialchars($produk['subjudul_produk'] ?? '-') ?></div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-4 text-[#475467]"><?= htmlspecialchars($kategoriProduk) ?></td>
                          <td class="px-6 py-4 text-[#475467]"><?= htmlspecialchars($techStack) ?></td>
                          <td class="px-6 py-4 text-[#475467]"><?= htmlspecialchars($tanggalUpdate) ?></td>
                          <td class="px-6 py-4 text-[#475467]">
                            <?php if (!empty($produk['link_produk'])): ?>
                              <a href="<?= htmlspecialchars($produk['link_produk']) ?>" target="_blank" class="inline-flex items-center rounded-full border border-[#d8c9b7] px-3 py-1 text-xs font-semibold text-[#475467] transition hover:bg-[#f2ede5]">Buka Link</a>
                            <?php else: ?>
                              <span class="text-xs text-gray-400">-</span>
                            <?php endif; ?>
                          </td>
                          <td class="px-6 py-4 text-right font-semibold text-[#101828]">Rp<?= htmlspecialchars($hargaProduk) ?></td>
                          <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">

                              <a
                                href="updateProduk.php?id=<?= urlencode((string)($produk['id'] ?? '')) ?>"
                                class="inline-flex items-center rounded-full border border-[#d8c9b7] px-3 py-1 text-xs font-semibold text-[#475467] transition hover:bg-[#f2ede5]">
                                Edit
                              </a>
                              <a
                                href="hapusProduk.php?id=<?= urlencode((string)($produk['id'] ?? '')) ?>"
                                onclick="return confirm('Asli mau dihapus?');"
                                class="inline-flex items-center rounded-full bg-red-500 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-600">
                                Hapus
                              </a>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-sm text-[#475467]">Belum ada produk yang ditambahkan.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <!-- Versi Mobile: card list -->
              <div class="space-y-4 md:hidden">
                <?php if (!empty($daftarProduk)): ?>
                  <?php foreach ($daftarProduk as $produk): ?>
                    <?php
                    $namaProduk = $produk['nama_produk'] ?? '-';
                    $kategoriProduk = $produk['kategori_produk'] ?? '-';
                    $techStack = $produk['tech_stack'] ?? '-';
                    $tanggalUpdate = $produk['tanggal_update'] ?? '-';
                    $hargaProduk = isset($produk['harga_produk']) ? number_format((float)$produk['harga_produk'], 0, ',', '.') : '-';
                    $gambarProduk = $produk['gambar_produk'] ?? '';
                    $lokasiGambar = !empty($gambarProduk) ? '../assets/produk/' . $gambarProduk : 'anjay';
                    ?>
                    <div class="rounded-xl border border-[#ece5d8] bg-white shadow-sm p-4">
                      <div class="flex gap-3">
                        <img src="<?= htmlspecialchars($lokasiGambar) ?>" alt="<?= htmlspecialchars($namaProduk) ?>" class="h-16 w-20 rounded-lg object-cover" />
                        <div>
                          <div class="font-semibold text-[#101828]"><?= htmlspecialchars($namaProduk) ?></div>
                          <div class="text-xs text-[#475467]"><?= htmlspecialchars($produk['subjudul_produk'] ?? '-') ?></div>
                        </div>
                      </div>
                      <div class="mt-3 space-y-1 text-sm text-[#475467]">
                        <p><span class="font-medium text-[#101828]">Kategori:</span> <?= htmlspecialchars($kategoriProduk) ?></p>
                        <p><span class="font-medium text-[#101828]">Tech Stack:</span> <?= htmlspecialchars($techStack) ?></p>
                        <p><span class="font-medium text-[#101828]">Update:</span> <?= htmlspecialchars($tanggalUpdate) ?></p>
                        <p><span class="font-medium text-[#101828]">Link:</span>
                          <?php if (!empty($produk['link_produk'])): ?>
                            <a href="<?= htmlspecialchars($produk['link_produk']) ?>" target="_blank" class="text-[#101828] underline">Buka</a>
                          <?php else: ?>
                            <span class="text-gray-400">-</span>
                          <?php endif; ?>
                        </p>
                        <p><span class="font-medium text-[#101828]">Harga:</span> Rp<?= htmlspecialchars($hargaProduk) ?></p>
                      </div>
                      <div class="mt-3 flex flex-col gap-2">
                        <div class="flex gap-2">
                          <a href="updateProduk.php?id=<?= urlencode((string)($produk['id'] ?? '')) ?>" class="flex-1 text-center rounded-full border border-[#d8c9b7] px-3 py-1 text-xs font-semibold text-[#475467] transition hover:bg-[#f2ede5]">Edit</a>
                          <a href="hapusProduk.php?id=<?= urlencode((string)($produk['id'] ?? '')) ?>" onclick="return confirm('Yakin ingin menghapus produk ini?');" class="flex-1 text-center rounded-full bg-red-500 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-600">Hapus</a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-center text-sm text-[#475467]">Belum ada produk yang ditambahkan.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>
<?php $conn->close(); ?>