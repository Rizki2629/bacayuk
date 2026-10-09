<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($judul ?? 'Dashboard') ?> — BacaYuk</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
<link href="<?= base_url('assets/css/daisyui.min.css') ?>" rel="stylesheet" type="text/css">
<script src="<?= base_url('assets/js/tailwind-play.js') ?>"></script>
<script src="<?= base_url('assets/js/chart.umd.min.js') ?>"></script>
<script>
tailwind.config = { theme: { extend: {
  colors: { primary:'#6956E8', 'primary-dark':'#5542D0', cream:'#FFF9F0', ink:'#29253D', muted:'#817D92', lilac:'#F1EEFF', peach:'#FFF0E8', mint:'#E7F7F2', gold:'#F5B942', bacayuk:'#6956E8', 'bacayuk-dark':'#5542D0', 'bacayuk-soft':'#F1EEFF', navy:'#29253D', krem:'#FFF9F0', skyy:'#5B84AE', minty:'#2E927D', pinky:'#D75C83', mustard:'#F5B942' },
  fontFamily: { display:['"Plus Jakarta Sans"','sans-serif'], body:['"DM Sans"','sans-serif'] },
  boxShadow: { soft:'0 10px 35px rgba(57,45,112,.07)', float:'0 20px 50px rgba(74,61,158,.15)' }
} } };
</script>
<style>
:root{--primary:#6956E8;--ink:#29253D;--cream:#FFF9F0}
*{box-sizing:border-box} body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink)}
.font-display{font-family:'Plus Jakarta Sans',sans-serif}.nav-link{color:#77728A;transition:.2s}.nav-link:hover{background:#F1EEFF;color:var(--primary)}.nav-link.active{background:var(--primary);color:white;box-shadow:0 8px 18px rgba(105,86,232,.2)}
.fade-in{animation:fadeIn .45s ease both}
.shadow-kartu{box-shadow:0 10px 35px rgba(57,45,112,.07)}
.font-kartun{font-family:'Baloo 2',ui-rounded,system-ui;letter-spacing:.01em}
.plakat{background:#FFF6E3;border:2px solid #F0DDB8;border-radius:20px;box-shadow:0 10px 24px rgba(41,37,61,.10)}
.bingkai-adegan{position:relative;overflow:hidden}
.card{border:1px solid #F2EEF8}
::selection{background:#6956E8;color:#fff}
::-webkit-scrollbar{width:10px;height:10px}::-webkit-scrollbar-thumb{background:#D9D2FF;border-radius:99px;border:2px solid #FFF9F0}::-webkit-scrollbar-track{background:transparent}
.table thead th{font-size:.68rem;letter-spacing:.08em;text-transform:uppercase;color:#A7A2B5;border-bottom:1px solid #F0EBF7;background:#fff}
.table tbody tr{border-bottom:1px solid #F6F3FA;transition:background .15s}
.table tbody tr:hover{background:#FCFAFF}
.input:focus,.select:focus,.textarea:focus{outline:2px solid #D9D2FF;outline-offset:1px;border-color:#B9AEF5}@keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
</style>
</head>
<body>
<?php
$role=session()->get('role');
$ic=[
'home'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 10.5 9-7.5 9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9.5 21v-6h5v6"/></svg>',
'users'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><circle cx="17" cy="9" r="2.6"/><path d="M16.5 15.2c2.3.3 3.6 1.9 4 4.3"/></svg>',
'kelas'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V8.5L12 4l7 4.5V21M9.5 21v-4.5h5V21M12 8v2"/></svg>',
'buku'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2 8-2V4c-4 0-6.2 4-8 2Z"/><path d="M12 6v14"/></svg>',
'jurnal'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h13v18H6.5A2.5 2.5 0 0 1 4 18.5v-13A2.5 2.5 0 0 1 6 3Z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H19M8.5 8h7M8.5 11.5h5"/></svg>',
'award'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5.5"/><path d="m8.8 13.5-1.6 7 4.8-2.6 4.8 2.6-1.6-7"/></svg>',
'chart'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V4M4 20h16M8 16v-5M12 16V8M16 16v-8"/></svg>',
'out'=>'<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7M10 12h10m-3-4 4 4-4 4"/></svg>'];
$menu=match($role){
'admin'=>[['/admin','home','Dashboard'],['/admin/users','users','Kelola User'],['/admin/kelas','kelas','Kelola Kelas'],['/buku','buku','Katalog Buku'],['/admin/jurnal','jurnal','Semua Jurnal'],['/admin/lencana','award','Lencana']],
'guru'=>[['/guru','home','Dashboard'],['/guru/verifikasi','jurnal','Verifikasi Jurnal'],['/guru/jurnal','jurnal','Semua Jurnal'],['/guru/siswa','users','Siswa Kelas'],['/buku','buku','Katalog Buku'],['/guru/peringkat','chart','Peringkat Kelas']],
default=>[['/siswa','home','Dashboard'],['/siswa/jurnal','jurnal','Jurnal Saya'],['/siswa/buku','buku','Katalog Buku'],['/siswa/lencana','award','Lencana Saya'],['/siswa/peringkat','chart','Peringkat Kelas']]};
$uriNow='/'.trim(uri_string(),'/');$namaUser=(string)(session()->get('nama')??'');$inisial=strtoupper(mb_substr($namaUser!==''?$namaUser:'P',0,1));
?>
<div class="drawer lg:drawer-open"><input id="drawer-bacayuk" type="checkbox" class="drawer-toggle"><div class="drawer-content min-h-screen">
<header class="h-[74px] bg-white/80 backdrop-blur border-b border-[#EEEAF6] flex items-center justify-between px-5 sm:px-8 sticky top-0 z-30">
<label for="drawer-bacayuk" class="btn btn-ghost btn-circle lg:hidden"><span class="text-xl">☰</span></label>
<div class="hidden lg:block"><p class="text-xs text-muted font-semibold uppercase tracking-[.14em]">Ruang belajar</p><p class="font-kartun font-bold text-[20px]"><?= esc($judul??'Dashboard')?></p></div>
<div class="flex items-center gap-3"><div class="hidden sm:block text-right"><p class="font-display font-bold text-sm"><?= esc($namaUser)?></p><p class="text-xs text-muted capitalize"><?= esc($role??'siswa')?></p></div><div class="w-10 h-10 rounded-2xl bg-primary text-white grid place-items-center font-display font-bold shadow-sm"><?= esc($inisial)?></div></div>
</header>
<main class="w-full max-w-[1380px] mx-auto px-5 sm:px-8 py-7 fade-in<?= session()->get('role') ? ' pb-28 lg:pb-10' : '' ?>">
<?php if(session()->getFlashdata('success')):?><div class="alert bg-mint border-0 text-[#247A68] shadow-sm mb-5 rounded-2xl font-semibold"><span>✓</span><span><?= esc(session()->getFlashdata('success'))?></span></div><?php endif;?>
<?php if(session()->getFlashdata('error')):?><div class="alert bg-[#FFE7EC] border-0 text-[#A23C56] shadow-sm mb-5 rounded-2xl font-semibold"><span>!</span><span><?= esc(session()->getFlashdata('error'))?></span></div><?php endif;?>
<?php if(session()->getFlashdata('errors')):?><div class="alert bg-[#FFF1D7] border-0 text-[#9A681B] shadow-sm mb-5 rounded-2xl"><ul class="list-disc ml-5 font-semibold"><?php foreach((array)session()->getFlashdata('errors') as $e):?><li><?= esc($e)?></li><?php endforeach;?></ul></div><?php endif;?>
<?= $this->renderSection('content')?><footer class="text-center text-xs text-[#AAA5B8] mt-12 mb-2">BacaYuk · Tumbuhkan kebiasaan membaca setiap hari</footer>
</main>
<?php $peranNav = (string) session()->get('role'); $navIkon = [
'beranda' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 10 9-7 9 7v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>',
'periksa' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="m8.5 12.2 2.4 2.4 4.6-5"/></svg>',
'jurnal' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h13v18H6.5A2.5 2.5 0 0 1 4 18.5v-13A2.5 2.5 0 0 1 6 3Z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H19M8.5 8h7M8.5 11.5h5"/></svg>',
'users' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><circle cx="17" cy="9" r="2.6"/><path d="M16.5 15.2c2.3.3 3.6 1.9 4 4.3"/></svg>',
'kelas' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V8.5L12 4l7 4.5V21M9.5 21v-4.5h5V21M12 8v2"/></svg>',
'buku' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>',
'chart' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V4M4 20h16M8 16v-5M12 16V8M16 16v-8"/></svg>',
'award' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.5 13 17 22l-5-3-5 3 1.5-9"/></svg>',
'profil' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6 8-6s8 2 8 6"/></svg>'];
$navSet = [
'siswa' => [['/siswa', 'beranda', 'Beranda'], ['/siswa/buku', 'buku', 'Katalog'], 'FAB', ['/siswa/lencana', 'award', 'Lencana'], ['/siswa/profil', 'profil', 'Profil']],
'guru' => [['/guru', 'beranda', 'Beranda'], ['/guru/verifikasi', 'periksa', 'Verifikasi'], ['/guru/jurnal', 'jurnal', 'Jurnal'], ['/guru/siswa', 'users', 'Siswa'], ['/guru/peringkat', 'chart', 'Peringkat']],
'admin' => [['/admin', 'beranda', 'Beranda'], ['/admin/users', 'users', 'Pengguna'], ['/admin/kelas', 'kelas', 'Kelas'], ['/buku', 'buku', 'Buku'], ['/admin/jurnal', 'jurnal', 'Jurnal']]];
if (isset($navSet[$peranNav])): ?>
<nav class="fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur border-t border-[#EEEAF6] lg:hidden" style="padding-bottom: env(safe-area-inset-bottom)">
<div class="flex items-end px-2 pt-2 pb-2">
<?php foreach ($navSet[$peranNav] as $item): if ($item === 'FAB'): ?>
<a href="<?= base_url('siswa/jurnal/baru')?>" class="flex-none w-[52px] h-[52px] -mt-7 rounded-full bg-primary text-white grid place-items-center shadow-lg shadow-primary/40 border-4 border-[#FBFAFF]" aria-label="Tulis jurnal baru"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg></a>
<?php else: [$uNav, $iNav, $lNav] = $item; $navOn = $uriNow === $uNav || (! in_array($uNav, ['/siswa', '/guru', '/admin'], true) && str_starts_with($uriNow, $uNav . '/')); ?>
<a href="<?= base_url(ltrim($uNav, '/'))?>" class="flex-1 flex flex-col items-center gap-0.5 text-[10px] font-bold <?= $navOn ? 'text-primary' : 'text-[#A79FC0]'?>"><?= $navIkon[$iNav]?><?= $lNav?></a>
<?php endif; endforeach; ?>
</div></nav>
<?php endif; ?>
</div>
<div class="drawer-side z-40"><label for="drawer-bacayuk" class="drawer-overlay"></label><aside class="w-[270px] min-h-full bg-white border-r border-[#EEEAF6] flex flex-col">
<div class="px-6 pt-7 pb-6"><div class="flex items-center gap-3"><div class="w-11 h-11 rounded-2xl bg-primary text-white grid place-items-center shadow-lg shadow-primary/20"><svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2-8-2V4c4 0 6.2 4 8 2Z"/><path d="M12 6v14"/></svg></div><div><p class="font-display font-extrabold text-xl tracking-tight">Baca<span class="text-primary">Yuk</span></p><p class="text-muted text-[11px] font-semibold">Jurnal membaca anak</p></div></div></div>
<div class="px-4 mb-3"><p class="px-3 text-[10px] uppercase tracking-[.16em] font-bold text-[#B0AABD]">Menu utama</p></div><ul class="px-4 space-y-1 flex-1"><?php foreach($menu as [$url,$ikon,$label]):?><li><a href="<?= base_url(ltrim($url,'/'))?>" class="nav-link <?= $uriNow===$url?'active':''?> flex items-center gap-3 px-3 py-3 rounded-2xl font-semibold text-sm"><span class="shrink-0"><?= $ic[$ikon]?></span><?= $label?></a></li><?php endforeach;?></ul>
<div class="p-4"><div class="bg-lilac rounded-2xl p-4 mb-3"><p class="font-display font-bold text-sm text-primary">Terus bertumbuh!</p><p class="text-xs text-[#817D92] mt-1 leading-relaxed">Satu halaman hari ini, satu langkah lebih hebat.</p></div><a href="<?= base_url('logout')?>" class="flex items-center gap-3 px-3 py-3 rounded-2xl text-sm font-semibold text-[#817D92] hover:bg-[#FFF0F2] hover:text-[#B64E68]"><?= $ic['out']?> Keluar</a></div>
</aside></div></div><?= $this->renderSection('scripts')?></body></html>
