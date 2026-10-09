# BacaYuk! 📚 — Jurnal Membaca Anak

Aplikasi web untuk memantau aktivitas membaca siswa SD: siswa mengisi jurnal membaca harian, guru memverifikasi dan memberi catatan, admin mengelola user/kelas/buku. Dilengkapi gamifikasi: streak membaca, bintang, lencana otomatis, dan leaderboard kelas.

**Stack:** CodeIgniter 4.7 • MySQL • Tailwind CSS + DaisyUI • Chart.js
**Desain:** terinspirasi referensi dari [ui.live](https://ui.live) (Child Education UI Kit, Courseflow Dashboard, Course Grid, Exercise Completed Modal, Khan Academy Header Redesign) — detailnya di `KONSEP.md`.

## Fitur per Role

| Role | Fitur |
|---|---|
| **Siswa** | Dashboard statistik + grafik 7 hari, isi/edit/hapus jurnal (judul, halaman, durasi, ringkasan, pesan cerita, rating bintang, emoji perasaan), popup perayaan, katalog buku per genre, lencana & progres, peringkat kelas |
| **Guru** | Dashboard kelas (statistik, grafik kelas, daftar siswa belum membaca minggu ini), verifikasi jurnal (setujui/revisi + catatan), daftar siswa + progres, kelola katalog buku, peringkat kelas |
| **Admin** | Dashboard global, kelola user (admin/guru/siswa), kelola kelas + wali kelas, kelola katalog buku, monitoring semua jurnal, daftar lencana |

Statistik, streak, leaderboard, dan lencana hanya menghitung jurnal berstatus **terverifikasi**.

## Instalasi (MySQL)

Syarat: PHP 8.2+ (ekstensi intl, mbstring, mysqli, curl, xml), MySQL 8 / MariaDB, Composer (opsional — `vendor/` sudah disertakan).

```bash
# 1. Buat database
mysql -u root -p -e "CREATE DATABASE bacayuk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
#    (atau import database/bacayuk.sql yang sekaligus membuat tabel + definisi lencana)

# 2. Salin file env dan sesuaikan kredensial database
cp env .env    # lalu edit bagian database.default.* bila perlu

# 3. Buat tabel + data demo (lewati bila sudah import SQL di langkah 1 untuk tabel;
#    migrasi tetap aman dijalankan)
php spark migrate --all
php spark db:seed BacaYukSeeder

# 4. Jalankan
php spark serve            # http://localhost:8080
```

Di XAMPP/hosting: letakkan proyek di `htdocs`, arahkan document root ke folder `public/` (atau pindahkan isi `public/` sesuai panduan deployment CI4), buat database, lalu jalankan migrasi + seeder lewat terminal, atau import `database/bacayuk.sql` lalu tetap jalankan seeder untuk akun demo.

## Akun Demo

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `admin123` |
| Guru (wali Kelas 4A) | `guru` | `guru123` |
| Siswa (demo utama) | `siswa` | `siswa123` |
| Siswa contoh lain | `bima`, `citra`, `dimas`, `eka`, `fajar`, `gita`, `hadi` | `siswa123` |

> Ganti semua password demo sebelum dipakai sungguhan!

## Alternatif Demo Cepat (SQLite, tanpa MySQL)

Ubah `.env` menjadi:

```
database.default.database = /path/ke/proyek/writable/bacayuk.sqlite3
database.default.DBDriver = SQLite3
database.default.hostname =
database.default.username =
database.default.password =
```

lalu jalankan `php spark migrate --all && php spark db:seed BacaYukSeeder && php spark serve`.

## Struktur Penting

- `app/Controllers/` — Auth, Siswa, Guru, Buku, Admin
- `app/Models/JurnalModel.php` — statistik, streak, grafik, leaderboard, mesin lencana otomatis
- `app/Database/Migrations/` & `app/Database/Seeds/BacaYukSeeder.php`
- `database/bacayuk.sql` — skema MySQL siap import
- `KONSEP.md` — konsep, palet warna, referensi desain

## Catatan

- Login memakai **username** (bukan email) agar mudah untuk anak.
- Jurnal yang sudah terverifikasi tidak bisa diubah/dihapus siswa (menjaga integritas data).
- Menghapus user siswa akan menghapus jurnalnya (FK cascade); menghapus buku tidak menghapus jurnal (judul tersimpan sebagai snapshot).
