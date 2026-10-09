<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\JurnalModel;
use App\Models\KelasModel;
use App\Models\LencanaModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $db = \Config\Database::connect();
        return view('admin/dashboard', [
            'judul' => 'Dashboard Admin',
            'ringkas' => [
                'users'   => model(UserModel::class)->countAllResults(),
                'guru'    => model(UserModel::class)->where('role', 'guru')->countAllResults(),
                'siswa'   => model(UserModel::class)->where('role', 'siswa')->countAllResults(),
                'kelas'   => model(KelasModel::class)->countAllResults(),
                'buku'    => model(BukuModel::class)->countAllResults(),
                'jurnal'  => model(JurnalModel::class)->countAllResults(),
                'menunggu' => model(JurnalModel::class)->where('status', 'menunggu')->countAllResults(),
                'lencana' => model(LencanaModel::class)->countAllResults(),
            ],
            'kelas' => model(KelasModel::class)->denganGuru(),
            'aktivitas' => $db->table('jurnal_baca j')
                ->select('j.*, u.nama AS nama_siswa')
                ->join('users u', 'u.id = j.siswa_id')
                ->orderBy('j.id', 'DESC')->limit(8)->get()->getResultArray(),
        ]);
    }

    // ---------------- Users ----------------
    public function users()
    {
        $users = model(UserModel::class)
            ->select('users.*, kelas.nama AS nama_kelas')
            ->join('kelas', 'kelas.id = users.kelas_id', 'left')
            ->orderBy('users.role', 'ASC')->orderBy('users.nama', 'ASC')
            ->findAll();
        return view('admin/users', ['judul' => 'Kelola User', 'users' => $users]);
    }

    public function userBaru()
    {
        return view('admin/user_form', [
            'judul' => 'Tambah User', 'user' => null,
            'kelas' => model(KelasModel::class)->orderBy('tingkat')->orderBy('nama')->findAll(),
        ]);
    }

    public function userEdit(int $id)
    {
        $u = model(UserModel::class)->find($id);
        if ($u === null) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }
        return view('admin/user_form', [
            'judul' => 'Ubah User', 'user' => $u,
            'kelas' => model(KelasModel::class)->orderBy('tingkat')->orderBy('nama')->findAll(),
        ]);
    }

    public function userSimpan()
    {
        $rules = [
            'nama'     => 'required|max_length[100]',
            'username' => 'required|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,guru,siswa]',
            'email'    => 'permit_empty|valid_email|max_length[100]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        model(UserModel::class)->insert([
            'nama'          => trim((string) $this->request->getPost('nama')),
            'username'      => trim((string) $this->request->getPost('username')),
            'email'         => trim((string) $this->request->getPost('email')) ?: null,
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => $this->request->getPost('role'),
            'kelas_id'      => $this->request->getPost('kelas_id') ?: null,
            'avatar'        => $this->request->getPost('avatar') ?: '🦊',
            'is_active'     => 1,
        ]);
        return redirect()->to('/admin/users')->with('success', 'User baru berhasil dibuat. 🎉');
    }

    public function userUpdate(int $id)
    {
        $m = model(UserModel::class);
        if ($m->find($id) === null) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }
        $rules = [
            'nama'     => 'required|max_length[100]',
            'username' => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'password' => 'permit_empty|min_length[6]',
            'role'     => 'required|in_list[admin,guru,siswa]',
            'email'    => 'permit_empty|valid_email|max_length[100]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = [
            'nama'      => trim((string) $this->request->getPost('nama')),
            'username'  => trim((string) $this->request->getPost('username')),
            'email'     => trim((string) $this->request->getPost('email')) ?: null,
            'role'      => $this->request->getPost('role'),
            'kelas_id'  => $this->request->getPost('kelas_id') ?: null,
            'avatar'    => $this->request->getPost('avatar') ?: '🦊',
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];
        $pw = (string) $this->request->getPost('password');
        if ($pw !== '') {
            $data['password_hash'] = password_hash($pw, PASSWORD_DEFAULT);
        }
        $m->update($id, $data);
        return redirect()->to('/admin/users')->with('success', 'User berhasil diperbarui.');
    }

    public function userHapus(int $id)
    {
        if ((int) $id === (int) session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        model(UserModel::class)->delete($id);
        return redirect()->to('/admin/users')->with('success', 'User dihapus.');
    }

    // ---------------- Kelas ----------------
    public function kelas()
    {
        return view('admin/kelas', [
            'judul' => 'Kelola Kelas',
            'kelas' => model(KelasModel::class)->denganGuru(),
        ]);
    }

    public function kelasBaru()
    {
        return view('admin/kelas_form', [
            'judul' => 'Tambah Kelas', 'kelas' => null,
            'guru'  => model(UserModel::class)->where('role', 'guru')->orderBy('nama')->findAll(),
        ]);
    }

    public function kelasEdit(int $id)
    {
        $k = model(KelasModel::class)->find($id);
        if ($k === null) {
            return redirect()->to('/admin/kelas')->with('error', 'Kelas tidak ditemukan.');
        }
        return view('admin/kelas_form', [
            'judul' => 'Ubah Kelas', 'kelas' => $k,
            'guru'  => model(UserModel::class)->where('role', 'guru')->orderBy('nama')->findAll(),
        ]);
    }

    private function olahKelas()
    {
        $rules = [
            'nama'    => 'required|max_length[50]',
            'tingkat' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[12]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        return [
            'nama'         => trim((string) $this->request->getPost('nama')),
            'tingkat'      => (int) $this->request->getPost('tingkat'),
            'tahun_ajaran' => trim((string) $this->request->getPost('tahun_ajaran')) ?: '2026/2027',
            'guru_id'      => $this->request->getPost('guru_id') ?: null,
        ];
    }

    public function kelasSimpan()
    {
        $data = $this->olahKelas();
        if (! is_array($data)) {
            return $data;
        }
        $id = model(KelasModel::class)->insert($data);
        if ($data['guru_id']) {
            model(UserModel::class)->update($data['guru_id'], ['kelas_id' => $id]);
        }
        return redirect()->to('/admin/kelas')->with('success', 'Kelas berhasil dibuat. 🏫');
    }

    public function kelasUpdate(int $id)
    {
        $data = $this->olahKelas();
        if (! is_array($data)) {
            return $data;
        }
        model(KelasModel::class)->update($id, $data);
        if ($data['guru_id']) {
            model(UserModel::class)->update($data['guru_id'], ['kelas_id' => $id]);
        }
        return redirect()->to('/admin/kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function kelasHapus(int $id)
    {
        model(KelasModel::class)->delete($id);
        return redirect()->to('/admin/kelas')->with('success', 'Kelas dihapus.');
    }

    // ---------------- Monitoring ----------------
    public function jurnal()
    {
        $daftar = model(JurnalModel::class)
            ->select('jurnal_baca.*, users.nama AS nama_siswa, users.avatar, kelas.nama AS nama_kelas')
            ->join('users', 'users.id = jurnal_baca.siswa_id')
            ->join('kelas', 'kelas.id = users.kelas_id', 'left')
            ->orderBy('jurnal_baca.tanggal', 'DESC')
            ->findAll(100);
        return view('guru/jurnal', ['judul' => 'Semua Jurnal (Monitoring)', 'daftar' => $daftar]);
    }

    public function lencana()
    {
        return view('admin/lencana', [
            'judul'   => 'Definisi Lencana',
            'lencana' => model(LencanaModel::class)->orderBy('syarat_tipe')->orderBy('syarat_nilai')->findAll(),
        ]);
    }
}
