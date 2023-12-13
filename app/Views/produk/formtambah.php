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
            <div class="col-sm-4">
                <input type="text" style="text-align: right;" class="form-control form-control-sm" name="hargajual" id="hargajual">
                <div class="invalid-feedback errorHargaJual" style="display:none;"></div>
            </div>
        </div>

        <div class="form-group row">
            <label for="uploadgambar" class="col-sm-4 col-form-label">Upload Gambar(Jika Ada)</label>
            <div class="col-sm-4">
                <input type="file" name="uploadgambar" id="uploadgambar" class="form-control form-control-md" accept=".jpg,.jpeg,.png">
                <div class="invalid-feedback errorUpload" style="display:none;"></div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <button type="submit" class="btn btn-success tombolSimpan">Simpan</button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
    <!-- End Card Body  -->
</div>
<div class="viewmodal" style="display:none;"></div>
<script>
    function tampilKategori() {
        $.ajax({
            url: "<?= site_url('produk/ambilDataKategori') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#kategori').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function tampilSatuan() {
        $.ajax({
            url: "<?= site_url('produk/ambilDataSatuan') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#satuan').html(response.data);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        tampilKategori();
        tampilSatuan();

        $('#hargabeli').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '2',
        })

        $('#hargajual').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '2',
        })

        $('#stok').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0',
        })

        $('.tombolTambahKategori').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= site_url('kategori/formTambah') ?>",
                data: {
                    aksi: 1
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahkategori').on('shown.bs.modal', function(event) {
                            $('#namakategori').focus();
                        })
                        $('#modaltambahkategori').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $('.tombolTambahSatuan').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?= site_url('satuan/fromTambah') ?>",
                data: {
                    aksi: 1
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahsatuan').on('shown.bs.modal', function(event) {
                            $('#namasatuan').focus();
                        })

                        $('#modaltambahsatuan').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        })

        $('.tombolSimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formsimpan')[0];
            let data = new FormData(form)

            $.ajax({
                type: "post",
                url: "<?= site_url('produk/simpandata') ?>",
                data: data,
                dataType: "json",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    if (response.error) {
                        let msg = response.error;
                        if (msg.errorKodeBarcode) {
                            $('.errorKodeBarcode').html(msg.errorKodeBarcode).show();
                            $('#kodebarcode').addClass('is-invalid')
                        } else {
                            $('.errorKodeBarcode').fadeOut();
                            $('#kodebarcode').removeClass('is-invalid');
                            $('#kodebarcode').addClass('is-valid');
                        }

                        if (msg.errorNamaProduk) {
                            $('.errorNamaProduk').html(msg.errorNamaProduk).show();
                            $('#namaproduk').addClass('is-invalid')
                        } else {
                            $('.errorNamaProduk').fadeOut();
                            $('#namaproduk').removeClass('is-invalid');
                            $('#namaproduk').addClass('is-valid');
                        }

                        if (msg.errorStok) {
                            $('.errorStok').html(msg.errorStok).show();
                            $('#stok').addClass('is-invalid')
                        } else {
                            $('.errorStok').fadeOut();
                            $('#stok').removeClass('is-invalid');
                            $('#stok').addClass('is-valid');
                        }

                        if (msg.errorKategori) {
                            $('.errorKategori').html(msg.errorKategori).show();
                            $('#kategori').addClass('is-invalid')
                        } else {
                            $('.errorKategori').fadeOut();
                            $('#kategori').removeClass('is-invalid');
                            $('#kategori').addClass('is-valid');
                        }

                        if (msg.errorSatuan) {
                            $('.errorSatuan').html(msg.errorSatuan).show();
                            $('#satuan').addClass('is-invalid')
                        } else {
                            $('.errorSatuan').fadeOut();
                            $('#satuan').removeClass('is-invalid');
                            $('#satuan').addClass('is-valid');
                        }

                        if (msg.errorHargaBeli) {
                            $('.errorHargaBeli').html(msg.errorHargaBeli).show();
                            $('#hargabeli').addClass('is-invalid')
                        } else {
                            $('.errorHargaBeli').fadeOut();
                            $('#hargabeli').removeClass('is-invalid');
                            $('#hargabeli').addClass('is-valid');
                        }


                        if (msg.errorHargaJual) {
                            $('.errorHargaJual').html(msg.errorHargaJual).show();
                            $('#hargajual').addClass('is-invalid')
                        } else {
                            $('.errorHargaJual').fadeOut();
                            $('#hargajual').removeClass('is-invalid');
                            $('#hargajual').addClass('is-valid');
                        }


                        if (msg.errorUpload) {
                            $('.errorUpload').html(msg.errorUpload).show();
                            $('#uploadgambar').addClass('is-invalid')
                        }

                    } else {
                        alert(response.sukses)
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

    });
</script>

<?= $this->endSection() ?>