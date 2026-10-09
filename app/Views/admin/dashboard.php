<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<!-- ===== BERANDA MOBILE ADMIN ===== -->
<div class="lg:hidden">
  <div class="relative overflow-hidden rounded-[26px] bg-gradient-to-br from-primary to-primary-dark text-white p-5 shadow-float">
    <div class="absolute -right-8 -top-12 w-40 h-40 rounded-full bg-white/10"></div>
    <div class="relative z-10">
      <p class="text-white/75 text-[13px] font-semibold">Panel pengelola</p>
      <h1 class="font-display font-extrabold text-[22px] leading-tight">Hai, Admin! 👋</h1>
      <p class="text-white/75 text-[13px] mt-1">Ringkasan seluruh aktivitas membaca di sekolah.</p>
      <div class="grid grid-cols-4 gap-2.5 mt-4">
        <?php foreach ([[$ringkas['users'], 'User'], [$ringkas['siswa'], 'Siswa'], [$ringkas['buku'], 'Buku'], [$ringkas['jurnal'], 'Jurnal']] as [$n, $lb]):?>
        <div class="bg-white/12 rounded-2xl py-3 text-center"><p class="font-display font-extrabold text-lg leading-none"><?= (int) $n?></p><p class="text-[10px] font-bold text-white/75 mt-1.5"><?= $lb?></p></div>
        <?php endforeach;?>
      </div>
      <?php if (($ringkas['menunggu'] ?? 0) > 0):?><a href="<?= base_url('admin/jurnal')?>" class="btn w-full mt-4 bg-white text-primary hover:bg-white/90 border-0 rounded-2xl normal-case font-display font-bold">Ada <?= (int) $ringkas['menunggu']?> jurnal menunggu verifikasi</a><?php endif;?>
    </div>
  </div>
  <h2 class="font-display font-extrabold text-[15px] mt-6 mb-3">Aksi Cepat</h2>
  <div class="grid grid-cols-3 gap-2.5">
    <a href="<?= base_url('admin/users/baru')?>" class="bg-white border border-[#F2EEF8] rounded-2xl shadow-soft py-4 text-center"><span class="text-[22px] block">👤</span><span class="text-xs font-bold">Tambah User</span></a>
    <a href="<?= base_url('admin/kelas/baru')?>" class="bg-white border border-[#F2EEF8] rounded-2xl shadow-soft py-4 text-center"><span class="text-[22px] block">🏫</span><span class="text-xs font-bold">Tambah Kelas</span></a>
    <a href="<?= base_url('buku/baru')?>" class="bg-white border border-[#F2EEF8] rounded-2xl shadow-soft py-4 text-center"><span class="text-[22px] block">📚</span><span class="text-xs font-bold">Tambah Buku</span></a>
  </div>
</div>
<!-- ===== AKHIR BERANDA MOBILE ADMIN ===== -->
<div class="hidden lg:block">

<h1 class="font-display font-extrabold text-3xl">Halo, Admin! </h1>
<p class="text-muted font-semibold mt-1">Ringkasan seluruh aktivitas membaca di sekolah.</p>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
  <?php foreach ([
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><circle cx="17" cy="9" r="2.6"/><path d="M16.5 15.2c2.3.3 3.6 1.9 4 4.3"/></svg>', $ringkas['users'], 'Total User', 'bg-[#EEF3FF] text-[#5B79D5]'],
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><circle cx="17" cy="9" r="2.6"/><path d="M16.5 15.2c2.3.3 3.6 1.9 4 4.3"/></svg>', $ringkas['guru'], 'Guru', 'bg-mint text-[#2E927D]'],
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.6"/><path d="M5 20.5c.8-3.8 3.6-5.7 7-5.7s6.2 1.9 7 5.7"/></svg>', $ringkas['siswa'], 'Siswa', 'bg-[#FFF0F5] text-[#D75C83]'],
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V8.5L12 4l7 4.5V21M9.5 21v-4.5h5V21M12 8v2"/></svg>', $ringkas['kelas'], 'Kelas', 'bg-[#FFF4D9] text-[#C18A18]'],
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2 8-2V4c-4 0-6.2.4-8 2Z"/><path d="M12 6v14"/></svg>', $ringkas['buku'], 'Buku di Katalog', 'bg-lilac text-primary'],
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h13v18H6.5A2.5 2.5 0 0 1 4 18.5v-13A2.5 2.5 0 0 1 6 3Z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H19M8.5 8h7M8.5 11.5h5"/></svg>', $ringkas['jurnal'], 'Total Jurnal', 'bg-[#EEF3FF] text-[#5B79D5]'],
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>', $ringkas['menunggu'], 'Menunggu Verifikasi', 'bg-[#FFF4D9] text-[#C18A18]'],
      ['<svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5.5"/><path d="m8.8 13.5-1.6 7 4.8-2.6 4.8 2.6-1.6-7"/></svg>', $ringkas['lencana'], 'Definisi Lencana', 'bg-mint text-[#2E927D]'],
  ] as [$i, $n, $l, $c]):?>
  <div class="card bg-white rounded-[22px] shadow-kartu"><div class="card-body p-5">
    <span class="w-11 h-11 rounded-2xl grid place-items-center <?= $c?>"><?= $i?></span>
    <p class="font-display font-extrabold text-3xl mt-2"><?= (int) $n?></p>
    <p class="font-bold text-muted text-sm"><?= $l?></p>
  </div></div>
  <?php endforeach;?>
</div>

<div class="grid lg:grid-cols-2 gap-4 mt-4">
  <div class="card bg-white rounded-[22px] shadow-kartu"><div class="card-body p-5">
    <h2 class="font-display font-bold text-xl"> Daftar Kelas</h2>
    <ul class="divide-y">
      <?php foreach ($kelas as $k):?>
        <li class="py-2 flex justify-between font-semibold"><span>Kelas <?= esc($k['nama'])?> (Tingkat <?= (int) $k['tingkat']?>)</span><span class="text-muted"><?= esc($k['nama_guru']?? '— belum ada wali —')?></span></li>
      <?php endforeach;?>
      <?php if ($kelas === []):?><li class="py-2 font-semibold text-muted">Belum ada kelas.</li><?php endif;?>
    </ul>
  </div></div>
  <div class="card bg-white rounded-[22px] shadow-kartu"><div class="card-body p-5">
    <h2 class="font-display font-bold text-xl"> Aktivitas Jurnal Terbaru</h2>
    <ul class="divide-y">
      <?php foreach ($aktivitas as $j):?>
        <li class="py-2 font-semibold text-sm"><b><?= esc($j['nama_siswa'])?></b> membaca <b><?= esc($j['judul_buku'])?></b>
          <span class="text-muted">• <?= date('d M', strtotime($j['tanggal']))?> • <?= esc($j['status'])?></span></li>
      <?php endforeach;?>
      <?php if ($aktivitas === []):?><li class="py-2 font-semibold text-muted">Belum ada aktivitas.</li><?php endif;?>
    </ul>
  </div></div>
</div>
</div>
<?= $this->endSection()?>
