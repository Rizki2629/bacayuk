<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<?php $j = $jurnal; $aksi = $j? base_url('siswa/jurnal/update/'. $j['id']): base_url('siswa/jurnal');?>

<h1 class="font-display font-extrabold text-3xl"><?= $j? ' Ubah Jurnal': ' Isi Jurnal Baru'?></h1>
<p class="text-slate-500 font-semibold mt-1">Ceritakan bacaanmu hari ini ya!</p>

<form method="post" action="<?= $aksi?>" class="card bg-white rounded-xl shadow-kartu mt-5">
  <div class="card-body gap-4">
    <?= csrf_field()?>

    <label class="form-control">
      <span class="label-text font-bold"> Pilih dari katalog (opsional)</span>
      <select name="buku_id" id="pilih-buku" class="select select-bordered rounded-xl">
        <option value="">— Tulis judul sendiri di bawah —</option>
        <?php foreach ($buku as $b):?>
          <option value="<?= $b['id']?>" data-judul="<?= esc($b['judul'])?>" <?= (string) old('buku_id', $j['buku_id']?? '') === (string) $b['id']? 'selected': ''?>>
            <?= esc($b['judul'])?> — <?= esc($b['penulis'])?>
          </option>
        <?php endforeach;?>
      </select>
    </label>

    <label class="form-control">
      <span class="label-text font-bold">Judul Buku *</span>
      <input type="text" name="judul_buku" id="judul-buku" required maxlength="200"
             value="<?= esc(old('judul_buku', $j['judul_buku']?? ''))?>"
             class="input input-bordered rounded-xl" placeholder="contoh: Si Kancil Anak Cerdik">
    </label>

    <div class="grid sm:grid-cols-4 gap-4">
      <label class="form-control">
        <span class="label-text font-bold"> Tanggal *</span>
        <input type="date" name="tanggal" required max="<?= date('Y-m-d')?>"
               value="<?= esc(old('tanggal', $j['tanggal']?? date('Y-m-d')))?>" class="input input-bordered rounded-xl">
      </label>
      <label class="form-control">
        <span class="label-text font-bold">Halaman dari *</span>
        <input type="number" name="halaman_dari" required min="1" value="<?= esc(old('halaman_dari', $j['halaman_dari']?? 1))?>" class="input input-bordered rounded-xl">
      </label>
      <label class="form-control">
        <span class="label-text font-bold">Halaman sampai *</span>
        <input type="number" name="halaman_sampai" required min="1" value="<?= esc(old('halaman_sampai', $j['halaman_sampai']?? 10))?>" class="input input-bordered rounded-xl">
      </label>
      <label class="form-control">
        <span class="label-text font-bold">⏱ Durasi (menit) *</span>
        <input type="number" name="durasi_menit" required min="1" max="600" value="<?= esc(old('durasi_menit', $j['durasi_menit']?? 15))?>" class="input input-bordered rounded-xl">
      </label>
    </div>

    <label class="form-control">
      <span class="label-text font-bold"> Ringkasan — ceritakan kembali isi bacaanmu</span>
      <textarea name="ringkasan" rows="3" class="textarea textarea-bordered rounded-xl" placeholder="Tadi aku membaca tentang..."><?= esc(old('ringkasan', $j['ringkasan']?? ''))?></textarea>
    </label>

    <label class="form-control">
      <span class="label-text font-bold"> Pesan / pelajaran dari cerita</span>
      <textarea name="pesan_cerita" rows="2" class="textarea textarea-bordered rounded-xl" placeholder="Dari cerita ini aku belajar..."><?= esc(old('pesan_cerita', $j['pesan_cerita']?? ''))?></textarea>
    </label>

    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <span class="label-text font-bold"> Beri bintang untuk bukunya *</span>
        <div class="rating rating-lg mt-1">
          <?php for ($i = 1; $i <= 5; $i++):?>
            <input type="radio" name="rating" value="<?= $i?>" class="mask mask-star-2 bg-amber-400" <?= (int) old('rating', $j['rating']?? 5) === $i? 'checked': ''?>>
          <?php endfor;?>
        </div>
      </div>
      <div>
        <span class="label-text font-bold">Perasaanmu setelah membaca</span>
        <div class="flex gap-2 mt-1">
          <?php foreach (['😊', '🤩', '😄', '🥰', '🤔', '😴'] as $emo):?>
            <label class="cursor-pointer">
              <input type="radio" name="perasaan" value="<?= $emo?>" class="peer sr-only" <?= old('perasaan', $j['perasaan']?? '😊') === $emo? 'checked': ''?>>
              <span class="block text-3xl p-1 rounded-xl peer-checked:bg-mustard/40 peer-checked:ring-2 ring-mustard"><?= $emo?></span>
            </label>
          <?php endforeach;?>
        </div>
      </div>
    </div>

    <div class="flex gap-3 mt-2">
      <button class="btn bg-bacayuk hover:bg-bacayuk-dark text-white border-0 rounded-xl font-display text-lg flex-1"> Simpan Jurnal</button>
      <a href="<?= base_url('siswa/jurnal')?>" class="btn btn-ghost rounded-xl font-display">Batal</a>
    </div>
  </div>
</form>

<script>
document.getElementById('pilih-buku').addEventListener('change', function () {
  const opt = this.options[this.selectedIndex];
  if (opt.dataset.judul) document.getElementById('judul-buku').value = opt.dataset.judul;
});
</script>
<?= $this->endSection()?>
