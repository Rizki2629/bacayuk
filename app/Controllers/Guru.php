<?php

namespace App\Controllers;

use App\Models\JurnalModel;
use App\Models\UserModel;

class Guru extends BaseController
{
    private JurnalModel $jurnal;

    public function __construct()
    {
        $this->jurnal = model(JurnalModel::class);
    }

    private function kelasSaya(): ?int
    {
        $kelasId = session()->get('kelas_id');
        return $kelasId ? (int) $kelasId : null;
    }

    public function dashboard()
    {
        $kelasId = $this->kelasSaya();
        if ($kelasId === null) {
            return view('guru/dashboard', [
                'judul' => 'Dashboard Guru', 'tanpaKelas' => true,
                'menunggu' => [], 'belum' => [], 'grafik' => ['labels' => [], 'menit' => []],
                'ringkas' => ['siswa' => 0, 'jurnal_minggu' => 0, 'menunggu' => 0],
            ]);
        }

        $db       = \Config\Database::connect();
        $mingguIni = $db->table('jurnal_baca j')
            ->join('users u', 'u.id = j.siswa_id')
            ->where('u.kelas_id', $kelasId)
            ->where('j.tanggal >=', date('Y-m-d', strtotime('-6 days')))
            ->countAllResults();

        $menunggu = $this->jurnal->menungguDiKelas($kelasId);

        return view('guru/dashboard', [
            'judul'    => 'Dashboard Guru',
            'tanpaKelas' => false,
            'menunggu' => array_slice($menunggu, 0, 5),
            'belum'    => $this->jurnal->belumMembacaMingguIni($kelasId),
            'grafik'   => $this->jurnal->grafikKelas7Hari($kelasId),
            'ringkas'  => [
                'siswa'         => model(UserModel::class)->where('role', 'siswa')->where('kelas_id', $kelasId)->countAllResults(),
                'jurnal_minggu' => $mingguIni,
                'menunggu'      => count($menunggu),
            ],
        ]);
    }

    public function verifikasi()
    {
        $kelasId = $this->kelasSaya();
        return view('guru/verifikasi', [
            'judul'   => 'Verifikasi Jurnal',
            'daftar'  => $kelasId ? $this->jurnal->menungguDiKelas($kelasId) : [],
        ]);
    }

    public function verifikasiSimpan(int $id)
    {
        $kelasId = $this->kelasSaya();
        $j = $this->jurnal->select('jurnal_baca.*, users.kelas_id')
            ->join('users', 'users.id = jurnal_baca.siswa_id')
            ->where('jurnal_baca.id', $id)->first();

        if ($j === null || $kelasId === null || (int) $j['kelas_id'] !== $kelasId || $j['status'] !== 'menunggu') {
            return redirect()->to('/guru/verifikasi')->with('error', 'Jurnal tidak ditemukan / sudah diproses.');
        }

        $status = $this->request->getPost('status');
        if (! in_array($status, ['terverifikasi', 'revisi'], true)) {
            return redirect()->back()->with('error', 'Pilih status verifikasi dulu ya.');
        }

        $this->jurnal->update($id, [
            'status'            => $status,
            'catatan_guru'      => trim((string) $this->request->getPost('catatan_guru')) ?: null,
            'diverifikasi_oleh' => session()->get('user_id'),
            'diverifikasi_pada' => date('Y-m-d H:i:s'),
        ]);

        $pesan = 'Jurnal berhasil diverifikasi. ✅';
        if ($status === 'terverifikasi') {
            $baru = $this->jurnal->periksaLencana((int) $j['siswa_id']);
            if ($baru !== []) {
                $pesan .= ' Siswa meraih lencana baru: ' . implode(', ', array_column($baru, 'nama')) . ' 🏅';
            }
        } else {
            $pesan = 'Jurnal dikembalikan untuk direvisi. ✏️';
        }

        return redirect()->to('/guru/verifikasi')->with('success', $pesan);
    }

    public function semuaJurnal()
    {
        $kelasId = $this->kelasSaya();
        $daftar  = [];
        if ($kelasId !== null) {
            $daftar = $this->jurnal->select('jurnal_baca.*, users.nama AS nama_siswa, users.avatar')
                ->join('users', 'users.id = jurnal_baca.siswa_id')
                ->where('users.kelas_id', $kelasId)
                ->orderBy('jurnal_baca.tanggal', 'DESC')
                ->findAll(100);
        }
        return view('guru/jurnal', ['judul' => 'Semua Jurnal Kelas', 'daftar' => $daftar]);
    }

    public function siswa()
    {
        $kelasId = $this->kelasSaya();
        $daftar  = [];
        if ($kelasId !== null) {
            foreach (model(UserModel::class)->siswaDiKelas($kelasId) as $s) {
                $s['stats'] = $this->jurnal->statistikSiswa((int) $s['id']);
                $daftar[]   = $s;
            }
        }
        return view('guru/siswa', ['judul' => 'Siswa Kelas Saya', 'daftar' => $daftar]);
    }

    public function peringkat()
    {
        $kelasId = $this->kelasSaya();
        return view('siswa/peringkat', [
            'judul' => 'Peringkat Kelas',
            'board' => $kelasId ? $this->jurnal->leaderboardKelas($kelasId, 32) : [],
        ]);
    }
}
