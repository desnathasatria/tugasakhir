<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SI-GTT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="<?= base_url('assets/image/logo-umkm.png') ?>" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url() ?>assets/template-user/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/template-user/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url() ?>assets/template-user/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/template-admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/template-admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/template-admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Template Stylesheet -->
    <link href="<?= base_url() ?>assets/template-user/css/style.css" rel="stylesheet">

    <style>
        .profile-container {
            padding-top: 150px;
            /* Adjust as needed to prevent content from being hidden */
        }

        .fixed-header {
            height: 150px;
            /* Set a fixed height for the header */
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar start -->
    <div class="container-fluid fixed-top fixed-header">
        <?php foreach ($profile as $loc) : ?>
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white"><?= $loc->address ?></a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white"><?= $loc->email ?></a></small>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.html" class="navbar-brand">
                        <h1 class="text-primary display-6">GTT Pusat Oleh - Oleh</h1>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="<?php echo base_url(); ?>" class="nav-item nav-link <?php echo $this->uri->segment(1) == '' ? 'active' : ''; ?>">Home</a>
                            <a href="<?php echo base_url("Front_page/product"); ?>" class="nav-item nav-link <?php echo $this->uri->segment(1) == 'Front_page' && $this->uri->segment(2) == 'product' ? 'active' : ''; ?>">Produk</a>
                            <a href="<?php echo base_url("Front_page/gallery"); ?>" class="nav-item nav-link <?php echo $this->uri->segment(1) == 'Front_page' && $this->uri->segment(2) == 'gallery' ? 'active' : ''; ?>">Galeri</a>
                            <a href="<?php echo base_url("Front_page/location"); ?>" class="nav-item nav-link <?php echo $this->uri->segment(1) == 'Front_page' && $this->uri->segment(2) == 'location' ? 'active' : ''; ?>">Lokasi
                                & Kontak</a>
                            <a href="<?php echo base_url("history"); ?>" class="nav-item nav-link <?php echo $this->uri->segment(1) == 'history'  ? 'active' : ''; ?>">History</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white px-2" style="top: -5px; right: -10px; height: 20px; min-width: 20px;" id="cartItemCount"></span>
                            </a>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                    <img src="<?= base_url() ?>assets/image/user/<?= $user['image'] ?>" alt="User Profile" class="rounded-circle" width="40" height="40">
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profil</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('logout_1') ?>">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Navbar End -->
</body>
<!-- Shopping Cart Modal -->
<div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shoppingCartModalLabel">Keranjang Belanja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="tabelKeranjang" class="table table-hover table-bordered" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">Produk</th>
                            <th width="15%">Harga</th>
                            <th width="15%">Jumlah</th>
                            <th width="15%">Total</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <form method="post" action="<?= base_url("Front_page/checkout_keranjang") ?>"> -->
                <input type="hidden" name="id_produk_1" id="id_produk_1">
                <input type="hidden" name="jumlah_1" id="jumlah_1">
                <button class="btn btn-primary" onclick="masuk_checkout()">Checkout</button>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>
<!-- Tambahkan script JavaScript di bagian akhir file html -->
<script>
    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';
</script>