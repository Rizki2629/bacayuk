-- ============================================================
-- BacaYuk! — Jurnal Membaca Anak
-- Skema MySQL 8 / MariaDB 10.6+
-- Import:  mysql -u root -p < bacayuk.sql
-- (Seeder CodeIgniter akan mengisi data demo; password di-hash
--  di seeder, bukan di file ini.)
-- ============================================================

CREATE DATABASE IF NOT EXISTS bacayuk
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bacayuk;

-- ---------- Kelas ----------
CREATE TABLE kelas (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama         VARCHAR(50)  NOT NULL,              -- contoh: 4A
  tingkat      TINYINT      NOT NULL DEFAULT 4,    -- 1..6
  tahun_ajaran VARCHAR(9)   NOT NULL DEFAULT '2026/2027',
  guru_id      INT UNSIGNED NULL,                  -- wali kelas (users.id, role=guru)
  created_at   DATETIME NULL,
  updated_at   DATETIME NULL,
  INDEX idx_kelas_guru (guru_id)
) ENGINE=InnoDB;

-- ---------- Users (admin / guru / siswa) ----------
CREATE TABLE users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama          VARCHAR(100) NOT NULL,
  username      VARCHAR(50)  NOT NULL UNIQUE,      -- login siswa pakai username/NIS (tanpa email)
  email         VARCHAR(100) NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  kelas_id      INT UNSIGNED NULL,                 -- untuk siswa & guru wali
  avatar        VARCHAR(10)  NULL DEFAULT '🦊',    -- emoji hewan maskot
  is_active     TINYINT(1)   NOT NULL DEFAULT 1,
  created_at    DATETIME NULL,
  updated_at    DATETIME NULL,
  INDEX idx_users_role (role),
  INDEX idx_users_kelas (kelas_id),
  CONSTRAINT fk_users_kelas FOREIGN KEY (kelas_id)
    REFERENCES kelas (id) ON DELETE SET NULL
) ENGINE=InnoDB;

ALTER TABLE kelas
  ADD CONSTRAINT fk_kelas_guru FOREIGN KEY (guru_id)
  REFERENCES users (id) ON DELETE SET NULL;

-- ---------- Katalog Buku ----------
CREATE TABLE buku (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  judul          VARCHAR(200) NOT NULL,
  penulis        VARCHAR(100) NOT NULL,
  penerbit       VARCHAR(100) NULL,
  genre          ENUM('Dongeng','Sains','Puisi','Cerita Rakyat','Komik','Novel Anak','Agama','Lainnya')
                 NOT NULL DEFAULT 'Dongeng',
  jumlah_halaman INT NOT NULL DEFAULT 0,
  warna_sampul   VARCHAR(7)  NOT NULL DEFAULT '#6C4CF1',  -- sampul digambar dari warna + inisial
  ikon           VARCHAR(10) NULL DEFAULT '📚',
  deskripsi      TEXT NULL,
  ditambah_oleh  INT UNSIGNED NULL,
  created_at     DATETIME NULL,
  updated_at     DATETIME NULL,
  INDEX idx_buku_genre (genre),
  CONSTRAINT fk_buku_user FOREIGN KEY (ditambah_oleh)
    REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------- Jurnal Baca ----------
CREATE TABLE jurnal_baca (
  id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  siswa_id         INT UNSIGNED NOT NULL,
  buku_id          INT UNSIGNED NULL,              -- NULL bila judul ditulis bebas
  judul_buku       VARCHAR(200) NOT NULL,          -- snapshot judul (tetap ada walau buku dihapus)
  tanggal          DATE NOT NULL,
  halaman_dari     INT NOT NULL DEFAULT 1,
  halaman_sampai   INT NOT NULL DEFAULT 1,
  jumlah_halaman   INT NOT NULL DEFAULT 0,         -- sampai - dari + 1 (dihitung aplikasi)
  durasi_menit     INT NOT NULL DEFAULT 0,
  ringkasan        TEXT NULL,                      -- ceritakan kembali isi bacaan
  pesan_cerita     TEXT NULL,                      -- kesan / pelajaran dari cerita
  rating           TINYINT NOT NULL DEFAULT 5,     -- bintang 1..5
  perasaan         VARCHAR(10) NULL DEFAULT '😊',  -- emoji perasaan setelah membaca
  status           ENUM('menunggu','terverifikasi','revisi') NOT NULL DEFAULT 'menunggu',
  catatan_guru     TEXT NULL,
  diverifikasi_oleh INT UNSIGNED NULL,
  diverifikasi_pada DATETIME NULL,
  created_at       DATETIME NULL,
  updated_at       DATETIME NULL,
  INDEX idx_jurnal_siswa (siswa_id),
  INDEX idx_jurnal_status (status),
  INDEX idx_jurnal_tanggal (tanggal),
  CONSTRAINT fk_jurnal_siswa FOREIGN KEY (siswa_id)
    REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT fk_jurnal_buku FOREIGN KEY (buku_id)
    REFERENCES buku (id) ON DELETE SET NULL,
  CONSTRAINT fk_jurnal_verifikator FOREIGN KEY (diverifikasi_oleh)
    REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------- Lencana (badge) ----------
CREATE TABLE lencana (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama         VARCHAR(80) NOT NULL,               -- contoh: Pembaca Rajin
  deskripsi    VARCHAR(200) NULL,
  ikon         VARCHAR(10) NOT NULL DEFAULT '🏅',
  syarat_tipe  ENUM('total_buku','total_halaman','total_menit','streak','total_jurnal')
               NOT NULL,
  syarat_nilai INT NOT NULL,                       -- contoh: 10 (buku), 500 (halaman), 7 (hari streak)
  created_at   DATETIME NULL,
  updated_at   DATETIME NULL
) ENGINE=InnoDB;

CREATE TABLE user_lencana (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  lencana_id INT UNSIGNED NOT NULL,
  diraih_pada DATETIME NULL,
  UNIQUE KEY uq_user_lencana (user_id, lencana_id),
  CONSTRAINT fk_ul_user FOREIGN KEY (user_id)
    REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT fk_ul_lencana FOREIGN KEY (lencana_id)
    REFERENCES lencana (id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------- Definisi lencana awal ----------
INSERT INTO lencana (nama, deskripsi, ikon, syarat_tipe, syarat_nilai) VALUES
  ('Langkah Pertama', 'Mengisi jurnal membaca pertama kali',            '🌱', 'total_jurnal',  1),
  ('Pembaca Rajin',   'Mengisi 10 jurnal membaca',                       '📖', 'total_jurnal',  10),
  ('Kutu Buku',       'Menyelesaikan 5 buku',                            '🐛', 'total_buku',    5),
  ('Penjelajah Cerita','Menyelesaikan 10 buku',                          '🧭', 'total_buku',    10),
  ('Pemburu Halaman', 'Membaca total 500 halaman',                       '🎯', 'total_halaman', 500),
  ('Maraton Baca',    'Membaca total 300 menit',                         '🏃', 'total_menit',   300),
  ('Bintang 7 Hari',  'Membaca 7 hari berturut-turut',                   '⭐', 'streak',        7),
  ('Konsisten Sebulan','Mengisi 30 jurnal membaca',                      '🏆', 'total_jurnal',  30);
