<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLencanaModel extends Model
{
    protected $table            = 'user_lencana';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'lencana_id', 'diraih_pada'];
    protected $useTimestamps    = false;

    public function milikUser(int $userId): array
    {
        return $this->select('lencana.*, user_lencana.diraih_pada')
            ->join('lencana', 'lencana.id = user_lencana.lencana_id')
            ->where('user_lencana.user_id', $userId)
            ->orderBy('user_lencana.diraih_pada', 'ASC')
            ->findAll();
    }

    public function sudahPunya(int $userId, int $lencanaId): bool
    {
        return $this->where('user_id', $userId)->where('lencana_id', $lencanaId)->countAllResults() > 0;
    }
}
