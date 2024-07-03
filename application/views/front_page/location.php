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
                    <input type="search" class="form-control p-3" placeholder="keywords"
                        aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Contact</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Contact</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <?php foreach ($location as $loc): ?>
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Lokasi & Kontak</h1>
                            <p class="mb-4">GTT Pusat Oleh - Oleh Kediri</p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="h-100 rounded">
                            <iframe src="<?= $loc->embed_address ?>" width="100%" height="450" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <b class="text-danger pl-1 mb-1" id="error-login"></b>
                        <input type="text" class="w-100 form-control border-0 py-3 mb-1" name="nama_pengirim"
                            id="nama_pengirim" placeholder="Your Name">
                        <small class="text-danger pl-1 mb-1" id="error-nama_pengirim"></small>
                        <input type="email" class="w-100 form-control border-0 py-3 mb-1" name="email_pengirim"
                            id="email_pengirim" placeholder="Enter Your Email">
                        <small class="text-danger pl-1 mb-1" id="error-email_pengirim"></small>
                        <textarea class="w-100 form-control border-0 mb-1" rows="5" cols="10" name="pesan" id="pesan"
                            placeholder="Your Message"></textarea>
                        <small class="text-danger pl-1 mb-1" id="error-pesan"></small>
                        <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary "
                            onclick="insert_message()">Submit</button>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Address</h4>
                                <p class="mb-2"><?= $loc->address ?></p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded mb-4 bg-white">
                            <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Mail Us</h4>
                                <p class="mb-2"><?= $loc->email ?></p>
                            </div>
                        </div>
                        <div class="d-flex p-4 rounded bg-white">
                            <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                            <div>
                                <h4>Telephone</h4>
                                <p class="mb-2"><?= $loc->phone_number ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="text-primary mb-4">Kritik dan Saran</h2>
            </div>
        </div>
        <div class="row" id="data_kritik_saran">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <center>
                    <button type="button" id="btn_tampil_data" class="btn btn-primary">Show More</button>
                </center>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>
<script src="<?= base_url() ?>assets/js-custom/message.js"></script>