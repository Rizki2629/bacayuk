<?php

namespace App\Controllers;

use App\Models\BukuModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/** Pembaca buku flipbook (PDF dirender di sisi klien memakai PDF.js + PageFlip). */
class Baca extends BaseController
{
    public function index(int $id)
    {
        $buku = model(BukuModel::class)->find($id);
        if (! $buku) {
            throw PageNotFoundException::forPageNotFound('Buku tidak ditemukan.');
        }

        $role    = (string) session()->get('role');
        $tautan  = (string) ($buku['tautan_pdf'] ?? '');
        $adalahPdf = $tautan !== ''
            && ! str_contains($tautan, 'letsreadasia')
            && str_contains(strtolower($tautan), '.pdf');

        $kembali = match ($role) {
            'siswa' => base_url('siswa/buku'),
            'guru', 'admin' => base_url('buku'),
            default => base_url('login'),
        };

        return view('baca/index', [
            'buku'      => $buku,
            'role'      => $role,
            'adalahPdf' => $adalahPdf,
            'kembali'   => $kembali,
        ]);
    }
}
