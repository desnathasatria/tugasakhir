<link href="<?php echo base_url('assets/template-user/css/gallery.css') ?>" rel="stylesheet">
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
    <h1 class="text-center text-white display-6">Galeri</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Galeri</li>
    </ol>
</div>
<!-- Single Page Header End -->
<!-- Galeri Start -->
<section id="Galeri">
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="row g-5 justify-content-center align-items-center">
                    <h1 class="section-title text-center">Galeri GTT Pusat Oleh - Oleh</h1>
                </div>
                <div class="filter-nav">
                    <button class="btn btn-success active filter-button" data-filter="">All</button>
                    <?php foreach ($kategori as $ktg) : ?>
                        <button class="btn btn-primary filter-button" data-filter="<?= $ktg->name ?>">
                            <?= $ktg->name ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="filter-gallery">
                    <div class="row items-container">
                        <?php foreach ($gambar as $img) : ?>
                            <div class="col-md-3 my-1">
                                <div class="clickable-item" data-category="<?= $img->name ?>" data-title="<?= $img->title ?>">
                                    <div class="item-content">
                                        <a href="#" class="open-modal" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('assets/image/gallery/') . $img->image ?>" data-title="<?= $img->title ?>">
                                            <img src="<?php echo base_url('assets/image/gallery/') . $img->image ?>" alt="image" class="img-fluid clickable-image">
                                            <div class="overlay">
                                                <h3 class="overlay-title"><?= $img->title ?></h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="no-photo-message d-none text-center my-3">Tidak ada foto</div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Galeri End -->

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt="modal-image" class="img-fluid modal-image">
            </div>
            <div class="modal-footer">
                <h5 class="modal-title" id="imageModalLabel"></h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
<!-- Gallery Modal Javascript -->
<script src="<?php echo base_url('assets/template-user/js/gallery_modal.js') ?>"></script>