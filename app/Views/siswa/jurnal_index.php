<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex flex-wrap items-center justify-between gap-3">
  <h1 class="font-display font-extrabold text-3xl"> Jurnal Saya</h1>
  <a href="<?= base_url('siswa/jurnal/baru')?>" class="btn bg-bacayuk hover:bg-bacayuk-dark text-white border-0 rounded-xl font-display shadow"> Jurnal Baru</a>
</div>

<?php if ($daftar === []):?>
  <div class="card bg-white rounded-xl shadow-kartu mt-5"><div class="card-body items-center text-center py-12">
    <img src="<?= base_url('assets/ilustrasi/no-data.svg')?>" alt="" class="h-28">
    <p class="font-display font-bold text-xl mt-2">Belum ada jurnal</p>
    <p class="text-slate-500 font-semibold">Klik tombol "Jurnal Baru" untuk mencatat bacaan pertamamu.</p>
  </div></div>
<?php else:?>
  <div class="grid md:grid-cols-2 gap-4 mt-5">
  <?php foreach ($daftar as $j):?>
    <div class="card bg-white rounded-xl shadow-kartu">
      <div class="card-body p-5">
        <div class="flex items-start justify-between gap-2">
          <h3 class="font-display font-bold text-lg leading-snug"><?= esc($j['judul_buku'])?></h3>
          <?php $b = ['menunggu' => 'badge-warning', 'terverifikasi' => 'badge-success', 'revisi' => 'badge-error'][$j['status']];?>
          <span class="badge <?= $b?> text-white border-0 font-bold shrink-0"><?= esc($j['status'])?></span>
        </div>
        <p class="text-sm font-semibold text-slate-500">
           <?= date('d M Y', strtotime($j['tanggal']))?> •  hal. <?= (int) $j['halaman_dari']?>–<?= (int) $j['halaman_sampai']?> (<?= (int) $j['jumlah_halaman']?> hal) •  <?= (int) $j['durasi_menit']?> menit • <?= esc($j['perasaan'])?>
        </p>
        <p class="text-amber-500 text-lg leading-none"><?= str_repeat('★', (int) $j['rating'])?><span class="text-slate-200"><?= str_repeat('★', 5 - (int) $j['rating'])?></span></p>
        <?php if ($j['ringkasan']):?><p class="text-sm"><span class="font-bold">Ringkasanku:</span> <?= esc($j['ringkasan'])?></p><?php endif;?>
        <?php if ($j['pesan_cerita']):?><p class="text-sm"><span class="font-bold">Pesan cerita:</span> <?= esc($j['pesan_cerita'])?></p><?php endif;?>
        <?php if ($j['catatan_guru']):?>
          <div class="bg-bacayuk-soft rounded-xl px-3 py-2 text-sm"><span class="font-bold"> Kata guru:</span> <?= esc($j['catatan_guru'])?></div>
        <?php endif;?>
        <?php if ($j['status']!== 'terverifikasi'):?>
          <div class="card-actions justify-end mt-1">
            <a href="<?= base_url('siswa/jurnal/edit/'. $j['id'])?>" class="btn btn-sm bg-skyy/20 hover:bg-skyy/40 border-0 rounded-xl font-display"> Ubah</a>
            <form method="post" action="<?= base_url('siswa/jurnal/hapus/'. $j['id'])?>" onsubmit="return confirm('Hapus jurnal ini?')">
              <?= csrf_field()?>
              <button class="btn btn-sm bg-pinky/20 hover:bg-pinky/40 border-0 rounded-xl font-display"> Hapus</button>
            </form>
          </div>
        <?php endif;?>
      </div>
    </div>
  <?php endforeach;?>
  </div>
<?php endif;?>

<?php $rayakan = session()->getFlashdata('celebrate'); if ($rayakan):?>
<!-- Popup perayaan (pola Exercise Completed Modal dari ui.live) -->
<dialog id="modal-raya" class="modal modal-open">
  <div class="modal-box rounded-xl text-center max-w-sm">
    <div class="w-24 h-24 mx-auto rounded-full bg-green-100 border-4 border-green-400 grid place-items-center text-6xl">✓</div>
    <h3 class="font-display font-extrabold text-3xl mt-3">Selesai Membaca!</h3>
    <p class="text-slate-500 font-semibold">Kamu baru saja membaca <b><?= esc($rayakan['judul_buku'])?></b>. Hebat! </p>
    <div class="grid grid-cols-3 gap-2 my-4 font-display">
      <div class="bg-krem rounded-xl py-3"><p class="font-extrabold text-xl"><?= (int) $rayakan['durasi_menit']?></p><p class="text-xs font-body font-bold text-slate-500">menit</p></div>
      <div class="bg-krem rounded-xl py-3"><p class="font-extrabold text-xl"><?= (int) $rayakan['jumlah_halaman']?></p><p class="text-xs font-body font-bold text-slate-500">halaman</p></div>
      <div class="bg-krem rounded-xl py-3"><p class="font-extrabold text-xl"><?= esc($rayakan['perasaan'])?></p><p class="text-xs font-body font-bold text-slate-500">perasaan</p></div>
    </div>
    <p class="text-amber-500 text-3xl"><?= str_repeat('★', (int) $rayakan['rating'])?><span class="text-slate-200"><?= str_repeat('★', 5 - (int) $rayakan['rating'])?></span></p>
    <form method="dialog" class="mt-4">
      <button class="btn btn-block bg-bacayuk hover:bg-bacayuk-dark text-white border-0 rounded-xl font-display text-lg">Lanjutkan </button>
    </form>
  </div>
</dialog>
<?php endif;?>

<?= $this->endSection()?>
