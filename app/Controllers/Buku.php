<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    private BukuModel $buku;

    public function __construct()
    {
        $this->buku = model(BukuModel::class);
    }

    public function index()
    {
        return view('buku/index', [
            'judul' => 'Kelola Katalog Buku',
            'buku'  => $this->buku->orderBy('judul', 'ASC')->findAll(),
        ]);
    }

    public function baru()
    {
        return view('buku/form', ['judul' => 'Tambah Buku', 'buku' => null]);
    }

    public function edit(int $id)
    {
        $b = $this->buku->find($id);
        if ($b === null) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }
        return view('buku/form', ['judul' => 'Ubah Buku', 'buku' => $b]);
    }

    private function olahForm()
    {
        $rules = [
            'judul'          => 'required|max_length[200]',
            'penulis'        => 'required|max_length[100]',
            'jumlah_halaman' => 'required|integer|greater_than_equal_to[1]',
            'genre'          => 'required|in_list[' . implode(',', BukuModel::GENRE) . ']',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        return [
            'judul'          => trim((string) $this->request->getPost('judul')),
            'penulis'        => trim((string) $this->request->getPost('penulis')),
            'penerbit'       => trim((string) $this->request->getPost('penerbit')) ?: null,
            'genre'          => $this->request->getPost('genre'),
            'jumlah_halaman' => (int) $this->request->getPost('jumlah_halaman'),
            'warna_sampul'   => $this->request->getPost('warna_sampul') ?: '#6C4CF1',
            'ikon'           => $this->request->getPost('ikon') ?: '📚',
            'deskripsi'      => trim((string) $this->request->getPost('deskripsi')) ?: null,
        ];
    }

    public function simpan()
    {
        $data = $this->olahForm();
        if (! is_array($data)) {
            return $data;
        }
        $data['ditambah_oleh'] = session()->get('user_id');
        $this->buku->insert($data);
        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan ke katalog. 📚');
    }

    public function update(int $id)
    {
        if ($this->buku->find($id) === null) {
            return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
        }
        $data = $this->olahForm();
        if (! is_array($data)) {
            return $data;
        }
        $this->buku->update($id, $data);
        return redirect()->to('/buku')->with('success', 'Buku berhasil diperbarui.');
    }

    public function hapus(int $id)
    {
        $this->buku->delete($id);
        return redirect()->to('/buku')->with('success', 'Buku dihapus dari katalog.');
    }
}
