<?php

namespace App\Controllers;

use App\Models\Modelitem;
use App\Models\Modelkategori;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;


class Transaksi extends BaseController
{
    public function __construct()
    {
        $this->item = new Modelitem;
        $this->kategori = new Modelkategori;
        $this->db = db_connect();
    }
    public function index()
    {
        //mengambil value dari request post
        $tombolCari = $this->request->getPost('search');

        //cek apakah ada value dari postnya 
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('keywords');
            session()->set('searchItem', $cari);
            redirect()->to('item/dataItem');
        } else {
            $cari = session()->get('searchItem');
        }

        $dataItem = $cari ? $this->item->cariData($cari) : $this->item;
        $dataItem->orderBy('id', 'desc');

        $noHalaman = $this->request->getVar('page_item') ? $this->request->getVar('page_item') : 1;

        $data = [
            'dataitem' => $dataItem->paginate(10, 'item'),
            'pager' => $this->item->pager,
            'nohalaman' => $noHalaman,
            'cari' => $cari
        ];

        return view('item/dataItem', $data);
    }
}
