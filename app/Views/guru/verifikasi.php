<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<h1 class="font-display font-extrabold text-3xl"> Verifikasi Jurnal</h1>
<p class="text-slate-500 font-semibold mt-1">Periksa jurnal anak-anak, lalu setujui atau minta revisi dengan catatan penyemangat.</p>

<?php if ($daftar === []):?>
  <div class="card bg-white rounded-xl shadow-kartu mt-5"><div class="card-body items-center py-12 text-center">
    <span class="text-6xl"></span>
    <p class="font-display font-bold text-xl mt-2">Antrean kosong!</p>
    <p class="text-slate-500 font-semibold">Semua jurnal sudah diverifikasi.</p>
  </div></div>
<?php else:?>
  <div class="space-y-4 mt-5">
  <?php foreach ($daftar as $j):?>
    <div class="card bg-white rounded-xl shadow-kartu"><div class="card-body p-5">
      <div class="flex flex-wrap items-start gap-3">
        <span class="text-4xl"><?= esc($j['avatar'])?></span>
        <div class="flex-1 min-w-[220px]">
          <p class="font-display font-bold text-lg"><?= esc($j['nama_siswa'])?></p>
          <p class="font-semibold"> <?= esc($j['judul_buku'])?></p>
          <p class="text-sm font-semibold text-slate-500"> <?= date('d M Y', strtotime($j['tanggal']))?> • hal. <?= (int) $j['halaman_dari']?>–<?= (int) $j['halaman_sampai']?> •  <?= (int) $j['durasi_menit']?> menit • <?= str_repeat('★', (int) $j['rating'])?> • <?= esc($j['perasaan'])?></p>
          <?php if ($j['ringkasan']):?><p class="text-sm mt-2"><b>Ringkasan:</b> <?= esc($j['ringkasan'])?></p><?php endif;?>
          <?php if ($j['pesan_cerita']):?><p class="text-sm"><b>Pesan cerita:</b> <?= esc($j['pesan_cerita'])?></p><?php endif;?>
        </div>
      </div>
      <form method="post" action="<?= base_url('guru/verifikasi/'. $j['id'])?>" class="mt-3 flex flex-col sm:flex-row gap-2">
        <?= csrf_field()?>
        <input type="text" name="catatan_guru" class="input input-bordered rounded-xl flex-1" placeholder="Catatan untuk siswa (opsional), mis: Hebat! Ringkasannya jelas ">
        <div class="flex gap-2">
          <button name="status" value="terverifikasi" class="btn bg-minty hover:brightness-95 text-white border-0 rounded-xl font-display"> Setujui</button>
          <button name="status" value="revisi" class="btn bg-pinky hover:brightness-95 text-white border-0 rounded-xl font-display"> Revisi</button>
        </div>
      </form>
    </div></div>
  <?php endforeach;?>
  </div>
<?php endif;?>
<?= $this->endSection()?>
