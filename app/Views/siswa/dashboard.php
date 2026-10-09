<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="relative overflow-hidden rounded-xl bg-bacayuk text-white p-6 sm:p-8 shadow-kartu">
  <div class="relative z-10 sm:max-w-[68%]">
    <h1 class="font-display font-extrabold text-3xl sm:text-4xl">Halo, <?= esc(session()->get('nama'))?></h1>
    <p class="text-white/85 font-semibold mt-1">Sudah membaca apa hari ini? Catat bacaanmu di jurnal. </p>
    <a href="<?= base_url('siswa/jurnal/baru')?>" class="btn bg-mustard hover:bg-[#D97706] text-ink border-0 rounded-xl font-display text-lg mt-4 shadow"> Isi Jurnal Hari Ini</a>
  </div>
  <img src="<?= base_url('assets/ilustrasi/book-lover.svg')?>" alt="" class="absolute right-3 -bottom-3 h-40 lg:h-48 hidden sm:block pointer-events-none select-none">
</div>

<!-- Kartu statistik (pola Courseflow) -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
  <?php
  $kartu = [
      ['<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2 8-2V4c-4 0-6.2.4-8 2Z"/><path d="M12 6v14"/></svg>', $stats['total_buku'], 'Buku Dibaca', 'bg-pinky/15 text-pinky'],
      ['<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="8" width="12" height="12" rx="2"/><path d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2"/></svg>', $stats['total_halaman'], 'Total Halaman', 'bg-skyy/15 text-skyy'],
      ['<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>', $stats['total_menit'], 'Menit Membaca', 'bg-minty/15 text-minty'],
      ['<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="5" width="17" height="16" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>', $stats['streak'], 'Hari Beruntun', 'bg-mustard/25 text-[#9c7300]'],
  ];
  foreach ($kartu as [$ikon, $nilai, $label, $kelas]):?>
  <div class="card bg-white rounded-xl shadow-kartu">
    <div class="card-body p-5">
      <span class="w-11 h-11 rounded-xl grid place-items-center text-2xl <?= $kelas?>"><?= $ikon?></span>
      <p class="font-display font-extrabold text-3xl mt-2"><?= number_format($nilai)?></p>
      <p class="font-bold text-slate-500 text-sm"><?= $label?></p>
    </div>
  </div>
  <?php endforeach;?>
</div>

<div class="grid lg:grid-cols-5 gap-4 mt-4">
  <!-- Grafik -->
  <div class="card bg-white rounded-xl shadow-kartu lg:col-span-3">
    <div class="card-body p-5">
      <h2 class="font-display font-bold text-xl"> Membacaku 7 Hari Terakhir</h2>
      <div class="h-56"><canvas id="grafikBaca"></canvas></div>
    </div>
  </div>
  <!-- Lencana terbaru -->
  <div class="card bg-white rounded-xl shadow-kartu lg:col-span-2">
    <div class="card-body p-5">
      <h2 class="font-display font-bold text-xl"> Lencana Terbaruku</h2>
      <?php if ($lencana === []):?>
        <p class="text-slate-500 font-semibold">Belum ada lencana. Isi jurnal pertamamu untuk meraih Langkah Pertama!</p>
      <?php else:?>
        <div class="flex flex-wrap gap-3">
          <?php foreach (array_slice($lencana, -6) as $l):?>
            <div class="tooltip" data-tip="<?= esc($l['nama'])?>">
              <span class="w-14 h-14 rounded-full bg-mustard/30 border-2 border-mustard grid place-items-center text-3xl"><?= esc($l['ikon'])?></span>
            </div>
          <?php endforeach;?>
        </div>
      <?php endif;?>
      <a href="<?= base_url('siswa/lencana')?>" class="btn btn-ghost rounded-xl font-display text-bacayuk mt-2">Lihat semua lencana →</a>
    </div>
  </div>
</div>

<!-- Lanjutkan Membaca -->
<div class="card bg-white rounded-xl shadow-kartu mt-4">
  <div class="card-body p-5">
    <h2 class="font-display font-bold text-xl"> Jurnal Terakhirku</h2>
    <?php if ($lanjut === []):?>
      <p class="text-slate-500 font-semibold">Belum ada jurnal. Mulai petualangan membacamu sekarang!</p>
    <?php else:?>
      <div class="divide-y">
      <?php foreach ($lanjut as $j):?>
        <div class="py-3 flex items-center gap-4">
          <span class="w-12 h-14 rounded-xl grid place-items-center text-2xl text-white font-display font-bold shrink-0" style="background:#2563EB"><?= esc($j['perasaan']?: '📚')?></span>
          <div class="flex-1 min-w-0">
            <p class="font-display font-bold truncate"><?= esc($j['judul_buku'])?></p>
            <p class="text-sm text-slate-500 font-semibold"><?= date('d M Y', strtotime($j['tanggal']))?> • hal. <?= (int) $j['halaman_dari']?>–<?= (int) $j['halaman_sampai']?> • <?= (int) $j['durasi_menit']?> menit</p>
            <?php if (! empty($j['total_halaman_buku'])):?>
              <progress class="progress progress-warning w-full max-w-xs" value="<?= (int) $j['halaman_sampai']?>" max="<?= (int) $j['total_halaman_buku']?>"></progress>
            <?php endif;?>
          </div>
          <?php
            $badge = ['menunggu' => 'badge-warning', 'terverifikasi' => 'badge-success', 'revisi' => 'badge-error'][$j['status']];
?>
          <span class="badge <?= $badge?> font-bold text-white border-0"><?= esc($j['status'])?></span>
        </div>
      <?php endforeach;?>
      </div>
    <?php endif;?>
  </div>
</div>

<?= $this->endSection()?>

<?= $this->section('scripts')?>
<script>
new Chart(document.getElementById('grafikBaca'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($grafik['labels'])?>,
    datasets: [{ label: 'Menit membaca', data: <?= json_encode($grafik['menit'])?>,
      backgroundColor: '#2563EB', borderRadius: 12, maxBarThickness: 42 }]
  },
  options: { responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: { y: { beginAtZero: true, grid: { color: '#E8EFFD' } }, x: { grid: { display: false } } } }
});
</script>
<?= $this->endSection()?>
