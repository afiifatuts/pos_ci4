<?php

namespace App\Controllers;

use App\Models\Modelitem;
use App\Models\Modelkategori;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;


class Item extends BaseController
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
    private function getRowIndexByName($values, $name)
    {
        foreach ($values as $index => $row) {
            if (!empty($row[0]) && $row[0] == $name) { // Assuming name is in the first column
                return $index + 1; // Adjusting to 1-based index
            }
        }

        return null; // Name not found
    }

    private function deleteRow($client, $spreadsheetId, $sheetName, $rowIndex)
    {
        $service = new \Google_Service_Sheets($client);

        $requests = [
            'deleteDimension' => [
                'range' => [
                    'sheetId' => 0,
                    'dimension' => 'ROWS',
                    'startIndex' => $rowIndex - 1, // Adjusting to 0-based index
                    'endIndex' => $rowIndex,
                ],
            ],
        ];

        $batchUpdateRequest = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => $requests,
        ]);

        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }

    public function hapus()
    {

        if ($this->request->isAJAX()) {
            // Use the Google API client library without requiring autoload.php
            $client = new \Google_Client();
            $client->setApplicationName('Your Application Name');
            $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
            $client->setAuthConfig($this->credentialsPath());
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            // For example:
            $spreadsheetId = '11eyL4MI9ATISrnoMcR8z_ghhTEVrbCXEYETAf_0Td78';

            // Get the sheet data
            $service = new \Google_Service_Sheets($client);
            $range = '2020'; // Change to your sheet name or range
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values)) {
                // No data found in the sheet
                return;
            }
            $nama = $this->request->getVar('nama');

            // Find the row index where the name matches
            $rowIndexToDelete = $this->getRowIndexByName($values, $nama);

            if ($rowIndexToDelete !== null) {
                // Delete the row
                $this->deleteRow($client, $spreadsheetId, '2020', $rowIndexToDelete);
            }


            $idItem = $this->request->getVar('idItem');
            //hapus di database
            $this->item->delete($idItem);

            $msg = [
                'sukses' => 'Item berhasil Dihapus'
            ];
            echo json_encode($msg);
        }
    }


    public function edit($id)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            // mengambil satu baris data berdasarkan id(database) sama dengan $id
            'item'    => $this->item->where(['id' => $id])->first(),
            'kategori'     => $this->kategori->findAll(), //untuk menampilkan data (value=id_category) dan (option name_category) 
        ];
        return view('item/formedit', $data);
    }

    // Function to find the row index based on 'nama'
    private function findRowIndexByNama($service, $spreadsheetId, $sheetName, $nama)
    {
        $range = $sheetName . '!A:A'; // Assuming 'nama' is in the first column

        // Fetch all values in the 'nama' column
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        // Find the row index where 'nama' matches
        foreach ($values as $index => $row) {
            if (!empty($row[0]) && $row[0] == $nama) {
                return $index + 1; // Adjusting to 1-based index
            }
        }

        return null; // 'nama' not found
    }

    public function update($id)
    {
        $client = new Google_Client();
        $client->setApplicationName('Your Application Name');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $client->setAuthConfig($this->credentialsPath());
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $service = new Google_Service_Sheets($client);
        $spreadsheetId = '11eyL4MI9ATISrnoMcR8z_ghhTEVrbCXEYETAf_0Td78';

        $nama        = $this->request->getVar('nama');
        $kategori        = $this->request->getVar('kategori');
        $ukuran    = $this->request->getVar('ukuran');
        $harga        = $this->request->getVar('harga');
        $status        = $this->request->getVar('status');



        // Find the row index based on 'nama'
        $rowIndex = $this->findRowIndexByNama($service, $spreadsheetId, '2020', $nama);


        if ($rowIndex !== null) {
            // Construct the range for the specific row
            $range = '2020!A' . $rowIndex . ':E' . $rowIndex;

            // Update the values
            $values = [
                [$nama, $kategori, $ukuran, $harga, $status],
            ];
            $body = new Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);

            // Set the update parameters
            $params = [
                'valueInputOption' => 'RAW'
            ];

            // Execute the update request
            $result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
        }

        // update data hampir sama dengan save, 
        // disini id harus diisi, agar tidak membuat data baru
        $this->item->save([
            'id'        => $id,
            'nama'        => $this->request->getVar('nama'),
            'kategori'        => $this->request->getVar('kategori'),
            'ukuran'    => $this->request->getVar('ukuran'),
            'harga'        => $this->request->getVar('harga'),
            'status'        => $this->request->getVar('status')
        ]);

        // flashData
        session()->setFlashdata('pesan', 'Data berhasil diedit.');
        // redirect ke halaman category setelah save data DENGAN BENAR
        return redirect()->to(site_url('item/index'));
    }
}
