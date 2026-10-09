<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<h1 class="font-display font-extrabold text-3xl">Halo, Admin! </h1>
<p class="text-slate-500 font-semibold mt-1">Ringkasan seluruh aktivitas membaca di sekolah.</p>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
  <?php foreach ([
      ['', $ringkas['users'], 'Total User', 'bg-skyy/15'],
      ['‍', $ringkas['guru'], 'Guru', 'bg-minty/15'],
      ['', $ringkas['siswa'], 'Siswa', 'bg-pinky/15'],
      ['', $ringkas['kelas'], 'Kelas', 'bg-mustard/25'],
      ['', $ringkas['buku'], 'Buku di Katalog', 'bg-bacayuk-soft'],
      ['', $ringkas['jurnal'], 'Total Jurnal', 'bg-skyy/15'],
      ['⏳', $ringkas['menunggu'], 'Menunggu Verifikasi', 'bg-mustard/25'],
      ['', $ringkas['lencana'], 'Definisi Lencana', 'bg-minty/15'],
  ] as [$i, $n, $l, $c]):?>
  <div class="card bg-white rounded-xl shadow-kartu"><div class="card-body p-5">
    <span class="w-11 h-11 rounded-xl grid place-items-center text-2xl <?= $c?>"><?= $i?></span>
    <p class="font-display font-extrabold text-3xl mt-2"><?= (int) $n?></p>
    <p class="font-bold text-slate-500 text-sm"><?= $l?></p>
  </div></div>
  <?php endforeach;?>
</div>

<div class="grid lg:grid-cols-2 gap-4 mt-4">
  <div class="card bg-white rounded-xl shadow-kartu"><div class="card-body p-5">
    <h2 class="font-display font-bold text-xl"> Daftar Kelas</h2>
    <ul class="divide-y">
      <?php foreach ($kelas as $k):?>
        <li class="py-2 flex justify-between font-semibold"><span>Kelas <?= esc($k['nama'])?> (Tingkat <?= (int) $k['tingkat']?>)</span><span class="text-slate-500"><?= esc($k['nama_guru']?? '— belum ada wali —')?></span></li>
      <?php endforeach;?>
      <?php if ($kelas === []):?><li class="py-2 font-semibold text-slate-500">Belum ada kelas.</li><?php endif;?>
    </ul>
  </div></div>
  <div class="card bg-white rounded-xl shadow-kartu"><div class="card-body p-5">
    <h2 class="font-display font-bold text-xl"> Aktivitas Jurnal Terbaru</h2>
    <ul class="divide-y">
      <?php foreach ($aktivitas as $j):?>
        <li class="py-2 font-semibold text-sm"><b><?= esc($j['nama_siswa'])?></b> membaca <b><?= esc($j['judul_buku'])?></b>
          <span class="text-slate-500">• <?= date('d M', strtotime($j['tanggal']))?> • <?= esc($j['status'])?></span></li>
      <?php endforeach;?>
      <?php if ($aktivitas === []):?><li class="py-2 font-semibold text-slate-500">Belum ada aktivitas.</li><?php endif;?>
    </ul>
  </div></div>
</div>
<?= $this->endSection()?>
