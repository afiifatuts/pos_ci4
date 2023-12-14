<?= $this->extend('layout/menu') ?>
<?= $this->section('judul') ?>
<h3> Produk Data &mdash; myPOS</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<div class="card">
    <!-- Start Card Header  -->
    <div class="card-header">
        <h3 class="card-title">
            <button type="button" class="btn btn-sm btn-primary" onclick="window.location='<?= site_url('produk/add') ?>'">
                <i class="fa fa-plus"></i>Tambah Data
            </button>
        </h3>
    </div>
    <!-- End Card Header  -->

    <!-- Start Session Menampilkan Pesan  -->
    <?php if (session()->getFlashdata('pesan')); ?>
    <div class="alert">
        <button type="button" class="close">
            <div class="alert-message">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        </button>
    </div>
    <!-- End Session Menampilkan Pesan  -->

    <!-- Start Modal Body  -->
    <div class="card-body">
        <!-- Start Form Pencarian     -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 text-right">
                    <form action="get" class="d-none d-sm-inline-block">
                        <div class="input-group input-group-navbar">
                            <input type="text" name="keyword" placeholder="Search..." aria-label="Search" class="form-control" /><button type="submit" name="submit" class="btn"> <i class="align-middle" data-feather="search"></i> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Form Pencarian     -->

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barcode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // $nomor = 1;
                    $i = 1 + (5 * ($currentPage - 1));
                    foreach ($dataproduk as $r) :
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $r['kodebarcode'] ?>
                                <br>
                                <form action="<?= site_url('item/barcode/' . $r['kodebarcode']) ?>" method="POST" class="d-inline" id="edit">
                                    <button class="fa fa-barcode btn btn-outline-primary btn-sm">
                                        <i class="align-middle"></i>
                                    </button>
                                </form>

                            </td>
                            <td><?= $r['namaproduk'] ?></td>
                            <td><?= $r['kategori_nama'] ?></td>
                            <td><?= $r['satuan_nama'] ?></td>
                            <td><?= $r['harga_jual'] ?></td>
                            <td><?= $r['stok_tersedia'] ?></td>
                            <td>
                                <img class="img-thumbnail" style="width: 10%;" src="<?= base_url(); ?>/<?= $r['gambar'] ?>" alt="">
                            </td>
                            <td>
                                <form action="<?= site_url('produk/edit/' . $r['kodebarcode']) ?>" method="POST" class="d-inline" id="edit">
                                    <?= csrf_field(); ?>

                                    <button class="btn btn-warning btn-sm" type="submit"> Edit</button>

                                </form>



                                <form action="<?= site_url('produk/delete/' . $r['kodebarcode']) ?>" method="post" class="d-inline" id="GFG">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('apakah anda yakin?')"><i class="align-middle" data-feather="trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="float-left">
                <?= $pager->links('produk', 'paging_data') ?>
            </div>
        </div>
    </div>
    <!-- End Modal Body  -->

</div>
<?= $this->endSection() ?>