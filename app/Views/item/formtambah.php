<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3>Tambah Items</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Tambah Item
        </h3>

    </div>
    <div class="card-body">
        <?= form_open('item/simpandata', ['class' => 'formsimpan']) ?>
        <div class="modal-body">
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Nama Item</label>
                <div class="col-sm-4">
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Kategori</label>
                <div class=" col-sm-4">
                    <!-- <input type="hidden" nama="idkategori" id="idkategori"> -->
                    <select name="kategori" id="kategori" class="form-control form-control-sm"></select>

                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Ukuran</label>
                <div class=" col-sm-4">
                    <select name="ukuran" id="ukuran" class="form-control form-control-sm">
                        <option value="S">S</option>
                        <option value="XS">XS</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Harga</label>
                <div class="col-sm-4">
                    <input type="number" name="harga" id="harga" class="form-control form-control-sm" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Status</label>
                <div class=" col-sm-4">
                    <select name="status" id="status" class="form-control form-control-sm">
                        <option value="AVAIL">AVAIL</option>
                        <option value="BOOKED">BOOKED</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<script>
    function tampilKategori() {
        $.ajax({
            url: "<?= site_url('item/ambilDataKategori') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#kategori').html(response.data);
                }
            },
            error: function(error) {
                Swal.fire({
                    title: "Ada Kesalahan!",
                    text: error,
                    icon: "error"
                });
            }
        });
    }


    $(document).ready(function() {
        //memanggil function untuk menampilkan kategori
        tampilKategori()

        //menyimpan item
        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function(e) {
                    $('.tombolSimpan').prop('disabled', true)
                    $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>')
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?php echo site_url('item/index'); ?>";
                            }
                        });
                    }
                },
                error: function(error) {
                    Swal.fire({
                        title: "Ada Kesalahan!",
                        text: error,
                        icon: "error"
                    });
                }
            });
        });

    });
</script>





<?= $this->endSection() ?>