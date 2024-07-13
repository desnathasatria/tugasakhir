<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Histori</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Histori</li>
    </ol>
</div>
<!-- Single Page Header End -->
<div class="container mt-4">
    <div class="card">
        <h5 class="card-header">Data histori transaksi</h5>
        <div class="card-body">
            <hr>
            <table id="example" class="table table-hover table-bordered" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Produk</th>
                        <th width="30%">Tanggal Transaksi</th>
                        <th width="20%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal untuk lihat detail history transaksi -->
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail history pengajuan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="nama">Nama Produk</label>
                            <div class="input-group">
                                <input type="hidden" class="form-control" id="id" name="id" readonly>
                                <input type="text" class="form-control" id="title" name="title" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date1">Tanggal Transaksi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Status</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="status" name="status" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-tambah" data-bs-dismiss="modal" class="btn btn-outline-primary btn-block">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal untuk hapus data -->
<div class="modal fade" id="modalKonfirmasi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Klik <b>Konfirmasi</b> untuk menyelesaikan pemesanan</h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success" type="button" id="btn-konfirmasi" data-bs-dismiss="modal">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>