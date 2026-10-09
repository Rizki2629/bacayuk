<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Data demo BacaYuk!
 * Akun: admin/admin123, guru/guru123, siswa/siswa123 (+ 7 siswa contoh)
 */
class BacaYukSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $hash = static fn (string $pw) => password_hash($pw, PASSWORD_DEFAULT);

        // ---------- Lencana ----------
        $lencana = [
            ['nama' => 'Langkah Pertama',   'deskripsi' => 'Mengisi jurnal membaca pertama kali', 'ikon' => '🌱', 'syarat_tipe' => 'total_jurnal',  'syarat_nilai' => 1],
            ['nama' => 'Pembaca Rajin',     'deskripsi' => 'Mengisi 10 jurnal membaca',           'ikon' => '📖', 'syarat_tipe' => 'total_jurnal',  'syarat_nilai' => 10],
            ['nama' => 'Kutu Buku',         'deskripsi' => 'Menyelesaikan 5 buku',                'ikon' => '🐛', 'syarat_tipe' => 'total_buku',    'syarat_nilai' => 5],
            ['nama' => 'Penjelajah Cerita', 'deskripsi' => 'Menyelesaikan 10 buku',               'ikon' => '🧭', 'syarat_tipe' => 'total_buku',    'syarat_nilai' => 10],
            ['nama' => 'Pemburu Halaman',   'deskripsi' => 'Membaca total 500 halaman',           'ikon' => '🎯', 'syarat_tipe' => 'total_halaman', 'syarat_nilai' => 500],
            ['nama' => 'Maraton Baca',      'deskripsi' => 'Membaca total 300 menit',             'ikon' => '🏃', 'syarat_tipe' => 'total_menit',   'syarat_nilai' => 300],
            ['nama' => 'Bintang 7 Hari',    'deskripsi' => 'Membaca 7 hari berturut-turut',       'ikon' => '⭐', 'syarat_tipe' => 'streak',        'syarat_nilai' => 7],
            ['nama' => 'Konsisten Sebulan', 'deskripsi' => 'Mengisi 30 jurnal membaca',           'ikon' => '🏆', 'syarat_tipe' => 'total_jurnal',  'syarat_nilai' => 30],
        ];
        foreach ($lencana as $l) {
            $this->db->table('lencana')->insert($l + ['created_at' => $now, 'updated_at' => $now]);
        }

        // ---------- Kelas ----------
        $this->db->table('kelas')->insert([
            'nama' => '4A', 'tingkat' => 4, 'tahun_ajaran' => '2026/2027',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $kelasId = (int) $this->db->insertID();

        // ---------- Users ----------
        $this->db->table('users')->insert([
            'nama' => 'Admin BacaYuk', 'username' => 'admin', 'email' => 'admin@bacayuk.sch.id',
            'password_hash' => $hash('admin123'), 'role' => 'admin', 'avatar' => '🦉',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $this->db->table('users')->insert([
            'nama' => 'Rizki Pratama', 'username' => 'guru', 'email' => 'guru@bacayuk.sch.id',
            'password_hash' => $hash('guru123'), 'role' => 'guru', 'kelas_id' => $kelasId, 'avatar' => '🦁',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $guruId = (int) $this->db->insertID();
        $this->db->table('kelas')->where('id', $kelasId)->update(['guru_id' => $guruId]);

        $siswaData = [
            ['Aisyah Putri',    'siswa',  '🦊'],
            ['Bima Aditya',     'bima',   '🐯'],
            ['Citra Lestari',   'citra',  '🐰'],
            ['Dimas Prasetyo',  'dimas',  '🐻'],
            ['Eka Nurhaliza',   'eka',    '🐱'],
            ['Fajar Ramadhan',  'fajar',  '🦁'],
            ['Gita Ayu',        'gita',   '🐼'],
            ['Hadi Kurniawan',  'hadi',   '🐸'],
        ];
        $siswaIds = [];
        foreach ($siswaData as [$nama, $username, $avatar]) {
            $this->db->table('users')->insert([
                'nama' => $nama, 'username' => $username,
                'password_hash' => $hash('siswa123'), 'role' => 'siswa',
                'kelas_id' => $kelasId, 'avatar' => $avatar,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $siswaIds[$username] = (int) $this->db->insertID();
        }

        // ---------- Buku ----------
        $bukuData = [
            ['Si Kancil Anak Cerdik', 'Dewi Nastiti', 'Dongeng', 48, '#FF7BAC', '🦌'],
            ['Petualangan ke Luar Angkasa', 'Rudi Hartono', 'Sains', 96, '#4CC9F0', '🚀'],
            ['Malin Kundang', 'Tim Cerita Rakyat', 'Cerita Rakyat', 36, '#2EC4B6', '⛵'],
            ['Puisi Indah untuk Ibu', 'Sari Melati', 'Puisi', 40, '#FFC531', '🌸'],
            ['Komik Si Unyil', 'Kurnia Harto', 'Komik', 64, '#F4845F', '😄'],
            ['Rahasia Hutan Rimba', 'Bambang Setiawan', 'Novel Anak', 120, '#6C4CF1', '🌳'],
        ];
        $bukuIds = [];
        foreach ($bukuData as [$judul, $penulis, $genre, $hal, $warna, $ikon]) {
            $this->db->table('buku')->insert([
                'judul' => $judul, 'penulis' => $penulis, 'genre' => $genre,
                'jumlah_halaman' => $hal, 'warna_sampul' => $warna, 'ikon' => $ikon,
                'ditambah_oleh' => $guruId, 'created_at' => $now, 'updated_at' => $now,
            ]);
            $bukuIds[] = (int) $this->db->insertID();
        }

        // ---------- Jurnal contoh ----------
        // Aisyah: streak 7 hari sampai hari ini (terverifikasi) -> meraih banyak lencana
        $ringkasan = [
            'Ceritanya seru! Tokohnya pintar dan suka menolong teman.',
            'Aku belajar hal baru hari ini. Gambarnya juga bagus.',
            'Bagian paling menarik waktu tokohnya berani mencoba hal baru.',
            'Aku suka karena ceritanya mengajarkan berbuat baik.',
            'Hari ini bacaannya pendek tapi pesannya dalam.',
        ];
        for ($d = 6; $d >= 0; $d--) {
            $bukuIdx = 6 - $d;
            $this->db->table('jurnal_baca')->insert([
                'siswa_id' => $siswaIds['siswa'], 'buku_id' => $bukuIds[$bukuIdx % 6],
                'judul_buku' => $bukuData[$bukuIdx % 6][0],
                'tanggal' => date('Y-m-d', strtotime("-{$d} days")),
                'halaman_dari' => 1 + (6 - $d) * 8, 'halaman_sampai' => 16 + (6 - $d) * 8,
                'jumlah_halaman' => 16, 'durasi_menit' => 20 + $d,
                'ringkasan' => $ringkasan[$d % 5],
                'pesan_cerita' => 'Kita harus rajin dan baik hati kepada semua orang.',
                'rating' => 4 + ($d % 2), 'perasaan' => ['😊', '🤩', '😄', '🥰', '😊', '🤩', '😄'][$d],
                'status' => 'terverifikasi', 'catatan_guru' => 'Bagus sekali, lanjutkan! 🌟',
                'diverifikasi_oleh' => $guruId, 'diverifikasi_pada' => $now,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // Siswa lain: sebaran acak ringan
        $pola = [
            'bima'  => [5, 3, 1],
            'citra' => [4, 2, 0],
            'dimas' => [3, 0],
            'eka'   => [6, 4, 2],
            'fajar' => [1],
            'gita'  => [5, 2],
            'hadi'  => [2],
        ];
        foreach ($pola as $username => $hariList) {
            foreach ($hariList as $i => $d) {
                $this->db->table('jurnal_baca')->insert([
                    'siswa_id' => $siswaIds[$username], 'buku_id' => $bukuIds[$i % 6],
                    'judul_buku' => $bukuData[$i % 6][0],
                    'tanggal' => date('Y-m-d', strtotime("-{$d} days")),
                    'halaman_dari' => 1, 'halaman_sampai' => 10 + $i * 3,
                    'jumlah_halaman' => 10 + $i * 3, 'durasi_menit' => 15 + $i * 5,
                    'ringkasan' => $ringkasan[($i + $d) % 5],
                    'pesan_cerita' => 'Banyak pelajaran baik dari cerita ini.',
                    'rating' => 3 + ($i % 3), 'perasaan' => '😊',
                    'status' => 'terverifikasi', 'catatan_guru' => 'Hebat! Terus semangat ya.',
                    'diverifikasi_oleh' => $guruId, 'diverifikasi_pada' => $now,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        // 2 jurnal MENUNGGU verifikasi (untuk demo guru)
        foreach (['bima', 'citra'] as $i => $username) {
            $this->db->table('jurnal_baca')->insert([
                'siswa_id' => $siswaIds[$username], 'buku_id' => $bukuIds[$i],
                'judul_buku' => $bukuData[$i][0],
                'tanggal' => date('Y-m-d'),
                'halaman_dari' => 17, 'halaman_sampai' => 28, 'jumlah_halaman' => 12,
                'durasi_menit' => 18, 'ringkasan' => $ringkasan[$i],
                'pesan_cerita' => 'Tidak boleh menyerah sebelum mencoba.',
                'rating' => 5, 'perasaan' => '🤩', 'status' => 'menunggu',
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ---------- Hitung lencana dari data demo ----------
        $jurnal = model(\App\Models\JurnalModel::class);
        foreach ($siswaIds as $id) {
            $jurnal->periksaLencana($id);
        }
    }
}
