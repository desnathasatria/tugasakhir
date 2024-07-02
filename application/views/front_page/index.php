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


 <!-- Hero Start -->
 <div class="container-fluid py-5 mb-5 hero-header">
     <div class="container py-5">
         <div class="row g-5 align-items-center">
             <div class="col-md-12 col-lg-7">
                 <h4 class="mb-3 text-secondary">100% Olahan Alami</h4>
                 <h1 class="mb-5 display-3 text-primary">GTT Pusat Oleh - Oleh Kediri</h1>
             </div>
             <div class="col-md-12 col-lg-5">
                 <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                     <div class="carousel-inner" role="listbox">
                         <?php $first = true; ?>
                         <?php foreach ($carousel as $key => $crsl) : ?>
                             <div class="carousel-item <?php echo $first ? 'active' : ''; ?> rounded">
                                 <img src="<?= base_url('assets/image/carousel/') . $crsl->image ?>" class="img-fluid w-100 h-100 bg-secondary rounded" alt="Slide <?= $key ?>">
                                 <a href="#" class="btn px-4 py-2 text-white rounded"><?= $crsl->title ?></a>
                             </div>
                             <?php $first = false; ?>
                         <?php endforeach; ?>
                     </div>
                     <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                         <span class="visually-hidden">Previous</span>
                     </button>
                     <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                         <span class="carousel-control-next-icon" aria-hidden="true"></span>
                         <span class="visually-hidden">Next</span>
                     </button>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <!-- Hero End -->


 <!-- Featurs Section Start -->
 <div class="container-fluid featurs py-5">
     <div class="container py-5">
         <div class="row g-4">
             <div class="col-md-6 col-lg-3">
                 <div class="featurs-item text-center rounded bg-light p-4">
                     <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                         <i class="fas fa-car-side fa-3x text-white"></i>
                     </div>
                     <div class="featurs-content text-center">
                         <h5>Pengiriman</h5>
                         <p class="mb-0">Pengiriman ke seluruh kota di Indonesia</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-3">
                 <div class="featurs-item text-center rounded bg-light p-4">
                     <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                         <i class="fas fa-user-shield fa-3x text-white"></i>
                     </div>
                     <div class="featurs-content text-center">
                         <h5>Keamanan Pembayaran</h5>
                         <p class="mb-0">100% Pembayaran Aman</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-3">
                 <div class="featurs-item text-center rounded bg-light p-4">
                     <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                         <i class="fas fa-exchange-alt fa-3x text-white"></i>
                     </div>
                     <div class="featurs-content text-center">
                         <h5>Jaminan</h5>
                         <p class="mb-0">Produk Terjamin</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-3">
                 <div class="featurs-item text-center rounded bg-light p-4">
                     <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                         <i class="fa fa-phone-alt fa-3x text-white"></i>
                     </div>
                     <div class="featurs-content text-center">
                         <h5>Contact</h5>
                         <p class="mb-0">Hubungi kami jika ada pertanyaan</p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Featurs Section End -->

 <!-- Bestsaler Product Start -->
 <div class="container-fluid py-5">
     <div class="container py-5">
         <div class="text-center mx-auto mb-5" style="max-width: 700px;">
             <h1 class="display-4">Bestseller Produk GTT</h1>
             <p>Beberapa Produk Unggulan dari GTT Pusat Oleh - Oleh Kediri</p>
         </div>
         <div class="row g-4">
             <div class="col-lg-6 col-xl-4">
                 <div class="p-4 rounded bg-light">
                     <div class="row align-items-center">
                         <div class="col-6">
                             <img src="<?= base_url() ?>assets/template-user/img/best-product-1.jpg" class="img-fluid rounded-circle w-100" alt="">
                         </div>
                         <div class="col-6">
                             <a href="#" class="h5">Organic Tomato</a>
                             <h4 class="mb-3">3.12 $</h4>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-xl-4">
                 <div class="p-4 rounded bg-light">
                     <div class="row align-items-center">
                         <div class="col-6">
                             <img src="<?= base_url() ?>assets/template-user/img/best-product-2.jpg" class="img-fluid rounded-circle w-100" alt="">
                         </div>
                         <div class="col-6">
                             <a href="#" class="h5">Organic Tomato</a>
                             <h4 class="mb-3">3.12 $</h4>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-xl-4">
                 <div class="p-4 rounded bg-light">
                     <div class="row align-items-center">
                         <div class="col-6">
                             <img src="<?= base_url() ?>assets/template-user/img/best-product-3.jpg" class="img-fluid rounded-circle w-100" alt="">
                         </div>
                         <div class="col-6">
                             <a href="#" class="h5">Organic Tomato</a>
                             <h4 class="mb-3">3.12 $</h4>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-xl-4">
                 <div class="p-4 rounded bg-light">
                     <div class="row align-items-center">
                         <div class="col-6">
                             <img src="<?= base_url() ?>assets/template-user/img/best-product-4.jpg" class="img-fluid rounded-circle w-100" alt="">
                         </div>
                         <div class="col-6">
                             <a href="#" class="h5">Organic Tomato</a>
                             <h4 class="mb-3">3.12 $</h4>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-xl-4">
                 <div class="p-4 rounded bg-light">
                     <div class="row align-items-center">
                         <div class="col-6">
                             <img src="<?= base_url() ?>assets/template-user/img/best-product-5.jpg" class="img-fluid rounded-circle w-100" alt="">
                         </div>
                         <div class="col-6">
                             <a href="#" class="h5">Organic Tomato</a>
                             <h4 class="mb-3">3.12 $</h4>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-xl-4">
                 <div class="p-4 rounded bg-light">
                     <div class="row align-items-center">
                         <div class="col-6">
                             <img src="<?= base_url() ?>assets/template-user/img/best-product-6.jpg" class="img-fluid rounded-circle w-100" alt="">
                         </div>
                         <div class="col-6">
                             <a href="#" class="h5">Organic Tomato</a>
                             <h4 class="mb-3">3.12 $</h4>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-6 col-xl-3">
                 <div class="text-center">
                     <img src="<?= base_url() ?>assets/template-user/img/fruite-item-1.jpg" class="img-fluid rounded" alt="">
                     <div class="py-4">
                         <a href="#" class="h5">Organic Tomato</a>
                         <h4 class="mb-3">3.12 $</h4>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-6 col-xl-3">
                 <div class="text-center">
                     <img src="<?= base_url() ?>assets/template-user/img/fruite-item-2.jpg" class="img-fluid rounded" alt="">
                     <div class="py-4">
                         <a href="#" class="h5">Organic Tomato</a>
                         <h4 class="mb-3">3.12 $</h4>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-6 col-xl-3">
                 <div class="text-center">
                     <img src="<?= base_url() ?>assets/template-user/img/fruite-item-3.jpg" class="img-fluid rounded" alt="">
                     <div class="py-4">
                         <a href="#" class="h5">Organic Tomato</a>
                         <h4 class="mb-3">3.12 $</h4>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-lg-6 col-xl-3">
                 <div class="text-center">
                     <img src="<?= base_url() ?>assets/template-user/img/fruite-item-4.jpg" class="img-fluid rounded" alt="">
                     <div class="py-2">
                         <a href="#" class="h5">Organic Tomato</a>
                         <h4 class="mb-3">3.12 $</h4>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Bestsaler Product End -->