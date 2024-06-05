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

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url() ?>assets/template-user/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/template-user/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url() ?>assets/template-user/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= base_url() ?>assets/template-user/css/style.css" rel="stylesheet">

    <style>
        .profile-container {
            padding-top: 150px; /* Adjust as needed to prevent content from being hidden */
        }

        .fixed-header {
            height: 150px; /* Set a fixed height for the header */
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
                        <a href="<?php echo base_url("Front_page/location"); ?>" class="nav-item nav-link <?php echo $this->uri->segment(1) == 'Front_page' && $this->uri->segment(2) == 'location' ? 'active' : ''; ?>">Lokasi & Kontak</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#shoppingCartModal" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white px-2" style="top: -5px; right: -10px; height: 20px; min-width: 20px;" id="cartItemCount"></span>
                        </a>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="<?= base_url() ?>assets/image/user/<?= $user['image'] ?>" alt="User Profile" class="rounded-circle" width="40" height="40">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profile</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('history') ?>">History</a></li>
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
    <!-- Modal -->
    <div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shoppingCartModalLabel">Keranjang Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($this->session->userdata('cart')) : ?>
                    <ul>
                        <?php foreach ($this->session->userdata('cart') as $item) : ?>
                        <li>
                            <?= $item['title'] ?> (Jumlah: <?= $item['quantity'] ?>, Harga: <?= $item['price'] ?>)
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else : ?>
                    <p>Belum ada produk di keranjang belanja.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Inisialisasi session untuk keranjang belanja
    $this->load->library('session');
    $this->session->set_userdata('cart', array());
    ?>
    <script>
        var shoppingCart = [];

        // Fungsi untuk menambahkan produk ke keranjang
        function addToCart(productId) {
            // Lakukan permintaan AJAX ke server untuk mendapatkan data produk
            // Anda dapat menggunakan jQuery atau fetch() untuk melakukan permintaan AJAX
            $.ajax({
                url: '<?= base_url('Front_page/getProductData') ?>',
                type: 'POST',
                data: {
                    productId: productId
                },
                dataType: 'json',
                success: function(response) {
                    // Tambahkan produk ke keranjang belanja
                    shoppingCart.push(response);

                    // Perbarui jumlah produk pada ikon keranjang
                    updateCartItemCount();
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data produk.');
                }
            });
        }

        // Fungsi untuk memperbarui jumlah produk pada ikon keranjang
        function updateCartItemCount() {
            var cartItemCount = shoppingCart.length;
            var cartItemCountElement = document.getElementById('cartItemCount');
            cartItemCountElement.textContent = cartItemCount;
        }

        // Tambahkan event listener untuk tombol "Add to Cart"
        var addToCartButtons = document.querySelectorAll('.addToCartBtn');
        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var productId = this.getAttribute('data-product-id');
                addToCart(productId);
            });
        });

        // Tampilkan data produk di keranjang belanja pada modal
        var shoppingCartModal = document.getElementById('shoppingCartModal');
        shoppingCartModal.addEventListener('shown.bs.modal', function() {
            var modalBody = shoppingCartModal.querySelector('.modal-body');
            modalBody.innerHTML = '';

            if (shoppingCart.length > 0) {
                var itemList = document.createElement('ul');
                shoppingCart.forEach(function(item) {
                    var itemElement = document.createElement('li');
                    itemElement.textContent = item.title + ' (Jumlah: 1, Harga: ' + item.price + ')';
                    itemList.appendChild(itemElement);
                });
                modalBody.appendChild(itemList);
            } else {
                var noItemsMessage = document.createElement('p');
                noItemsMessage.textContent = 'Belum ada produk di keranjang belanja.';
                modalBody.appendChild(noItemsMessage);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.addToCartBtn').click(function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                $.ajax({
                    url: '<?= base_url('Front_page/addToCart/') ?>' + productId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Produk berhasil ditambahkan ke keranjang belanja.');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menambahkan produk ke keranjang belanja.');
                    }
                });
            });
        });
    </script>
</body>