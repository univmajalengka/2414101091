<?php
$pesanan = $pesanan ?? null;
$flash = $flash_success ?? null;
?>
<main class="max-w-4xl mx-auto px-4 py-10">
    <?php if ($flash) : ?>
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg">
        <?= esc($flash); ?>
    </div>
    <?php endif; ?>

    <?php if (!$pesanan) : ?>
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
        Data pesanan tidak ditemukan.
    </div>
    <?php else : ?>
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <p class="text-sm text-slate-500">Terima kasih, pesanan Anda sudah tercatat.</p>
        <h2 class="text-xl font-semibold mt-2"><?= esc($pesanan['nama_paket']); ?></h2>

        <div class="grid gap-4 mt-6 md:grid-cols-2 text-sm">
            <div>
                <p class="text-slate-500">Nama Pemesan</p>
                <p class="font-semibold"><?= esc($pesanan['nama_pemesan']); ?></p>
            </div>
            <div>
                <p class="text-slate-500">Nomor HP/Telp</p>
                <p class="font-semibold"><?= esc($pesanan['no_hp']); ?></p>
            </div>
            <div>
                <p class="text-slate-500">Tanggal Pesan</p>
                <p class="font-semibold"><?= esc($pesanan['tanggal_pesan']); ?></p>
            </div>
            <div>
                <p class="text-slate-500">Durasi</p>
                <p class="font-semibold"><?= (int) $pesanan['lama_perjalanan']; ?> hari</p>
            </div>
            <div>
                <p class="text-slate-500">Jumlah Peserta</p>
                <p class="font-semibold"><?= (int) $pesanan['jumlah_peserta']; ?> orang</p>
            </div>
            <div>
                <p class="text-slate-500">Total Tagihan</p>
                <p class="font-semibold"><?= format_rupiah((int) $pesanan['jumlah_tagihan']); ?></p>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700"
                href="<?= route_url('home/index'); ?>">Kembali ke Beranda</a>
            <a class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300"
                href="<?= route_url('pesanan/create'); ?>">Pesan Paket Lagi</a>
        </div>
    </div>
    <?php endif; ?>
</main>
