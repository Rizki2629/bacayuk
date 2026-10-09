<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex items-center justify-between gap-4">
  <div>
    <h1 class="font-display font-extrabold text-3xl">Halo, <?= esc(session()->get('nama'))?></h1>
    <p class="text-muted font-semibold mt-1">Pantau aktivitas membaca anak-anak kelasmu hari ini.</p>
  </div>
  <img src="<?= base_url('assets/ilustrasi/online-learning.svg')?>" alt="" class="h-24 hidden md:block shrink-0 bg-[#F1EEFF] rounded-xl p-2">
</div>

<?php if ($tanpaKelas):?>
  <div class="alert alert-warning rounded-xl font-semibold mt-5">Akun gurumu belum terhubung ke kelas mana pun. Minta admin untuk menunjukmu sebagai wali kelas ya. </div>
<?php else:?>

<div class="grid grid-cols-3 gap-4 mt-5">
  <?php foreach ([['<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/></svg>', $ringkas['siswa'], 'Siswa di Kelas', 'bg-skyy/15'], ['<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2 8-2V4c-4 0-6.2.4-8 2Z"/><path d="M12 6v14"/></svg>', $ringkas['jurnal_minggu'], 'Jurnal 7 Hari Ini', 'bg-minty/15'], ['<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>', $ringkas['menunggu'], 'Menunggu Verifikasi', 'bg-mustard/25']] as [$i, $n, $l, $c]):?>
  <div class="card bg-white rounded-[22px] shadow-kartu"><div class="card-body p-5">
    <span class="w-11 h-11 rounded-xl grid place-items-center text-2xl <?= $c?>"><?= $i?></span>
    <p class="font-display font-extrabold text-3xl mt-2"><?= (int) $n?></p>
    <p class="font-bold text-muted text-sm"><?= $l?></p>
  </div></div>
  <?php endforeach;?>
</div>

<div class="grid lg:grid-cols-5 gap-4 mt-4">
  <div class="card bg-white rounded-[22px] shadow-kartu lg:col-span-3"><div class="card-body p-5">
    <h2 class="font-display font-bold text-xl"> Menit Membaca Kelas (7 hari)</h2>
    <div class="h-56"><canvas id="grafikKelas"></canvas></div>
  </div></div>

  <div class="card bg-white rounded-[22px] shadow-kartu lg:col-span-2"><div class="card-body p-5">
    <h2 class="font-display font-bold text-xl"> Belum Membaca Minggu Ini</h2>
    <?php if ($belum === []):?>
      <p class="font-semibold text-muted">Semua anak sudah membaca minggu ini. Luar biasa! </p>
    <?php else:?>
      <ul class="space-y-2">
        <?php foreach ($belum as $s):?>
          <li class="flex items-center gap-2 bg-krem rounded-xl px-3 py-2 font-bold"><span class="text-2xl"><?= esc($s['avatar'])?></span><?= esc($s['nama'])?></li>
        <?php endforeach;?>
      </ul>
    <?php endif;?>
  </div></div>
</div>

<div class="card bg-white rounded-[22px] shadow-kartu mt-4"><div class="card-body p-5">
  <div class="flex items-center justify-between">
    <h2 class="font-display font-bold text-xl"> Jurnal Terbaru Menunggu Verifikasi</h2>
    <a href="<?= base_url('guru/verifikasi')?>" class="btn btn-sm bg-bacayuk text-white border-0 rounded-xl font-display">Lihat semua →</a>
  </div>
  <?php if ($menunggu === []):?>
    <p class="font-semibold text-muted mt-2">Tidak ada antrean. Semua jurnal sudah diperiksa. </p>
  <?php else:?>
    <div class="divide-y">
    <?php foreach ($menunggu as $j):?>
      <div class="py-3 flex items-center gap-3">
        <span class="text-3xl"><?= esc($j['avatar'])?></span>
        <div class="flex-1 min-w-0">
          <p class="font-display font-bold truncate"><?= esc($j['nama_siswa'])?> — <?= esc($j['judul_buku'])?></p>
          <p class="text-sm text-muted font-semibold"><?= date('d M Y', strtotime($j['tanggal']))?> • <?= (int) $j['jumlah_halaman']?> hal • <?= (int) $j['durasi_menit']?> menit</p>
        </div>
        <a href="<?= base_url('guru/verifikasi')?>" class="btn btn-sm bg-mustard text-ink border-0 rounded-xl font-display">Periksa</a>
      </div>
    <?php endforeach;?>
    </div>
  <?php endif;?>
</div></div>
<?php endif;?>

<?= $this->endSection()?>

<?= $this->section('scripts')?>
<?php if (! $tanpaKelas):?>
<script>
new Chart(document.getElementById('grafikKelas'), {
  type: 'bar',
  data: { labels: <?= json_encode($grafik['labels'])?>,
    datasets: [{ label: 'Menit', data: <?= json_encode($grafik['menit'])?>, backgroundColor: '#2F8F83', borderRadius: 12, maxBarThickness: 42 }] },
  options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
    scales: { y: { beginAtZero: true, grid: { color: '#E6F4F1' } }, x: { grid: { display: false } } } }
});
</script>
<?php endif;?>
<?= $this->endSection()?>
