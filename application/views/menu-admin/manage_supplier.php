<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Supplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <h5 class="card-header">Kelola Supplier</h5>
            <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                    onclick="submit('tambah')"><i class="fa-solid fa-circle-plus"></i> Input data</button>
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Filter produk</label>
                            <select id="filter" name="filter[]" class="form-control akses" style="width: 100%;">
                                <option value="">Semua Produk</option>
                                <?php foreach ($select as $row): ?>
                                    <option value="<?php echo $row->title; ?>">
                                        <?php echo $row->title; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Nama Produk</th>
                            <th width="15%">Nama Supplier</th>
                            <th width="15%">Stok</th>
                            <th width="15%">Tanggal</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Data Supplier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="supplier" class="col-lg-2 col-form-label">Nama Produk</label>
                                <div class="col-lg-10">
                                    <select id="name_produk" name="nama[]" class="form-control supplier"
                                        style="width: 100%;">
                                        <?php foreach ($select as $row): ?>
                                            <option value="<?php echo $row->id; ?>">
                                                <?php echo $row->title; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger pl-3" id="error-nama"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Nama Supplier</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" id="id">
                                    <input type="text" name="nama_supplier" id="nama_supplier" class="form-control"
                                        placeholder="Masukkan Nama Supplier">
                                    <small class="text-danger pl-1" id="error-nama_supplier"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Stok</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" id="id">
                                    <input type="number" name="stok" id="stok" class="form-control"
                                        placeholder="Masukkan Stok">
                                    <small class="text-danger pl-1" id="error-stok"></small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-tambah" onclick="insert_data()"
                        class="btn btn-outline-primary btn-block">Tambah</button>
                </div>
                <div class="col-lg-2">
                    <button type="button" id="btn-ubah" onclick="edit_data()"
                        class="btn btn-outline-primary btn-block">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapusSupplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Klik hapus jika anda ingin menghapus data ini</h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-warning" type="button" id="btn-hapus" data-dismiss="modal">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>
