<?php

namespace App\Models;

use CodeIgniter\Model;

class LencanaModel extends Model
{
    protected $table            = 'lencana';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'deskripsi', 'ikon', 'syarat_tipe', 'syarat_nilai'];
    protected $useTimestamps    = true;
}
