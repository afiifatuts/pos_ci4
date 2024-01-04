<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeltransaksi extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'nama_lengkap_penerima', 'nama_lengkap_pengirim', 'nohp_pengirim', 'nohp_penerima', 'nohp_ortu', 'instagram', 'provinsi', 'kota', 'kodepos', 'ekspedisi', 'status_pembayaran', 'dp','harga_sewa','ongkir','denda', 'perlunasan', 'alamat_penerima', 'jenis_item','id_item','nama_item' ,'ukuran', 'tanggal_pickup','jam_pickup', 'no_resi'];

    public function cariData($cari)
    {
        return $this->table('item')->like('nama', $cari);
    }
}
