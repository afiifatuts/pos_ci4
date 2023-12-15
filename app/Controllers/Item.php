<?php

namespace App\Controllers;

use App\Models\Modelitem;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;


class Item extends BaseController
{
    public function __construct()
    {
        $this->item = new Modelitem;
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

    public function formTambah()
    {
        return view('item/formtambah');
    }

    public function ambilDataKategori()
    {
        if ($this->request->isAJAX()) {
            $dataKategori = $this->db->table('kategori')->get();
            $isidata = "<option value='' selected>-Pilih-</option>";

            foreach ($dataKategori->getResultArray() as $row) :
                $isidata .= '<option value="' . $row['katnama'] . '">' . $row['katnama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];
            echo  json_encode($msg);
        }
    }

    public static function credentialsPath(): string
    {
        // Change the path accordingly
        return ROOTPATH . 'app/Config/credentials.json';
    }
    private function getLastRow($client, $spreadsheetId, $sheetName)
    {
        $service = new \Google_Service_Sheets($client);

        // Get the last row of the specified sheet
        $response = $service->spreadsheets_values->get($spreadsheetId, $sheetName);
        $values = $response->getValues();

        if (!empty($values)) {
            return count($values) + 1; // Adding 1 to get the next empty row
        } else {
            return 2; // Start from the second row if the sheet is empty
        }
    }

    private function updateSheetValues($client, $spreadsheetId, $range, $values)
    {
        $service = new \Google_Service_Sheets($client);

        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => 'RAW'
        ];

        $insert = [
            'insertDataOption' => 'INSERT_ROWS'
        ];

        // Executing the request
        $result = $service->spreadsheets_values->update(
            $spreadsheetId,
            $range,
            $body,
            $params,
            $insert
        );
    }

    private function setRowBackgroundColor($client, $spreadsheetId, $rowIndex, $color)
    {
        $service = new \Google_Service_Sheets($client);

        $requests = [
            'repeatCell' => [
                'range' => [
                    'sheetId' => 0,
                    'startRowIndex' => $rowIndex - 1,
                    'endRowIndex' => $rowIndex,
                    'startColumnIndex' => 4,
                    'endColumnIndex' => 5, // Assuming you have 5 columns
                ],
                'cell' => [
                    'userEnteredFormat' => [
                        'backgroundColor' => [
                            'red' => hexdec(substr($color, 1, 2)) / 255,
                            'green' => hexdec(substr($color, 3, 2)) / 255,
                            'blue' => hexdec(substr($color, 5, 2)) / 255,
                        ],
                    ],
                ],
                'fields' => 'userEnteredFormat.backgroundColor',
            ],
        ];

        $batchUpdateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => $requests,
        ]);

        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }



    public function simpandata()
    {
        // Load the Google Sheets credentials
        $client = new Google_Client();
        $client->setApplicationName('Your Application Name');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig($this->credentialsPath());
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Create the Google Sheets service
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = '11eyL4MI9ATISrnoMcR8z_ghhTEVrbCXEYETAf_0Td78';

        if ($this->request->isAJAX()) {
            $nama = $this->request->getVar('nama');
            $kategori = $this->request->getVar('kategori');
            $ukuran = $this->request->getVar('ukuran');
            $harga = $this->request->getVar('harga');
            $status = $this->request->getVar('status');

            $lastRow = $this->getLastRow($client, $spreadsheetId, '2020');

            // Construct the range
            $range = '2020!A' . $lastRow . ':E' . $lastRow;
            // $range = '2020';
            // $values = [[$nama, $kategori, $ukuran,  $harga, $status]];

            // $body = new Google_Service_Sheets_ValueRange([
            //     'values' => $values
            // ]);
            // $params = [
            //     'valueInputOption' => 'RAW'
            // ];


            // $insert = [
            //     'insertDataOption' => 'INSERT_ROWS'
            // ];
            // //executing the request
            // $result = $service->spreadsheets_values->update(
            //     $spreadsheetId,
            //     $range,
            //     $body,
            //     $params,
            //     $insert
            // );
            // Update the values
            $values = [[$nama, $kategori, $ukuran, $harga, $status]];
            $this->updateSheetValues($client, $spreadsheetId, $range, $values);

            // Style the row based on the status
            if ($status == 'AVAILABLE') {
                $this->setRowBackgroundColor($client, $spreadsheetId, $lastRow, '#FF0000'); // Green
            } else {
                $this->setRowBackgroundColor($client, $spreadsheetId, $lastRow, '#00FF00'); // Red
            }

            $this->item->insert([
                'nama' => $nama,
                'kategori' => $kategori,
                'ukuran' => $ukuran,
                'harga' => $harga,
                'status' => $status,
            ]);

            $msg = [
                'sukses' => 'Data Berhasil Disimpan'
            ];

            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $idItem = $this->request->getVar('idItem');

            $this->item->delete($idItem);

            $msg = [
                'sukses' => 'Item berhasil Dihapus'
            ];
            echo json_encode($msg);
        }
    }
}
