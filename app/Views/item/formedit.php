<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3>Edit Items</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Edit Item
        </h3>

    </div>
    <div class="card-body">
        <form action="<?= site_url('item/update/' . $item['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" id="id" value="<?= $item['id'] ?>">
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Item</label>
                    <div class="col-sm-4">
                        <input type="text" name="nama" id="nama" class="form-control form-control-sm" value="<?= $item['nama'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kategori</label>
                    <div class=" col-sm-4">
                        <select name="kategori" id="kategori" class="form-control form-control-sm">
                            <option value selected disabled>Pilih..</option>
                            <?php foreach ($kategori as $c) : ?>
                                <option value="<?= $c['katnama'] ?>" <?= $c['katnama'] == $item['kategori'] ? 'selected' : '' ?>><?= $c['katnama']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Ukuran</label>
                    <div class=" col-sm-4">
                        <select name="ukuran" id="ukuran" class="form-control form-control-sm">
                            <option <?php echo ($item['ukuran'] === 'S' ? 'selected' : '') ?> value="S">S</option>
                            <option <?php echo ($item['ukuran'] === 'XS' ? 'selected' : '') ?> value="XS">XS</option>
                            <option <?php echo ($item['ukuran'] === 'M' ? 'selected' : '') ?> value="M">M</option>
                            <option <?php echo ($item['ukuran'] === 'L' ? 'selected' : '') ?> value="L">L</option>
                            <option <?php echo ($item['ukuran'] === 'XL' ? 'selected' : '') ?> value="XL">XL</option>
                            <option <?php echo ($item['ukuran'] === 'XXL' ? 'selected' : '') ?> value="XXL">XXL</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Harga</label>
                    <div class="col-sm-4">
                        <input type="number" name="harga" id="harga" value="<?= $item['harga'] ?>" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status</label>
                    <div class=" col-sm-4">
                        <select name="status" id="status" class="form-control form-control-sm">
                            <option <?php echo ($item['status'] === 'AVAIL' ? 'selected' : '') ?> value="AVAIL">AVAIL</option>
                            <option <?php echo ($item['status'] === 'BOOKED' ? 'selected' : '') ?> value="BOOKED">BOOKED</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>