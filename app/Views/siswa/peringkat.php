<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="plakat flex items-center justify-between gap-4">
  <div>
    <h1 class="font-kartun font-bold text-[28px] sm:text-[32px] leading-[1.15]">Peringkat Kelas</h1>
    <p class="text-muted font-semibold mt-1">Berdasarkan jurnal yang sudah terverifikasi.</p>
  </div>
  <img src="<?= base_url('assets/3d/maskot.jpg')?>" alt="" class="h-16 w-16 object-cover rounded-2xl hidden md:block shrink-0">
</div>

<div class="card bg-white rounded-[22px] shadow-kartu mt-5">
  <div class="card-body p-4 sm:p-6">
    <?php if ($board === []):?>
      <p class="text-muted font-semibold text-center py-6">Belum ada data peringkat.</p>
    <?php else:?>
      <div class="space-y-2">
      <?php foreach ($board as $i => $b):
          $saya = (int) $b['id'] === (int) session()->get('user_id');
          $medali = [0 => '<span class="w-9 h-9 rounded-full bg-[#FFD36A] text-[#8A6410] grid place-items-center text-base mx-auto">1</span>', 1 => '<span class="w-9 h-9 rounded-full bg-[#E4E7EE] text-[#5B6472] grid place-items-center text-base mx-auto">2</span>', 2 => '<span class="w-9 h-9 rounded-full bg-[#F3C39A] text-[#8A5A1E] grid place-items-center text-base mx-auto">3</span>'][$i]?? ('#'. ($i + 1));
?>
        <div class="flex items-center gap-3 rounded-2xl px-3 py-2 <?= $saya? 'bg-bacayuk-soft ring-1 ring-primary/40': 'bg-[#FCFAFF]'?>">
          <span class="w-10 text-center font-display font-extrabold text-xl"><?= $medali?></span>
          <span class="text-3xl"><?= esc($b['avatar']?: '')?></span>
          <div class="flex-1 min-w-0">
            <p class="font-display font-bold truncate"><?= esc($b['nama'])?><?= $saya? ' <span class="badge badge-sm bg-bacayuk text-white border-0">kamu</span>': ''?></p>
            <p class="text-xs font-bold text-muted"><?= (int) $b['total_jurnal']?> jurnal • <?= (int) $b['total_buku']?> buku • <?= (int) $b['total_menit']?> menit</p>
          </div>
          <p class="font-display font-extrabold text-bacayuk"><?= number_format((int) $b['total_halaman'])?> <span class="text-xs text-muted">hal</span></p>
        </div>
      <?php endforeach;?>
      </div>
    <?php endif;?>
  </div>
</div>
<?= $this->endSection()?>
