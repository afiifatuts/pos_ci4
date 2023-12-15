<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelitem extends Model
{
    protected $table      = 'items';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'nama', 'kategori', 'ukuran', 'harga', 'status', 'created_at'];

    public function cariData($cari)
    {
        return $this->table('item')->like('nama', $cari);   
    }
}
