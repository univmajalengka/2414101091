<?php
$flash = $flash_success ?? null;
$pesananList = $pesanan_list ?? [];
?>
<main class="max-w-6xl mx-auto px-4 py-8 w-full">
    <?php if ($flash) : ?>
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg">
        <?= esc($flash); ?>
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
                <?php if (empty($pesananList)) : ?>
                <tr>
                    <td colspan="7" class="py-6 text-center text-slate-500">Belum ada pesanan tersimpan.</td>
                </tr>
                <?php else : ?>
                <?php foreach ($pesananList as $pesanan) : ?>
                <tr class="border-b last:border-b-0">
                    <td class="py-3"><?= esc($pesanan['nama_paket']); ?></td>
                    <td class="py-3"><?= esc($pesanan['nama_pemesan']); ?></td>
                    <td class="py-3"><?= esc($pesanan['tanggal_pesan']); ?></td>
                    <td class="py-3"><?= (int) $pesanan['lama_perjalanan']; ?></td>
                    <td class="py-3"><?= (int) $pesanan['jumlah_peserta']; ?></td>
                    <td class="py-3"><?= format_rupiah((int) $pesanan['jumlah_tagihan']); ?></td>
                    <td class="py-3 flex flex-wrap gap-2">
                        <a class="px-3 py-1.5 bg-slate-200 rounded-lg hover:bg-slate-300"
                            href="<?= route_url('pesanan/edit', ['id' => (int) $pesanan['id']]); ?>">Edit</a>
                        <a class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200"
                            href="<?= route_url('pesanan/delete', ['id' => (int) $pesanan['id']]); ?>"
                            onclick="return confirm('Yakin ingin menghapus pesanan ini?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
