<?php
session_start();

if (empty($_SESSION['is_login'])) {
  header('Location: ../auth/login.php');
  exit();
}

require_once '../config/db.php';

$menuNavigasi = [
  ['label' => 'Produk', 'href' => 'index.php',],
  ['label' => 'Pesanan', 'href' => 'orders.php', 'active' => true,],
];

$judulSidebar = 'Khrzmi Admin';

$sql = "SELECT o.id, p.nama_produk, o.nama_pembeli, o.kontak 
        FROM orders o 
        JOIN produk p ON o.produk_id = p.id 
        ORDER BY o.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Daftar Pesanan - Khrzmi Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../styles.css">
</head>

<body class="bg-[#f6f5f2] text-[#101828]">
  <div class="flex min-h-screen bg-[#f6f5f2] lg:gap-6 xl:gap-8">
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <main class="flex-1">
      <div class="w-full px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto flex max-w-6xl flex-col gap-6">
          <!-- Header -->
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#101828]/60">Pesanan</p>
            <h1 class="mt-2 text-2xl font-semibold text-[#101828]">Daftar Pesanan Masuk</h1>
            <p class="mt-1 text-sm text-[#475467]">Pantau pesanan pembelian produk source code Anda.</p>
          </div>

          <!-- Card wrapper -->
          <div class="overflow-hidden rounded-2xl border border-[#ece5d8] bg-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#ece5d8] px-4 py-4 sm:px-6">
              <div class="text-sm font-medium text-[#101828]">Ringkasan Pesanan</div>
            </div>

            <div class="space-y-2 p-4 sm:p-6">
              <!-- Versi Desktop: tabel -->
              <div class="hidden md:block overflow-x-auto">
                <table class="w-full divide-y divide-[#ece5d8]">
                  <thead class="bg-[#f9f6f0]">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Nama Produk</th>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Nama Pembeli</th>
                      <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Kontak</th>
                      <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-[#475467]">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-[#f2eadd] bg-white text-sm text-[#101828]">
                    <?php if ($result && $result->num_rows > 0): ?>
                      <?php while ($order = $result->fetch_assoc()): ?>
                        <tr>
                          <td class="px-6 py-4 font-medium text-[#101828]"><?= htmlspecialchars($order['nama_produk']); ?></td>
                          <td class="px-6 py-4 text-[#475467]"><?= htmlspecialchars($order['nama_pembeli']); ?></td>
                          <td class="px-6 py-4 text-[#475467]"><?= htmlspecialchars($order['kontak']); ?></td>
                          <td class="px-6 py-4 text-right">
                            <a
                              href="service/DeleteOrderService.php?id=<?= urlencode((string) $order['id']); ?>"
                              onclick="return confirm('Yakin ingin menghapus pesanan ini?');"
                              class="inline-flex items-center rounded-full bg-red-500 px-3 py-1 text-xs font-semibold text-white transition hover:bg-red-600">
                              Hapus
                            </a>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-sm text-[#475467]">Belum ada pesanan yang masuk.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <!-- Versi Mobile: card list -->
              <div class="space-y-4 md:hidden">
                <?php if ($result && $result->num_rows > 0): ?>
                  <?php $result->data_seek(0);
                  while ($order = $result->fetch_assoc()): ?>
                    <div class="rounded-xl border border-[#ece5d8] bg-white p-4 shadow-sm">
                      <p class="text-sm font-semibold text-[#101828]"><?= htmlspecialchars($order['nama_produk']); ?></p>
                      <div class="mt-2 space-y-1 text-sm text-[#475467]">
                        <p><span class="font-medium text-[#101828]">Nama:</span> <?= htmlspecialchars($order['nama_pembeli']); ?></p>
                        <p><span class="font-medium text-[#101828]">Kontak:</span> <?= htmlspecialchars($order['kontak']); ?></p>
                      </div>
                      <div class="mt-3 flex gap-2">
                        <a
                          href="service/DeleteOrderService.php?id=<?= urlencode((string) $order['id']); ?>"
                          onclick="return confirm('Yakin ingin menghapus pesanan ini?');"
                          class="flex-1 rounded-full bg-red-500 px-3 py-1 text-center text-xs font-semibold text-white transition hover:bg-red-600">
                          Hapus
                        </a>
                      </div>
                    </div>
                  <?php endwhile; ?>
                <?php else: ?>
                  <p class="text-center text-sm text-[#475467]">Belum ada pesanan yang ditambahkan.</p>
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
