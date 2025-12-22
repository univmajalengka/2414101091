<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Wisata MJLK'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">
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
                <?php $activeNav = $activeNav ?? ''; ?>
                <a class="block w-full rounded-md px-2 py-1 hover:bg-emerald-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent <?= $activeNav === 'home' ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600'; ?>"
                    href="<?= route_url('home/index'); ?>">Beranda</a>
                <a class="block w-full rounded-md px-2 py-1 hover:bg-emerald-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent <?= $activeNav === 'pemesanan' ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600'; ?>"
                    href="<?= route_url('pesanan/create'); ?>">Pesan</a>
                <a class="block w-full rounded-md px-2 py-1 hover:bg-emerald-50 md:w-auto md:px-0 md:py-0 md:hover:bg-transparent <?= $activeNav === 'kelola' ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600'; ?>"
                    href="<?= route_url('pesanan/manage'); ?>">Kelola Pesanan</a>
            </nav>
        </div>
    </header>

    <div class="flex-1 w-full">
        <?= $content ?? ''; ?>
    </div>

    <footer class="mt-12 bg-white border-t border-slate-100">
        <div
            class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-500 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <p>Wisata MJLK - Aplikasi Pemesanan Paket Wisata</p>
            <p>&copy; <?= date('Y'); ?> Wisata MJLK. All rights reserved.</p>
        </div>
    </footer>

    <script>
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    if (navToggle && navMenu) {
        const openLabel = navToggle.querySelector('.nav-open');
        const closeLabel = navToggle.querySelector('.nav-close');
        navToggle.addEventListener('click', () => {
            const isOpen = !navMenu.classList.contains('hidden');
            navMenu.classList.toggle('hidden');
            navToggle.setAttribute('aria-expanded', String(!isOpen));
            if (openLabel && closeLabel) {
                openLabel.classList.toggle('hidden', !isOpen);
                closeLabel.classList.toggle('hidden', isOpen);
            }
        });
    }
    </script>
</body>

</html>
