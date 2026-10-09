<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<?php $k = $kelas; $aksi = $k? base_url('admin/kelas/update/'. $k['id']): base_url('admin/kelas');?>

<h1 class="font-display font-extrabold text-3xl"><?= $k? ' Ubah Kelas': ' Tambah Kelas'?></h1>

<form method="post" action="<?= $aksi?>" class="card bg-white rounded-[22px] shadow-kartu mt-5">
  <div class="card-body gap-4">
    <?= csrf_field()?>
    <div class="grid sm:grid-cols-3 gap-4">
      <label class="form-control"><span class="label-text font-bold">Nama Kelas *</span>
        <input type="text" name="nama" required maxlength="50" value="<?= esc(old('nama', $k['nama']?? ''))?>" class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]" placeholder="contoh: 4A"></label>
      <label class="form-control"><span class="label-text font-bold">Tingkat *</span>
        <input type="number" name="tingkat" required min="1" max="12" value="<?= esc(old('tingkat', $k['tingkat']?? 4))?>" class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]"></label>
      <label class="form-control"><span class="label-text font-bold">Tahun Ajaran</span>
        <input type="text" name="tahun_ajaran" maxlength="9" value="<?= esc(old('tahun_ajaran', $k['tahun_ajaran']?? '2026/2027'))?>" class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]"></label>
    </div>
    <label class="form-control"><span class="label-text font-bold">Wali Kelas (Guru)</span>
      <select name="guru_id" class="select select-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
        <option value="">— Belum ditunjuk —</option>
        <?php foreach ($guru as $g):?>
          <option value="<?= $g['id']?>" <?= (string) old('guru_id', $k['guru_id']?? '') === (string) $g['id']? 'selected': ''?>><?= esc($g['nama'])?> (@<?= esc($g['username'])?>)</option>
        <?php endforeach;?>
      </select></label>
    <div class="flex gap-3">
      <button class="btn bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl font-display shadow-lg shadow-primary/20 text-lg flex-1"> Simpan</button>
      <a href="<?= base_url('admin/kelas')?>" class="btn btn-ghost rounded-2xl font-display">Batal</a>
    </div>
  </div>
</form>
<?= $this->endSection()?>
