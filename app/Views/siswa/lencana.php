<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex items-center justify-between gap-4">
  <div>
    <h1 class="font-display font-extrabold text-3xl">Lencana Saya</h1>
    <p class="text-muted font-semibold mt-1">Terus membaca untuk membuka semua lencana.</p>
  </div>
  <img src="<?= base_url('assets/ilustrasi/winners.svg')?>" alt="" class="h-24 hidden md:block shrink-0">
</div>

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-5">
<?php foreach ($semua as $l):
    $diraih = in_array($l['id'], $punya, false);
    $nilai = (int) ($stats[$l['syarat_tipe']]?? 0);
    $target = (int) $l['syarat_nilai'];
    $persen = min(100, $target > 0? intdiv($nilai * 100, $target): 0);
?>
  <div class="card rounded-[22px] shadow-kartu <?= $diraih? 'bg-white': 'bg-white/60'?>">
    <div class="card-body items-center text-center p-5">
      <span class="w-20 h-20 rounded-full grid place-items-center text-5xl <?= $diraih? 'bg-[#FFF2CF] border-2 border-[#FFE29A]': 'bg-slate-100 grayscale opacity-60'?>"><?= esc($l['ikon'])?></span>
      <h3 class="font-display font-bold"><?= esc($l['nama'])?></h3>
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
