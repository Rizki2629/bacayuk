<?= $this->extend('layout/main')?>
<?= $this->section('content')?>

<div class="flex flex-wrap items-center justify-between gap-3">
  <h1 class="font-display font-extrabold text-3xl"> Kelola User</h1>
  <a href="<?= base_url('admin/users/baru')?>" class="btn bg-bacayuk hover:bg-bacayuk-dark text-white border-0 rounded-xl font-display shadow"> Tambah User</a>
</div>

<div class="card bg-white rounded-xl shadow-kartu mt-5 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="table table-zebra w-full">
      <thead><tr class="font-display"><th>Nama</th><th>Username</th><th>Role</th><th>Kelas</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
      <tbody>
      <?php foreach ($users as $u):?>
        <tr>
          <td class="font-bold whitespace-nowrap"><span class="text-xl mr-1"><?= esc($u['avatar']?: '')?></span><?= esc($u['nama'])?></td>
          <td class="font-semibold">@<?= esc($u['username'])?></td>
          <td><span class="badge border-0 font-bold text-white <?= ['admin' => 'badge-error', 'guru' => 'badge-info', 'siswa' => 'badge-success'][$u['role']]?>"><?= esc($u['role'])?></span></td>
          <td class="font-semibold"><?= esc($u['nama_kelas']?? '—')?></td>
          <td><?= (int) $u['is_active'] === 1? '<span class="badge badge-success text-white border-0 font-bold">aktif</span>': '<span class="badge badge-ghost font-bold">nonaktif</span>'?></td>
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
