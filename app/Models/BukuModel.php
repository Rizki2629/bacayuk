<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'judul', 'penulis', 'penerbit', 'genre', 'jumlah_halaman',
        'warna_sampul', 'ikon', 'deskripsi', 'ditambah_oleh', 'tautan_pdf', 'sampul_url',
    ];
    protected $useTimestamps = true;

    public const GENRE = ['Dongeng', 'Sains', 'Puisi', 'Cerita Rakyat', 'Komik', 'Novel Anak', 'Agama', 'Lainnya'];
}
