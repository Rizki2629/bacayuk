# BacaYuk! — Redesign "Dunia Cerita 3D"

Dokumen arah desain lanjutan di atas [DESIGN-SYSTEM.md](DESIGN-SYSTEM.md).
Sistem dasar (token warna Manus, kartu, tombol, tabel, form, ikon SVG garis) **tetap berlaku
penuh** — dokumen ini hanya menambah satu lapisan di atasnya: **adegan ilustrasi 3D render**
sebagai pembuka layar-layar utama yang berhadapan dengan anak.

Prinsip warisannya sederhana: DESIGN-SYSTEM mengatur *bagaimana UI bekerja*;
dokumen ini mengatur *bagaimana layar menyambut*.

---

## 1. Bahasa desain baru — "Dunia Cerita 3D"

Terinspirasi presentasi interaktif anak: layar tidak dibuka oleh tumpukan kartu,
melainkan oleh **sebuah adegan** — hutan/perpustakaan ajaib dengan cahaya hangat,
hewan-hewan lucu, dan sudut pandang render 3D yang lembut (bentuk membulat,
material seperti mainan, tanpa tepi tajam).

Prinsip-prinsipnya:

1. **Adegan dulu, data kemudian.** Setiap layar utama siswa membuka dengan satu
   bingkai adegan (lihat 4.4). Di bawah adegan, semua kembali ke pola resmi:
   kartu standar `rounded-[22px] shadow-kartu`, tabel, form — tidak berubah.
2. **Satu adegan per layar.** Adegan adalah pembuka, bukan latar seluruh halaman.
   Tidak ada gambar 3D kedua yang bersaing dalam satu layar (maskot di dalam
   adegan yang sama tidak dihitung sebagai adegan kedua).
3. **Judul duduk di atas papan, bukan di atas gambar.** Teks judul selalu ditaruh
   pada komponen `.plakat` (4.1) yang menumpang di tepi bawah adegan — terbaca,
   kontras aman, dan tidak bergantung pada isi gambar.
4. **Suasana dari gambar, fungsi dari token.** Kehangatan (hijau hutan, cahaya emas,
   langit) datang dari piksel adegan. Semua elemen interaktif tetap memakai token
   resmi DESIGN-SYSTEM — ungu `primary` tidak pernah digantikan warna gambar.
5. **Meriah tapi tenang.** Tidak ada animasi berjalan terus-menerus; satu-satunya
   momen bergerak adalah perayaan (modal selesai membaca / lencana baru).
   Lihat larangan di bab 7.

Di luar layar siswa, lapisan ini hanya berupa **sentuhan ringan** (bab 6) —
dashboard guru & admin tetap profesional dan padat informasi.

---

## 2. Aset resmi — `public/assets/3d/`

Lima berkas PNG render 3D. Inilah satu-satunya sumber gambar 3D yang sah;
jangan mengambil render lain dari internet agar gaya visualnya satu keluarga
(sudut cahaya konsisten, material mainan membulat, tanpa teks di dalam gambar).

| Berkas | Isi adegan | Dipakai di |
|---|---|---|
| `maskot.png` | **Kika si Kancil** sendirian, latar transparan | Elemen melayang: hero, keadaan kosong kecil, modal, profil (lihat 2.1) |
| `hero-baca.png` | Kika membaca di perpustakaan hutan ajaib, cahaya hangat dari jendela daun | Login, dashboard siswa |
| `perayaan.png` | Kika & teman hewan bersorak, confetti, suasana pesta kecil | Modal perayaan, halaman/rapor pencapaian |
| `misi.png` | Kika berlari di jalur setapak hutan membawa buku, papan penunjuk arah | Kartu misi membaca (dashboard siswa), peringkat |
| `kosong.png` | Sudut perpustakaan yang sepi, satu buku tertutup & tanaman, cahaya redup ramah | Keadaan kosong (jurnal, katalog, lencana) |

Format & teknis:

- PNG; `hero-baca.png`, `perayaan.png`, `misi.png` rasio lebar **16:7–16:9**
  (dirender untuk dipotong `object-cover` di bingkai adegan); `maskot.png` &
  `kosong.png` rasio bebas dengan latar transparan/utuh sesuai tabel.
- Target ukuran berkas ≤ 600 KB per gambar (kompres `pngquant`/WebP diizinkan
  selama nama & rasio dipertahankan). Jangan tampilkan di atas lebar aslinya.
- Selalu beri `alt=""` (dekoratif) — makna disampaikan teks pendamping, bukan gambar.
- Gambar dimuat lambat (`loading="lazy"`) kecuali adegan di layar pertama (login).

### 2.1 Maskot: Kika si Kancil

- **Siapa:** kancil 3D kecil berkacamata bulat, **syal ungu `#6956E8`** melilit di leher
  (syal adalah jangkar mereknya — jangan diganti warna lain di render turunan mana pun).
- **Peran:** pemandu, bukan dekorasi acak. Kika muncul untuk menyapa (hero),
  mengantar misi (misi), merayakan (perayaan), dan menemani keadaan kosong.
- **Aturan pakai:**
  - Maksimal **satu Kika per layar** (Kika di dalam adegan `hero-baca.png`/`misi.png`
    sudah dihitung; jangan tambah `maskot.png` melayang di layar yang sama).
  - `maskot.png` berdiri sendiri hanya di: profil siswa, modal perayaan (bila tidak
    memakai `perayaan.png`), dan keadaan kosong versi panel kecil.
  - Ukuran tampil `maskot.png`: tinggi 96–160px di desktop, 72–112px di mobile.
    Selalu menapak di tepi bawah wadahnya (`bottom-0`), jangan melayang di tengah teks.
  - Jangan membalik (mirror) gambar Kika — arah pandang & syalnya sudah disengaja.

---

## 3. Tipografi — tambahan font display "Baloo 2"

Satu font ditambahkan khusus lapisan 3D. **Font isi tidak berubah.**

| Font | Kelas | Bobot | Dipakai untuk |
|---|---|---|---|
| **Baloo 2** (baru) | `.font-kartun` | 700–800 | Judul di atas `.plakat`, judul hero di dalam bingkai adegan, angka besar di layar perayaan |
| Plus Jakarta Sans | `font-display` (tetap) | 500–800 | Semua judul UI lain, **semua angka statistik & data**, tombol |
| DM Sans | `font-body` (tetap) | 400–700 | Seluruh teks isi, seperti sebelumnya |

Aturan pakai Baloo 2 (`.font-kartun`):

- Hanya untuk **teks pajangan pendek**: judul papan/hero (maks. ±6 kata) dan
  seruan perayaan ("Hebat!", "Misi Selesai!"). Tidak pernah untuk paragraf,
  label form, tabel, tombol, atau angka data.
- Ukuran acuan: hero desktop `text-4xl`–`text-5xl`, hero mobile `text-3xl`,
  judul plakat `text-2xl`–`text-3xl`, selalu `font-extrabold` dengan
  `leading-tight` dan `tracking-normal` (Baloo sudah lebar secara bawaan).
- Selalu berwarna `ink` di atas plakat krem, atau putih di atas gradasi adegan —
  tidak pernah berwarna ungu/emas sebagai teks besar (ungu tetap milik tombol & tautan).
- Dimuat dari Google Fonts bersama dua font lama, `display=swap`,
  subset latin saja agar tidak memberatkan halaman login.

Definisi utilitasnya ditambahkan di layout (dan login standalone) bersama config lama:

```css
.font-kartun { font-family: 'Baloo 2', 'Plus Jakarta Sans', sans-serif; }
```

---

## 4. Komponen baru

### 4.1 `.plakat` — papan judul

Papan krem seperti papan kayu dicat lembut, tempat judul layar duduk.
Menumpang di tepi bawah bingkai adegan (negatif margin) atau berdiri sendiri
di kepala seksi besar untuk siswa.

```css
.plakat {
  background: #FFF6E3;
  border: 2px solid #F0DDB8;
  border-radius: 24px;
  box-shadow: 0 12px 30px rgba(120, 84, 20, .12);
  color: #29253D; /* ink */
  padding: 1rem 1.5rem;
}
```

- Teks judul di dalamnya memakai `.font-kartun`; subjudul tetap DM Sans `text-muted`.
- **Aksen daun opsional:** satu SVG daun kecil hijau `#3E9B4F` di sudut kanan atas
  plakat — satu-satunya elemen dekoratif yang diizinkan menempel pada plakat,
  ukuran ≤ 28px, `aria-hidden`. Tanpa daun pun plakat tetap sah.
- Jangan menaruh tombol di dalam plakat; plakat murni judul + subjudul.

### 4.2 Kartu permainan

Kartu konten versi "mainan" untuk daftar yang dihadapi anak (katalog, lencana, misi):
dasar kartu standar DESIGN-SYSTEM, dengan tiga penyesuaian —

- Radius naik ke `rounded-[24px]`, border tetap `#F2EEF8`, bayangan `shadow-kartu`.
- Kepala kartu boleh berupa potongan adegan/sampul dengan rasio tetap (lihat 4.4).
- Label aksen di dalam kartu memakai **pil oranye/emas**:
  `bg-gold text-ink rounded-full px-3 py-1 text-xs font-bold`
  (dipakai untuk level baca, genre, dan status "baru"). Pil ini **label, bukan tombol**.

Selain tiga hal itu kartu permainan identik dengan kartu standar — harga konsistensi
lebih penting daripada variasi.

### 4.3 Lencana level

Penanda jenjang membaca yang menempel pada sampul/kartu buku dan baris peringkat:

```html
<span class="rounded-full bg-gold text-ink px-2.5 py-0.5 text-[11px] font-extrabold shadow-sm">Level B2</span>
```

- Selalu pil emas di sudut kiri atas gambar sampul; teks selalu `ink`, tidak pernah putih.
- Satu lencana per buku. Bila ada status lain (mis. "baru"), tumpuk vertikal di sudut
  yang sama dengan jarak 4px — jangan menyebar ke sudut lain.

### 4.4 Bingkai adegan

Wadah gambar 3D sebagai kepala kartu/hero. Gambar memenuhi bingkai,
judul tidak pernah dibakar ke dalam gambar.

```html
<div class="relative overflow-hidden rounded-[24px]">
  <img src="assets/3d/hero-baca.jpg" class="w-full h-44 sm:h-56 object-cover" alt="">
  <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-[#29253D]/45 to-transparent"></div>
  <!-- .plakat menumpang di sini (di luar bingkai, -mt-8) atau teks putih singkat di atas gradasi -->
</div>
```

- Overlay gradasi hanya dari bawah, maksimal 45% gelap, dan hanya untuk teks putih
  **singkat** (satu baris sapaan). Judul resmi tetap di `.plakat` di bawah bingkai.
- Tinggi acuan: hero dashboard `h-44 sm:h-56`, kepala kartu `h-32`, modal `h-40`.
- Sudut bingkai mengikuti wadahnya (`rounded-[24px]` kartu permainan / `[28px]` hero).

---

## 5. Palet harmonisasi

Ungu Manus tetap satu-satunya warna merek & interaksi. Warna alam **hanya hidup
di dalam piksel adegan** dan aksen dekoratif kecil yang tidak membawa makna fungsi.

| Warna | Hex | Boleh | Dilarang |
|---|---|---|---|
| Ungu utama `primary` | `#6956E8` | Semua tombol primer, tautan, menu aktif, syal Kika | — |
| Emas `gold` | `#F5B942` | Pil label, lencana level, bintang rating, aksen plakat | Latar tombol utama |
| Krem plakat | `#FFF6E3` + border `#F0DDB8` | Latar `.plakat` saja | Latar halaman (tetap `cream #FFF9F0`) |
| Hijau hutan | `#3E9B4F` | Aksen daun plakat, ikon kecil non-fungsi, detail di dalam gambar | **Tombol, badge status, teks tautan** |
| Hijau daun muda | `#7BC96F` | Pasangan gradasi aksen daun, titik dekoratif | Sama seperti di atas |
| Biru langit | `#8ED8FF` | Elemen di dalam gambar adegan, aksen kecil pada ilustrasi kosong | **Tombol, header, latar panel** |

Aturan kerasnya: **status tidak pernah memakai warna alam.** Status jurnal tetap
persis tabel warna resmi DESIGN-SYSTEM §1.4 (menunggu/terverifikasi/revisi),
dan "berhasil" di UI tetap keluarga `mint`, bukan hijau hutan — anak & guru harus
membedakan "suasana" dari "informasi" secara naluriah.

---

## 6. Peta penerapan per layar

| Layar | Perlakuan 3D |
|---|---|
| **Login** | `hero-baca.png` menjadi panel gambar split-screen menggantikan ilustrasi SVG lama; judul masuk di `.plakat` kecil di bawah panel pada mobile. Form, warna, perilaku tidak berubah. |
| **Dashboard siswa — desktop** | Hero misi diganti **bingkai adegan** `hero-baca.png` + plakat judul berisi sapaan; kartu misi memakai `misi.png` sebagai kepala kartu permainan. Di bawahnya semua pola Manus tetap. |
| **Dashboard siswa — mobile** | Adegan dipadatkan: bingkai `h-36` di puncak beranda aplikasi, plakat menumpang `-mt-6`; navigasi bawah & FAB tidak berubah. |
| **Katalog buku** | Kartu buku menjadi **kartu permainan**; sampul buku asli bila ada, bila tidak ada sampul, pakai potongan adegan generik + **lencana level** emas di sudutnya. Chip filter genre tetap pola resmi. |
| **Lencana** | Kepala halaman memakai plakat; ubin lencana diraih boleh memakai potongan `perayaan.png` sebagai latar kepala seksi "Koleksiku". Ubin & badge "Sudah diraih" tetap pola resmi. |
| **Peringkat** | Kepala kartu podium memakai `misi.png`; chip medali emas/perak/perunggu tidak berubah. Tabel peringkat tetap pola tabel resmi — tanpa gambar di dalam baris. |
| **Profil / Kartu Pembaca** | `maskot.png` berdiri di sudut kartu pembaca virtual (menapak di tepi bawah kartu); barcode, statistik, dan grid menu tidak berubah. |
| **Keadaan kosong** | Pola kosong resmi diganti gambar: `kosong.png` (atau `maskot.png` untuk panel kecil) di tengah kartu kosong + judul plakat mini; teks ajakan & tombol tetap pola resmi. Berlaku untuk jurnal kosong, katalog kosong, antrean verifikasi kosong (guru). |
| **Modal perayaan** | Kepala modal = bingkai adegan `perayaan.png` `h-40`; di tengahnya lingkaran centang besar (pola resmi: `bg-mint` + `✓`) menumpang di tepi bawah gambar; judul seruan `.font-kartun`; confetti hanya sebagai bagian dari gambar `perayaan.png` (bukan animasi/DOM). Statistik & tombol tetap pola modal resmi. |
| **Dashboard guru** | **Sentuhan ringan:** ilustrasi chip di kepala halaman diganti `maskot.png` kecil (h-16) dalam chip lilac yang sama. Tanpa bingkai adegan, tanpa plakat. |
| **Dashboard admin** | **Sentuhan ringan:** sama seperti guru — satu `maskot.png` kecil di kepala halaman. Seluruh kartu statistik & tabel tetap persis DESIGN-SYSTEM. |
| **Form & halaman data lain** (jurnal form, kelola, verifikasi) | Tidak disentuh lapisan 3D. Kecepatan & kejelasan data diutamakan. |

Urutan pengerjaan yang disarankan: login & dashboard siswa → modal perayaan &
keadaan kosong → katalog, lencana, peringkat, profil → sentuhan guru/admin.

---

## 7. Larangan & pagar pengaman

1. **Tidak ada teks penting di dalam gambar.** Judul, angka, status, dan instruksi
   selalu teks HTML. Gambar adegan tidak boleh mengandung tulisan apa pun —
   bila render membawa teks, render ditolak.
2. **Ilustrasi tidak menutupi data.** Adegan hanya di kepala layar/kartu;
   tidak ada gambar di belakang tabel, grafik, atau form. Grafik Chart.js
   tampil di atas putih bersih, selalu.
3. **Kontras tidak boleh turun.** Teks di atas gradasi adegan hanya untuk sapaan
   satu baris berwarna putih di atas gradasi ≥ 45%; semua teks fungsional tetap
   `ink`/`muted` di atas putih/krem sesuai DESIGN-SYSTEM.
4. **Hormati `prefers-reduced-motion`.** Bila kelak ditambah animasi (mis. Kika
   melambai atau confetti jatuh pada modal), animasi wajib mati total di bawah
   media query ini, dan tidak ada animasi berulang tanpa henti di layar mana pun:

   ```css
   @media (prefers-reduced-motion: reduce) {
     *, *::before, *::after { animation: none !important; transition: none !important; }
   }
   ```

5. **Satu Kika per layar** (aturan 2.1) dan **satu adegan per layar** (prinsip 1.2)
   tidak bisa ditawar demi "lebih ramai".
6. **Warna alam bukan warna fungsi** (bab 5): hijau hutan & biru langit tidak
   pernah menjadi tombol, tautan, atau status.
7. **Berat halaman dijaga:** total gambar 3D per layar ≤ ±900 KB; login hanya
   memuat `hero-baca.png`. Bila melebihi, turunkan kualitas render — jangan
   mengorbankan kecepatan demi ketajaman.

---

*Dokumen ini menambah lapisan "Dunia Cerita 3D" di atas DESIGN-SYSTEM.md
(Oktober 2026). Bila ada pertentangan, DESIGN-SYSTEM menang untuk komponen &
token; dokumen ini menang untuk adegan, maskot, dan plakat.*
