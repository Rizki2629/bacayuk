<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<?php $b = $buku; $aksi = $b? base_url('buku/update/'. $b['id']): base_url('buku');?>

<h1 class="font-display font-extrabold text-3xl"><?= $b? ' Ubah Buku': ' Tambah Buku'?></h1>

<form method="post" action="<?= $aksi?>" class="card bg-white rounded-xl shadow-kartu mt-5">
  <div class="card-body gap-4">
    <?= csrf_field()?>
    <label class="form-control"><span class="label-text font-bold">Judul Buku *</span>
      <input type="text" name="judul" required maxlength="200" value="<?= esc(old('judul', $b['judul']?? ''))?>" class="input input-bordered rounded-xl"></label>
    <div class="grid sm:grid-cols-2 gap-4">
      <label class="form-control"><span class="label-text font-bold">Penulis *</span>
        <input type="text" name="penulis" required maxlength="100" value="<?= esc(old('penulis', $b['penulis']?? ''))?>" class="input input-bordered rounded-xl"></label>
      <label class="form-control"><span class="label-text font-bold">Penerbit</span>
        <input type="text" name="penerbit" maxlength="100" value="<?= esc(old('penerbit', $b['penerbit']?? ''))?>" class="input input-bordered rounded-xl"></label>
    </div>
    <div class="grid sm:grid-cols-4 gap-4">
      <label class="form-control"><span class="label-text font-bold">Genre *</span>
        <select name="genre" class="select select-bordered rounded-xl">
          <?php foreach (\App\Models\BukuModel::GENRE as $g):?>
            <option value="<?= $g?>" <?= old('genre', $b['genre']?? 'Dongeng') === $g? 'selected': ''?>><?= $g?></option>
          <?php endforeach;?>
        </select></label>
      <label class="form-control"><span class="label-text font-bold">Jumlah Halaman *</span>
        <input type="number" name="jumlah_halaman" required min="1" value="<?= esc(old('jumlah_halaman', $b['jumlah_halaman']?? 32))?>" class="input input-bordered rounded-xl"></label>
      <label class="form-control"><span class="label-text font-bold">Warna Sampul</span>
        <input type="color" name="warna_sampul" value="<?= esc(old('warna_sampul', $b['warna_sampul']?? '#2563EB'))?>" class="input input-bordered rounded-xl p-1"></label>
      <label class="form-control"><span class="label-text font-bold">Ikon Sampul (emoji)</span>
        <input type="text" name="ikon" maxlength="4" value="<?= esc(old('ikon', $b['ikon']?? ''))?>" class="input input-bordered rounded-xl"></label>
    </div>
    <label class="form-control"><span class="label-text font-bold">Deskripsi Singkat</span>
      <textarea name="deskripsi" rows="2" class="textarea textarea-bordered rounded-xl"><?= esc(old('deskripsi', $b['deskripsi']?? ''))?></textarea></label>
    <div class="flex gap-3">
      <button class="btn bg-bacayuk hover:bg-bacayuk-dark text-white border-0 rounded-xl font-display text-lg flex-1"> Simpan</button>
      <a href="<?= base_url('buku')?>" class="btn btn-ghost rounded-xl font-display">Batal</a>
    </div>
  </div>
</form>
<?= $this->endSection()?>
