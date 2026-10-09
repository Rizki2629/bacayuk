<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($judul?? 'Dashboard')?> — BacaYuk</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        bacayuk: { DEFAULT: '#2563EB', dark: '#1D4ED8', soft: '#E8EFFD' },
        navy: '#173A5E',
        mustard: '#D97706',
        krem: '#F5F7FA',
        ink: '#1F2A37',
        pinky: '#C2516B',
        minty: '#2F8F83',
        skyy: '#5B84AE',
      },
      fontFamily: {
        display: ['"Plus Jakarta Sans"', 'sans-serif'],
        body: ['"Plus Jakarta Sans"', 'sans-serif'],
      },
      boxShadow: {
        kartu: '0 1px 3px rgba(16,24,40,.08), 0 1px 2px rgba(16,24,40,.04)',
      },
    }
  }
}
</script>
<style>
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F7FA; color: #1F2A37; }
.font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
.menu a.active { background: rgba(255,255,255,.16); color: #fff; }
</style>
</head>
<body>
<?php
$role = session()->get('role');
$ic = [
  'home' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9.5 21v-6h5v6"/></svg>',
  'users' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><circle cx="17" cy="9" r="2.6"/><path d="M16.5 15.2c2.3.3 3.6 1.9 4 4.3"/></svg>',
  'kelas' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V8.5L12 4l7 4.5V21"/><path d="M9.5 21v-4.5h5V21"/><path d="M12 8v2"/></svg>',
  'buku' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2 8-2V4c-4 0-6.2.4-8 2Z"/><path d="M12 6v14"/></svg>',
  'jurnal'=> '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h13v18H6.5A2.5 2.5 0 0 1 4 18.5v-13A2.5 2.5 0 0 1 6 3Z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H19"/><path d="M8.5 8h7M8.5 11.5h5"/></svg>',
  'award' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5.5"/><path d="m8.8 13.5-1.6 7 4.8-2.6 4.8 2.6-1.6-7"/></svg>',
  'check' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="m8.5 12.2 2.4 2.4 4.6-5"/></svg>',
  'chart' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V4"/><path d="M4 20h16"/><path d="M8 16v-5M12 16V8M16 16v-8"/></svg>',
  'out' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7"/><path d="M10 12h10"/><path d="m17 8 4 4-4 4"/></svg>',
];
$menu = match ($role) {
    'admin' => [
        ['/admin', 'home', 'Dashboard'],
        ['/admin/users', 'users', 'Kelola User'],
        ['/admin/kelas', 'kelas', 'Kelola Kelas'],
        ['/buku', 'buku', 'Katalog Buku'],
        ['/admin/jurnal', 'jurnal', 'Semua Jurnal'],
        ['/admin/lencana', 'award', 'Lencana'],
    ],
    'guru' => [
        ['/guru', 'home', 'Dashboard'],
        ['/guru/verifikasi', 'check', 'Verifikasi Jurnal'],
        ['/guru/jurnal', 'jurnal', 'Semua Jurnal'],
        ['/guru/siswa', 'users', 'Siswa Kelas'],
        ['/buku', 'buku', 'Katalog Buku'],
        ['/guru/peringkat', 'chart', 'Peringkat Kelas'],
    ],
    default => [
        ['/siswa', 'home', 'Dashboard'],
        ['/siswa/jurnal', 'jurnal', 'Jurnal Saya'],
        ['/siswa/buku', 'buku', 'Katalog Buku'],
        ['/siswa/lencana', 'award', 'Lencana Saya'],
        ['/siswa/peringkat', 'chart', 'Peringkat Kelas'],
    ],
};
$uriNow = '/'. trim(uri_string(), '/');
$namaUser = (string) (session()->get('nama')?? '');
$inisial = strtoupper(mb_substr($namaUser!== ''? $namaUser: 'P', 0, 1));
?>
<div class="drawer lg:drawer-open">
  <input id="drawer-bacayuk" type="checkbox" class="drawer-toggle">
  <div class="drawer-content flex flex-col min-h-screen">
    <!-- Navbar atas (mobile) -->
    <div class="navbar bg-white sticky top-0 z-30 shadow-sm lg:hidden">
      <label for="drawer-bacayuk" class="btn btn-ghost btn-circle">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
      </label>
      <span class="font-display font-bold text-lg text-navy">BacaYuk</span>
    </div>

    <main class="flex-1 w-full max-w-6xl mx-auto px-4 sm:px-6 py-6">
      <?php if (session()->getFlashdata('success')):?>
        <div class="alert alert-success shadow-sm mb-5 rounded-xl font-medium"><span><?= esc(session()->getFlashdata('success'))?></span></div>
      <?php endif;?>
      <?php if (session()->getFlashdata('error')):?>
        <div class="alert alert-error shadow-sm mb-5 rounded-xl font-medium"><span><?= esc(session()->getFlashdata('error'))?></span></div>
      <?php endif;?>
      <?php if (session()->getFlashdata('errors')):?>
        <div class="alert alert-warning shadow-sm mb-5 rounded-xl">
          <ul class="list-disc ml-5 font-medium">
            <?php foreach ((array) session()->getFlashdata('errors') as $e):?><li><?= esc($e)?></li><?php endforeach;?>
          </ul>
        </div>
      <?php endif;?>

      <?= $this->renderSection('content')?>

      <footer class="text-center text-xs text-slate-400 mt-10 mb-2">BacaYuk — Jurnal Membaca Anak</footer>
    </main>
  </div>

  <!-- Sidebar -->
  <div class="drawer-side z-40">
    <label for="drawer-bacayuk" class="drawer-overlay"></label>
    <aside class="w-72 min-h-full bg-navy text-white flex flex-col">
      <div class="px-5 pt-6 pb-4">
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-lg bg-white grid place-items-center text-bacayuk shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2 8-2V4c-4 0-6.2.4-8 2Z"/><path d="M12 6v14"/></svg>
          </div>
          <div>
            <p class="font-display font-extrabold text-xl leading-tight">BacaYuk</p>
            <p class="text-white/60 text-xs">Jurnal Membaca Anak</p>
          </div>
        </div>
        <div class="mt-5 bg-white/10 rounded-xl p-3 flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-bacayuk grid place-items-center font-display font-bold text-base shrink-0"><?= esc($inisial)?></div>
          <div class="min-w-0">
            <p class="font-semibold truncate text-sm"><?= esc($namaUser)?></p>
            <span class="text-white/60 text-xs capitalize"><?= esc($role?? '')?></span>
          </div>
        </div>
      </div>
      <ul class="menu gap-1 px-3 flex-1 text-white [&_a]:text-white/85 [&_a:hover]:bg-white/10 [&_a:hover]:text-white">
        <?php foreach ($menu as [$url, $ikon, $label]):?>
          <li><a href="<?= base_url(ltrim($url, '/'))?>" class="<?= $uriNow === $url? 'active': ''?> rounded-lg font-medium gap-3"><span class="shrink-0 opacity-90"><?= $ic[$ikon]?></span><?= $label?></a></li>
        <?php endforeach;?>
      </ul>
      <div class="p-4">
        <a href="<?= base_url('logout')?>" class="btn btn-block bg-white/10 hover:bg-white/20 text-white border-0 rounded-lg font-semibold justify-start gap-3 normal-case"><span><?= $ic['out']?></span>Keluar</a>
      </div>
    </aside>
  </div>
</div>
<?= $this->renderSection('scripts')?>
</body>
</html>
