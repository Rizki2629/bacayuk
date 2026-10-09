<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex flex-wrap items-center justify-between gap-3">
  <h1 class="font-display font-extrabold text-3xl"> Kelola Kelas</h1>
  <a href="<?= base_url('admin/kelas/baru')?>" class="btn bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl font-display shadow-lg shadow-primary/20"> Tambah Kelas</a>
</div>

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 mt-5">
<?php foreach ($kelas as $k):?>
  <div class="card bg-white rounded-[22px] shadow-kartu"><div class="card-body p-5">
    <p class="font-display font-extrabold text-2xl">Kelas <?= esc($k['nama'])?></p>
    <p class="font-semibold text-muted">Tingkat <?= (int) $k['tingkat']?> • Tahun ajaran <?= esc($k['tahun_ajaran'])?></p>
    <p class="font-semibold">‍ Wali: <?= esc($k['nama_guru']?? '— belum ditunjuk —')?></p>
    <div class="card-actions justify-end mt-2">
      <a href="<?= base_url('admin/kelas/edit/'. $k['id'])?>" class="btn btn-sm bg-skyy/20 hover:bg-skyy/40 border-0 rounded-xl font-display"> Ubah</a>
      <form method="post" action="<?= base_url('admin/kelas/hapus/'. $k['id'])?>" onsubmit="return confirm('Hapus kelas ini?')">
        <?= csrf_field()?><button class="btn btn-sm bg-pinky/20 hover:bg-pinky/40 border-0 rounded-xl font-display"> Hapus</button>
      </form>
    </div>
  </div></div>
<?php endforeach;?>
<?php if ($kelas === []):?><p class="font-semibold text-muted">Belum ada kelas.</p><?php endif;?>
</div>
<?= $this->endSection()?>
