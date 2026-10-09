<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<!-- ===== BERANDA MOBILE (ala aplikasi) ===== -->
<?php $menitMinggu = array_sum($grafik['menit']); $persenMisi = min(100, (int) round($menitMinggu / 150 * 100)); ?>
<div class="lg:hidden">
  <div class="relative overflow-hidden rounded-[26px] bg-gradient-to-br from-primary to-primary-dark text-white p-5 shadow-float">
    <div class="absolute -right-8 -top-12 w-40 h-40 rounded-full bg-white/10"></div>
    <div class="relative z-10">
      <p class="text-white/75 text-[13px] font-semibold">Selamat datang kembali</p>
      <h1 class="font-kartun font-bold text-[24px] leading-[1.15]">Hai, <?= esc(session()->get('nama'))?>! 👋</h1>
      <form method="get" action="<?= base_url('siswa/buku')?>" class="mt-4 bg-white rounded-full flex items-center gap-2 pl-4 pr-1.5 py-1.5 shadow-lg">
        <input type="text" name="q" placeholder="Cari buku di katalog..." class="flex-1 min-w-0 bg-transparent outline-none text-sm text-ink placeholder:text-[#A79FC0]">
        <button type="submit" class="w-9 h-9 flex-none rounded-full bg-lilac grid place-items-center" aria-label="Cari"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#6956E8" stroke-width="2.2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg></button>
      </form>
      <div class="mt-5 flex items-end justify-between gap-3">
        <div><p class="text-[10px] font-bold tracking-[.14em] text-gold">MISI MEMBACA MINGGU INI</p>
        <p class="font-kartun font-extrabold text-lg mt-1"><?= number_format($menitMinggu)?> dari 150 menit</p></div>
        <div class="flex items-center gap-2 flex-none"><img src="<?= base_url('assets/3d/misi.jpg')?>" alt="" class="h-12 w-auto drop-shadow-lg"><span class="rounded-full bg-white/15 px-3 py-1.5 text-xs font-bold">🔥 <?= number_format($stats['streak'])?> hari</span></div>
      </div>
      <div class="h-2 rounded-full bg-white/20 mt-2.5 overflow-hidden"><div class="h-full rounded-full bg-gold" style="width: <?= $persenMisi?>%"></div></div>
    </div>
  </div>

  <div class="grid grid-cols-4 gap-2.5 mt-4">
    <?php foreach ([['📚', $stats['total_buku'], 'Buku'], ['📖', $stats['total_halaman'], 'Halaman'], ['⏱', $stats['total_menit'], 'Menit'], ['📝', $stats['total_jurnal'], 'Jurnal']] as [$ic, $n, $lb]): ?>
    <div class="bg-white rounded-2xl border border-[#F2EEF8] shadow-soft py-3 text-center"><p class="text-lg leading-none"><?= $ic?></p><p class="font-display font-bold text-[17px] mt-1.5"><?= number_format($n)?></p><p class="text-[10px] font-bold text-muted"><?= $lb?></p></div>
    <?php endforeach; ?>
  </div>

  <div class="flex items-center justify-between mt-6 mb-3"><h2 class="font-display font-bold text-[17px]">Cari Buku dari Kategori</h2><a href="<?= base_url('siswa/buku')?>" class="text-primary text-xs font-bold">Semua</a></div>
  <div class="flex gap-2.5 overflow-x-auto pb-1 -mx-5 px-5">
    <?php foreach ([['Dongeng', '🦌', 'bg-lilac'], ['Sains', '🚀', 'bg-[#EAF7FF]'], ['Cerita Rakyat', '⛵', 'bg-mint'], ['Komik', '😄', 'bg-[#FFEDE4]'], ['Puisi', '🌸', 'bg-[#FFF0F5]'], ['Novel Anak', '🌳', 'bg-cream']] as [$g, $ic, $bg]): ?>
    <a href="<?= base_url('siswa/buku?genre=' . urlencode($g))?>" class="flex-none flex items-center gap-2 <?= $bg?> rounded-2xl pl-2 pr-3.5 py-2"><span class="w-8 h-8 rounded-[10px] bg-white grid place-items-center text-base shadow-sm"><?= $ic?></span><span class="text-xs font-bold whitespace-nowrap"><?= esc($g)?></span></a>
    <?php endforeach; ?>
  </div>

  <div class="flex items-center justify-between mt-6 mb-3"><h2 class="font-display font-bold text-[17px]">Koleksi Terbaru</h2><a href="<?= base_url('siswa/buku')?>" class="text-primary text-xs font-bold">Lihat Semua</a></div>
  <div class="flex gap-3 overflow-x-auto pb-1 -mx-5 px-5">
    <?php foreach ($bukuTerbaru as $b): ?>
    <a href="<?= base_url('siswa/buku')?>" class="flex-none w-[104px]">
      <div class="h-[138px] rounded-2xl p-3 text-white flex flex-col shadow-md relative overflow-hidden" style="background: linear-gradient(160deg, <?= esc($b['warna_sampul'] ?: '#6956E8')?>, <?= esc($b['warna_sampul'] ?: '#6956E8')?>)"><span class="absolute left-0 top-0 bottom-0 w-[5px] bg-black/15"></span><span class="text-[32px] mb-auto"><?= esc($b['ikon'] ?: '📚')?></span><span class="font-display font-bold text-xs leading-snug"><?= esc($b['judul'])?></span><span class="text-[10px] text-white/85"><?= esc($b['genre'])?> · <?= (int) $b['jumlah_halaman']?> hlm</span></div>
      <p class="font-bold text-xs mt-2 leading-snug line-clamp-2"><?= esc($b['judul'])?></p><p class="text-[11px] text-muted"><?= esc($b['penulis'])?></p>
    </a>
    <?php endforeach; ?>
  </div>

  <?php if ($seringDibaca !== []): ?>
  <div class="flex items-center justify-between mt-6 mb-3"><h2 class="font-display font-bold text-[17px]">Koleksi Sering Dibaca</h2><a href="<?= base_url('siswa/peringkat')?>" class="text-primary text-xs font-bold">Peringkat</a></div>
  <div class="space-y-2.5">
    <?php foreach ($seringDibaca as $i => $s): ?>
    <div class="flex items-center gap-3 bg-white border border-[#F2EEF8] rounded-2xl p-2.5 shadow-soft"><span class="w-10 h-[52px] rounded-[10px] grid place-items-center text-xl flex-none" style="background: <?= esc($s['warna'] ?: '#F1EEFF')?>33"><?= esc($s['ikon'] ?: '📚')?></span><div class="flex-1 min-w-0"><p class="font-display font-bold text-[13px] truncate"><?= esc($s['judul_buku'])?></p><p class="text-[11px] text-muted"><?= esc($s['penulis'] ?? 'BacaYuk')?> · dibaca <?= (int) $s['dibaca']?>×</p></div><span class="font-display font-extrabold text-[#C3BEE0] text-sm">#<?= $i + 1?></span></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ($lencana !== []): ?>
  <div class="flex items-center justify-between mt-6 mb-3"><h2 class="font-display font-bold text-[17px]">Lencana Terbaru</h2><a href="<?= base_url('siswa/lencana')?>" class="text-primary text-xs font-bold">Lihat Semua</a></div>
  <div class="flex gap-4 overflow-x-auto pb-1 -mx-5 px-5">
    <?php foreach (array_slice($lencana, -6) as $l): ?>
    <div class="flex-none text-center"><span class="w-14 h-14 rounded-2xl bg-[#FFF2CF] border border-[#FFE29A] grid place-items-center text-[26px]"><?= esc($l['ikon'])?></span><p class="text-[10px] font-bold text-muted mt-1.5 w-14 truncate"><?= esc($l['nama'])?></p></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ($lanjut !== []): ?>
  <div class="flex items-center justify-between mt-6 mb-3"><h2 class="font-display font-bold text-[17px]">Jurnal Terakhir</h2><a href="<?= base_url('siswa/jurnal')?>" class="text-primary text-xs font-bold">Lihat Semua</a></div>
  <div class="bg-white border border-[#F2EEF8] rounded-[22px] shadow-soft divide-y divide-[#F3F0F7] px-4">
    <?php foreach (array_slice($lanjut, 0, 3) as $j): ?>
    <div class="py-3.5 flex items-center gap-3"><span class="w-11 h-12 rounded-xl bg-gradient-to-br from-[#8C7AF4] to-primary grid place-items-center text-xl text-white flex-none"><?= esc($j['perasaan'] ?: '📚')?></span><div class="flex-1 min-w-0"><p class="font-display font-bold text-[13px] truncate"><?= esc($j['judul_buku'])?></p><p class="text-[11px] text-muted mt-0.5"><?= date('d M Y', strtotime($j['tanggal']))?> · <?= (int) $j['durasi_menit']?> menit</p></div><span class="rounded-full px-2.5 py-1 text-[10px] font-bold <?= ['menunggu' => 'bg-[#FFF1D7] text-[#A36C17]', 'terverifikasi' => 'bg-mint text-[#2A816F]', 'revisi' => 'bg-[#FFE7EC] text-[#A23C56]'][$j['status']]?>"><?= esc($j['status'])?></span></div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<!-- ===== AKHIR BERANDA MOBILE ===== -->
<div class="hidden lg:block">
<div class="flex flex-wrap items-end justify-between gap-4 mb-7"><div><p class="text-sm font-semibold text-primary mb-2">Selamat datang kembali 👋</p><h1 class="font-kartun font-bold text-[28px] sm:text-[32px] leading-[1.15]">Halo, <?= esc(session()->get('nama'))?>!</h1><p class="text-muted mt-2 text-base">Siap melanjutkan petualangan membaca hari ini?</p></div><a href="<?= base_url('siswa/jurnal/baru')?>" class="btn bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl px-5 normal-case font-display font-bold shadow-lg shadow-primary/20">+ Catat bacaan</a></div>

<div class="relative overflow-hidden rounded-[28px] bg-primary text-white p-6 sm:p-8 shadow-float mb-6"><img src="<?= base_url('assets/3d/hero-baca.jpg')?>" alt="" class="absolute inset-0 w-full h-full object-cover"><div class="absolute inset-0 bg-gradient-to-r from-[rgba(28,18,80,0.95)] via-[rgba(61,42,180,0.65)] to-transparent"></div><div class="absolute -right-10 -top-16 w-60 h-60 rounded-full border-[30px] border-white/10"></div><div class="absolute right-24 -bottom-24 w-44 h-44 rounded-full border-[20px] border-white/10"></div><div class="relative z-10 sm:max-w-[62%]"><div class="flex items-center gap-2 text-white/70 text-sm font-semibold mb-3"><span class="w-2 h-2 bg-[#FFC857] rounded-full"></span> Misi membaca minggu ini</div><h2 class="font-kartun font-bold text-[26px] sm:text-[32px] leading-[1.18]">Sedikit demi sedikit,<br>jadi kebiasaan hebat.</h2><p class="text-white/75 mt-3 text-sm leading-relaxed">Kamu sudah membaca <?= number_format($stats['total_menit'])?> menit. Yuk, tambah satu cerita lagi!</p><div class="mt-5 flex items-center gap-4"><a href="<?= base_url('siswa/jurnal/baru')?>" class="btn bg-white text-primary hover:bg-white/90 border-0 rounded-xl normal-case font-bold">Mulai membaca</a><span class="text-white/70 text-sm font-semibold">🔥 <?= number_format($stats['streak'])?> hari streak</span></div></div><img src="<?= base_url('assets/3d/maskot.jpg')?>" alt="" class="absolute right-7 bottom-5 h-40 sm:h-48 hidden sm:block rounded-[22px] border-4 border-white/70 shadow-2xl rotate-2"></div>

<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6"><?php $kartu=[['📚',$stats['total_buku'],'Buku dibaca','bg-[#FFF0F5] text-[#D75C83]'],['📖',$stats['total_halaman'],'Total halaman','bg-[#EEF3FF] text-[#5B79D5]'],['⏱',$stats['total_menit'],'Menit membaca','bg-mint text-[#2E927D]'],['🔥',$stats['streak'],'Hari beruntun','bg-[#FFF4D9] text-[#C18A18]']];foreach($kartu as [$ikon,$nilai,$label,$kelas]):?><div class="bg-white rounded-[22px] p-5 shadow-soft border border-[#F2EEF8]"><div class="flex items-start justify-between"><span class="w-11 h-11 rounded-2xl grid place-items-center text-xl <?= $kelas?>"><?= $ikon?></span><span class="text-[#C3BECF]">↗</span></div><p class="font-display font-extrabold text-2xl mt-4"><?= number_format($nilai)?></p><p class="font-semibold text-sm text-muted mt-1"><?= $label?></p></div><?php endforeach;?></div>

<div class="grid xl:grid-cols-5 gap-5"><div class="bg-white rounded-[24px] shadow-soft border border-[#F2EEF8] xl:col-span-3 p-5 sm:p-6"><div class="flex items-center justify-between mb-5"><div><h2 class="font-display font-bold text-[17px]">Aktivitas membaca</h2><p class="text-muted text-sm mt-1">7 hari terakhir</p></div><span class="rounded-full bg-lilac text-primary px-3 py-1.5 text-xs font-bold">Menit</span></div><div class="h-56"><canvas id="grafikBaca"></canvas></div></div>
<div class="bg-white rounded-[24px] shadow-soft border border-[#F2EEF8] xl:col-span-2 p-5 sm:p-6"><div class="flex items-center justify-between mb-5"><div><h2 class="font-display font-bold text-[17px]">Lencana terbaru</h2><p class="text-muted text-sm mt-1">Koleksi pencapaianmu</p></div><a href="<?= base_url('siswa/lencana')?>" class="text-primary text-sm font-bold">Lihat semua</a></div><?php if($lencana===[]):?><div class="bg-cream rounded-2xl p-5 text-center"><div class="text-4xl mb-2">🏅</div><p class="font-bold text-sm">Lencana pertamamu menunggu!</p><p class="text-muted text-xs mt-1">Isi jurnal untuk mulai mengoleksi.</p></div><?php else:?><div class="flex flex-wrap gap-4"><?php foreach(array_slice($lencana,-6) as $l):?><div class="text-center"><span class="w-14 h-14 rounded-2xl bg-[#FFF2CF] border border-[#FFE29A] grid place-items-center text-3xl"><?= esc($l['ikon'])?></span><p class="text-[11px] font-bold text-muted mt-2 max-w-[64px] truncate"><?= esc($l['nama'])?></p></div><?php endforeach;?></div><?php endif;?></div></div>

<div class="bg-white rounded-[24px] shadow-soft border border-[#F2EEF8] mt-5 p-5 sm:p-6"><div class="flex items-center justify-between mb-2"><div><h2 class="font-display font-bold text-[17px]">Jurnal terakhir</h2><p class="text-muted text-sm mt-1">Perjalanan bacaanmu</p></div><a href="<?= base_url('siswa/jurnal')?>" class="text-primary text-sm font-bold">Lihat semua →</a></div><?php if($lanjut===[]):?><div class="py-9 text-center"><p class="text-4xl">🌱</p><p class="font-display font-bold mt-3">Cerita pertamamu dimulai di sini</p><p class="text-muted text-sm mt-1">Catat bacaanmu dan lihat progresnya tumbuh.</p></div><?php else:?><div class="divide-y divide-[#F3F0F7]"><?php foreach($lanjut as $j):?><div class="py-4 flex items-center gap-4"><span class="w-12 h-14 rounded-2xl bg-gradient-to-br from-[#8C7AF4] to-primary grid place-items-center text-2xl text-white shrink-0"><?= esc($j['perasaan']?:'📚')?></span><div class="flex-1 min-w-0"><p class="font-display font-bold truncate"><?= esc($j['judul_buku'])?></p><p class="text-sm text-muted mt-1"><?= date('d M Y',strtotime($j['tanggal']))?> · <?= (int)$j['jumlah_halaman']?> halaman · <?= (int)$j['durasi_menit']?> menit</p></div><?php $badge=['menunggu'=>'bg-[#FFF1D7] text-[#A36C17]','terverifikasi'=>'bg-mint text-[#2A816F]','revisi'=>'bg-[#FFE7EC] text-[#A23C56]'][$j['status']];?><span class="rounded-full px-3 py-1 text-xs font-bold <?= $badge?> hidden sm:inline-flex"><?= esc($j['status'])?></span></div><?php endforeach;?></div><?php endif;?></div>
</div>
<?= $this->endSection()?>
<?= $this->section('scripts')?><script>new Chart(document.getElementById('grafikBaca'),{type:'bar',data:{labels:<?= json_encode($grafik['labels'])?>,datasets:[{data:<?= json_encode($grafik['menit'])?>,backgroundColor:'#D9D2FF',hoverBackgroundColor:'#6956E8',borderRadius:8,maxBarThickness:34}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{displayColors:false,backgroundColor:'#29253D',padding:10,cornerRadius:10}},scales:{y:{beginAtZero:true,grid:{color:'#F2EFF8'},border:{display:false},ticks:{color:'#A7A2B5',font:{family:'DM Sans'}}},x:{grid:{display:false},border:{display:false},ticks:{color:'#A7A2B5',font:{family:'DM Sans',weight:'600'}}}}}});</script><?= $this->endSection()?>