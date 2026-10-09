<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex items-center justify-between gap-4">
  <div>
    <h1 class="font-display font-extrabold text-3xl">Katalog Buku</h1>
    <p class="text-slate-500 font-semibold mt-1">Pilih buku yang ingin kamu baca.</p>
  </div>
  <img src="<?= base_url('assets/ilustrasi/book-reading.svg')?>" alt="" class="h-24 hidden md:block shrink-0 bg-[#E8EFFD] rounded-xl p-2">
</div>

<div class="flex flex-wrap gap-2 mt-4">
  <a href="<?= base_url('siswa/buku')?>" class="btn btn-sm rounded-full font-display border-0 <?=! $genre? 'bg-bacayuk text-white': 'bg-white'?>">Semua</a>
  <?php foreach (\App\Models\BukuModel::GENRE as $g):?>
    <a href="<?= base_url('siswa/buku?genre='. urlencode($g))?>" class="btn btn-sm rounded-full font-display border-0 <?= $genre === $g? 'bg-bacayuk text-white': 'bg-white'?>"><?= esc($g)?></a>
  <?php endforeach;?>
</div>

<?php if ($buku === []):?>
  <div class="card bg-white rounded-xl shadow-kartu mt-5"><div class="card-body items-center py-10">
    <img src="<?= base_url('assets/ilustrasi/no-data.svg')?>" alt="" class="h-24 mx-auto"><p class="font-display font-bold text-lg mt-2">Belum ada buku di genre ini.</p>
  </div></div>
<?php else:?>
  <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-5">
  <?php foreach ($buku as $b):?>
    <div class="card bg-white rounded-xl shadow-kartu overflow-hidden">
      <div class="h-36 grid place-items-center text-6xl" style="background: <?= esc($b['warna_sampul'])?>22">
        <span class="w-20 h-24 rounded-r-xl rounded-l-sm grid place-items-center text-4xl shadow" style="background: <?= esc($b['warna_sampul'])?>"><?= esc($b['ikon']?: '')?></span>
      </div>
      <div class="card-body p-4">
        <span class="badge badge-sm bg-bacayuk-soft text-bacayuk border-0 font-bold"><?= esc($b['genre'])?></span>
        <h3 class="font-display font-bold leading-snug"><?= esc($b['judul'])?></h3>
        <p class="text-sm text-slate-500 font-semibold"> <?= esc($b['penulis'])?> • <?= (int) $b['jumlah_halaman']?> halaman</p>
        <a href="<?= base_url('siswa/jurnal/baru')?>" class="btn btn-sm bg-mustard hover:bg-[#D97706] text-ink border-0 rounded-xl font-display mt-1">Mulai Membaca </a>
      </div>
    </div>
  <?php endforeach;?>
  </div>
<?php endif;?>
<?= $this->endSection()?>
