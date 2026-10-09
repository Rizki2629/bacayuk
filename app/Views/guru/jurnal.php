<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<h1 class="font-display font-extrabold text-3xl"> <?= esc($judul)?></h1>

<div class="card bg-white rounded-[22px] shadow-kartu mt-5 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead><tr class="font-display">
        <th>Tanggal</th><th>Siswa</th><?php if (isset($daftar[0]['nama_kelas'])):?><th>Kelas</th><?php endif;?>
        <th>Buku</th><th>Halaman</th><th>Menit</th><th>Bintang</th><th>Status</th>
      </tr></thead>
      <tbody>
      <?php if ($daftar === []):?>
        <tr><td colspan="8" class="text-center font-semibold text-muted py-8">Belum ada jurnal.</td></tr>
      <?php endif;?>
      <?php foreach ($daftar as $j):?>
        <tr>
          <td class="whitespace-nowrap font-semibold"><?= date('d M Y', strtotime($j['tanggal']))?></td>
          <td class="whitespace-nowrap"><span class="text-xl mr-1"><?= esc($j['avatar']?? '')?></span><span class="font-bold"><?= esc($j['nama_siswa']?? '-')?></span></td>
          <?php if (isset($j['nama_kelas'])):?><td><?= esc($j['nama_kelas']?? '-')?></td><?php endif;?>
          <td class="font-semibold"><?= esc($j['judul_buku'])?></td>
          <td><?= (int) $j['jumlah_halaman']?></td>
          <td><?= (int) $j['durasi_menit']?></td>
          <td class="text-amber-500"><?= str_repeat('★', (int) $j['rating'])?></td>
          <td><?php $b = ['menunggu' => 'badge-warning', 'terverifikasi' => 'badge-success', 'revisi' => 'badge-error'][$j['status']];?>
            <span class="badge <?= $b?> text-white border-0 font-bold"><?= esc($j['status'])?></span></td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection()?>
