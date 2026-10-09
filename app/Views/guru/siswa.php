<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<h1 class="font-display font-extrabold text-3xl"> Siswa Kelas Saya</h1>
<p class="text-slate-500 font-semibold mt-1">Progres membaca tiap anak (hanya jurnal terverifikasi yang dihitung).</p>

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 mt-5">
<?php foreach ($daftar as $s):?>
  <div class="card bg-white rounded-xl shadow-kartu"><div class="card-body p-5">
    <div class="flex items-center gap-3">
      <span class="w-14 h-14 rounded-xl bg-bacayuk-soft grid place-items-center text-3xl"><?= esc($s['avatar'])?></span>
      <div>
        <p class="font-display font-bold"><?= esc($s['nama'])?></p>
        <p class="text-xs font-bold text-slate-500">@<?= esc($s['username'])?></p>
      </div>
    </div>
    <div class="grid grid-cols-4 gap-2 text-center mt-3 font-display">
      <div class="bg-krem rounded-xl py-2"><p class="font-extrabold"><?= (int) $s['stats']['total_jurnal']?></p><p class="text-[11px] font-body font-bold text-slate-500">jurnal</p></div>
      <div class="bg-krem rounded-xl py-2"><p class="font-extrabold"><?= (int) $s['stats']['total_buku']?></p><p class="text-[11px] font-body font-bold text-slate-500">buku</p></div>
      <div class="bg-krem rounded-xl py-2"><p class="font-extrabold"><?= (int) $s['stats']['total_halaman']?></p><p class="text-[11px] font-body font-bold text-slate-500">halaman</p></div>
      <div class="bg-krem rounded-xl py-2"><p class="font-extrabold"><?= (int) $s['stats']['streak']?></p><p class="text-[11px] font-body font-bold text-slate-500">streak</p></div>
    </div>
  </div></div>
<?php endforeach;?>
</div>
<?= $this->endSection()?>
