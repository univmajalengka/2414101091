<?php
$menuNavigasi = $menuNavigasi ?? [
  ['label' => 'Produk', 'href' => '/admin/index.php', 'active' => true],
  ['label' => 'Pesanan', 'href' => '/admin/orders.php'],
];

$judulSidebar = $judulSidebar ?? 'Khrzmi Dashboard';
?>

<?php if (!defined('ASET_SIDEBAR_TERSEDIA')) :
  define('ASET_SIDEBAR_TERSEDIA', true);
?>
  <script>
    (function() {
      if (window.sidebarSudahInisialisasi) return;
      window.sidebarSudahInisialisasi = true;

      function setSidebarState(open) {
        var sidebar = document.querySelector('[data-menu-samping]');
        var backdrop = document.querySelector('[data-latar-menu]');
        if (!sidebar) return;

        sidebar.classList.toggle('-translate-x-full', !open);
        sidebar.classList.toggle('translate-x-0', open);

        if (backdrop) {
          backdrop.classList.toggle('opacity-100', open);
          backdrop.classList.toggle('pointer-events-auto', open);
          backdrop.classList.toggle('pointer-events-none', !open);
        }
      }

      function toggleSidebar(force) {
        var sidebar = document.querySelector('[data-menu-samping]');
        if (!sidebar) return;
        var isOpen = !sidebar.classList.contains('-translate-x-full');
        var willOpen = typeof force === 'boolean' ? force : !isOpen;
        setSidebarState(willOpen);
      }

      document.addEventListener('click', function(event) {
        var toggleButton = event.target.closest('[data-tombol-menu]');
        var closeButton = event.target.closest('[data-tutup-menu]');
        var backdrop = event.target.closest('[data-latar-menu]');

        if (toggleButton) {
          event.preventDefault();
          toggleSidebar();
        }

        if (closeButton || backdrop) {
          toggleSidebar(false);
        }
      });

      window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
          setSidebarState(true);
        } else {
          setSidebarState(false);
        }
      });

      document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth >= 1024) {
          setSidebarState(true);
        }
      });
    })();
  </script>
<?php endif; ?>

<button
  type="button"
  class="fixed left-4 top-4 z-40 inline-flex items-center gap-2 rounded-full bg-[#101828] px-4 py-2 text-sm font-semibold text-[#fdfbf7] shadow-lg transition hover:bg-[#101828]/90 lg:hidden"
  data-tombol-menu
  aria-expanded="false">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
    <path d="M4 6h16M4 12h16M4 18h16" />
  </svg>
  Menu
</button>

<div
  class="fixed inset-0 z-30 bg-black/40 opacity-0 transition-opacity pointer-events-none lg:hidden"
  data-latar-menu>
</div>

<aside
  class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full transform flex-col bg-[#101828] text-[#fdfbf7] transition-transform duration-300 lg:static lg:translate-x-0 lg:shadow-none"
  data-menu-samping
  aria-label="Navigasi utama">
  <div class="flex items-center justify-between border-b border-white/10 px-6 py-5">
    <h2 class="text-lg font-semibold"><?php echo htmlspecialchars($judulSidebar); ?></h2>
    <button
      type="button"
      class="rounded-full p-2 text-xl text-[#fdfbf7]/70 transition hover:bg-white/10 hover:text-[#fdfbf7] lg:hidden"
      data-tutup-menu
      aria-label="Tutup navigasi">
      &times;
    </button>
  </div>
  <nav class="flex-1 overflow-y-auto px-2 py-4">
    <ul class="space-y-1">
      <?php foreach ($menuNavigasi as $menu) :
        $teksMenu = $menu['label'] ?? 'Menu';
        $tautanMenu = $menu['href'] ?? '#';
        $aktif = !empty($menu['active']);
      ?>
        <li>
          <a
            href="<?php echo htmlspecialchars($tautanMenu); ?>"
            class="flex items-center rounded-xl px-4 py-3 text-sm font-medium transition hover:bg-white/10 <?php echo $aktif ? 'bg-white/15 text-white' : 'text-white/80'; ?>">
            <?php echo htmlspecialchars($teksMenu); ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <div class="border-t border-white/10 px-6 py-4 text-xs text-white/60 space-y-3">
    <a
      href="../service/AuthLogout.php"
      class="inline-flex w-full items-center justify-center rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">
      Logout
    </a>
    <p class="text-center text-xs text-white/60">&copy; <?php echo date('Y'); ?> Khrzmi Code</p>
  </div>
</aside>
