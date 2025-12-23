<?php
session_start();
require_once __DIR__ . "/koneksi.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$pesanan = null;

if ($id > 0) {
    $stmt = $koneksi->prepare(
        "SELECT pesanan.*, paket_wisata.nama_paket
         FROM pesanan
         JOIN paket_wisata ON pesanan.paket_id = paket_wisata.id
         WHERE pesanan.id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pesanan = $result ? $result->fetch_assoc() : null;
    $stmt->close();
}

$flash_success = $_SESSION["flash_success"] ?? null;
unset($_SESSION["flash_success"]);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-5 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-emerald-600 font-semibold">Wisata MJLK</p>
                <h1 class="text-2xl font-bold">Pemesanan Berhasil</h1>
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
                <a class="text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-emerald-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="pemesanan.php">Pesan</a>
                <a class="text-slate-600 hover:text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-slate-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="modifikasi_pesanan.php">Kelola Pesanan</a>
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10">
        <?php if ($flash_success) : ?>
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg">
            <?php echo htmlspecialchars($flash_success); ?>
        </div>
        <?php endif; ?>

        <?php if (!$pesanan) : ?>
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            Data pesanan tidak ditemukan.
        </div>
        <?php else : ?>
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <p class="text-sm text-slate-500">Terima kasih, pesanan Anda sudah tercatat.</p>
            <h2 class="text-xl font-semibold mt-2"><?php echo htmlspecialchars($pesanan["nama_paket"]); ?></h2>

            <div class="grid gap-4 mt-6 md:grid-cols-2 text-sm">
                <div>
                    <p class="text-slate-500">Nama Pemesan</p>
                    <p class="font-semibold"><?php echo htmlspecialchars($pesanan["nama_pemesan"]); ?></p>
                </div>
                <div>
                    <p class="text-slate-500">Nomor HP/Telp</p>
                    <p class="font-semibold"><?php echo htmlspecialchars($pesanan["no_hp"]); ?></p>
                </div>
                <div>
                    <p class="text-slate-500">Tanggal Pesan</p>
                    <p class="font-semibold"><?php echo htmlspecialchars($pesanan["tanggal_pesan"]); ?></p>
                </div>
                <div>
                    <p class="text-slate-500">Durasi</p>
                    <p class="font-semibold"><?php echo (int) $pesanan["lama_perjalanan"]; ?> hari</p>
                </div>
                <div>
                    <p class="text-slate-500">Jumlah Peserta</p>
                    <p class="font-semibold"><?php echo (int) $pesanan["jumlah_peserta"]; ?> orang</p>
                </div>
                <div>
                    <p class="text-slate-500">Total Tagihan</p>
                    <p class="font-semibold">Rp
                        <?php echo number_format((int) $pesanan["jumlah_tagihan"], 0, ",", "."); ?></p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700" href="index.php">Kembali
                    ke Beranda</a>
                <a class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300"
                    href="pemesanan.php">Pesan Paket Lagi</a>
            </div>
        </div>
        <?php endif; ?>
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









