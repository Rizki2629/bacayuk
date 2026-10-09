<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex items-center justify-between gap-4">
  <div>
    <h1 class="font-display font-extrabold text-3xl">Peringkat Kelas</h1>
    <p class="text-slate-500 font-semibold mt-1">Berdasarkan jurnal yang sudah terverifikasi.</p>
  </div>
  <img src="<?= base_url('assets/ilustrasi/winners.svg')?>" alt="" class="h-24 hidden md:block shrink-0">
</div>

<div class="card bg-white rounded-xl shadow-kartu mt-5">
  <div class="card-body p-4 sm:p-6">
    <?php if ($board === []):?>
      <p class="text-slate-500 font-semibold text-center py-6">Belum ada data peringkat.</p>
    <?php else:?>
      <div class="space-y-2">
      <?php foreach ($board as $i => $b):
          $saya = (int) $b['id'] === (int) session()->get('user_id');
          $medali = [0 => '', 1 => '', 2 => ''][$i]?? ('#'. ($i + 1));
?>
        <div class="flex items-center gap-3 rounded-xl px-3 py-2 <?= $saya? 'bg-bacayuk-soft ring-2 ring-bacayuk': 'bg-krem'?>">
          <span class="w-10 text-center font-display font-extrabold text-xl"><?= $medali?></span>
          <span class="text-3xl"><?= esc($b['avatar']?: '')?></span>
          <div class="flex-1 min-w-0">
            <p class="font-display font-bold truncate"><?= esc($b['nama'])?><?= $saya? ' <span class="badge badge-sm bg-bacayuk text-white border-0">kamu</span>': ''?></p>
            <p class="text-xs font-bold text-slate-500"><?= (int) $b['total_jurnal']?> jurnal • <?= (int) $b['total_buku']?> buku • <?= (int) $b['total_menit']?> menit</p>
          </div>
          <p class="font-display font-extrabold text-bacayuk"><?= number_format((int) $b['total_halaman'])?> <span class="text-xs text-slate-500">hal</span></p>
        </div>
      <?php endforeach;?>
      </div>
    <?php endif;?>
  </div>
</div>
<?= $this->endSection()?>
