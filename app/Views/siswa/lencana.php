<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="relative overflow-hidden rounded-[26px] shadow-float">
  <img src="<?= base_url('assets/3d/perayaan.jpg')?>" alt="" class="absolute inset-0 w-full h-full object-cover object-[50%_22%]">
  <div class="absolute inset-0 bg-gradient-to-r from-[rgba(28,18,80,0.88)] via-[rgba(61,42,180,0.55)] to-transparent"></div>
  <div class="relative z-10 p-6 sm:p-7 min-h-[132px] flex flex-col justify-center">
    <h1 class="plakat font-kartun font-bold self-start text-[26px] sm:text-[30px] leading-none px-6 py-3">Lencana Saya</h1>
    <p class="text-white/85 font-semibold mt-2.5">Terus membaca untuk membuka semua lencana.</p>
  </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-5">
<?php foreach ($semua as $l):
    $diraih = in_array($l['id'], $punya, false);
    $nilai = (int) ($stats[$l['syarat_tipe']]?? 0);
    $target = (int) $l['syarat_nilai'];
    $persen = min(100, $target > 0? intdiv($nilai * 100, $target): 0);
?>
  <div class="card rounded-[22px] shadow-kartu <?= $diraih? 'bg-white border-2 border-[#F5B942]/70': 'bg-white/60'?>">
    <div class="card-body items-center text-center p-5">
      <span class="w-20 h-20 rounded-full grid place-items-center text-5xl <?= $diraih? 'bg-[#FFF2CF] border-4 border-[#F5B942] shadow-[0_10px_24px_rgba(245,185,66,0.35)] scale-110': 'bg-slate-100 grayscale opacity-60'?>"><?= esc($l['ikon'])?></span>
      <h3 class="font-display font-bold text-[15px]"><?= esc($l['nama'])?></h3>
      <p class="text-sm text-muted font-semibold"><?= esc($l['deskripsi'])?></p>
      <?php if ($diraih):?>
        <span class="badge bg-mint text-[#2A816F] border-0 font-bold rounded-full px-3">Sudah diraih</span>
      <?php else:?>
        <progress class="progress progress-warning w-full" value="<?= $persen?>" max="100"></progress>
        <p class="text-xs font-bold text-muted"><?= $nilai?> / <?= $target?></p>
      <?php endif;?>
    </div>
  </div>
<?php endforeach;?>
</div>
<?= $this->endSection()?>
