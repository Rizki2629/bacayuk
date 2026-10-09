<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex flex-wrap items-center justify-between gap-3">
  <h1 class="font-display font-extrabold text-3xl"> Kelola Kelas</h1>
  <a href="<?= base_url('admin/kelas/baru')?>" class="btn bg-bacayuk hover:bg-bacayuk-dark text-white border-0 rounded-xl font-display shadow"> Tambah Kelas</a>
</div>

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 mt-5">
<?php foreach ($kelas as $k):?>
  <div class="card bg-white rounded-xl shadow-kartu"><div class="card-body p-5">
    <p class="font-display font-extrabold text-2xl">Kelas <?= esc($k['nama'])?></p>
    <p class="font-semibold text-slate-500">Tingkat <?= (int) $k['tingkat']?> • Tahun ajaran <?= esc($k['tahun_ajaran'])?></p>
    <p class="font-semibold">‍ Wali: <?= esc($k['nama_guru']?? '— belum ditunjuk —')?></p>
    <div class="card-actions justify-end mt-2">
      <a href="<?= base_url('admin/kelas/edit/'. $k['id'])?>" class="btn btn-sm bg-skyy/20 hover:bg-skyy/40 border-0 rounded-xl font-display"> Ubah</a>
      <form method="post" action="<?= base_url('admin/kelas/hapus/'. $k['id'])?>" onsubmit="return confirm('Hapus kelas ini?')">
        <?= csrf_field()?><button class="btn btn-sm bg-pinky/20 hover:bg-pinky/40 border-0 rounded-xl font-display"> Hapus</button>
      </form>
    </div>
  </div></div>
<?php endforeach;?>
<?php if ($kelas === []):?><p class="font-semibold text-slate-500">Belum ada kelas.</p><?php endif;?>
</div>
<?= $this->endSection()?>
