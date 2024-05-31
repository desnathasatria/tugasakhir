        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h3 class="text-primary mb-0">GTT Pusat Oleh Oleh</h3>
                                <p class="text-secondary mb-0">Kediri</p>
                            </a>
                        </div>
                        <div class="col-lg-9">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                <?php foreach ($profile as $loc) : ?>
                    <div class="col-lg-6 col-md-9">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address: <?= $loc->address ?></p>
                            <p>Email: <?= $loc->email ?></p>
                            <p>Phone: <?= $loc->phone_number ?></p>
                            <p>Payment Accepted</p>
                            <img src="<?= base_url() ?>assets/template-user/img/payment.png" class="img-fluid" alt="">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>GTT Pusat Oleh - Oleh</a></span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        Desnatha Satria Lando Arisukma
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>assets/template-user/lib/easing/easing.min.js"></script>
        <script src="<?= base_url() ?>assets/template-user/lib/waypoints/waypoints.min.js"></script>
        <script src="<?= base_url() ?>assets/template-user/lib/lightbox/js/lightbox.min.js"></script>
        <script src="<?= base_url() ?>assets/template-user/lib/owlcarousel/owl.carousel.min.js"></script>

        <!-- Template Javascript -->
        <script src="<?= base_url() ?>assets/template-user/js/main.js"></script>
        <!-- Gallery Filter Javascript -->
        <script src="<?php echo base_url('assets/template-user/js/gallery_filter.js') ?>"></script>
        </body>

        </html>