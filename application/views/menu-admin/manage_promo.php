<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Produk Promo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Produk Promo</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <h5 class="card-header">Data Produk Promo</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Filter kategori</label>
                            <select class="form-control filter" style="width: 100%;">
                                <option value="">Semua kategori</option>
                                <?php foreach ($select as $row) : ?>
                                    <option value="<?php echo $row->name; ?>">
                                        <?php echo $row->name; ?>
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
                            <th width="10%">Judul</th>
                            <th width="5%">Kategori</th>
                            <th width="20%">Deskripsi</th>
                            <th width="15%">Harga Jual</th>
                            <th width="10%">Berat</th>
                            <th width="10%">Foto</th>
                            <th width="5%">Stok</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- modal untuk insert dan edit data -->
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Data Produk Promo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="nama" class="col-lg-2 col-form-label">Nama Produk</label>
                                <div class="col-lg-10">
                                    <input type="hidden" name="id" class="form-control">
                                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan nama produk">
                                    <small class="text-danger pl-1" id="error-judul"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="kategori" class="col-lg-2 col-form-label">Kategori</label>
                                <div class="col-lg-10">
                                    <select id="kategori" name="kategori[]" class="form-control kategori" style="width: 100%;">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($select as $row) : ?>
                                            <option value="<?php echo $row->id; ?>">
                                                <?php echo $row->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger pl-1" id="error-kategori"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="deskripsi" class="col-lg-2 col-form-label">Deskripsi</label>
                                <div class="col-lg-10">
                                    <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan Deskripsi produk">
                                    <small class="text-danger pl-1" id="error-deskripsi"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="harga" class="col-lg-2 col-form-label">Harga Jual</label>
                                <div class="col-lg-10">
                                    <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukkan Harga" oninput="formatRupiahInput(this)" readonly>
                                    <small class="text-danger pl-1" id="error-harga"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="berat" class="col-lg-2 col-form-label">Berat</label>
                                <div class="col-lg-10">
                                    <input type="text" name="berat" id="berat" class="form-control" placeholder="Masukkan Berat">
                                    <small class="text-danger pl-1" id="error-berat"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="image" class="col-lg-2 col-form-label">Foto Produk</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image" onchange="previewImage(event)">
                                            <label class="custom-file-label" for="image">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 offset-2">
                                    <small class="text-danger pl-1" id="error-image"></small>
                                    <div id="imagePreview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-tambah" onclick="insert_data()" class="btn btn-outline-primary btn-block">Tambah</button>
                </div>
                <div class="col-lg-2">
                    <button type="button" id="btn-ubah" onclick="edit_data()" class="btn btn-outline-primary btn-block">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal untuk hapus data -->
<div class="modal fade" id="hapusPromo">
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