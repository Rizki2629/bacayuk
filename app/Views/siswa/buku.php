<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="plakat flex items-center justify-between gap-4">
  <div>
    <h1 class="font-kartun font-bold text-[28px] sm:text-[32px] leading-[1.15]">Katalog Buku</h1>
    <p class="text-muted font-semibold mt-1">Pilih buku yang ingin kamu baca.</p>
  </div>
  <img src="<?= base_url('assets/3d/misi.jpg')?>" alt="" class="h-24 hidden md:block shrink-0 bg-[#F1EEFF] rounded-xl p-2">
</div>

<form method="get" action="<?= base_url('siswa/buku')?>" class="mt-5 flex gap-2 max-w-md">
  <input type="text" name="q" value="<?= esc($q ?? '')?>" placeholder="Cari judul buku..." class="input flex-1 h-11 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF] focus:outline-none focus:border-[#B7A8FF]">
  <button type="submit" class="btn h-11 min-h-0 bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl font-display px-5">Cari</button>
</form>

<div class="flex flex-wrap gap-2 mt-4">
  <a href="<?= base_url('siswa/buku')?>" class="btn btn-sm rounded-full font-display border-0 <?=! $genre? 'bg-bacayuk text-white shadow-md shadow-primary/20': 'bg-white border border-[#EDEAF6]'?>">Semua</a>
  <?php foreach (\App\Models\BukuModel::GENRE as $g):?>
    <a href="<?= base_url('siswa/buku?genre='. urlencode($g))?>" class="btn btn-sm rounded-full font-display border-0 <?= $genre === $g? 'bg-bacayuk text-white': 'bg-white'?>"><?= esc($g)?></a>
  <?php endforeach;?>
</div>

<?php if ($buku === []):?>
  <div class="card bg-white rounded-[22px] shadow-kartu mt-5"><div class="card-body items-center py-10">
    <img src="<?= base_url('assets/3d/kosong.jpg')?>" alt="" class="h-24 mx-auto"><p class="font-display font-bold text-lg mt-2">Belum ada buku di genre ini.</p>
  </div></div>
<?php else:?>
  <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-5">
  <?php foreach ($buku as $b):?>
    <div class="card bg-white rounded-[22px] shadow-kartu overflow-hidden transition duration-200 hover:-translate-y-1">
      <div class="h-36 grid place-items-center text-6xl" style="background: <?= esc($b['warna_sampul'])?>22">
        <span class="w-20 h-24 rounded-r-xl rounded-l-sm grid place-items-center text-4xl shadow" style="background: <?= esc($b['warna_sampul'])?>"><?= esc($b['ikon']?: '')?></span>
      </div>
      <div class="card-body p-4">
        <span class="badge badge-sm bg-bacayuk-soft text-bacayuk border-0 font-bold"><?= esc($b['genre'])?></span>
        <h3 class="font-display font-bold text-[15px] leading-snug"><?= esc($b['judul'])?></h3>
        <p class="text-sm text-muted font-semibold"> <?= esc($b['penulis'])?> • <?= (int) $b['jumlah_halaman']?> halaman</p>
        <?php if (! empty($b['tautan_pdf'])):?><a href="<?= esc($b['tautan_pdf'])?>" target="_blank" rel="noopener" class="btn btn-sm bg-primary hover:bg-primary-dark text-white border-0 rounded-xl font-display mt-1"><?= str_contains($b['tautan_pdf'], 'letsreadasia') ? 'Baca Online' : 'Baca PDF'?></a><?php endif;?>
        <a href="<?= base_url('siswa/jurnal/baru')?>" class="btn btn-sm bg-mustard hover:brightness-95 text-ink border-0 rounded-xl font-display mt-1">Mulai Membaca </a>
      </div>
    </div>
  <?php endforeach;?>
  </div>
<?php endif;?>
<?= $this->endSection()?>
