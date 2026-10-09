# BacaYuk! — Design System

Dokumen acuan desain untuk seluruh view BacaYuk! (CodeIgniter 4 + Tailwind Play + DaisyUI).
Bahasa desain yang berlaku adalah **redesign Manus**: ungu premium di atas krem hangat,
tipografi Plus Jakarta Sans + DM Sans, kartu besar membulat, bayangan lembut, ikon garis SVG.

Referensi utama (sumber kebenaran):

| File | Peran |
|---|---|
| `app/Views/layout/main.php` | Kerangka aplikasi: `tailwind.config`, CSS sistem, sidebar, header, pola flash message |
| `app/Views/auth/login.php` | Halaman login split-screen Manus (standalone, tidak memakai layout) |
| `app/Views/siswa/dashboard.php` | Dashboard siswa Manus: hero misi, kartu statistik pastel, grafik, badge status |

Aturan praktis: **kalau ragu, tiru ketiga file di atas.** Halaman lain menyesuaikan ke pola di dokumen ini.

---

## 1. Warna

### 1.1 Token inti (di `tailwind.config`, layout/main.php)

| Token | Hex | Pemakaian |
|---|---|---|
| `primary` | `#6956E8` | Warna merek utama: tombol primer, menu aktif, hero, tautan aksi, grafik |
| `primary-dark` | `#5542D0` | Hover tombol primer |
| `gold` / `mustard` | `#F5B942` | Aksen prestasi: streak, lencana, tombol sekunder emas ("Mulai Membaca", "Periksa") |
| `cream` / `krem` | `#FFF9F0` | Latar halaman (body) dan ubin netral |
| `ink` | `#29253D` | Teks utama, tooltip grafik |
| `muted` | `#817D92` | Teks sekunder: subjudul, label, meta |
| `lilac` | `#F1EEFF` | Latar aksen lembut: panel motivasi sidebar, badge genre, chip ilustrasi, hover menu |
| `mint` | `#E7F7F2` | Latar sukses: flash success, badge terverifikasi, chip statistik hijau |
| `peach` | `#FFF0E8` | Latar aksen hangat (cadangan, jarang dipakai) |
| `minty` | `#2E927D` | Teks/ikon hijau di atas chip pastel (statistik, status sukses) |
| `pinky` | `#D75C83` | Aksen merah muda: chip statistik siswa, tombol hapus lembut |
| `skyy` | `#5B84AE` | Aksen biru baja: tombol "Ubah" lembut, chip statistik biru |

### 1.2 Warna pendukung (belum jadi token — dipakai sebagai hex langsung)

| Hex | Peran saat ini |
|---|---|
| `#FCFAFF` | Isi kolom input; hover baris tabel |
| `#E4DFEE` | Border input |
| `#D9D2FF` | Fokus input, batang grafik non-hover, scrollbar, bayangan teks |
| `#F2EEF8` | Border kartu standar |
| `#EEEAF6` / `#F0EBF7` | Garis pemisah header & tabel |
| `#A7A2B5` | Teks tersier: label grafik, header tabel |
| `#AAA5B8` / `#B0AABD` | Teks footer & label seksi sidebar |
| `#8C7AF4` → `primary` | Gradasi ubin jurnal terakhir (dashboard siswa) |
| `#FFD36A` / `#FFC857` | Emas terang di panel ungu (login, titik misi) |

### 1.3 Palet pastel chip statistik (pola Manus, dashboard siswa)

| Pasangan latar + teks | Dipakai untuk |
|---|---|
| `bg-[#FFF0F5] text-[#D75C83]` | Buku / siswa (pinky) |
| `bg-[#EEF3FF] text-[#5B79D5]` | Halaman / total (biru) |
| `bg-mint text-[#2E927D]` | Menit / guru (hijau) |
| `bg-[#FFF4D9] text-[#C18A18]` | Streak / menunggu (emas) |
| `bg-lilac text-primary` | Buku di katalog (admin) |

### 1.4 Warna status jurnal (satu-satunya definisi resmi)

| Status | Kelas badge |
|---|---|
| `menunggu` | `bg-[#FFF1D7] text-[#A36C17]` |
| `terverifikasi` | `bg-mint text-[#2A816F]` |
| `revisi` | `bg-[#FFE7EC] text-[#A23C56]` |

Pasangan flash message di layout mengikuti keluarga yang sama:
sukses `bg-mint text-[#247A68]`, error `bg-[#FFE7EC] text-[#A23C56]`, peringatan/daftar error `bg-[#FFF1D7] text-[#9A681B]`.

### 1.5 Alias lama (jangan dipakai di kode baru)

Token berikut dipertahankan di config hanya agar view lama tidak rusak.
Di kode baru gunakan padanan modernnya:

| Alias lama | Ganti dengan |
|---|---|
| `bacayuk` | `primary` |
| `bacayuk-dark` | `primary-dark` |
| `bacayuk-soft` | `lilac` |
| `krem` | `cream` |
| `navy` | `ink` |
| `mustard` | `gold` |

---

## 2. Tipografi

Dua font dimuat dari Google Fonts di layout **dan** login (login standalone, muat sendiri):

| Font | Token | Bobot dimuat | Pemakaian |
|---|---|---|---|
| Plus Jakarta Sans | `font-display` | 500–800 | Judul halaman, angka statistik, nama merek, tombol, judul kartu |
| DM Sans | `font-body` / body default | 400–700 | Seluruh teks isi |

Skala yang dipakai:

| Elemen | Kelas acuan |
|---|---|
| Judul halaman (H1) | `font-display font-extrabold text-3xl` (dashboard siswa: `sm:text-[2.6rem] tracking-tight`) |
| Judul seksi/kartu (H2) | `font-display font-bold text-xl` (di kartu Manus: `text-lg`) |
| Judul kartu kecil (H3) | `font-display font-bold text-lg` |
| Angka statistik | `font-display font-extrabold text-3xl` (kartu siswa Manus: `text-2xl`) |
| Subjudul halaman | `text-muted font-semibold mt-1` |
| Label meta kecil | `text-sm text-muted font-semibold` |
| Eyebrow (di atas judul) | `text-xs font-bold uppercase tracking-[.14em–.18em]` |
| Label seksi sidebar | `text-[10px] uppercase tracking-[.16em] font-bold text-[#B0AABD]` |

---

## 3. Radius & bayangan

### 3.1 Skala radius

| Nilai | Pemakaian resmi |
|---|---|
| `rounded-[28px]` | Hero/pita besar (hero misi dashboard siswa) |
| `rounded-[26px]` | Kartu formulir login |
| `rounded-[24px]` | Kartu konten besar Manus (grafik, lencana, jurnal terakhir) |
| `rounded-[22px]` | **Kartu standar** di semua halaman non-Manus (DaisyUI `.card`) |
| `rounded-2xl` (16px) | Tombol, input, ubin ikon, panel kecil, alert |
| `rounded-xl` (12px) | Elemen kecil lama: tombol `btn-sm`, ubin di dalam daftar |
| `rounded-full` | Badge status, chip filter genre, avatar, titik indikator |

### 3.2 Bayangan (token di config)

| Token | Nilai | Pemakaian |
|---|---|---|
| `shadow-soft` | `0 10px 35px rgba(57,45,112,.07)` | Bayangan kartu standar Manus |
| `shadow-kartu` | identik dengan soft (kelas CSS di layout) | Bayangan kartu standar halaman non-Manus |
| `shadow-float` | `0 20px 50px rgba(74,61,158,.15)` | Elemen melayang: hero misi |
| `shadow-lg shadow-primary/20` | bayangan berwarna ungu | Tombol primer & logo sidebar |

Border kartu selalu menyertai bayangan: `border border-[#F2EEF8]`
(layout juga memaksa `.card{border:1px solid #F2EEF8}` secara global).

---

## 4. Pola komponen

### 4.1 Kartu standar

```html
<div class="card bg-white rounded-[22px] shadow-kartu">
  <div class="card-body p-5"> … </div>
</div>
```

Varian Manus (tanpa `.card`, untuk halaman yang dirancang khusus):

```html
<div class="bg-white rounded-[24px] shadow-soft border border-[#F2EEF8] p-5 sm:p-6"> … </div>
```

### 4.2 Kartu statistik

Pola Manus (dashboard siswa) — ubin ikon pastel + panah ↗ + angka besar:

```html
<div class="bg-white rounded-[22px] p-5 shadow-soft border border-[#F2EEF8]">
  <span class="w-11 h-11 rounded-2xl grid place-items-center text-xl bg-[#FFF0F5] text-[#D75C83]">[ikon]</span>
  <p class="font-display font-extrabold text-2xl mt-4">128</p>
  <p class="font-semibold text-sm text-muted mt-1">Buku dibaca</p>
</div>
```

Pola ringkas (guru/admin, memakai `.card` + ikon SVG 21–22px di dalam `.card-body p-5`,
angka `text-3xl`). Pasangan warna chip mengikuti tabel 1.3.

### 4.3 Tombol

| Jenis | Kelas acuan | Contoh pemakaian |
|---|---|---|
| Primer | `btn bg-primary hover:bg-primary-dark text-white border-0 rounded-2xl font-display font-bold shadow-lg shadow-primary/20 normal-case` | "Jurnal Baru", "+ Catat bacaan", submit form |
| Primer login | sama, ditambah `w-full h-12 min-h-12` | "Masuk ke BacaYuk →" |
| Sekunder putih | `btn bg-white text-primary hover:bg-white/90 border-0 rounded-xl font-bold normal-case` | CTA di atas hero ungu ("Mulai membaca") |
| Emas | `btn bg-mustard hover:brightness-95 text-ink border-0 rounded-xl font-display` | "Mulai Membaca" (katalog), "Periksa" (guru) |
| Kecil lembut (ubah) | `btn btn-sm bg-skyy/20 hover:bg-skyy/40 border-0 rounded-xl font-display` | Aksi Ubah di tabel/daftar |
| Kecil lembut (hapus) | `btn btn-sm bg-pinky/20 hover:bg-pinky/40 border-0 rounded-xl font-display` | Aksi Hapus |
| Kecil primer | `btn btn-sm bg-bacayuk text-white border-0 rounded-xl font-display` | "Lihat semua →" (sedang bermigrasi ke `bg-primary`) |
| Ghost | `btn btn-ghost rounded-2xl font-display` | Aksi batal/netral |

Catatan: DaisyUI `btn` secara default mengkapitalkan teks — tombol Manus selalu
menambah `normal-case`. Tombol non-Manus belum konsisten (lihat temuan no. 4).

### 4.4 Badge status & label

- Badge status jurnal: `rounded-full px-3 py-1 text-xs font-bold` + pasangan warna tabel 1.4.
  Di kartu jurnal ditambah `badge … border-0 shrink-0`.
- Badge genre buku: `badge badge-sm bg-bacayuk-soft text-bacayuk border-0 font-bold`
  (target migrasi: `bg-lilac text-primary`).
- Chip "Menit" pada kartu grafik: `rounded-full bg-lilac text-primary px-3 py-1.5 text-xs font-bold`.

### 4.5 Tabel

Struktur resmi: kartu membungkus tabel DaisyUI.

```html
<div class="card bg-white rounded-[22px] shadow-kartu mt-5 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="table w-full"> … </table>
  </div>
</div>
```

Gaya header & baris diatur global di layout (`.table thead th`:
huruf kapital kecil 0.68rem, `letter-spacing .08em`, warna `#A7A2B5`, garis bawah `#F0EBF7`;
baris `hover:bg-[#FCFAFF]`, pemisah `#F6F3FA`). Sel aksi rata kanan (`text-right` di `th`,
`flex justify-end gap-2` di `td`), tombol aksi memakai pola 4.3 kecil lembut.
Baris kosong: satu sel `colspan` penuh, `text-center font-semibold text-muted py-8`.

### 4.6 Form & input

Pola yang sudah dominan dan menjadi standar (26 pemakaian konsisten):

```html
<input class="input input-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
<select class="select select-bordered h-12 rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
<textarea class="textarea textarea-bordered rounded-2xl border-[#E4DFEE] bg-[#FCFAFF]">
```

- Label: `block text-sm font-bold mb-2` (login) / `label-text font-bold` (form jurnal).
- Fokus diatur global: outline `2px solid #D9D2FF`, border `#B9AEF5`.
- Baris tombol form: tombol primer (4.3) + tombol ghost "Batal".
- Input warna (warna sampul buku) memakai pola sama + `p-1`.

### 4.7 Chip & filter

Chip filter genre (katalog siswa): `btn btn-sm rounded-full font-display border-0` —
aktif `bg-bacayuk text-white shadow-md shadow-primary/20`, nonaktif `bg-white border border-[#EDEAF6]`.

### 4.8 Keadaan kosong (empty state)

Dua pola yang sah:

1. **Kartu ilustrasi** (jurnal kosong, katalog kosong, antrean verifikasi kosong):
   `.card` putih + `card-body items-center text-center py-12` + ilustrasi SVG
   `assets/ilustrasi/no-data.svg` setinggi `h-24`–`h-28` + judul `font-display font-bold text-xl`
   + teks `text-muted font-semibold`.
2. **Panel krem sebaris** (Manus, di dalam kartu): `bg-cream rounded-2xl p-5 text-center`
   + ikon besar + teks kecil muted. Dipakai untuk "lencana masih kosong" & "jurnal masih kosong"
   di dashboard siswa.

Ilustrasi yang tersedia di `public/assets/ilustrasi/`:
`book-lover.svg` (hero dashboard siswa), `book-reading.svg` (login & katalog),
`online-learning.svg` (dashboard guru), `winners.svg` (lencana & peringkat),
`no-data.svg` (keadaan kosong). Ilustrasi kecil di header halaman dibungkus chip:
`bg-[#F1EEFF] rounded-xl p-2 h-24 hidden md:block`.

### 4.9 Modal

Satu-satunya modal saat ini: popup perayaan selesai membaca di `siswa/jurnal_index.php`
(DaisyUI `<dialog class="modal modal-open">`). Pola resminya mengikuti komponen lain:
kotak putih membulat, lingkaran centang, grid 3 statistik ubin krem, bintang emas,
satu tombol primer blok. (Keadaan saat ini masih menyimpang — lihat temuan no. 6.)

### 4.10 Flash message & alert

Diatur layout, jangan dibuat ulang di view: `alert rounded-2xl font-semibold shadow-sm` —
sukses mint, error merah muda, daftar error validasi kuning pastel (lihat 1.4).
Pengecualian: peringatan kontekstual di dalam halaman (mis. guru tanpa kelas) masih
memakai `alert alert-warning` DaisyUI (lihat temuan no. 5).

### 4.11 Grafik (Chart.js)

Pola Manus (dashboard siswa): batang `#D9D2FF`, hover `#6956E8`, `borderRadius 8`,
`maxBarThickness 34`, grid sumbu Y `#F2EFF8`, label `#A7A2B5` font DM Sans,
tooltip latar `ink` radius 10 tanpa kotak warna. Tinggi kanvas `h-56` dalam kartu.

### 4.12 Kerangka halaman (layout)

- Sidebar 270px putih, garis kanan `#EEEAF6`; menu `nav-link` rounded-2xl —
  hover lilac, aktif ungu penuh + `shadow 0 8px 18px rgba(105,86,232,.2)`.
- Header lengket 74px `bg-white/80 backdrop-blur`, eyebrow "Ruang belajar" + judul halaman.
- Avatar inisial: kotak `w-10 h-10 rounded-2xl bg-primary`.
- Konten: `max-w-[1380px] mx-auto px-5 sm:px-8 py-7` + animasi `.fade-in`
  (naik 8px, 0.45s). Footer teks kecil `#AAA5B8`.
- Judul halaman di konten: pola `flex items-center justify-between gap-4` —
  H1 + subjudul muted di kiri, ilustrasi chip (4.8) atau tombol primer di kanan.

---

## 5. Ikon

Dua sistem ikon hidup berdampingan; **sistem resmi adalah SVG garis**:

- **SVG garis (resmi):** viewBox `0 0 24 24`, `fill="none"`, `stroke="currentColor"`,
  `stroke-width="1.8"`, `stroke-linecap="round"`, `stroke-linejoin="round"`.
  Ukuran: 19px di menu sidebar (katalog ikon `$ic` di layout: home, users, kelas, buku,
  jurnal, award, chart, out), 21–22px di ubin statistik guru/admin, 25–27px untuk logo buku.
  Ubin ikon selalu `w-11 h-11 rounded-2xl grid place-items-center` di atas chip pastel (1.3).
- **Emoji (pengecualian yang ditoleransi):**
  - *Data dari database* — avatar pengguna, ikon buku, ikon lencana, pemilih perasaan
    di form jurnal (😊🤩😄🥰🤔😴). Ini konten, bukan dekorasi.
  - *Rating* — karakter `★` emas `text-amber-500` + sisa `text-slate-200`.
  - *Sisa dekorasi di file Manus* — 📚📖⏱🔥 pada kartu statistik dashboard siswa,
    👋 pada sapaan, 🏅🌱 pada keadaan kosong Manus. Dipertahankan apa adanya
    selama file Manus belum direvisi (lihat temuan no. 2).
- Karakter teks lain yang sah: `✓` pada lingkaran modal & flash, `→` pada tautan/tombol,
  `↗` pada kartu statistik Manus, `•` sebagai pemisah meta, `☰` pada tombol drawer mobile.

---

## 6. Ketidakkonsistenan saat ini & rekomendasi

Diurutkan dari dampak terbesar. Perbaikan kode dilakukan agen frontend; dokumen ini hanya memetakan.

### No. 1 — Dua dialek kartu & bayangan berjalan bersamaan
Kartu `.card` + `shadow-kartu` + `rounded-[22px]` (26 pemakaian) vs kartu polos Manus
`shadow-soft` + `rounded-[24px]` + border hex manual (dashboard siswa). Radius kartu
tercatat 22px (27×), 24px (3×), 26px (1×), 28px (1×) — belum satu angka.
**Rekomendasi:** tetapkan `rounded-[22px]` + `shadow-kartu` sebagai standar tunggal
(atau naikkan semua ke 24px), dan samakan nilai `shadow-kartu`/`shadow-soft` yang
sekarang kebetulan identik menjadi satu token saja.

### No. 2 — Sistem ikon ganda: emoji dekoratif vs SVG garis
Kartu statistik dashboard siswa (file Manus) memakai emoji 📚📖⏱🔥, sementara dashboard
guru & admin memakai SVG garis 21–22px untuk konsep yang sama persis (buku, halaman,
menit, streak). Sapaan dan keadaan kosong Manus juga beremoji (👋🏅🌱).
**Rekomendasi:** ganti emoji dekoratif dashboard siswa dengan ikon SVG dari katalog
layout (buku, jurnal, jam, api) saat file Manus direvisi; emoji data (avatar, perasaan,
ikon DB) tetap dipertahankan.

### No. 3 — Badge status punya dua bahasa
Status jurnal tampil pastel resmi (tabel 1.4) di dashboard siswa & daftar jurnal siswa,
tetapi `guru/jurnal.php` dan `admin/users.php` masih memakai kelas semantik DaisyUI
(`badge-warning`, `badge-success`, `badge-error`, teks putih). Badge genre memakai
alias `bg-bacayuk-soft text-bacayuk`.
**Rekomendasi:** satu peta warna status untuk semua peran (peran user di admin/users
dibuatkan pasangan pastel sendiri), dan migrasi `bacayuk-soft`→`lilac`, `bacayuk`→`primary`.

### No. 4 — Tombol belum seragam
`bg-primary` vs `bg-bacayuk` untuk tombol yang sama; `normal-case` hanya ada di file
Manus sehingga tombol halaman lain tampil HURUF KAPITAL bawaan DaisyUI; ada kelas
bayangan ganda (`shadow-lg shadow-primary/20 shadow` di `buku/index.php` dan
`siswa/jurnal_index.php`); radius tombol tersebar `rounded-xl` vs `rounded-2xl`.
**Rekomendasi:** tetapkan satu string kelas tombol primer (4.3) dan terapkan global;
tambah `normal-case` di semua tombol; hapus kelas `shadow` ganda.

### No. 5 — Warna bawaan Tailwind/DaisyUI bocor di beberapa tempat
Rating memakai `text-amber-500` + `text-slate-200`; modal perayaan memakai
`bg-green-100 border-green-400`; antrean guru tanpa kelas memakai `alert-warning`
DaisyUI; progres lencana `progress-warning`; chip statistik guru memakai alias
transparan `bg-skyy/15`, `bg-minty/15`, `bg-mustard/25` alih-alih pastel resmi (1.3).
**Rekomendasi:** petakan ke palet: bintang → `text-gold` + `#E9E4F5`;
hijau modal → `bg-mint` + `minty`; alert peringatan → `bg-[#FFF1D7] text-[#9A681B]`;
chip guru → pasangan pastel tabel 1.3.

### No. 6 — Modal perayaan menyimpang paling jauh
`siswa/jurnal_index.php`: `modal-box rounded-xl` (standar kartu 22px), lingkaran
centang hijau bawaan Tailwind, ubin statistik `rounded-xl`, tombol di dalamnya
sudah benar.
**Rekomendasi:** samakan ke `rounded-[26px]`, lingkaran `bg-mint border-[#8FD8C6]`
atau emas, ubin `rounded-2xl`, dan pertahankan satu tombol primer blok.

### No. 7 — Grafik guru beda keluarga warna
Grafik kelas di dashboard guru memakai batang `#2F8F83` (toska warisan palet biru
sekolah) + grid `#E6F4F1`, radius 12, tanpa pola tooltip Manus — sementara grafik
siswa ungu/lilac (4.11).
**Rekomendasi:** samakan konfigurasi Chart.js kedua dashboard ke pola 4.11
(satu cuplikan konfigurasi bersama).

### No. 8 — Alias token lama masih tersebar
`bg-krem` (8×), `bg-bacayuk-soft` (6×), `text-bacayuk`/`bg-bacayuk` (8×),
`bg-mustard` & turunan `/25`–`/40`, `bg-skyy/20`, `bg-pinky/20` masih dipakai luas
termasuk di tombol aksi tabel seluruh halaman.
**Rekomendasi:** migrasi bertahap ke token inti (tabel 1.5) lalu hapus alias dari
config agar tidak dipakai lagi; `skyy`/`pinky`/`minty` dipertahankan sebagai token
aksen resmi atau diganti hex pastel sekalian.

### No. 9 — Judul halaman menyisakan spasi & pola kepala tak seragam
Banyak H1 menyisakan spasi di awal (`" Jurnal Saya"`, `" Verifikasi Jurnal"`,
`" Kelola Kelas"` — sisa penghapusan emoji), dan kepala halaman terbagi dua pola:
dengan ilustrasi chip (katalog, lencana, peringkat, guru) vs teks polos (admin, form).
**Rekomendasi:** bersihkan spasi awal judul; tetapkan pola kepala halaman tunggal
(4.12) — ilustrasi chip hanya untuk halaman berorientasi siswa.

### No. 10 — Halaman error & sambutan masih bawaan CodeIgniter
`errors/html/*` memakai oranye CI `#dd4814` dan `welcome_message.php` masih ada
di repo. Di luar jalur pengguna, tapi terlihat bila error muncul.
**Rekomendasi:** buat halaman error 404/500 sederhana berlayout krem + ungu,
dan hapus `welcome_message.php` dari distribusi.

---

*Dokumen ini memetakan keadaan per Oktober 2026 (pasca poles menyeluruh ala Manus).
Perubahan desain berikutnya: ubah dokumen ini dulu, baru view-nya.*
