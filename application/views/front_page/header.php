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
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
    rel="stylesheet">

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
</head>

<body>

  <!-- Spinner Start -->
  <div id="spinner"
    class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
  </div>
  <!-- Spinner End -->


  <!-- Navbar start -->
  <div class="container-fluid fixed-top">
    <?php foreach ($profile as $loc): ?>
      <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
          <div class="top-info ps-2">
            <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                class="text-white"><?= $loc->address ?></a></small>
            <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                class="text-white"><?= $loc->email ?></a></small>
          </div>
        </div>
      </div>
      <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
          <a href="index.html" class="navbar-brand">
            <h1 class="text-primary display-6">GTT Pusat Oleh - Oleh</h1>
          </a>
          <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse">
            <span class="fa fa-bars text-primary"></span>
          </button>
          <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
            <div class="navbar-nav mx-auto">
              <a href="<?php echo base_url(); ?>"
                class="nav-item nav-link <?php echo $this->uri->segment(1) == '' ? 'active' : ''; ?>">Home</a>
              <a href="<?php echo base_url("Front_page/product"); ?>"
                class="nav-item nav-link <?php echo $this->uri->segment(1) == 'Front_page' && $this->uri->segment(2) == 'product' ? 'active' : ''; ?>">Produk</a>
              <a href="<?php echo base_url("Front_page/gallery"); ?>"
                class="nav-item nav-link <?php echo $this->uri->segment(1) == 'Front_page' && $this->uri->segment(2) == 'gallery' ? 'active' : ''; ?>">Galeri</a>
              <a href="<?php echo base_url("Front_page/location"); ?>"
                class="nav-item nav-link <?php echo $this->uri->segment(1) == 'Front_page' && $this->uri->segment(2) == 'location' ? 'active' : ''; ?>">Lokasi
                & Kontak</a>
            </div>
            <div class="d-flex m-3 me-0">
              <a href="<?php echo base_url("login"); ?>" class="my-auto">
                <i class="fas fa-user fa-2x"></i>
              </a>
            </div>
          </div>

        </nav>
      </div>
    <?php endforeach; ?>
  </div>
  <!-- Navbar End -->