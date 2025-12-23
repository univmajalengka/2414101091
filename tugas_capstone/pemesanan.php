<?php
session_start();
require_once __DIR__ . "/koneksi.php";

$paket_id = isset($_GET["paket_id"]) ? (int) $_GET["paket_id"] : 0;
$paket = null;
if ($paket_id > 0) {
    $stmt = $koneksi->prepare("SELECT id, nama_paket, deskripsi FROM paket_wisata WHERE id = ?");
    $stmt->bind_param("i", $paket_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $paket = $result ? $result->fetch_assoc() : null;
    $stmt->close();
}

$errors = $_SESSION["form_errors"] ?? [];
$old = $_SESSION["form_old"] ?? [];
unset($_SESSION["form_errors"], $_SESSION["form_old"]);

function old_value($key, $default = "") {
    global $old;
    return isset($old[$key]) ? $old[$key] : $default;
}

$old_layanan = $old["layanan"] ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Paket Wisata</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-5 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-emerald-600 font-semibold">Wisata MJLK</p>
                <h1 class="text-2xl font-bold">Form Pemesanan Paket Wisata</h1>
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

    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
            <?php if ($paket) : ?>
            <div class="mb-6">
                <p class="text-sm text-slate-500">Paket dipilih</p>
                <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($paket["nama_paket"]); ?></h2>
                <p class="text-slate-600"><?php echo htmlspecialchars($paket["deskripsi"]); ?></p>
            </div>
            <?php else : ?>
            <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-lg">
                Pilih paket dari halaman beranda agar paket terisi otomatis.
            </div>
            <?php endif; ?>

            <?php if (!empty($errors)) : ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
                <p class="font-semibold mb-1">Periksa kembali input Anda:</p>
                <ul class="list-disc list-inside text-sm">
                    <?php foreach ($errors as $error) : ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form class="grid gap-4" method="POST" action="proses_simpan.php" id="formPemesanan">
                <input type="hidden" name="paket_id"
                    value="<?php echo $paket ? (int) $paket["id"] : (int) $paket_id; ?>">

                <div>
                    <label class="text-sm font-semibold">Nama Paket Wisata</label>
                    <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2 bg-slate-100" type="text"
                        value="<?php echo htmlspecialchars($paket["nama_paket"] ?? "Belum dipilih"); ?>" readonly>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Nama Pemesan</label>
                        <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="text"
                            name="nama_pemesan" value="<?php echo htmlspecialchars(old_value("nama_pemesan")); ?>"
                            required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Nomor HP/Telp</label>
                        <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="text" name="no_hp"
                            value="<?php echo htmlspecialchars(old_value("no_hp")); ?>" required>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-sm font-semibold">Tanggal Pesan</label>
                        <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="date"
                            name="tanggal_pesan" value="<?php echo htmlspecialchars(old_value("tanggal_pesan")); ?>"
                            required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Waktu Pelaksanaan (hari)</label>
                        <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="number"
                            name="lama_perjalanan" min="1"
                            value="<?php echo htmlspecialchars(old_value("lama_perjalanan", "1")); ?>" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Jumlah Peserta</label>
                        <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2" type="number"
                            name="jumlah_peserta" min="1"
                            value="<?php echo htmlspecialchars(old_value("jumlah_peserta", "1")); ?>" required>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold mb-2">Pelayanan (checkbox)</p>
                    <div class="grid gap-2 md:grid-cols-3 text-sm">
                        <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">
                            <input type="checkbox" name="layanan[]" value="penginapan"
                                <?php echo in_array("penginapan", $old_layanan, true) ? "checked" : ""; ?>>
                            Penginapan (Rp 1.000.000)
                        </label>
                        <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">
                            <input type="checkbox" name="layanan[]" value="transportasi"
                                <?php echo in_array("transportasi", $old_layanan, true) ? "checked" : ""; ?>>
                            Transportasi (Rp 1.200.000)
                        </label>
                        <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">
                            <input type="checkbox" name="layanan[]" value="makan"
                                <?php echo in_array("makan", $old_layanan, true) ? "checked" : ""; ?>>
                            Service/Makan (Rp 500.000)
                        </label>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold">Harga Paket Perjalanan (total layanan)</label>
                        <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2 bg-slate-100"
                            type="number" name="harga_paket" id="harga_paket" readonly value="0">
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Jumlah Tagihan</label>
                        <input class="mt-2 w-full border border-slate-200 rounded-lg px-3 py-2 bg-slate-100"
                            type="number" name="jumlah_tagihan" id="jumlah_tagihan" readonly value="0">
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700"
                        type="submit">Simpan Pemesanan</button>
                    <a class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300"
                        href="index.php">Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </main>

    <script>
    const layananHarga = {
        penginapan: 1000000,
        transportasi: 1200000,
        makan: 500000,
    };

    const form = document.getElementById("formPemesanan");
    const hargaPaket = document.getElementById("harga_paket");
    const jumlahTagihan = document.getElementById("jumlah_tagihan");

    function hitungTotal() {
        const layanan = Array.from(form.querySelectorAll("input[name='layanan[]']:checked"));
        const lama = parseInt(form.lama_perjalanan.value || "0", 10);
        const peserta = parseInt(form.jumlah_peserta.value || "0", 10);
        const harga = layanan.reduce((total, item) => total + (layananHarga[item.value] || 0), 0);
        const tagihan = harga * lama * peserta;

        hargaPaket.value = harga;
        jumlahTagihan.value = tagihan;
    }

    form.addEventListener("input", hitungTotal);
    window.addEventListener("load", hitungTotal);
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
        <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-500 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <p>Wisata MJLK - Aplikasi Pemesanan Paket Wisata</p>
            <p>&copy; 2025 Wisata MJLK. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>









