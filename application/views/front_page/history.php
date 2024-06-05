<div class="container mt-4">
    <h1 class="text-center mb-4">History Transaksi</h1>
    <div class="card">
        <h5 class="card-header">Data history transaksi</h5>
        <div class="card-body">
            <p class="text-muted font-14">Anda dapat cek surat yang telah anda ajukan beserta alasan pada tabel di bawah
                ini</p>
            <hr>
            <table id="example" class="table table-hover table-bordered" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Surat</th>
                        <th width="30%">Tanggal pengajuan</th>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="nama">Nama Pengaju</label>
                            <div class="input-group">
                                <input type="hidden" class="form-control" id="id" name="id" readonly>
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="letter">Nama Surat</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="letter" name="letter" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date1">Tanggal Pengajuan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="date1" name="date1" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date2">Tanggal Selesai</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="date2" name="date2" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="keterangan" name="keterangan" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <div class="col-lg-2">
                    <button type="button" id="btn-tambah" data-dismiss="modal"
                        class="btn btn-outline-primary btn-block">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>