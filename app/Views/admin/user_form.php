<?= $this->extend('layout/main')?>
<?= $this->section('content')?>
<?php $u = $user; $aksi = $u? base_url('admin/users/update/'. $u['id']): base_url('admin/users');?>

<h1 class="font-display font-extrabold text-3xl"><?= $u? ' Ubah User': ' Tambah User'?></h1>

<form method="post" action="<?= $aksi?>" class="card bg-white rounded-xl shadow-kartu mt-5">
  <div class="card-body gap-4">
    <?= csrf_field()?>
    <label class="form-control"><span class="label-text font-bold">Nama Lengkap *</span>
      <input type="text" name="nama" required maxlength="100" value="<?= esc(old('nama', $u['nama']?? ''))?>" class="input input-bordered rounded-xl"></label>
    <div class="grid sm:grid-cols-2 gap-4">
      <label class="form-control"><span class="label-text font-bold">Username *</span>
        <input type="text" name="username" required maxlength="50" value="<?= esc(old('username', $u['username']?? ''))?>" class="input input-bordered rounded-xl"></label>
      <label class="form-control"><span class="label-text font-bold">Email</span>
        <input type="email" name="email" maxlength="100" value="<?= esc(old('email', $u['email']?? ''))?>" class="input input-bordered rounded-xl"></label>
    </div>
    <div class="grid sm:grid-cols-3 gap-4">
      <label class="form-control"><span class="label-text font-bold">Role *</span>
        <select name="role" class="select select-bordered rounded-xl">
          <?php foreach (['siswa', 'guru', 'admin'] as $r):?>
            <option value="<?= $r?>" <?= old('role', $u['role']?? 'siswa') === $r? 'selected': ''?>><?= ucfirst($r)?></option>
          <?php endforeach;?>
        </select></label>
      <label class="form-control"><span class="label-text font-bold">Kelas</span>
        <select name="kelas_id" class="select select-bordered rounded-xl">
          <option value="">— Tidak ada —</option>
          <?php foreach ($kelas as $k):?>
            <option value="<?= $k['id']?>" <?= (string) old('kelas_id', $u['kelas_id']?? '') === (string) $k['id']? 'selected': ''?>>Kelas <?= esc($k['nama'])?></option>
          <?php endforeach;?>
        </select></label>
      <label class="form-control"><span class="label-text font-bold">Avatar (emoji)</span>
        <input type="text" name="avatar" maxlength="4" value="<?= esc(old('avatar', $u['avatar']?? ''))?>" class="input input-bordered rounded-xl"></label>
    </div>
    <label class="form-control"><span class="label-text font-bold">Kata Sandi <?= $u? '(kosongkan bila tidak diubah)': '*'?></span>
      <input type="password" name="password" <?= $u? '': 'required'?> minlength="6" class="input input-bordered rounded-xl" placeholder="minimal 6 karakter"></label>
    <?php if ($u):?>
      <label class="label cursor-pointer justify-start gap-3">
        <input type="checkbox" name="is_active" value="1" class="toggle toggle-success" <?= (int) $u['is_active'] === 1? 'checked': ''?>>
        <span class="label-text font-bold">Akun aktif</span>
      </label>
    <?php endif;?>
    <div class="flex gap-3">
      <button class="btn bg-bacayuk hover:bg-bacayuk-dark text-white border-0 rounded-xl font-display text-lg flex-1"> Simpan</button>
      <a href="<?= base_url('admin/users')?>" class="btn btn-ghost rounded-xl font-display">Batal</a>
    </div>
  </div>
</form>
<?= $this->endSection()?>
