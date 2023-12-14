<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3><i class="fa fa-fw fa-table"></i> Form Tambah Produk</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-sm btn-warning" onclick="window.location='<?= site_url('produk/index') ?>'">
                <i class="fa fa-backward"></i> Kembali
            </button>
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= form_open_multipart('', ['class' => 'formsimpan']) ?>
        <?= csrf_field(); ?>
        <div class="form-group row">
            <label for="kodebarcode" class="col-sm-4 col-form-label">Kode Barcode</label>
            <div class="col-sm-8">
                <input type="text" class="form-control form-control-sm" id="kodebarcode" name="kodebarcode" autofocus>
                <div class="invalid-feedback errorKodeBarcode" style="display: none;">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="namaproduk" class="col-sm-4 col-form-label">Nama Produk</label>
            <div class="col-sm-8">
                <input type="text" class="form-control form-control-sm" id="namaproduk" name="namaproduk">
                <div class="invalid-feedback errorNamaProduk" style="display: none;">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="stok" class="col-sm-4 col-form-label">Stok Tersedia</label>
            <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" id="stok" name="stok" value="0">
                <div class="invalid-feedback errorStok" style="display: none;">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="kategori" id="kategori">

                </select>
                <div class="invalid-feedback errorKategori" style="display: none;">
                </div>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-sm btn-primary tombolTambahKategori">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>


        <div class="form-group row">
            <label for="satuan" class="col-sm-4 col-form-label">Satuan</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="satuan" id="satuan">

                </select>
                <div class="invalid-feedback errorSatuan" style="display: none;">
                </div>
            </div>
            <div class="col-sm-2">
                <button type="button" class="btn btn-sm btn-primary tombolTambahSatuan">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>


        <div class="form-group row">
            <label for="hargabeli" class="col-sm-4 col-form-label">Harga Beli (Rp)</label>
            <div class="col-sm-4">
                <input style="text-align: right;" type="text" class="form-control form-control-sm" name="hargabeli" id="hargabeli">
                <div class="invalid-feedback errorHargaBeli" style="display: none;">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="hargajual" class="col-sm-4 col-form-label">Harga Jual (Rp)</label>
            <div class="col-sm-4">
                <input style="text-align: right;" type="text" class="form-control form-control-sm" name="hargajual" id="hargajual">
                <div class="invalid-feedback errorHargaJual" style="display: none;">
                </div>
            </div>

        </div>
        <div class="form-group row">
            <label for="uploadgambar" class="col-sm-4 col-form-label">Upload Gambar (Jika Ada)</label>
            <div class="col-sm-4">
                <input type="file" name="uploadgambar" id="uploadgambar" class="form-control form-control-md" accept=".jpg,.jpeg,.png">
                <div class="invalid-feedback errorUpload" style="display: none;">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="uploadgambar" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-success tombolSimpan">
                    Simpan
                </button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<div class="viewmodal" style="display:none;"></div>

<?= $this->endSection() ?>