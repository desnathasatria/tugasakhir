<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Detail Produk</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= base_url('') ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Detail Produk</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Single Product Start -->
<div class="container-fluid py-5 mt-5">
    <?php foreach ($produk as $pr): ?>
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="<?= base_url('assets/image/product/') . $pr->image ?>"
                                        class="img-fluid rounded" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3"><?= $pr->title ?></h4>
                            <p class="mb-3">Kategori : <?= $pr->name ?></p>
                            <h5 class="fw-bold mb-3"><?= $pr->price ?></h5>
                            <p class="mb-4"><?= $pr->description ?></p>
                            <p class="mb-4">Stok : <?= $pr->total_stok ?></p>
                            <form method="post" action="<?= base_url("Front_page/checkout") ?>">
                                <input type="hidden" name="id_produk" id="id_produk" value="<?= $pr->id ?>">
                                <?php if ($this->session->flashdata('error_login')): ?>
                                    <div class="alert alert-danger"><?= $this->session->flashdata('error_login') ?></div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                                <?php endif; ?>
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="jumlah"
                                        class="form-control form-control-sm text-center border-0" value="1">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">Checkout</button>
                            </form>
                            <button class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"
                                onclick="masukan_keranjang(<?= $pr->id ?>)"><i
                                    class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                        id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Description</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p><?= $pr->description ?></p>
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div
                                                    class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Berat</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0"><?= $pr->weight ?> Gram</p>
                                                    </div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Kategori</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0"><?= $pr->name ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                        </div>
                        <div class="col-lg-12">
                        </div>
                        <div class="col-lg-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- Single Product End -->
<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>