<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"><title>Baca: <?= esc($buku['judul'])?> — BacaYuk</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet"><script src="<?= base_url('assets/js/tailwind-play.js')?>"></script><style>*{box-sizing:border-box}body{margin:0;font-family:'DM Sans',sans-serif}.font-display{font-family:'Plus Jakarta Sans',sans-serif}.font-kartun{font-family:'Baloo 2',ui-rounded,system-ui}.putar{width:44px;height:44px;border-radius:50%;border:4px solid rgba(255,255,255,.18);border-top-color:#F5B942;animation:pusing 0.9s linear infinite}@keyframes pusing{to{transform:rotate(360deg)}}.stf__parent{margin:0 auto}.page{background:#fff;overflow:hidden}.page img{width:100%;height:100%;display:block;object-fit:cover;-webkit-user-drag:none;user-select:none}</style>
<script src="<?= base_url('assets/js/lib/pdf.min.js')?>"></script>
<script src="<?= base_url('assets/js/lib/page-flip.browser.min.js')?>"></script>
</head>
<body class="bg-[#1D1830] text-white">
<div id="pembungkus" class="flex h-dvh flex-col bg-[#1D1830]">
<header class="z-20 flex items-center gap-2.5 px-3.5 py-3 sm:gap-3 sm:px-6">
<a href="<?= esc($kembali)?>" aria-label="Kembali ke katalog" class="grid size-10 shrink-0 place-items-center rounded-full bg-white/10 transition hover:bg-white/20"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg></a>
<div class="min-w-0 flex-1">
<h1 class="truncate font-display text-[15px] font-bold leading-tight sm:text-base"><?= esc($buku['judul'])?></h1>
<p class="truncate text-xs text-white/55"><?= esc($buku['penulis'] ?: 'Tanpa penulis')?> · <span id="info-halaman"><?php if ($adalahPdf):?>Menyiapkan buku…<?php else:?>Pratinjau buku<?php endif;?></span></p>
</div>
<?php if ($role === 'siswa'):?><a href="<?= base_url('siswa/jurnal/baru?buku_id=' . $buku['id'])?>" class="hidden shrink-0 items-center gap-1.5 rounded-full bg-[#F5B942] px-4 py-2 font-display text-[13px] font-bold text-[#29253D] transition hover:brightness-105 sm:inline-flex">✎ Isi Jurnal</a><?php endif;?>
<?php if (! empty($buku['tautan_pdf'])):?><a href="<?= esc($buku['tautan_pdf'])?>" target="_blank" rel="noopener" class="shrink-0 rounded-full bg-white/10 px-3.5 py-2 font-display text-[13px] font-bold transition hover:bg-white/20">PDF Asli</a><?php endif;?>
<button id="btn-layar" aria-label="Layar penuh" class="grid size-10 shrink-0 place-items-center rounded-full bg-white/10 transition hover:bg-white/20"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg></button>
</header>

<?php if ($adalahPdf):?>
<main id="panggung" class="relative flex-1 overflow-hidden">
<div class="absolute inset-0 px-1.5 pb-2 sm:px-4"><div id="buku-flip" class="h-full w-full"></div></div>
<div id="memuat" class="absolute inset-0 z-10 grid place-items-center bg-[#1D1830]/85 px-6">
<div class="w-full max-w-[300px] text-center">
<?php if (! empty($buku['sampul_url'])):?><img src="<?= esc($buku['sampul_url'])?>" alt="Sampul <?= esc($buku['judul'])?>" class="mx-auto mb-5 w-32 rounded-lg shadow-2xl"><?php endif;?>
<div class="putar mx-auto"></div>
<p id="teks-muat" class="mt-4 font-display text-sm font-bold">Mengunduh buku…</p>
<div class="mt-3 h-2 overflow-hidden rounded-full bg-white/12"><div id="bilah-muat" class="h-full w-0 rounded-full bg-[#F5B942] transition-all duration-300"></div></div>
<p class="mt-2.5 text-xs text-white/50">Buku besar butuh waktu lebih lama — jangan tutup halaman ini.</p>
</div>
</div>
<div id="gagal" class="absolute inset-0 z-10 hidden place-items-center bg-[#1D1830]/92 px-6">
<div class="w-full max-w-[340px] rounded-3xl bg-white p-6 text-center text-[#29253D]">
<p class="font-kartun text-xl font-bold">Yah, bukunya gagal dibuka 😢</p>
<p class="mt-2 text-sm leading-relaxed text-[#6F6A7D]">Koneksi atau berkas PDF-nya sedang bermasalah. Coba lagi, atau buka PDF aslinya langsung.</p>
<div class="mt-5 grid gap-2">
<button id="btn-ulang" class="h-11 rounded-xl bg-[#6554E8] font-display text-sm font-bold text-white">Coba Lagi</button>
<a href="<?= esc($buku['tautan_pdf'])?>" target="_blank" rel="noopener" class="grid h-11 place-items-center rounded-xl bg-[#F1EEFF] font-display text-sm font-bold text-[#6554E8]">Buka PDF Asli</a>
<a href="<?= esc($kembali)?>" class="grid h-11 place-items-center rounded-xl font-display text-sm font-bold text-[#6F6A7D]">Kembali ke Katalog</a>
</div>
</div>
</div>
</main>
<footer class="z-20 px-3.5 pb-4 pt-1 sm:px-6">
<div class="mx-auto mb-3 h-1 max-w-[560px] overflow-hidden rounded-full bg-white/12"><div id="bilah-baca" class="h-full w-0 rounded-full bg-[#6554E8] transition-all duration-300"></div></div>
<div class="mx-auto flex max-w-[560px] items-center justify-between gap-3">
<button id="btn-sebelum" class="inline-flex h-11 items-center gap-1 rounded-full bg-white/10 px-4 font-display text-sm font-bold transition hover:bg-white/20 disabled:opacity-35" disabled><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg><span class="hidden sm:inline">Sebelumnya</span></button>
<span id="nomor-halaman" class="font-display text-sm font-bold text-white/75">–</span>
<button id="btn-berikut" class="inline-flex h-11 items-center gap-1 rounded-full bg-[#6554E8] px-4 font-display text-sm font-bold shadow-lg shadow-[#6554E8]/30 transition hover:bg-[#5847D8] disabled:opacity-35" disabled><span class="hidden sm:inline">Berikutnya</span><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"/></svg></button>
</div>
<?php if ($role === 'siswa'):?><a href="<?= base_url('siswa/jurnal/baru?buku_id=' . $buku['id'])?>" class="mx-auto mt-3 flex h-11 max-w-[560px] items-center justify-center rounded-full bg-[#F5B942] font-display text-sm font-bold text-[#29253D] sm:hidden">✎ Selesai membaca? Isi Jurnal</a><?php endif;?>
</footer>
<script>
const URL_PDF = <?= json_encode($buku['tautan_pdf'])?>;
pdfjsLib.GlobalWorkerOptions.workerSrc = '<?= base_url('assets/js/lib/pdf.worker.min.js')?>';
let flip = null;
const $ = id => document.getElementById(id);
function aturMuat(persen, teks){ $('bilah-muat').style.width = persen + '%'; if (teks) $('teks-muat').textContent = teks; }
function perbaruiKendali(){
  if (!flip) return;
  const idx = flip.getCurrentPageIndex(), total = flip.getPageCount();
  const land = flip.getOrientation() === 'landscape';
  let teks = 'Halaman ' + (idx + 1);
  if (land && idx + 2 <= total && idx > 0) teks += '–' + (idx + 2);
  $('nomor-halaman').textContent = teks + ' dari ' + total;
  $('info-halaman').textContent = teks + ' dari ' + total + ' halaman';
  $('bilah-baca').style.width = (total > 1 ? ((idx + 1) / total) * 100 : 100) + '%';
  $('btn-sebelum').disabled = idx <= 0;
  $('btn-berikut').disabled = idx >= total - 1;
}
async function muatBuku(){
  $('gagal').classList.add('hidden'); $('gagal').classList.remove('grid');
  $('memuat').classList.remove('hidden');
  try {
    const tugas = pdfjsLib.getDocument({url: URL_PDF});
    tugas.onProgress = p => { if (p.total) aturMuat(Math.round(p.loaded / p.total * 55), 'Mengunduh buku… ' + Math.round(p.loaded / p.total * 100) + '%'); };
    const doc = await tugas.promise;
    const total = doc.numPages;
    const gambar = [];
    let lebarH = 1500, tinggiH = 2122;
    for (let i = 1; i <= total; i++){
      const hal = await doc.getPage(i);
      const dasar = hal.getViewport({scale: 1});
      const skala = Math.min(1500 / dasar.width, 2100 / dasar.height);
      const vp = hal.getViewport({scale: skala});
      if (i === 1){ lebarH = Math.round(vp.width); tinggiH = Math.round(vp.height); }
      const kanvas = document.createElement('canvas');
      kanvas.width = Math.round(vp.width); kanvas.height = Math.round(vp.height);
      await hal.render({canvasContext: kanvas.getContext('2d'), viewport: vp}).promise;
      const webp = kanvas.toDataURL('image/webp', 0.9);
      gambar.push(webp.startsWith('data:image/webp') ? webp : kanvas.toDataURL('image/jpeg', 0.92));
      aturMuat(55 + Math.round(i / total * 45), 'Menyiapkan halaman ' + i + ' dari ' + total + '…');
    }
    const wadah = $('buku-flip');
    if (flip) { flip.destroy(); flip = null; }
    wadah.innerHTML = '';
    for (const g of gambar) {
      const d = document.createElement('div');
      d.className = 'page';
      const im = document.createElement('img');
      im.src = g; im.alt = 'Halaman buku'; im.draggable = false;
      d.appendChild(im);
      wadah.appendChild(d);
    }
    flip = new St.PageFlip(wadah, {
      width: lebarH, height: tinggiH, size: 'stretch',
      minWidth: 280, maxWidth: 1700, minHeight: 360, maxHeight: 2400,
      drawShadow: true, flippingTime: 650, usePortrait: true,
      startZIndex: 5, autoSize: true, maxShadowOpacity: 0.35,
      showCover: true, mobileScrollSupport: false, swipeDistance: 24,
      clickEventForward: true, useMouseEvents: true, showPageCorners: true, disableFlipByClick: false
    });
    flip.loadFromHTML(wadah.querySelectorAll('.page'));
    flip.on('flip', perbaruiKendali);
    flip.on('changeOrientation', perbaruiKendali);
    flip.on('init', () => { $('memuat').classList.add('hidden'); perbaruiKendali(); });
    setTimeout(() => { $('memuat').classList.add('hidden'); perbaruiKendali(); }, 600);
  } catch (e) {
    $('memuat').classList.add('hidden');
    $('gagal').classList.remove('hidden'); $('gagal').classList.add('grid');
  }
}
$('btn-sebelum').addEventListener('click', () => flip && flip.flipPrev('bottom'));
$('btn-berikut').addEventListener('click', () => flip && flip.flipNext('bottom'));
$('btn-ulang').addEventListener('click', muatBuku);
document.addEventListener('keydown', e => { if (!flip) return; if (e.key === 'ArrowRight') flip.flipNext('bottom'); if (e.key === 'ArrowLeft') flip.flipPrev('bottom'); });
$('btn-layar').addEventListener('click', () => { const el = $('pembungkus'); if (document.fullscreenElement) document.exitFullscreen(); else if (el.requestFullscreen) el.requestFullscreen(); });
muatBuku();
</script>
<?php else:?>
<main class="grid flex-1 place-items-center px-5 py-10">
<div class="w-full max-w-[380px] rounded-[28px] bg-white p-7 text-center text-[#29253D]">
<?php if (! empty($buku['sampul_url'])):?><img src="<?= esc($buku['sampul_url'])?>" alt="Sampul <?= esc($buku['judul'])?>" class="mx-auto w-40 rounded-xl shadow-lg"><?php endif;?>
<p class="font-kartun mt-5 text-[22px] font-bold leading-snug"><?= esc($buku['judul'])?></p>
<p class="mt-1.5 text-sm text-[#6F6A7D]"><?= esc($buku['penulis'] ?: '')?></p>
<?php if (! empty($buku['tautan_pdf'])):?>
<p class="mt-4 text-sm leading-relaxed text-[#6F6A7D]">Buku ini dibaca langsung di situs penerbitnya, jadi belum bisa dibuka sebagai flipbook di sini.</p>
<a href="<?= esc($buku['tautan_pdf'])?>" target="_blank" rel="noopener" class="mt-5 grid h-12 place-items-center rounded-2xl bg-[#6554E8] font-display text-[15px] font-bold text-white">Baca Online di Penerbit →</a>
<?php else:?>
<p class="mt-4 text-sm leading-relaxed text-[#6F6A7D]">Buku ini belum mempunyai tautan baca. Mintalah bantuan Pak Guru untuk menambahkannya.</p>
<?php endif;?>
<a href="<?= esc($kembali)?>" class="mt-3 grid h-12 place-items-center rounded-2xl bg-[#F1EEFF] font-display text-[15px] font-bold text-[#6554E8]">Kembali ke Katalog</a>
</div>
</main>
<?php endif;?>
</div>
</body></html>
