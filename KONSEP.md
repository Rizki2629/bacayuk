# BacaYuk! — Jurnal Membaca Anak

Aplikasi web untuk memantau aktivitas membaca siswa SD dalam bentuk jurnal membaca digital, dengan gamifikasi (streak, bintang, lencana, leaderboard kelas).

## Stack
- Backend: **CodeIgniter 4** (PHP 8.2+)
- Database: **MySQL** 8 / MariaDB 10.6+
- Frontend: **Tailwind CSS + DaisyUI** (CDN) — komponen rounded & ceria untuk anak
- Grafik: **Chart.js**; Font: **Baloo 2** (judul) + **Nunito** (isi)
- Ikon: emoji + inline SVG (tanpa dependensi ikon berat)

## Referensi desain (dari ui.live)
1. Child Education Website UI Kit (UIHut) — identitas utama: ungu indigo `#6C4CF1` + kuning mustard `#FFC531`, aksen bintang, sudut sangat bulat, logo buku terbuka, kartu genre berwarna.
2. Courseflow - My Course Screen (Saasify.design) — pola dashboard: sidebar biru muda, 4 kartu statistik, daftar "Lanjutkan Membaca" (sampul + progress bar + tombol pil).
3. Course Grid (Omega Orion) — pola daftar buku: filter pil per genre, kartu sampul + rating bintang kuning + penulis + jumlah halaman.
4. Exercise Completed Pop-up Modal (Lokanaka Studio) — popup "Selesai Membaca!": centang hijau besar, 3 statistik mini, bintang, tombol lanjut.
5. Khan Academy Web Header Redesign (Sohidur Rahman) — kartu melayang "total menit membaca minggu ini" + progress bar target + doodle pesawat kertas.

Lencana & leaderboard: adaptasi dari pola di atas + maskot hewan pastel (terinspirasi Cute Animal 3D Icons di ui.live) sebagai avatar peringkat.

## Palet warna
- Primary (ungu): `#6C4CF1`
- Secondary (kuning mustard): `#FFC531`
- Accent: pink `#FF7BAC`, mint `#2EC4B6`, sky `#4CC9F0`
- Background: `#FFF9F0` (krem hangat) / kartu putih
- Teks: `#2D3142`

## Role & Fitur

### Siswa
- Dashboard: sapaan + maskot, kartu statistik (buku selesai, total halaman, total menit, streak hari), grafik membaca 7 hari, daftar "Lanjutkan Membaca", jurnal terakhir.
- Jurnal Saya: tambah jurnal (pilih buku dari katalog atau tulis judul bebas, tanggal, halaman dari–sampai, durasi menit, ringkasan, pesan/kesan cerita, rating bintang 1–5, emoji perasaan), edit/hapus jurnal berstatus *menunggu*.
- Popup perayaan setelah simpan jurnal (pola desain no. 4).
- Lencana Saya: badge yang sudah diraih & progres menuju badge berikutnya.
- Peringkat Kelas: leaderboard kelas (total halaman & jumlah buku) dengan avatar hewan.

### Guru
- Dashboard: statistik kelas (total jurnal minggu ini, siswa aktif membaca, rata-rata menit), grafik kelas, daftar jurnal terbaru yang menunggu verifikasi, daftar siswa yang belum membaca minggu ini.
- Verifikasi Jurnal: setujui / minta revisi + catatan/komentar guru.
- Siswa Kelas: daftar siswa di kelasnya + progres masing-masing.
- Katalog Buku: tambah/edit/hapus buku untuk kelasnya.
- Leaderboard kelas.

### Admin
- Dashboard: statistik global (total user, kelas, buku, jurnal).
- Kelola User (admin/guru/siswa), Kelola Kelas (termasuk menunjuk wali/guru), Kelola Buku, semua jurnal (read-only monitoring), kelola definisi Lencana.

## Alur utama
1. Siswa login → isi jurnal → status `menunggu`.
2. Guru memeriksa → `terverifikasi` (masuk hitungan statistik & leaderboard) atau `revisi` + catatan.
3. Sistem menghitung statistik, streak, dan lencana otomatis dari jurnal terverifikasi.

## Akun demo (seeder)
- Admin — username `admin` / `admin123`
- Guru — username `guru` / `guru123` (wali Kelas 4A)
- Siswa — username `siswa` / `siswa123` (+ beberapa siswa contoh sekelas)

## Struktur folder proyek
```
bacayuk/
  app/            (Controllers, Models, Views, Filters, Database/Migrations & Seeds)
  public/         (index.php, assets)
  database/
    bacayuk.sql   (skema MySQL siap import — alternatif migrations)
  KONSEP.md       (dokumen ini)
  README.md       (panduan install)
```
