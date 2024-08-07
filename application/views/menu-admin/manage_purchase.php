<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Pembelian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Pembelian</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <h5 class="card-header">Data Pembelian</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <h6>Filter range tanggal</h6>
                    </div>
                    <div class="col-lg-4">
                        <h6 style="margin-left: 0.8rem;">Filter status pengiriman</h6>
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
                            <div class="form-group">
                                <select class="form-control filter" name="filter_pengiriman" id="filter_pengiriman" style="width: 100%;">
                                    <option value="">Semua status</option>
                                    <option value="Menunggu Pembayaran">Menunggu pembayaran</option>
                                    <option value="Dikemas">Dikemas</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
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
                            <th width="15%">Pelanggan</th>
                            <th width="10%">Harga</th>
                            <th width="15%">Tanggal</th>
                            <th width="10%">Pembayaran</th>
                            <th width="10%">Pengiriman</th>
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
                <h4 class="modal-title">Form Data Pembelian</h4>
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
                                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan Nama Produk" readonly>
                                    <small class="text-danger pl-1" id="error-judul"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="pelanggan" class="col-lg-2 col-form-label">Nama Pelanggan</label>
                                <div class="col-lg-10">
                                    <input type="text" name="pelanggan" id="pelanggan" class="form-control" placeholder="Masukkan Pelanggan" readonly>
                                    <small class="text-danger pl-1" id="error-pelanggan"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="harga" class="col-lg-2 col-form-label">Harga</label>
                                <div class="col-lg-10">
                                    <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukkan Harga" readonly>
                                    <small class="text-danger pl-1" id="error-harga"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="tanggal" class="col-lg-2 col-form-label">Tanggal Pembelian</label>
                                <div class="col-lg-10">
                                    <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Masukkan Tanggal" readonly>
                                    <small class="text-danger pl-1" id="error-tanggal"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="pembayaran" class="col-lg-2 col-form-label">Pembayaran</label>
                                <div class="col-lg-10">
                                    <input type="text" name="pembayaran" id="pembayaran" class="form-control" placeholder="Pembayaran" readonly>
                                    <small class="text-danger pl-1" id="error-pembayaran"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row" id="status_pengiriman">
                                <label for="status" class="col-lg-3 col-form-label">Pengiriman</label>
                                <div class="form-check form-check-inline" id="kemas">
                                    <input class="form-check-input" type="radio" name="status" id="status_dikemas" value="Dikemas">
                                    <label class="form-check-label" for="status_dikemas">Dikemas</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_dikirim" value="Dikirim">
                                    <label class="form-check-label" for="status_dikirim">Dikirim</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_sudah" value="Selesai">
                                    <label class="form-check-label" for="status_sudah">Selesai</label>
                                </div>
                                <small class="text-danger pl-3" id="error-status"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-2">
                            <button class="btn btn-outline-primary btn-block" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="col-lg-4">
                            <button type="button" id="btn-status" onclick="update_status()" class="btn btn-outline-primary btn-block">Ubah Status</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal untuk hapus data -->
<div class="modal fade" id="hapusPurchase">
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