<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<h1 class="font-display font-extrabold text-3xl"> Definisi Lencana</h1>
<p class="text-slate-500 font-semibold mt-1">Lencana diberikan otomatis saat syarat statistik siswa terpenuhi (dari jurnal terverifikasi).</p>

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-5">
<?php
$labelSyarat = ['total_jurnal' => 'jurnal', 'total_buku' => 'buku', 'total_halaman' => 'halaman', 'total_menit' => 'menit', 'streak' => 'hari streak'];
foreach ($lencana as $l):?>
  <div class="card bg-white rounded-xl shadow-kartu"><div class="card-body items-center text-center p-5">
    <span class="w-16 h-16 rounded-full bg-mustard/30 border-2 border-mustard grid place-items-center text-4xl"><?= esc($l['ikon'])?></span>
    <h3 class="font-display font-bold"><?= esc($l['nama'])?></h3>
    <p class="text-sm text-slate-500 font-semibold"><?= esc($l['deskripsi'])?></p>
    <span class="badge bg-bacayuk-soft text-bacayuk border-0 font-bold">syarat: <?= (int) $l['syarat_nilai']?> <?= esc($labelSyarat[$l['syarat_tipe']]?? $l['syarat_tipe'])?></span>
  </div></div>
<?php endforeach;?>
</div>
<?= $this->endSection()?>
