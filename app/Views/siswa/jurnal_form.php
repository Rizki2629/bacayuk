<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<?php $j = $jurnal; $aksi = $j? base_url('siswa/jurnal/update/'. $j['id']): base_url('siswa/jurnal');?>

<h1 class="font-display font-extrabold text-3xl"><?= $j? ' Ubah Jurnal': ' Isi Jurnal Baru'?></h1>
<p class="text-muted font-semibold mt-1">Ceritakan bacaanmu hari ini ya!</p>

<form method="post" action="<?= $aksi?>" class="card bg-white rounded-[22px] shadow-kartu mt-5">
  <div class="card-body gap-5 p-6 sm:p-8">
    <?= csrf_field()?>

    <label class="form-control gap-1.5">
      <span class="label-text text-sm font-bold"> Pilih dari katalog (opsional)</span>
      <select name="buku_id" id="pilih-buku" class="select select-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
        <option value="">— Tulis judul sendiri di bawah —</option>
        <?php foreach ($buku as $b):?>
          <option value="<?= $b['id']?>" data-judul="<?= esc($b['judul'])?>" <?= (string) old('buku_id', $j['buku_id']?? '') === (string) $b['id']? 'selected': ''?>>
            <?= esc($b['judul'])?> — <?= esc($b['penulis'])?>
          </option>
        <?php endforeach;?>
      </select>
    </label>

    <label class="form-control gap-1.5">
      <span class="label-text text-sm font-bold">Judul Buku *</span>
      <input type="text" name="judul_buku" id="judul-buku" required maxlength="200"
             value="<?= esc(old('judul_buku', $j['judul_buku']?? ''))?>"
             class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]" placeholder="contoh: Si Kancil Anak Cerdik">
    </label>

    <div class="grid sm:grid-cols-4 gap-4">
      <label class="form-control gap-1.5">
        <span class="label-text text-sm font-bold"> Tanggal *</span>
        <input type="date" name="tanggal" required max="<?= date('Y-m-d')?>"
               value="<?= esc(old('tanggal', $j['tanggal']?? date('Y-m-d')))?>" class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
      </label>
      <label class="form-control gap-1.5">
        <span class="label-text text-sm font-bold">Halaman dari *</span>
        <input type="number" name="halaman_dari" required min="1" value="<?= esc(old('halaman_dari', $j['halaman_dari']?? 1))?>" class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
      </label>
      <label class="form-control gap-1.5">
        <span class="label-text text-sm font-bold">Halaman sampai *</span>
        <input type="number" name="halaman_sampai" required min="1" value="<?= esc(old('halaman_sampai', $j['halaman_sampai']?? 10))?>" class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
      </label>
      <label class="form-control gap-1.5">
        <span class="label-text text-sm font-bold">Durasi membaca (menit) *</span>
        <input type="number" name="durasi_menit" required min="1" max="600" value="<?= esc(old('durasi_menit', $j['durasi_menit']?? 15))?>" class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
      </label>
    </div>

    <label class="form-control gap-1.5">
      <span class="label-text text-sm font-bold"> Ringkasan — ceritakan kembali isi bacaanmu</span>
      <textarea name="ringkasan" rows="3" class="textarea textarea-bordered rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]" placeholder="Tadi aku membaca tentang..."><?= esc(old('ringkasan', $j['ringkasan']?? ''))?></textarea>
    </label>

    <label class="form-control gap-1.5">
      <span class="label-text text-sm font-bold"> Pesan / pelajaran dari cerita</span>
      <textarea name="pesan_cerita" rows="2" class="textarea textarea-bordered rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]" placeholder="Dari cerita ini aku belajar..."><?= esc(old('pesan_cerita', $j['pesan_cerita']?? ''))?></textarea>
    </label>

    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <span class="label-text text-sm font-bold"> Beri bintang untuk bukunya *</span>
        <div class="rating rating-lg mt-2 bg-bacayuk-soft/60 rounded-2xl px-3 py-2">
          <?php for ($i = 1; $i <= 5; $i++):?>
            <input type="radio" name="rating" value="<?= $i?>" class="mask mask-star-2 bg-amber-400 !w-11 !h-11 cursor-pointer" <?= (int) old('rating', $j['rating']?? 5) === $i? 'checked': ''?>>
          <?php endfor;?>
        </div>
      </div>
      <div>
        <span class="label-text text-sm font-bold">Perasaanmu setelah membaca</span>
        <div class="flex flex-wrap gap-2.5 mt-2">
          <?php foreach (['😊', '🤩', '😄', '🥰', '🤔', '😴'] as $emo):?>
            <label class="cursor-pointer">
              <input type="radio" name="perasaan" value="<?= $emo?>" class="peer sr-only" <?= old('perasaan', $j['perasaan']?? '😊') === $emo? 'checked': ''?>>
              <span class="flex w-12 h-12 items-center justify-center text-3xl rounded-2xl transition hover:bg-bacayuk-soft/70 peer-checked:bg-bacayuk-soft peer-checked:ring-2 peer-checked:ring-primary peer-checked:scale-105"><?= $emo?></span>
            </label>
          <?php endforeach;?>
        </div>
      </div>
    </div>

    <div class="flex gap-3 mt-2">
      <button class="btn bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl font-display shadow-lg shadow-primary/20 text-lg h-12 flex-1"> Simpan Jurnal</button>
      <a href="<?= base_url('siswa/jurnal')?>" class="btn bg-bacayuk-soft text-primary hover:bg-[#E3DBFF] border-0 rounded-2xl font-display text-lg h-12 px-6">Batal</a>
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
