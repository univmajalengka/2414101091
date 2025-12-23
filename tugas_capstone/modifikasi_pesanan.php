<?php
session_start();
require_once __DIR__ . "/koneksi.php";

$pesanan_list = [];
$sql = "SELECT pesanan.*, paket_wisata.nama_paket FROM pesanan
        JOIN paket_wisata ON pesanan.paket_id = paket_wisata.id
        ORDER BY pesanan.id DESC";
$result = $koneksi->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pesanan_list[] = $row;
    }
}

$flash_success = $_SESSION["flash_success"] ?? null;
unset($_SESSION["flash_success"]);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-5 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-emerald-600 font-semibold">Wisata MJLK</p>
                <h1 class="text-2xl font-bold">Kelola Pesanan</h1>
            </div>
                        <button class="md:hidden inline-flex items-center justify-center rounded-lg border border-slate-200 px-2.5 py-2 text-slate-600 hover:text-emerald-600" type="button" id="navToggle" aria-expanded="false" aria-controls="navMenu">
                <svg class="nav-open h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <svg class="nav-close hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                <span class="sr-only">Toggle menu</span>
            </button>
            <nav id="navMenu" class="hidden w-full flex-col items-stretch gap-2 rounded-lg border border-slate-200 bg-emerald-50/90 px-3 py-3 text-sm font-semibold md:w-auto md:flex md:flex-row md:items-center md:border-0 md:bg-transparent md:px-0 md:py-0">
                <a class="text-slate-600 hover:text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-slate-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="index.php">Beranda</a>
                <a class="text-slate-600 hover:text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-slate-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="pemesanan.php">Pesan</a>
                <a class="text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-emerald-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="modifikasi_pesanan.php">Kelola Pesanan</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8 flex-1 w-full">
        <?php if ($flash_success) : ?>
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg">
            <?php echo htmlspecialchars($flash_success); ?>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 border-b">
                        <th class="pb-3">Nama Paket</th>
                        <th class="pb-3">Pemesan</th>
                        <th class="pb-3">Tanggal</th>
                        <th class="pb-3">Hari</th>
                        <th class="pb-3">Peserta</th>
                        <th class="pb-3">Total Tagihan</th>
                        <th class="pb-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pesanan_list)) : ?>
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-500">Belum ada pesanan tersimpan.</td>
                    </tr>
                    <?php else : ?>
                    <?php foreach ($pesanan_list as $pesanan) : ?>
                    <tr class="border-b last:border-b-0">
                        <td class="py-3"><?php echo htmlspecialchars($pesanan["nama_paket"]); ?></td>
                        <td class="py-3"><?php echo htmlspecialchars($pesanan["nama_pemesan"]); ?></td>
                        <td class="py-3"><?php echo htmlspecialchars($pesanan["tanggal_pesan"]); ?></td>
                        <td class="py-3"><?php echo (int) $pesanan["lama_perjalanan"]; ?></td>
                        <td class="py-3"><?php echo (int) $pesanan["jumlah_peserta"]; ?></td>
                        <td class="py-3">Rp <?php echo number_format((int) $pesanan["jumlah_tagihan"], 0, ",", "."); ?>
                        </td>
                        <td class="py-3 flex flex-wrap gap-2">
                            <a class="px-3 py-1.5 bg-slate-200 rounded-lg hover:bg-slate-300"
                                href="edit_pesanan.php?id=<?php echo (int) $pesanan["id"]; ?>">Edit</a>
                            <a class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200"
                                href="hapus_pesanan.php?id=<?php echo (int) $pesanan["id"]; ?>"
                                onclick="return confirm('Yakin ingin menghapus pesanan ini?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        const navToggle = document.getElementById("navToggle");
        const navMenu = document.getElementById("navMenu");
        if (navToggle && navMenu) {
            const openLabel = navToggle.querySelector(".nav-open");
            const closeLabel = navToggle.querySelector(".nav-close");
            navToggle.addEventListener("click", () => {
                const isOpen = !navMenu.classList.contains("hidden");
                navMenu.classList.toggle("hidden");
                navToggle.setAttribute("aria-expanded", String(!isOpen));
                if (openLabel && closeLabel) {
                    openLabel.classList.toggle("hidden", !isOpen);
                    closeLabel.classList.toggle("hidden", isOpen);
                }
            });
        }
    </script>
    <footer class="mt-12 bg-white border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-500 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <p>Wisata MJLK - Aplikasi Pemesanan Paket Wisata</p>
            <p>&copy; 2025 Wisata MJLK. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>









