<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex flex-wrap items-center justify-between gap-3">
  <h1 class="font-display font-extrabold text-[28px] leading-tight"> Kelola Katalog Buku</h1>
  <a href="<?= base_url('buku/baru')?>" class="btn bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl font-display shadow-lg shadow-primary/20"> Tambah Buku</a>
</div>

<div class="card bg-white rounded-[22px] shadow-kartu mt-5 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead><tr class="font-display"><th>Sampul</th><th>Judul</th><th>Penulis</th><th>Genre</th><th>Halaman</th><th class="text-right">Aksi</th></tr></thead>
      <tbody>
      <?php if ($buku === []):?><tr><td colspan="6" class="text-center font-semibold text-muted py-8"><img src="<?= base_url('assets/3d/kosong.jpg')?>" alt="" class="h-20 mx-auto mb-2">Katalog masih kosong.</td></tr><?php endif;?>
      <?php foreach ($buku as $b):?>
        <tr>
          <td><span class="w-10 h-12 rounded-md grid place-items-center text-xl shadow" style="background: <?= esc($b['warna_sampul'])?>"><?= esc($b['ikon']?: '')?></span></td>
          <td class="font-bold"><?= esc($b['judul'])?></td>
          <td class="font-semibold"><?= esc($b['penulis'])?></td>
          <td><span class="badge bg-bacayuk-soft text-bacayuk border-0 font-bold"><?= esc($b['genre'])?></span></td>
          <td class="font-semibold"><?= (int) $b['jumlah_halaman']?></td>
          <td><div class="flex justify-end gap-2">
            <a href="<?= base_url('buku/edit/'. $b['id'])?>" class="btn btn-sm bg-skyy/20 hover:bg-skyy/40 border-0 rounded-xl font-display font-bold text-[#2B5EA7] text-xs">Ubah</a>
            <form method="post" action="<?= base_url('buku/hapus/'. $b['id'])?>" onsubmit="return confirm('Hapus buku ini dari katalog?')">
              <?= csrf_field()?><button class="btn btn-sm bg-pinky/20 hover:bg-pinky/40 border-0 rounded-xl font-display font-bold text-[#A23C56] text-xs">Hapus</button>
            </form>
          </div></td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection()?>
