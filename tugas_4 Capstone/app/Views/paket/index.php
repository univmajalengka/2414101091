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
                        href="<?= route_url('pesanan/create'); ?>">Pesan Sekarang</a>
                    <a class="px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20" href="#paket-list">Lihat Paket</a>
                </div>
            </div>
            <div class="absolute bottom-4 right-4 flex gap-2" id="heroDots"></div>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-2">Pilihan Paket Wisata</h2>
        <p class="text-slate-600">Pilih paket terbaik untuk mendukung pelaku lokal. Setiap paket telah dikurasi agar nyaman dan berkesan.</p>
    </section>

    <?php if (empty($paket_list)) : ?>
    <div class="bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-lg">
        Data paket belum tersedia. Jalankan <code>schema.sql</code> untuk menambahkan sample paket.
    </div>
    <?php else : ?>
    <div id="paket-list" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($paket_list as $paket) : ?>
        <?php $embedSrc = build_youtube_embed_src($paket['video_url']); ?>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100 flex flex-col">
            <?php if ($embedSrc) : ?>
            <div class="h-44 w-full bg-black">
                <iframe class="w-full h-full" src="<?= $embedSrc; ?>" title="<?= esc($paket['nama_paket']); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
            <?php else : ?>
            <img class="h-44 w-full object-cover" src="<?= esc($paket['gambar_url']); ?>" alt="<?= esc($paket['nama_paket']); ?>">
            <?php endif; ?>
            <div class="p-5 flex flex-col gap-3 flex-1">
                <div>
                    <h3 class="text-lg font-semibold"><?= esc($paket['nama_paket']); ?></h3>
                    <p class="text-sm text-slate-600 mt-1"><?= esc($paket['deskripsi']); ?></p>
                    <p class="text-sm text-emerald-600 font-semibold mt-2">
                        Mulai <?= format_rupiah((int) $paket['harga_per_hari']); ?> / hari
                    </p>
                </div>
                <div class="mt-auto flex flex-wrap gap-2">
                    <a class="px-3 py-2 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700"
                        href="<?= route_url('pesanan/create', ['paket_id' => (int) $paket['id']]); ?>">
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
    'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=1600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1600&auto=format&fit=crop',
    'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=1600&auto=format&fit=crop'
];
const heroSlide = document.getElementById('heroSlide');
const heroDots = document.getElementById('heroDots');
let heroIndex = 0;

function renderDots() {
    heroDots.innerHTML = '';
    heroImages.forEach((_, idx) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'h-2.5 w-2.5 rounded-full ' + (idx === heroIndex ? 'bg-emerald-300' : 'bg-white/50');
        dot.addEventListener('click', () => {
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
