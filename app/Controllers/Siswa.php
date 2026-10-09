<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\JurnalModel;
use App\Models\LencanaModel;
use App\Models\UserLencanaModel;

class Siswa extends BaseController
{
    private JurnalModel $jurnal;

    public function __construct()
    {
        $this->jurnal = model(JurnalModel::class);
    }

    private function saya(): int
    {
        return (int) session()->get('user_id');
    }

    public function dashboard()
    {
        $id    = $this->saya();
        $stats = $this->jurnal->statistikSiswa($id);

        $lanjut = $this->jurnal->select('jurnal_baca.*, buku.jumlah_halaman AS total_halaman_buku')
            ->join('buku', 'buku.id = jurnal_baca.buku_id', 'left')
            ->where('siswa_id', $id)
            ->orderBy('tanggal', 'DESC')
            ->findAll(5);

        $seringDibaca = $this->jurnal->select('jurnal_baca.judul_buku, COUNT(*) AS dibaca, buku.warna_sampul AS warna, buku.ikon, buku.penulis')
            ->join('buku', 'buku.judul = jurnal_baca.judul_buku', 'left')
            ->where('jurnal_baca.status', 'terverifikasi')
            ->groupBy('jurnal_baca.judul_buku, buku.warna_sampul, buku.ikon, buku.penulis')
            ->orderBy('dibaca', 'DESC')
            ->findAll(3);

        return view('siswa/dashboard', [
            'judul'       => 'Dashboard',
            'stats'       => $stats,
            'grafik'      => $this->jurnal->grafik7Hari($id),
            'lanjut'      => $lanjut,
            'lencana'     => model(UserLencanaModel::class)->milikUser($id),
            'bukuTerbaru' => model(BukuModel::class)->orderBy('id', 'DESC')->findAll(6),
            'seringDibaca' => $seringDibaca,
        ]);
    }

    public function profil()
    {
        $id   = $this->saya();
        $user = model(\App\Models\UserModel::class)->find($id);
        $kelasNama = '-';
        if ($user && ! empty($user['kelas_id'])) {
            $kelas = model(\App\Models\KelasModel::class)->find((int) $user['kelas_id']);
            $kelasNama = $kelas['nama'] ?? '-';
        }

        return view('siswa/profil', [
            'judul'   => 'Profil Saya',
            'user'    => $user,
            'kelas'   => $kelasNama,
            'stats'   => $this->jurnal->statistikSiswa($id),
            'lencana' => model(UserLencanaModel::class)->milikUser($id),
        ]);
    }

    public function jurnal()
    {
        $daftar = $this->jurnal->where('siswa_id', $this->saya())
            ->orderBy('tanggal', 'DESC')->orderBy('id', 'DESC')->findAll();

        return view('siswa/jurnal_index', ['judul' => 'Jurnal Saya', 'daftar' => $daftar]);
    }

    public function jurnalBaru()
    {
        return view('siswa/jurnal_form', [
            'judul' => 'Isi Jurnal Baru',
            'buku'  => model(BukuModel::class)->orderBy('judul', 'ASC')->findAll(),
            'jurnal' => null,
        ]);
    }

    /** Ambil & validasi isian jurnal dari form. Mengembalikan array data atau redirect response. */
    private function olahFormJurnal()
    {
        $rules = [
            'judul_buku'     => 'required|max_length[200]',
            'tanggal'        => 'required|valid_date',
            'halaman_dari'   => 'required|integer|greater_than_equal_to[0]',
            'halaman_sampai' => 'required|integer|greater_than_equal_to[1]',
            'durasi_menit'   => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[1440]',
            'rating'         => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dari   = (int) $this->request->getPost('halaman_dari');
        $sampai = (int) $this->request->getPost('halaman_sampai');
        if ($sampai < $dari) {
            return redirect()->back()->withInput()
                ->with('errors', ['halaman_sampai' => 'Halaman sampai harus lebih besar dari halaman dari.']);
        }

        if (strtotime((string) $this->request->getPost('tanggal')) > strtotime('today')) {
            return redirect()->back()->withInput()
                ->with('errors', ['tanggal' => 'Tanggal membaca tidak boleh di masa depan.']);
        }

        $bukuId = $this->request->getPost('buku_id');
        $bukuId = ($bukuId === '' || $bukuId === null) ? null : (int) $bukuId;
        $judul  = trim((string) $this->request->getPost('judul_buku'));
        if ($bukuId !== null) {
            $buku = model(BukuModel::class)->find($bukuId);
            if ($buku !== null) {
                $judul = $buku['judul'];
            }
        }

        return [
            'buku_id'        => $bukuId,
            'judul_buku'     => $judul,
            'tanggal'        => $this->request->getPost('tanggal'),
            'halaman_dari'   => $dari,
            'halaman_sampai' => $sampai,
            'jumlah_halaman' => $sampai - $dari + 1,
            'durasi_menit'   => (int) $this->request->getPost('durasi_menit'),
            'ringkasan'      => trim((string) $this->request->getPost('ringkasan')),
            'pesan_cerita'   => trim((string) $this->request->getPost('pesan_cerita')),
            'rating'         => (int) $this->request->getPost('rating'),
            'perasaan'       => $this->request->getPost('perasaan') ?: '😊',
        ];
    }

    public function jurnalSimpan()
    {
        $data = $this->olahFormJurnal();
        if (! is_array($data)) {
            return $data; // redirect berisi error
        }
        $data['siswa_id'] = $this->saya();
        $data['status']   = 'menunggu';
        $this->jurnal->insert($data);

        return redirect()->to('/siswa/jurnal')
            ->with('celebrate', $data)
            ->with('success', 'Yeay! Jurnalmu sudah tersimpan dan menunggu diperiksa guru. 🎉');
    }

    public function jurnalEdit(int $id)
    {
        $j = $this->milikSaya($id);
        if ($j === null) {
            return redirect()->to('/siswa/jurnal')->with('error', 'Jurnal tidak ditemukan.');
        }
        if ($j['status'] === 'terverifikasi') {
            return redirect()->to('/siswa/jurnal')->with('error', 'Jurnal yang sudah terverifikasi tidak bisa diubah.');
        }
        return view('siswa/jurnal_form', [
            'judul'  => 'Ubah Jurnal',
            'buku'   => model(BukuModel::class)->orderBy('judul', 'ASC')->findAll(),
            'jurnal' => $j,
        ]);
    }

    public function jurnalUpdate(int $id)
    {
        $j = $this->milikSaya($id);
        if ($j === null || $j['status'] === 'terverifikasi') {
            return redirect()->to('/siswa/jurnal')->with('error', 'Jurnal tidak bisa diubah.');
        }
        $data = $this->olahFormJurnal();
        if (! is_array($data)) {
            return $data;
        }
        $data['status']        = 'menunggu';
        $data['catatan_guru']  = null;
        $this->jurnal->update($id, $data);

        return redirect()->to('/siswa/jurnal')->with('success', 'Jurnal berhasil diperbarui. 👍');
    }

    public function jurnalHapus(int $id)
    {
        $j = $this->milikSaya($id);
        if ($j === null || $j['status'] === 'terverifikasi') {
            return redirect()->to('/siswa/jurnal')->with('error', 'Jurnal tidak bisa dihapus.');
        }
        $this->jurnal->delete($id);
        return redirect()->to('/siswa/jurnal')->with('success', 'Jurnal dihapus.');
    }

    private function milikSaya(int $id): ?array
    {
        $j = $this->jurnal->find($id);
        return ($j !== null && (int) $j['siswa_id'] === $this->saya()) ? $j : null;
    }

    public function buku()
    {
        $genre = $this->request->getGet('genre');
        $q     = trim((string) $this->request->getGet('q'));
        $m     = model(BukuModel::class);
        if ($genre && in_array($genre, BukuModel::GENRE, true)) {
            $m = $m->where('genre', $genre);
        }
        if ($q !== '') {
            $m = $m->like('judul', $q);
        }
        return view('siswa/buku', [
            'judul' => 'Katalog Buku',
            'buku'  => $m->orderBy('judul', 'ASC')->findAll(),
            'genre' => $genre,
            'q'     => $q,
        ]);
    }

    public function lencana()
    {
        $id     = $this->saya();
        $stats  = $this->jurnal->statistikSiswa($id);
        $semua  = model(LencanaModel::class)->orderBy('syarat_nilai', 'ASC')->findAll();
        $milik  = model(UserLencanaModel::class)->milikUser($id);
        $punya  = array_column($milik, 'lencana_id');

        return view('siswa/lencana', [
            'judul' => 'Lencana Saya', 'semua' => $semua,
            'punya' => $punya, 'stats' => $stats,
        ]);
    }

    public function peringkat()
    {
        $kelasId = session()->get('kelas_id');
        return view('siswa/peringkat', [
            'judul' => 'Peringkat Kelas',
            'board' => $kelasId ? $this->jurnal->leaderboardKelas((int) $kelasId, 32) : [],
        ]);
    }
}
