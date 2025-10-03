<?php
require_once '../service/AuthLogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Khrzmi Code</title>

  <!-- tailwind cdn -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../styles.css" />

  <style type="text/tailwindcss">
    @theme {
        --color-black-500: #101828;
        --color-white: #fdfbf7;
      }
    </style>
</head>

<body class="h-full bg-white text-gray-900 antialiased">
  <div
    class="pointer-events-none fixed inset-0 -z-10 bg-ornament"
    aria-hidden="true">
    <div class="blob"></div>
    <div class="grid-overlay"></div>
  </div>
  <main>
    <section class="mx-auto max-w-[1120px] px-4 py-12">
      <div
        class="mx-auto max-w-xl rounded-3xl border border-black-500/10 bg-white/80 p-8 shadow-sm backdrop-blur sm:p-10">
        <div class="space-y-3 text-center">
          <span
            class="inline-flex rounded-full border border-black-500/10 bg-white px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-black-500/70">Login</span>
          <h1 class="text-3xl font-semibold tracking-tight text-black-500">
            Masuk ke Dashboard
          </h1>
          <p class="text-sm text-gray-600">
            Akses dashboard dan riwayat pembelian Anda.
          </p>
        </div>
        <?php if (!empty($login_message)) : ?>
          <div
            class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
            <?php echo htmlspecialchars($login_message); ?>
          </div>
        <?php endif; ?>
        <form class="mt-8 space-y-6" method="post" action="">
          <div class="space-y-2">
            <label
              for="username"
              class="block text-sm font-medium text-black-500">Username</label>
            <input
              type="text"
              id="username"
              name="username"
              required
              autocomplete="username"
              placeholder="Masukkan username"
              value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
              class="w-full rounded-2xl border border-[#ece5d8] bg-white/90 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-[#d8c9b7] focus:bg-white focus:ring-0" />
          </div>
          <div class="space-y-2">
            <div class="flex items-center justify-between text-sm">
              <label for="password" class="font-medium text-black-500">Password</label>
            </div>
            <input
              type="password"
              id="password"
              name="password"
              required
              autocomplete="current-password"
              placeholder="Masukkan password"
              class="w-full rounded-2xl border border-[#ece5d8] bg-white/90 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-[#d8c9b7] focus:bg-white focus:ring-0" />
          </div>
          <button
            type="submit"
            name="login"
            value="1"
            class="w-full rounded-xl bg-black-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-black-500/90">
            Masuk
          </button>
        </form>
        <p class="mt-8 text-center text-sm text-gray-600">
          Belum punya akun?
          <a
            href="register.php"
            class="font-medium text-black-500 transition hover:text-black-500/80">Daftar sekarang</a>
        </p>
      </div>
    </section>
  </main>
</body>

</html>