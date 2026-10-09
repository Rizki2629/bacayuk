<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<?php
$namaUser  = (string) ($user['nama'] ?? session()->get('nama'));
$username  = (string) ($user['username'] ?? '');
$kodeKartu = '*2026' . str_pad((string) ($user['id'] ?? 0), 4, '0', STR_PAD_LEFT) . '*';
$menuSaya  = [
    ['siswa/jurnal', '#6956E8', 'bg-lilac', '<path d="M2 4h6a4 4 0 0 1 4 4v12a3 3 0 0 0-3-3H2z"/><path d="M22 4h-6a4 4 0 0 0-4 4v12a3 3 0 0 1 3-3h7z"/>', 'Jurnal Saya'],
    ['siswa/jurnal/baru', '#2A816F', 'bg-mint', '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>', 'Tulis Jurnal'],
    ['siswa/buku', '#A36C17', 'bg-[#FFF4D6]', '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>', 'Katalog Buku'],
    ['siswa/lencana', '#B07E10', 'bg-[#FFF1D7]', '<circle cx="12" cy="8" r="6"/><path d="M15.5 13 17 22l-5-3-5 3 1.5-9"/>', 'Lencana Saya'],
    ['siswa/peringkat', '#5B79D5', 'bg-[#EEF3FF]', '<path d="M8 21h8m-4-4v4M7 4h10v5a5 5 0 0 1-10 0z"/><path d="M7 6H4a2 2 0 0 0 0 4h3m10-4h3a2 2 0 0 1 0 4h-3"/>', 'Peringkat'],
    ['logout', '#A23C56', 'bg-[#FFE7EC]', '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5m5 5H9"/>', 'Keluar'],
];
?>
<div class="max-w-xl mx-auto">
  <div class="relative overflow-hidden rounded-[26px] bg-gradient-to-br from-[#3E348F] to-primary text-white p-6 shadow-float">
    <div class="absolute -right-10 -top-14 w-44 h-44 rounded-full bg-gold/25"></div>
    <div class="relative z-10">
      <div class="flex items-start justify-between gap-3">
        <div>
          <p class="text-[10px] font-bold tracking-[.16em] text-white/70">KARTU PEMBACA VIRTUAL</p>
          <h1 class="font-display font-extrabold text-[22px] mt-1.5"><?= esc($namaUser)?></h1>
          <p class="text-white/75 text-sm"><?= esc($username)?>@bacayuk.sch.id</p>
        </div>
        <div class="flex flex-col items-end gap-2 flex-none">
          <img src="<?= base_url('assets/3d/maskot.jpg')?>" alt="" class="h-16 w-16 object-cover rounded-2xl drop-shadow-lg">
          <span class="bg-gold text-[#5C4300] text-[11px] font-extrabold px-3 py-1.5 rounded-full">SISWA AKTIF</span>
        </div>
      </div>
      <span class="inline-block mt-3 bg-white/95 text-[#453A8F] text-[11px] font-extrabold px-3 py-1.5 rounded-full">Kelas <?= esc($kelas)?> ›</span>
      <div class="bg-white rounded-2xl mt-4 px-4 pt-3.5 pb-2.5 text-center">
        <div class="h-11 rounded" style="background: repeating-linear-gradient(90deg, #29253D 0 2px, transparent 2px 5px, #29253D 5px 8px, transparent 8px 10px, #29253D 10px 11px, transparent 11px 15px, #29253D 15px 18px, transparent 18px 20px)"></div>
        <p class="text-ink font-bold tracking-[.3em] text-sm mt-2"><?= esc($kodeKartu)?></p>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-4 gap-2.5 mt-4">
    <?php foreach ([[$stats['total_jurnal'], 'Jurnal'], [$stats['total_menit'], 'Menit Baca'], [count($lencana), 'Lencana'], [$stats['streak'], 'Hari Streak']] as [$n, $lb]): ?>
    <div class="bg-white rounded-2xl border border-[#F2EEF8] shadow-soft py-3.5 text-center"><p class="font-display font-extrabold text-lg"><?= number_format((int) $n)?></p><p class="text-[10px] font-bold text-muted mt-0.5"><?= $lb?></p></div>
    <?php endforeach; ?>
  </div>

  <h2 class="font-display font-bold text-[17px] mt-7 mb-4">Menu Saya</h2>
  <div class="grid grid-cols-3 gap-y-6 gap-x-3 bg-white border border-[#F2EEF8] rounded-[24px] shadow-soft p-5">
    <?php foreach ($menuSaya as [$url, $warna, $bg, $path, $label]): ?>
    <a href="<?= base_url($url)?>" class="text-center group">
      <span class="w-[52px] h-[52px] mx-auto rounded-full <?= $bg?> grid place-items-center group-hover:scale-105 transition"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="<?= $warna?>" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><?= $path?></svg></span>
      <span class="block text-xs font-bold text-[#4A4560] mt-2"><?= $label?></span>
    </a>
    <?php endforeach; ?>
  </div>

  <?php if ($lencana !== []): ?>
  <h2 class="font-display font-bold text-[17px] mt-7 mb-4">Lencana Terbaruku</h2>
  <div class="flex gap-4 overflow-x-auto pb-1">
    <?php foreach (array_slice($lencana, -6) as $l): ?>
    <div class="flex-none text-center"><span class="w-14 h-14 rounded-2xl bg-[#FFF2CF] border border-[#FFE29A] grid place-items-center text-[26px]"><?= esc($l['ikon'])?></span><p class="text-[10px] font-bold text-muted mt-1.5 w-16 leading-tight line-clamp-2"><?= esc($l['nama'])?></p></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<?= $this->endSection()?>
