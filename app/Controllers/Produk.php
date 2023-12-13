<?php

namespace App\Controllers;

use App\Models\Modelproduk;

class Produk extends BaseController
{
    public function __construct()
    {
        $this->produk = new Modelproduk();
        $this->db = db_connect();
    }

    public function index()
    {

        $data = [
            'dataproduk' => $this->produk->join('kategori', 'produk_katid=katid')
                ->join('satuan', 'produk_satid=satid')
                ->paginate(10, 'produk'),
            'pager' => $this->produk->pager,
            // 'nohalaman' => $noHalaman,
            // 'cari' => $cari
        ];
        return view('produk/data', $data);
    }

    public function add()
    {
        return view('produk/formtambah');
    }

    // public function ambilDataKategori()
    // {
    //     if
    // }
}
