<?php
require_once __DIR__ . "/koneksi.php";

$paket_list = [];
$result = $koneksi->query("SELECT id, nama_paket, deskripsi, gambar_url, video_url FROM paket_wisata ORDER BY id ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $paket_list[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Wisata MJLK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-5 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xl lg:text-sm text-emerald-600 font-bold">Wisata MJLK</p>
                <h1 class="hidden lg:block text-2xl font-bold">Aplikasi Pengelolaan & Pemesanan Paket Wisata</h1>
            </div>
            <button
                class="md:hidden inline-flex items-center justify-center rounded-lg border border-slate-200 px-2.5 py-2 text-slate-600 hover:text-emerald-600"
                type="button" id="navToggle" aria-expanded="false" aria-controls="navMenu">
                <svg class="nav-open h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <svg class="nav-close hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                <span class="sr-only">Toggle menu</span>
            </button>
            <nav id="navMenu"
                class="hidden w-full flex-col items-stretch gap-2 rounded-lg border border-slate-200 bg-emerald-50/90 px-3 py-3 text-sm font-semibold md:w-auto md:flex md:flex-row md:items-center md:border-0 md:bg-transparent md:px-0 md:py-0">
                <a class="text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-emerald-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="index.php">Beranda</a>
                <a class="text-slate-600 hover:text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-slate-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="pemesanan.php">Pesan</a>
                <a class="text-slate-600 hover:text-emerald-600 block w-full rounded-md px-2 py-1 hover:bg-slate-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent" href="modifikasi_pesanan.php">Kelola Pesanan</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        <section class="mb-10">
            <div class="relative overflow-hidden rounded-2xl shadow-sm border border-slate-100 bg-slate-900 text-white">
                <div id="heroSlide" class="absolute inset-0 bg-cover bg-center transition-opacity duration-700"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/60 to-transparent"></div>
                <div class="relative z-10 px-6 py-12 md:px-10 md:py-16 max-w-2xl">
                    <p class="text-sm uppercase tracking-widest text-emerald-200">Wisata MJLK</p>
                    <h2 class="text-3xl md:text-4xl font-bold mt-3">Temukan Paket Wisata Lokal Terbaik</h2>
                    <p class="mt-4 text-slate-100">
                        Jelajahi pengalaman unik, dukung pelaku lokal, dan buat perjalanan Anda lebih bermakna bersama
                        pemandu lokal.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600"
                            href="pemesanan.php">Pesan Sekarang</a>
                        <a class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20"
                            href="#paket-list">Lihat Paket</a>
                    </div>
                </div>
                <div class="absolute bottom-4 right-4 flex gap-2" id="heroDots"></div>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Pilihan Paket Wisata</h2>
            <p class="text-slate-600">Pilih paket terbaik untuk mendukung pelaku lokal. Setiap paket telah dikurasi agar
                nyaman dan berkesan.</p>
        </section>

        <?php if (empty($paket_list)) : ?>
        <div class="bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-lg">
            Data paket belum tersedia. Jalankan `schema.sql` untuk menambahkan sample paket.
        </div>
        <?php else : ?>
        <div id="paket-list" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($paket_list as $paket) : ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100 flex flex-col">
                <img class="h-44 w-full object-cover" src="<?php echo htmlspecialchars($paket["gambar_url"]); ?>"
                    alt="<?php echo htmlspecialchars($paket["nama_paket"]); ?>">
                <div class="p-5 flex flex-col gap-3 flex-1">
                    <div>
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($paket["nama_paket"]); ?></h3>
                        <p class="text-sm text-slate-600 mt-1"><?php echo htmlspecialchars($paket["deskripsi"]); ?></p>
                    </div>
                    <div class="mt-auto flex flex-wrap gap-2">
                        <a class="px-3 py-2 text-sm rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100"
                            href="<?php echo htmlspecialchars($paket["video_url"]); ?>" target="_blank" rel="noopener">
                            Lihat Video
                        </a>
                        <a class="px-3 py-2 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700"
                            href="pemesanan.php?paket_id=<?php echo (int) $paket["id"]; ?>">
                            Pesan Paket
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </main>

    <script>
    const heroImages = [
        "",
    ];
    const heroSlide = document.getElementById("heroSlide");
    const heroDots = document.getElementById("heroDots");
    let heroIndex = 0;

    function renderDots() {
        heroDots.innerHTML = "";
        heroImages.forEach((_, idx) => {
            const dot = document.createElement("button");
            dot.type = "button";
            dot.className = "h-2.5 w-2.5 rounded-full " + (idx === heroIndex ? "bg-emerald-300" :
                "bg-white/50");
            dot.addEventListener("click", () => {
                heroIndex = idx;
                updateHero();
            });
            heroDots.appendChild(dot);
        });
    }

    function updateHero() {
        heroSlide.style.backgroundImage = `url('${heroImages[heroIndex]}')`;
        renderDots();
    }

    function nextHero() {
        heroIndex = (heroIndex + 1) % heroImages.length;
        updateHero();
    }

    updateHero();
    setInterval(nextHero, 5000);
    </script>
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
        <div
            class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-500 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <p>Wisata MJLK - Aplikasi Pemesanan Paket Wisata</p>
            <p>&copy; 2025 Wisata MJLK. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>



