<?= $this->extend('layout/menu') ?>
<?= $this->section('judul') ?>
<h3><i class="fa fa-fw fa-table"></i>Form Tambah Produk</h3>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<script src="<?= base_url('assets/plugins/autoNumeric.js') ?>"></script>
<div class="card">
    <!-- Start Card Header  -->
    <div class="card-header">
        <!-- Start Card Title  -->
        <div class="card-title">
            <button type="button" class="btn btn-sm btn-warning" onclick="window.location='<?= site_url('produk/index') ?>'">
                <i class="fa fa-backward"></i> Kembali
            </button>
        </div>
        <!-- End Card Title  -->
        <!-- Start Card Tools  -->
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Coollapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- End Card Tools  -->
    </div>
    <!-- End Card Header  -->

    <!-- Start Card Body  -->
    <div class="card-body">
        <?= form_open_multipart('', ['class' => 'form_simpan']) ?>
        <?= csrf_field(); ?>
        <div class="form-group row">
            <label for="kodebarcode" class="col-sm-4 col-form-label">Kode Barcode</label>
            <div class="col-sm-8">
                <input type="text" name="kodebarcode" id="kodebarcode" class="form-control form-control-sm" autofocus>
                <div class="invalid-feedback errorKodeBarcode" style="display: none;"></div>
            </div>
        </div>

        <div class="form-group row">
            <label for="namaproduk" class="col-sm-4 col-form-label">Nama Produk</label>
            <div class="col-sm-8">
                <input type="text" name="namaproduk" id="namaproduk" class="form-control form-control-sm">
                <div class="invalid-feedback errorNamaProduk" style="display:none;"></div>
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
                <select name="kategori" id="kategori" class="form-control form-control-sm">
                </select>
                <div class="invalid-feedback errorKategori" style="display:none;">
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
                <select name="satuan" id="satuan" class="form-control form-control-sm"></select>
                <div class="invalid-feedback errorSatuan" style="display:none;">
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
                <input style="text-align: right;" type="text" name="hargabeli" id="hargabeli" class="form-control form-control-sm">
                <div class="invalid-feedback errorHargaBeli" style="display:none;"></div>
            </div>
        </div>

        <div class="form-group row">
            <label for="hargajual" class="col-sm-4 col-form-label">Harga Jual (Rp)</label>
        </div>




        <?= form_close() ?>
    </div>
    <!-- End Card Body  -->
</div>

<?= $this->endSection() ?>