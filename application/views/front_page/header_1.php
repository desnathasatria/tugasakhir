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
</body>
<!-- Shopping Cart Modal -->
<div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shoppingCartModalLabel">Shopping Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="shoppingCartTableBody">
                        <!-- Cart items will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Checkout</button>
            </div>
        </div>
    </div>
</div>
<!-- Tambahkan script JavaScript di bagian akhir file html -->
<script>
    $(document).ready(function() {
        var shoppingCart = [];

        // Fungsi untuk menambahkan produk ke keranjang
        $('.btn-add-to-cart').click(function() {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productPrice = $(this).data('product-price');
            var quantity = parseInt($('input[name="jumlah"]').val());

            var cartItem = {
                id: productId,
                name: productName,
                price: productPrice,
                quantity: quantity
            };

            shoppingCart.push(cartItem);
            updateShoppingCartModal();
            $('#shoppingCartModal').modal('show');
        });

        // Fungsi untuk memperbarui tampilan modal keranjang
        function updateShoppingCartModal() {
            var tableBody = $('#shoppingCartTableBody');
            tableBody.empty();

            shoppingCart.forEach(function(item) {
                var row = `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.price}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price * item.quantity}</td>
                        <td><button class="btn btn-danger btn-sm remove-item" data-product-id="${item.id}">Remove</button></td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }


        // Fungsi untuk menghapus produk dari keranjang
        $(document).on('click', '.remove-item', function() {
            var productId = $(this).data('product-id');
            shoppingCart = shoppingCart.filter(function(item) {
                return item.id !== productId;
            });
            updateShoppingCartModal();
        });

        function getShoppingCartData() {
            $.ajax({
                url: '<?php echo base_url('Front_page/get_cart_data'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    shoppingCart = data;
                    updateShoppingCartModal();
                },
                error: function() {
                    alert('Error retrieving shopping cart data');
                }
            });
        }

        // Panggil fungsi getShoppingCartData() saat halaman dimuat
        getShoppingCartData();
    });
</script>