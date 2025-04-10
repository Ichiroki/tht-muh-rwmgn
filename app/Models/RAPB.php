<?php

namespace App\Models;

use CodeIgniter\Model;

class RAPB extends Model
{
    protected $table            = 'rapb_master';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id', 'nama_kegiatan', 'kategori', 'anggaran', 'tahun', 'deskripsi'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
