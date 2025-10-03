<?php
session_start();

if (empty($_SESSION['is_login'])) {
  header('Location: ../auth/login.php');
  exit();
}

$menuNavigasi = [
  ['label' => 'Produk', 'href' => 'index.php'],
  ['label' => 'Tambah Produk', 'href' => 'createProduk.php', 'active' => true],
  ['label' => 'Pesanan', 'href' => 'orders.php'],
];

$judulSidebar = 'Khrzmi Admin';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk - Khrzmi Admin</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../styles.css">
</head>

<body class="bg-[#f6f5f2] text-[#101828]">
  <div class="flex min-h-screen bg-[#f6f5f2] lg:gap-6 xl:gap-8">
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <main class="flex-1">
      <div class="w-full px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
        <div class="mx-auto max-w-4xl space-y-6">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#101828]/60">Produk</p>
            <h1 class="mt-2 text-2xl font-semibold text-[#101828]">Tambah Produk Baru</h1>
            <p class="mt-1 text-sm text-[#475467]">Lengkapi detail produk untuk menambahkannya ke katalog.</p>
          </div>

          <form
            action="../service/CreateProdukService.php"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-8 rounded-2xl border border-[#ece5d8] bg-white p-6 shadow-sm sm:p-8">
            <div class="grid gap-6 md:grid-cols-2">
              <div class="space-y-2">
                <label for="nama_produk" class="text-sm font-medium text-[#101828]">Nama Produk</label>
                <input
                  type="text"
                  id="nama_produk"
                  name="nama_produk"
                  required
                  placeholder="Contoh: Sistem Informasi Akademik"
                  class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] shadow-sm outline-none transition focus:border-[#d8c9b7] focus:ring-0" />
              </div>

              <div class="space-y-2">
                <label for="subjudul_produk" class="text-sm font-medium text-[#101828]">Subtitle</label>
                <input
                  type="text"
                  id="subjudul_produk"
                  name="subjudul_produk"
                  required
                  placeholder="Deskripsi singkat produk"
                  class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] shadow-sm outline-none transition focus:border-[#d8c9b7] focus:ring-0" />
              </div>

              <div class="space-y-2">
                <label for="kategori_produk" class="text-sm font-medium text-[#101828]">Kategori</label>
                <select
                  id="kategori_produk"
                  name="kategori_produk"
                  required
                  class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] shadow-sm outline-none transition focus:border-[#d8c9b7] focus:ring-0">
                  <option value="" disabled selected>Pilih kategori</option>
                  <option value="Laravel">Laravel</option>
                  <option value="React">React</option>
                  <option value="PHP Native">PHP Native</option>
                  <option value="HTML CSS JS">HTML CSS JS</option>
                </select>
              </div>

              <div class="space-y-2">
                <label for="tech_stack" class="text-sm font-medium text-[#101828]">Tech Stack</label>
                <input
                  type="text"
                  id="tech_stack"
                  name="tech_stack"
                  required
                  placeholder="Contoh: Laravel, Tailwind, MySQL"
                  class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] shadow-sm outline-none transition focus:border-[#d8c9b7] focus:ring-0" />
                <p class="text-xs text-[#98a2b3]">Pisahkan setiap teknologi dengan koma.</p>
              </div>

              <div class="space-y-2">
                <label for="tanggal_update" class="text-sm font-medium text-[#101828]">Update Terakhir</label>
                <input
                  type="date"
                  id="tanggal_update"
                  name="tanggal_update"
                  required
                  class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] shadow-sm outline-none transition focus:border-[#d8c9b7] focus:ring-0" />
              </div>

              <div class="space-y-2">
                <label for="harga_produk" class="text-sm font-medium text-[#101828]">Harga</label>
                <div class="relative">
                  <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-semibold text-[#475467]">Rp</span>
                  <input
                    type="number"
                    min="0"
                    step="1000"
                    id="harga_produk"
                    name="harga_produk"
                    required
                    placeholder="2000000"
                    class="w-full rounded-xl border border-[#ece5d8] bg-white px-12 py-3 text-sm text-[#101828] shadow-sm outline-none transition focus:border-[#d8c9b7] focus:ring-0" />
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <label for="link_produk" class="text-sm font-medium text-[#101828]">Link Download Produk</label>
              <input
                type="text"
                id="link_produk"
                name="link_produk"
                required
                placeholder="https://haisyam.com/buewir0vu"
                class="w-full rounded-xl border border-[#ece5d8] bg-white px-4 py-3 text-sm text-[#101828] shadow-sm outline-none transition focus:border-[#d8c9b7] focus:ring-0" />
            </div>

            <div class="space-y-3">
              <label for="gambar_produk" class="text-sm font-medium text-[#101828]">Gambar Produk</label>
              <div class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-dashed border-[#d8c9b7] bg-[#fdfbf7] px-6 py-8 text-center" data-area-upload>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  class="h-12 w-12 text-[#b8ad9c]">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 16.5V8A3 3 0 016 5h12a3 3 0 013 3v8.5a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 16.5z" />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 14l3.553-3.553a1.5 1.5 0 012.121 0L15 15l2.014-2.014a1.5 1.5 0 012.121 0L21 14" />
                  <circle cx="9" cy="9" r="1.5" />
                </svg>
                <label
                  for="gambar_produk"
                  class="inline-flex cursor-pointer items-center gap-2 rounded-full bg-[#101828] px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#fdfbf7] transition hover:bg-[#101828]/90">
                  Pilih Gambar
                </label>
                <input type="file" accept="image/*" id="gambar_produk" name="gambar_produk" required class="hidden" data-input-gambar />
                <p class="text-xs font-medium text-[#101828]" data-teks-file>Belum ada file dipilih</p>
                <p class="text-xs text-[#98a2b3]">Format JPG, PNG, atau WEBP. Ukuran maksimum 5MB.</p>
              </div>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
              <a
                href="index.php"
                class="inline-flex items-center justify-center rounded-xl border border-[#d8c9b7] px-5 py-3 text-sm font-semibold text-[#475467] transition hover:bg-[#f2ede5]">
                Batal
              </a>
              <button
                type="submit"
                name="createProduk"
                value="1"
                class="inline-flex items-center justify-center rounded-xl bg-[#101828] px-5 py-3 text-sm font-semibold text-[#fdfbf7] shadow-sm transition hover:bg-[#101828]/90">
                Simpan Produk
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-input-gambar]').forEach(function(inputEl) {
      var infoEl = inputEl.closest('[data-area-upload]')?.querySelector('[data-teks-file]');
      if (!infoEl) return;

      inputEl.addEventListener('change', function() {
        var namaFile = inputEl.files && inputEl.files.length > 0 ? inputEl.files[0].name : 'Belum ada file dipilih';
        infoEl.textContent = namaFile;
      });
    });
  });
</script>

</html>
