<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama', 'username', 'email', 'password_hash', 'role',
        'kelas_id', 'avatar', 'is_active',
    ];
    protected $useTimestamps = true;

    public function byUsername(string $username): ?array
    {
        return $this->where('username', $username)->first();
    }

    public function siswaDiKelas(int $kelasId): array
    {
        return $this->where('role', 'siswa')
            ->where('kelas_id', $kelasId)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }
}
