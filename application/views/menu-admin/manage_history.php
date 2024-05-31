<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <h5 class="card-header">Data History</h5>
            <div class="card-body">
                <button class="btn btn-danger text-white" data-toggle="modal" data-target="#exampleModal" onclick="submit('cetak')">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i> Cetak Laporan
                </button>
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <h6>Filter range tanggal</h6>
                    </div>
                </div>
                <form method="POST" id="aksidata">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1" id="date1" name="date1" />
                                <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <h3> - </h3>
                        <div class="col-lg-2">
                            <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2" id="date2" name="date2" />
                                <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-success" onclick="get_data_filter()">Cari data</button>
                        </div>
                    </div>
                </form>
                <hr>
                <table id="example" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Produk</th>
                            <th width="15%">Nama Pelanggan</th>
                            <th width="10%">Harga</th>
                            <th width="5%">Ongkir</th>
                            <th width="15%">Tanggal Pembelian</th>
                            <th width="10%">Status</th>
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

<!-- modal untuk detail arsip/history-->
<div class="modal fade" id="detailArsip">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Arsip Surat</h4>
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
                                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan Nama Produk">
                                    <small class="text-danger pl-1" id="error-judul"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="pelanggan" class="col-lg-2 col-form-label">Nama Pelanggan</label>
                                <div class="col-lg-10">
                                    <input type="text" name="pelanggan" id="pelanggan" class="form-control" placeholder="Masukkan Pelanggan">
                                    <small class="text-danger pl-1" id="error-pelanggan"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="harga" class="col-lg-2 col-form-label">Harga</label>
                                <div class="col-lg-10">
                                    <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukkan Harga">
                                    <small class="text-danger pl-1" id="error-harga"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="ongkir" class="col-lg-2 col-form-label">Ongkir</label>
                                <div class="col-lg-10">
                                    <input type="text" name="ongkir" id="ongkir" class="form-control" placeholder="Masukkan Ongkir">
                                    <small class="text-danger pl-1" id="error-ongkir"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="tanggal" class="col-lg-2 col-form-label">Tanggal Pembelian</label>
                                <div class="col-lg-10">
                                    <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Masukkan Tanggal">
                                    <small class="text-danger pl-1" id="error-tanggal"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="dokumen" class="col-lg-3 col-form-label">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="blm1" value="1">
                                    <label class="form-check-label" for="blm">Belum Bayar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="dikemas1" value="2">
                                    <label class="form-check-label" for="belum">Dikemas</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="dikirim1" value="3">
                                    <label class="form-check-label" for="terpenuhi">Dikirim</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="sudah1" value="4">
                                    <label class="form-check-label" for="non-halal">Selesai</label>
                                </div>
                                <small class="text-danger pl-3" id="error-status"></small>
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
                    <button type="button" id="btn-balas" class="btn btn-outline-primary btn-block" data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>