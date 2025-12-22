<?php
$pesanan = $pesanan ?? [];
$errors = $errors ?? [];
$old = $old ?? [];
$hargaPerHari = $harga_per_hari ?? (int) ($pesanan['harga_paket'] ?? 0);
?>
<main class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
        <div class="mb-6">
            <p class="text-sm text-slate-500">Paket dipilih</p>
            <h2 class="text-xl font-semibold"><?= esc($pesanan['nama_paket'] ?? '-'); ?></h2>
        </div>

        <?php if (!empty($errors)) : ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <p class="font-semibold mb-1">Periksa kembali input Anda:</p>
            <ul class="list-disc list-inside text-sm">
                <?php foreach ($errors as $error) : ?>
                <li><?= esc($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form class="grid gap-4" method="POST" action="<?= route_url('pesanan/update'); ?>" id="formEdit">
            <input type="hidden" name="id" value="<?= (int) ($pesanan['id'] ?? 0); ?>">
            <input type="hidden" name="paket_id" value="<?= (int) ($pesanan['paket_id'] ?? 0); ?>">

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Nama Pemesan</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="text"
                        name="nama_pemesan"
                        value="<?= esc(old_input($old, 'nama_pemesan', $pesanan['nama_pemesan'] ?? '')); ?>" required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Nomor HP/Telp</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="text" name="no_hp"
                        value="<?= esc(old_input($old, 'no_hp', $pesanan['no_hp'] ?? '')); ?>" required>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-sm font-semibold">Tanggal Pesan</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="date"
                        name="tanggal_pesan"
                        value="<?= esc(old_input($old, 'tanggal_pesan', $pesanan['tanggal_pesan'] ?? '')); ?>" required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Waktu Pelaksanaan (hari)</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="number"
                        name="lama_perjalanan" min="1"
                        value="<?= esc((string) old_input($old, 'lama_perjalanan', $pesanan['lama_perjalanan'] ?? '1')); ?>"
                        required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Jumlah Peserta</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="number"
                        name="jumlah_peserta" min="1"
                        value="<?= esc((string) old_input($old, 'jumlah_peserta', $pesanan['jumlah_peserta'] ?? '1')); ?>"
                        required>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold">Harga Paket (per hari)</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2 bg-slate-100" type="number"
                        id="harga_paket" readonly value="<?= (int) $hargaPerHari; ?>">
                </div>
                <div>
                    <label class="text-sm font-semibold">Jumlah Tagihan</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2 bg-slate-100" type="number"
                        id="jumlah_tagihan" readonly value="0">
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700" type="submit">Simpan
                    Perubahan</button>
                <a class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300"
                    href="<?= route_url('pesanan/manage'); ?>">Batal</a>
            </div>
        </form>
    </div>
</main>

<script>
const form = document.getElementById('formEdit');
const hargaPaket = document.getElementById('harga_paket');
const jumlahTagihan = document.getElementById('jumlah_tagihan');
const hargaPerHari = parseInt(hargaPaket.value || '0', 10);

function hitungTotal() {
    const lama = parseInt(form.lama_perjalanan.value || '0', 10);
    const peserta = parseInt(form.jumlah_peserta.value || '0', 10);
    const tagihan = hargaPerHari * lama * peserta;

    hargaPaket.value = hargaPerHari;
    jumlahTagihan.value = tagihan;
}

form.addEventListener('input', hitungTotal);
window.addEventListener('load', hitungTotal);
</script>
