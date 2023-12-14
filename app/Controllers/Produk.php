<?php

namespace App\Controllers;

use App\Models\Modelkategori;
use App\Models\Modelproduk;
use App\Models\Modelsatuan;

class Produk extends BaseController
{
    public function __construct()
    {
        $this->produk = new Modelproduk();
        $this->kategori = new Modelkategori();
        $this->satuan = new Modelsatuan();
        $this->db = db_connect();
    }

    public function index()
    {
        //fitur search 
        //jika ada keyword maka search, jika tidak panggil model 
        //ambil keyword 
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $item_search = $this->produk->search($keyword)->join('kategori', 'kategori.katid=produk.produk_katid')->join('satuan', 'satuan.satid = produk.produk_satid')->select('produk.*, kategori.katnama as kategori_nama,satuan.satnama as satuan_nama ');
        } else {
            $item_search = $this->produk->join('kategori', 'kategori.katid=produk.produk_katid')->join('satuan', 'satuan.satid=produk.produk_satid')->select('produk.*, kategori.katnama as kategori_nama, satuan.satnama as satuan_nama');
        }
        // currentpage = untuk keperluan penomoran data pada tabel
        $currentPage = $this->request->getVar('page_item') ? $this->request->getVar('page_item') : 1;

        $data = [
            'dataproduk' => $item_search->paginate(5, 'produk'),
            'pager' => $this->produk->pager,
            'currentPage' => $currentPage
        ];

        return view('produk/data', $data);
    }

    // public function index()
    // {

    //     $data = [
    //         'dataproduk' => $this->produk->join('kategori', 'produk_katid=katid')
    //             ->join('satuan', 'produk_satid=satid')
    //             ->paginate(10, 'produk'),
    //         'pager' => $this->produk->pager,
    //         // 'nohalaman' => $noHalaman,
    //         // 'cari' => $cari
    //     ];
    //     return view('produk/data', $data);
    // }

    public function add()
    {
        return view('produk/formtambah');
    }

    public function ambilDataKategori()
    {
        if ($this->request->isAJAX()) {
            $datakategori = $this->db->table('kategori')->get();

            $isidata = "<option value='' selected>-Pilih-</option>";

            foreach ($datakategori->getResultArray() as $row) :
                $isidata .= '<option value="' . $row['katid'] . '">' . $row['katnama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }

    public function ambilDataSatuan()
    {
        if ($this->request->isAJAX()) {
            $datasatuan = $this->db->table('satuan')->get();

            $isidata = "<option value='' selected>-Pilih-</option>";

            foreach ($datasatuan->getResultArray() as $row) :
                $isidata .= '<option value="' . $row['satid'] . '">' . $row['satnama'] . '</option>';
            endforeach;

            $msg = [
                'data' => $isidata
            ];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $kodebarcode = $this->request->getVar('kodebarcode');
            $namaproduk = $this->request->getVar('namaproduk');
            $stok = $this->request->getVar('stok');
            $kategori = $this->request->getVar('kategori');
            $satuan = $this->request->getVar('satuan');
            $hargabeli = str_replace(',', '', $this->request->getVar('hargabeli'));
            $hargajual = str_replace(',', '', $this->request->getVar('hargajual'));

            $validation =  \Config\Services::validation();

            $doValid = $this->validate([
                'kodebarcode' => [
                    'label' => 'Kode Barcode',
                    'rules' => 'is_unique[produk.kodebarcode]|required',
                    'errors' => [
                        'is_unique' => '{field} sudah ada, coba dengan kode yang lain',
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'namaproduk' => [
                    'label' => 'Nama Produk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'stok' => [
                    'label' => 'Stok Tersedia',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'kategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib dipilih'
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib dipilih'
                    ]
                ],
                'hargabeli' => [
                    'label' => 'Harga Beli',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh Kosong',
                    ]
                ],
                'hargajual' => [
                    'label' => 'Harga Jual',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh Kosong'
                    ]
                ],
                'uploadgambar' => [
                    'label' => 'Upload Gambar',
                    'rules' => 'mime_in[uploadgambar,image/png,image/jpg,image/jpeg]|ext_in[uploadgambar,png,jpg,jpeg]|is_image[uploadgambar]',
                ]
            ]);

            if (!$doValid) {
                $msg = [
                    'error' => [
                        'errorKodeBarcode' => $validation->getError('kodebarcode'),
                        'errorNamaProduk' => $validation->getError('namaproduk'),
                        'errorStok' => $validation->getError('stok'),
                        'errorKategori' => $validation->getError('kategori'),
                        'errorSatuan' => $validation->getError('satuan'),
                        'errorHargaBeli' => $validation->getError('hargabeli'),
                        'errorHargaJual' => $validation->getError('hargajual'),
                        'errorUpload' => $validation->getError('uploadgambar')
                    ]
                ];
            } else {
                $uploadGambar = $_FILES['uploadgambar']['name'];

                if ($uploadGambar != NULL) {
                    $namaFileGambar = "$kodebarcode-$namaproduk";
                    $fileGambar = $this->request->getFile('uploadgambar');
                    $fileGambar->move('assets/upload', $namaFileGambar . '.' . $fileGambar->getExtension());

                    $pathGambar = 'assets/upload/' . $fileGambar->getName();
                } else {
                    $pathGambar = '';
                }

                $this->produk->insert([
                    'kodebarcode' => $kodebarcode,
                    'namaproduk' => $namaproduk,
                    'produk_satid' => $satuan,
                    'produk_katid' => $kategori,
                    'stok_tersedia' => $stok,
                    'hargabeli' => $hargabeli,
                    'hargajual' => $hargajual,
                    'gambar' => $pathGambar
                ]);

                $msg = [
                    'sukses' => 'Berhasil dieksekusi'
                ];
            }

            echo json_encode($msg);
        }
    }

    public function edit($id)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'item' => $this->produk->where(['kodebarcode' => $id])->first(),
            'kategori' => $this->kategori->findAll(),
            'satuan' => $this->satuan->findAll(),
        ];
        return view('produk/formedit', $data);
    }

    public function update($id)
    {
        //$item lama akan mengambil data berdasarkan id
        $itemLama = $this->produk->where(['kodebarcode' => $id])->first();
        // jika barcode item = barcode item yang ada di form, maka barcode harus diisi (form otomatis terisi karena valuenya udah terisi) (tapi form tidak bisa kosong), 
        // namun jika user memasukkan barcode item baru, maka barcode harus diisi & harus uniq 
        if ($itemLama['kodebarcode'] == $this->request->getVar('barcode')) {
            $rules_barcode_item = 'required';
        } else {
            $rules_barcode_item = 'required|is_unique[produk.kodebarcode]';
        }

        //validasi form input
        if (!$this->validate([
            //'name' merupakan nama dari inputan form 
            'kodebarcode' => [
                'rules' => $rules_barcode_item,
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'is_unique' => '{field} customer sudah terdaftar.',
                ]
            ],
            'namaproduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama produk harus diisi'
                ]
            ],
            'katid' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus diisi'
                ]
            ],
            'satid' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Satuan harus diisi'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'numeric' => 'masukkan {field} dengan angka'
                ]
            ],
            'image'=>[
                'rules'=>'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg, image/jpeg, image/png]',
                'errors'
            ]
        ]));
    }

    public function delete($id)
    {
        $hapusGambar = $this->produk->find($id);
        if ($hapusGambar['gambar'] !== NULL) {
            unlink($hapusGambar['gambar']);
        }

        $this->produk->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('produk/data');
    }
}
