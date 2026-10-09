<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'tingkat', 'tahun_ajaran', 'guru_id'];
    protected $useTimestamps    = true;

    public function denganGuru(): array
    {
        return $this->select('kelas.*, users.nama AS nama_guru')
            ->join('users', 'users.id = kelas.guru_id', 'left')
            ->orderBy('kelas.tingkat', 'ASC')
            ->orderBy('kelas.nama', 'ASC')
            ->findAll();
    }
}
