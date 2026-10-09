# Deploy BacaYuk! ke InfinityFree

Panduan memasang (deploy ulang) dan memperbarui (patch) BacaYuk! di hosting gratis [InfinityFree](https://www.infinityfree.com). Dokumen ini generik — semua nilai kredensial diisi dari panel akun masing-masing, **jangan pernah menulis kata sandi asli ke dokumen/repositori**.

## Gambaran

- InfinityFree menyediakan: akun hosting (subdomain gratis atau domain sendiri), MySQL, dan phpMyAdmin. Tidak ada akses SSH/terminal, jadi migrasi CLI (`php spark ...`) **tidak bisa** dijalankan di server — pembuatan tabel dilakukan lewat impor SQL, dan pembaruan kode lewat File Manager.
- Yang berjalan di server adalah isi proyek CodeIgniter secara utuh, dengan `.env` mode `production`.

## Prasyarat

- Akun klien InfinityFree + satu akun hosting aktif (status *Active*).
- Dari panel hosting (vPanel / halaman detail akun), catat untuk dipakai di langkah berikutnya:
  - **MySQL Host** (formatnya mirip `sqlXXX.infinityfree.com`), port `3306`
  - **MySQL Database name** (sudah termasuk awalan akun, dibuat dari menu *MySQL Databases*)
  - **MySQL Username** (biasanya sama dengan username akun hosting)
  - **MySQL Password** = kata sandi akun hosting/vPanel tersebut
  - **FTP hostname** (biasanya `ftpupload.net`) bila memakai klien FTP
  - Folder situs: akun biasanya berakar di `/home/volXX_X/infinityfree.com/<username>/` dengan folder web **`htdocs`** di dalamnya

## A. Deploy Ulang dari Nol

### 1. Buat database
Di vPanel → **MySQL Databases** → buat database baru. Catat host, nama database, username, dan kata sandi (lihat Prasyarat).

### 2. Siapkan paket proyek
Dari komputer lokal, kemas seluruh isi proyek sebagai satu ZIP (struktur di dalam ZIP langsung berisi `app/`, `public/`, `writable/`, `database/`, `spark`, `composer.json`, dll. — bukan dibungkus folder tambahan). Folder `vendor/` boleh disertakan agar tidak perlu Composer di server.

Sertakan juga file `.htaccess` **di akar paket** (sejajar `app/` dan `public/`) yang mengarahkan semua permintaan ke `public/`:

```apache
# Arahkan semua trafik ke folder public/ (document root virtual)
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ public/$1 [L]
```

### 3. Siapkan `.env` produksi
Buat/isi `.env` di akar proyek (di dalam paket atau disunting setelah terunggah) dengan nilai dari panel:

```ini
CI_ENVIRONMENT = production

app.baseURL = 'https://<subdomain-kamu>/'
app.forceGlobalSecureRequests = false

database.default.hostname = <MySQL Host dari panel>
database.default.database = <nama database dari panel>
database.default.username = <username dari panel>
database.default.password = <kata sandi akun hosting>
database.default.DBDriver = MySQLi
database.default.port = 3306
```

> `.env` berisi kredensial — jangan dimasukkan ke repositori publik dan jangan disertakan dalam ZIP patch (langkah B).

### 4. Unggah & ekstrak
File Manager (menu *Online File Manager* pada detail akun) → masuk ke **`htdocs`** → **Upload & Unzip / Upload and extract archive** → pilih ZIP proyek → ekstrak. Setelah selesai, `htdocs` harus berisi langsung: `app/`, `public/`, `writable/`, `.env`, `.htaccess`, dst.

### 5. Pastikan folder writable ada
Ekstrak ZIP **tidak membawa folder kosong**. Situs akan menampilkan halaman error *Whoops!* (`CacheException: Cache unable to write ...`) bila folder berikut hilang. Buat manual lewat File Manager (di dalam `writable/` proyek):

```
writable/cache/
writable/logs/
writable/session/
```

(Taruh berkas `index.html` kosong di masing-masing folder agar tidak hilang saat dipaket ulang.)

### 6. Buat tabel & data awal
Karena tidak ada terminal, gunakan **phpMyAdmin** dari vPanel:

1. Pilih database → tab **Import** → unggah `database/bacayuk.sql` → jalankan. Ini membuat 6 tabel + definisi lencana awal.
2. Isi akun awal (admin/guru/siswa demo) — salah satu cara:
   - Import SQL tambahan berisi `INSERT` user dengan `password_hash` yang dibuat lokal (`password_hash('...', PASSWORD_DEFAULT)` dari PHP lokal), atau
   - Jalankan *installer sekali jalan* lokal buatan sendiri (controller sementara berisi migrasi+seeder yang dilindungi kunci acak di URL, menulis berkas kunci/lock setelah sukses, lalu hapus controller-nya). Pola ini dipakai pada pemasangan perdana situs ini; perlakukan sebagai perkakas sekali pakai dan **hapus segera setelah berhasil**.

### 7. Verifikasi
- Buka `https://<subdomain-kamu>/` → harus tampil halaman login.
- Masuk dengan akun admin, guru, dan siswa demo; pastikan dashboard masing-masing tampil dan grafik termuat.
- Bila halaman *Whoops!* muncul: aktifkan sementara `CI_ENVIRONMENT = development` di `.env` untuk membaca pesan error-nya, perbaiki, lalu kembalikan ke `production`.

## B. Memasang Patch Pembaruan (cara rutin)

Untuk perubahan tampilan/kode tanpa menyentuh data:

1. Di lokal, buat ZIP berisi **hanya folder/file yang berubah**, dengan jalur relatif sama seperti struktur proyek. Contoh patch tampilan:
   ```
   app/Views/...          (seluruh folder Views)
   public/assets/...      (bila ada aset baru)
   ```
2. **Jangan** sertakan `.env`, `writable/`, atau `vendor/` dalam patch.
3. File Manager → **`htdocs`** → **Upload & Unzip** → ekstrak; mode ini menimpa berkas lama secara langsung.
4. Muat ulang situs (hard refresh: Ctrl+F5) dan periksa halaman-halaman yang berubah untuk ketiga role.

## C. Pemecahan Masalah

| Gejala | Penyebab umum | Perbaikan |
|---|---|---|
| Halaman *Whoops!* / `CacheException` soal `writable/cache` | Folder `writable/cache|logs|session` hilang setelah ekstrak ZIP | Buat ketiga folder itu (langkah A.5) |
| CSS/JS/ilustrasi 404, halaman tanpa gaya | Folder `public/assets` belum terunggah, atau `.htaccess` akar hilang | Unggah ulang `public/assets`; pastikan `.htaccess` akar ada (langkah A.2) |
| Halaman tampil polos padahal HTML baru | Cache peramban/hosting menyajikan versi lama | Hard refresh; tambahkan parameter acak di URL untuk memeriksa |
| Login berputar kembali ke halaman login | `app.baseURL` tidak cocok dengan domain/subdomain aktual | Samakan `baseURL` persis dengan alamat situs (termasuk `https://` dan `/` di akhir) |
| Error koneksi database | Nilai `database.default.*` tidak sesuai panel | Samakan dengan halaman detail akun (host, nama DB, username, kata sandi vPanel) |
| Perubahan kode tidak terasa | Ekstrak patch tidak menimpa (jalur folder di ZIP salah) | Pastikan isi ZIP langsung `app/...`, bukan `bacayuk/app/...` |

## D. Catatan Keamanan

- Selalu `CI_ENVIRONMENT = production` di server; mode `development` hanya sesaat untuk diagnosis.
- Ganti kata sandi semua akun demo setelah pemasangan.
- Berkas `.env` dan kredensial database tidak boleh masuk repositori publik maupun ZIP yang dibagikan.
