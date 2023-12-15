<?= $this->extend('layout/menu') ?>

<?= $this->section('judul') ?>
<h3>Items</h3>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="<?= site_url('item/formtambah') ?>" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Tambah Item
            </a>

            <a href="<?= site_url('item/googlesheet') ?>" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i> Google Sheet
            </a>
        </h3>

    </div>
    <div class="card-body">

        <form action="<?php site_url('/kategori/index') ?>" method="post">
            <?= csrf_field(); ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Nama Ketegori" name="keywords" autofocus value="<?= $cari; ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit" name="search">Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Ukuran</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 1 + (($nohalaman - 1) * 10);
                foreach ($dataitem as $row) :
                ?>
                    <tr>
                        <td><?= $nomor++; ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['ukuran'] ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td><?= $row['harga'] ?></td>
                        <td>
                            <button class="btn <?php echo ($row['status'] === 'BOOKED') ? 'btn-danger' : 'btn-info'; ?>">
                                <?= $row['status'] ?>
                            </button>

                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $row['id'] ?>','<?= $row['nama'] ?>')">
                                <i class="fa fa-trash-alt"></i>
                            </button>

                            <button type="button" class="btn btn-info btn-sm" title="Edit Kategori" onclick="edit('<?= $row['id'] ?>')">
                                <i class="fa fa-pencil-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="float-center">
            <?= $pager->links('item', 'paging_data'); ?>
        </div>
    </div>
</div>



<script>
    function hapus(id, nama) {
        Swal.fire({
            title: "Hapus Kategori",
            html: `Yakin hapus kategori <strong>${nama}</strong> ini ?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('item/hapus') ?>",
                    data: {
                        idItem: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            window.location.reload()
                            // Swal.fire({
                            //     title: "Berhasil",
                            //     text: response.sukses,
                            //     icon: "success"
                            // });
                        }
                    }
                });

            }
        });
    }

    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kategori/formEdit') ?>",
            data: {
                idItem: id
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalformedit').on('shown.bs.modal', function(event) {
                        $('#namakategori').focus();
                    })
                    $('#modalformedit').modal('show')
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    }



    $(document).ready(function() {
        $('.tombolTambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('kategori/formTambah') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahkategori').on('show.bs.modal', function(e) {
                            $('#namakategori').focus();
                        })
                        $('#modaltambahkategori').modal('show');
                    }
                },
                error: function() {
                    console.log("error")
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>