<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex flex-wrap items-center justify-between gap-3">
  <h1 class="font-display font-extrabold text-[28px] leading-tight">Kelola User</h1>
  <a href="<?= base_url('admin/users/baru')?>" class="btn bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl font-display shadow-lg shadow-primary/20"> Tambah User</a>
</div>

<div class="card bg-white rounded-[22px] shadow-kartu mt-5 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="table w-full">
      <thead><tr class="font-display"><th>Nama</th><th>Username</th><th>Role</th><th>Kelas</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
      <tbody>
      <?php foreach ($users as $u):?>
        <tr>
          <td class="font-bold whitespace-nowrap"><span class="text-xl mr-1"><?= esc($u['avatar']?: '')?></span><?= esc($u['nama'])?></td>
          <td class="font-semibold">@<?= esc($u['username'])?></td>
          <td><span class="badge border-0 font-bold rounded-full px-3 <?= ['admin' => 'bg-[#FFE7EC] text-[#A23C56]', 'guru' => 'bg-[#EEF3FF] text-[#5B79D5]', 'siswa' => 'bg-mint text-[#2A816F]'][$u['role']]?>"><?= esc($u['role'])?></span></td>
          <td class="font-semibold"><?= esc($u['nama_kelas']?? '—')?></td>
          <td><?= (int) $u['is_active'] === 1? '<span class="badge bg-mint text-[#2A816F] border-0 font-bold rounded-full px-3">aktif</span>': '<span class="badge bg-[#F1EFF7] text-[#817D92] border-0 font-bold rounded-full px-3">nonaktif</span>'?></td>
          <td><div class="flex justify-end gap-2">
            <a href="<?= base_url('admin/users/edit/'. $u['id'])?>" class="btn btn-sm bg-skyy/20 hover:bg-skyy/40 border-0 rounded-xl font-display"></a>
            <form method="post" action="<?= base_url('admin/users/hapus/'. $u['id'])?>" onsubmit="return confirm('Hapus user ini? Jurnalnya ikut terhapus.')">
              <?= csrf_field()?><button class="btn btn-sm bg-pinky/20 hover:bg-pinky/40 border-0 rounded-xl font-display"></button>
            </form>
          </div></td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection()?>
