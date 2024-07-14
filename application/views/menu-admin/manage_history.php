<style>
    .rating-star1 {
        font-size: 24px;
        color: #ccc;
    }

    .rating-star1.active {
        color: #ffc107;
    }
</style>

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
                        <li class="breadcrumb-item active">History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <h5 class="card-header">History</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <h6>Filter range tanggal</h6>
                    </div>
                </div>
                <form method="GET" id="aksidata" action="<?= base_url('export-pdf-history') ?>">
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
                            <button type="button" class="btn btn-success" onclick="get_data_filter()">Cari data</button>
                        </div>
                        <div class="col">
                            <div class="float-right">
                                <!-- Changed to a submit button -->
                                <button type="submit" class="btn btn-danger">Export to PDF</button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields to hold date values for export -->
                    <input type="hidden" id="hiddenDate1" name="date1">
                    <input type="hidden" id="hiddenDate2" name="date2">
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
<div class="modal fade" id="detailHistory">
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
                            <div class="row">
                                <label for="status" class="col-lg-3 col-form-label">Pengiriman</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="dikemas1" value="Dikemas" disabled>
                                    <label class="form-check-label" for="belum">Dikemas</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="dikirim1" value="Dikirim" disabled>
                                    <label class="form-check-label" for="terpenuhi">Dikirim</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="sudah1" value="Selesai" disabled>
                                    <label class="form-check-label" for="non-halal">Selesai</label>
                                </div>
                                <small class="text-danger pl-3" id="error-status"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <div class="input-group">
                                <input type="hidden" class="form-control" id="id" name="id" readonly>
                                <textarea class="form-control" id="keterangan1" name="keterangan1" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <div class="input-group">
                                <span class="rating-star1" data-rating="1"><i class="bi bi-star"></i></span>
                                <span class="rating-star1" data-rating="2"><i class="bi bi-star"></i></span>
                                <span class="rating-star1" data-rating="3"><i class="bi bi-star"></i></span>
                                <span class="rating-star1" data-rating="4"><i class="bi bi-star"></i></span>
                                <span class="rating-star1" data-rating="5"><i class="bi bi-star"></i></span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';

    document.getElementById('aksidata').addEventListener('submit', function(e) {
        var date1 = document.getElementById('date1').value;
        var date2 = document.getElementById('date2').value;

        document.getElementById('hiddenDate1').value = date1;
        document.getElementById('hiddenDate2').value = date2;

        // Optionally, you can modify the action URL if needed
        this.action = `<?= base_url('export-pdf-history') ?>?date1=${encodeURIComponent(date1)}&date2=${encodeURIComponent(date2)}`;
    });
</script>