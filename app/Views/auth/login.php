<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — BacaYuk</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { theme: { extend: { colors: { bacayuk: '#2563EB', navy: '#173A5E', krem: '#F5F7FA', ink: '#1F2A37' }, fontFamily: { display: ['"Plus Jakarta Sans"','sans-serif'], body: ['"Plus Jakarta Sans"','sans-serif'] } } } }
</script>
<style>body{font-family:'Plus Jakarta Sans',sans-serif}.font-display{font-family:'Plus Jakarta Sans',sans-serif}</style>
</head>
<body class="bg-krem min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-md">
    <div class="text-center mb-6">
      <img src="<?= base_url('assets/ilustrasi/book-lover.svg')?>" alt="Ilustrasi anak membaca buku" class="h-36 mx-auto mb-3">
      <div class="inline-grid place-items-center w-14 h-14 rounded-xl bg-bacayuk text-white mb-3">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1.8-1.6-4-2-8-2v14c4 0 6.2.4 8 2 1.8-1.6 4-2 8-2V4c-4 0-6.2.4-8 2Z"/><path d="M12 6v14"/></svg>
      </div>
      <h1 class="font-display font-extrabold text-3xl text-navy">BacaYuk</h1>
      <p class="text-slate-500 mt-1">Jurnal membaca untuk siswa dan guru</p>
    </div>

    <div class="card bg-white border border-slate-200 shadow-sm rounded-xl">
      <form method="post" action="<?= base_url('login')?>" class="card-body gap-4">
        <?= csrf_field()?>
        <h2 class="font-display font-bold text-xl text-ink">Masuk ke akun Anda</h2>

        <?php if (session()->getFlashdata('error')):?>
          <div class="alert alert-error rounded-xl font-medium text-sm"><span><?= esc(session()->getFlashdata('error'))?></span></div>
        <?php endif;?>
        <?php if (session()->getFlashdata('success')):?>
          <div class="alert alert-success rounded-xl font-medium text-sm"><span><?= esc(session()->getFlashdata('success'))?></span></div>
        <?php endif;?>

        <label class="form-control">
          <span class="label-text font-semibold">Username</span>
          <input type="text" name="username" value="<?= esc(old('username'))?>" required autofocus
                 class="input input-bordered rounded-lg" placeholder="contoh: siswa">
        </label>
        <label class="form-control">
          <span class="label-text font-semibold">Kata Sandi</span>
          <input type="password" name="password" required
                 class="input input-bordered rounded-lg" placeholder="••••••••">
        </label>
        <button class="btn bg-bacayuk hover:bg-[#1D4ED8] text-white border-0 rounded-lg font-semibold text-base normal-case">Masuk</button>
      </form>
    </div>

    <div class="card bg-white border border-slate-200 mt-4 rounded-xl">
      <div class="card-body py-4">
        <p class="font-semibold text-sm text-ink">Akun demo</p>
        <div class="grid grid-cols-3 gap-2 text-center text-sm mt-1">
          <div class="border border-slate-200 rounded-lg py-2 px-1"><span class="font-semibold text-slate-600">Admin</span><br><span class="text-slate-500 text-xs">admin / admin123</span></div>
          <div class="border border-slate-200 rounded-lg py-2 px-1"><span class="font-semibold text-slate-600">Guru</span><br><span class="text-slate-500 text-xs">guru / guru123</span></div>
          <div class="border border-slate-200 rounded-lg py-2 px-1"><span class="font-semibold text-slate-600">Siswa</span><br><span class="text-slate-500 text-xs">siswa / siswa123</span></div>
        </div>
      </div>
    </div>

    <p class="text-center text-xs text-slate-400 mt-6">SDN Grogol Utara 09 — Kelas IV</p>
  </div>
</body>
</html>
