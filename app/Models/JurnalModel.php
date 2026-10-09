<?php

namespace App\Models;

use CodeIgniter\Model;

class JurnalModel extends Model
{
    protected $table            = 'jurnal_baca';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'siswa_id', 'buku_id', 'judul_buku', 'tanggal', 'halaman_dari', 'halaman_sampai',
        'jumlah_halaman', 'durasi_menit', 'ringkasan', 'pesan_cerita', 'rating', 'perasaan',
        'status', 'catatan_guru', 'diverifikasi_oleh', 'diverifikasi_pada',
    ];
    protected $useTimestamps = true;

    // ------------------------------------------------------------------
    // Statistik satu siswa — hanya jurnal TERVERIFIKASI yang dihitung.
    // ------------------------------------------------------------------
    public function statistikSiswa(int $siswaId): array
    {
        $row = $this->select('COUNT(*) AS total_jurnal,
                              COALESCE(SUM(jumlah_halaman),0) AS total_halaman,
                              COALESCE(SUM(durasi_menit),0) AS total_menit,
                              COUNT(DISTINCT judul_buku) AS total_buku')
            ->where('siswa_id', $siswaId)
            ->where('status', 'terverifikasi')
            ->first();

        return [
            'total_jurnal'  => (int) ($row['total_jurnal'] ?? 0),
            'total_halaman' => (int) ($row['total_halaman'] ?? 0),
            'total_menit'   => (int) ($row['total_menit'] ?? 0),
            'total_buku'    => (int) ($row['total_buku'] ?? 0),
            'streak'        => $this->hitungStreak($siswaId),
        ];
    }

    /** Streak = jumlah hari berurutan (berakhir hari ini / kemarin) dengan jurnal terverifikasi. */
    public function hitungStreak(int $siswaId): int
    {
        $rows = $this->select('tanggal')
            ->where('siswa_id', $siswaId)
            ->where('status', 'terverifikasi')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        if ($rows === []) {
            return 0;
        }

        $hariIni  = new \DateTimeImmutable('today');
        $terakhir = new \DateTimeImmutable($rows[0]['tanggal']);
        // Streak putus bila jurnal terakhir lebih dari 1 hari yang lalu.
        if ($hariIni->diff($terakhir)->days > 1) {
            return 0;
        }

        $streak   = 0;
        $expected = $terakhir;
        foreach ($rows as $r) {
            $t = new \DateTimeImmutable($r['tanggal']);
            if ($t == $expected) {
                $streak++;
                $expected = $expected->modify('-1 day');
            } else {
                break;
            }
        }
        return $streak;
    }

    /** Data grafik 7 hari terakhir: label hari + total menit per hari. */
    public function grafik7Hari(int $siswaId): array
    {
        $labels = [];
        $menit  = [];
        $namaHari = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];

        for ($i = 6; $i >= 0; $i--) {
            $tgl      = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = $namaHari[(int) date('N', strtotime($tgl))];
            $row      = $this->select('COALESCE(SUM(durasi_menit),0) AS m')
                ->where('siswa_id', $siswaId)
                ->where('status', 'terverifikasi')
                ->where('tanggal', $tgl)
                ->first();
            $menit[] = (int) ($row['m'] ?? 0);
        }
        return ['labels' => $labels, 'menit' => $menit];
    }

    /** Grafik kelas: total menit membaca per hari (7 hari) untuk semua siswa di kelas. */
    public function grafikKelas7Hari(int $kelasId): array
    {
        $labels = [];
        $menit  = [];
        $namaHari = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];
        $db = \Config\Database::connect();

        for ($i = 6; $i >= 0; $i--) {
            $tgl      = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = $namaHari[(int) date('N', strtotime($tgl))];
            $row      = $db->table('jurnal_baca j')
                ->select('COALESCE(SUM(j.durasi_menit),0) AS m')
                ->join('users u', 'u.id = j.siswa_id')
                ->where('u.kelas_id', $kelasId)
                ->where('j.status', 'terverifikasi')
                ->where('j.tanggal', $tgl)
                ->get()->getRowArray();
            $menit[] = (int) ($row['m'] ?? 0);
        }
        return ['labels' => $labels, 'menit' => $menit];
    }

    /** Leaderboard satu kelas berdasarkan jurnal terverifikasi. */
    public function leaderboardKelas(int $kelasId, int $limit = 10): array
    {
        $db = \Config\Database::connect();
        return $db->table('users u')
            ->select('u.id, u.nama, u.avatar,
                      COUNT(j.id) AS total_jurnal,
                      COALESCE(SUM(j.jumlah_halaman),0) AS total_halaman,
                      COALESCE(SUM(j.durasi_menit),0) AS total_menit,
                      COUNT(DISTINCT j.judul_buku) AS total_buku')
            ->join('jurnal_baca j', 'j.siswa_id = u.id AND j.status = \'terverifikasi\'', 'left')
            ->where('u.role', 'siswa')
            ->where('u.kelas_id', $kelasId)
            ->groupBy('u.id, u.nama, u.avatar')
            ->orderBy('total_halaman', 'DESC')
            ->orderBy('total_jurnal', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    /** Jurnal menunggu verifikasi untuk siswa-siswa di satu kelas. */
    public function menungguDiKelas(int $kelasId): array
    {
        return $this->select('jurnal_baca.*, users.nama AS nama_siswa, users.avatar')
            ->join('users', 'users.id = jurnal_baca.siswa_id')
            ->where('users.kelas_id', $kelasId)
            ->where('jurnal_baca.status', 'menunggu')
            ->orderBy('jurnal_baca.tanggal', 'ASC')
            ->findAll();
    }

    /** ID siswa di kelas yang belum punya jurnal terverifikasi dalam 7 hari terakhir. */
    public function belumMembacaMingguIni(int $kelasId): array
    {
        $db    = \Config\Database::connect();
        $aktif = $db->table('jurnal_baca j')
            ->select('j.siswa_id')
            ->join('users u', 'u.id = j.siswa_id')
            ->where('u.kelas_id', $kelasId)
            ->where('j.status', 'terverifikasi')
            ->where('j.tanggal >=', date('Y-m-d', strtotime('-6 days')))
            ->groupBy('j.siswa_id')
            ->get()->getResultArray();
        $aktifIds = array_column($aktif, 'siswa_id');

        $semua = model(UserModel::class)->siswaDiKelas($kelasId);
        return array_values(array_filter($semua, static fn ($s) => ! in_array($s['id'], $aktifIds, false)));
    }

    // ------------------------------------------------------------------
    // Lencana otomatis — dipanggil setelah jurnal terverifikasi /
    // setelah siswa menambah jurnal. Mengembalikan lencana yang BARU diraih.
    // ------------------------------------------------------------------
    public function periksaLencana(int $siswaId): array
    {
        $stats    = $this->statistikSiswa($siswaId);
        $lencanaM = model(LencanaModel::class);
        $milikM   = model(UserLencanaModel::class);
        $baru     = [];

        foreach ($lencanaM->findAll() as $l) {
            $nilai = $stats[$l['syarat_tipe']] ?? 0;
            if ($nilai >= (int) $l['syarat_nilai'] && ! $milikM->sudahPunya($siswaId, (int) $l['id'])) {
                $milikM->insert([
                    'user_id'     => $siswaId,
                    'lencana_id'  => $l['id'],
                    'diraih_pada' => date('Y-m-d H:i:s'),
                ]);
                $baru[] = $l;
            }
        }
        return $baru;
    }
}
