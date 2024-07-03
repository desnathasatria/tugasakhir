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
                        <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <?php foreach ($profile as $loc): ?>
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
                <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>GTT Pusat Oleh -
                        Oleh</a></span>
            </div>
            <div class="col-md-6 my-auto text-center text-md-end text-white">
                Desnatha Satria Lando Arisukma
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->



<!-- Back to Top -->
<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
        class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/template-user/lib/easing/easing.min.js"></script>
<script src="<?= base_url() ?>assets/template-user/lib/waypoints/waypoints.min.js"></script>
<script src="<?= base_url() ?>assets/template-user/lib/lightbox/js/lightbox.min.js"></script>
<script src="<?= base_url() ?>assets/template-user/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script
    src="<?= base_url() ?>assets/template-admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script
    src="<?= base_url() ?>assets/template-admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/template-admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Alertify CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/default.min.css" />

<!-- Alertify JS -->
<script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>


<!-- Template Javascript -->
<script src="<?= base_url() ?>assets/template-user/js/main.js"></script>
<!-- Gallery Filter Javascript -->
<script src="<?php echo base_url('assets/template-user/js/gallery_filter.js') ?>"></script>
</body>
<script>
    $(document).ready(function () {
        get_keranjang();
    });

    var base_url = '<?php echo base_url() ?>';
    var _controller = '<?= $this->router->fetch_class() ?>';

    function updateCartItemCount(count) {
        $('#cartItemCount').text(count);
    }

    function get_keranjang() {
        $.ajax({
            url: base_url + _controller + "/get_data_keranjang",
            method: "GET",
            dataType: "json",
            success: function (data) {
                var id_produk_array = data.map(function (item) {
                    return item.id_produk;
                });
                var id_produk_string = id_produk_array.join(',');
                $("[name='id_produk_1']").val(id_produk_string);

                var jumlah_array = data.map(function (item) {
                    return item.quantity;
                });
                var jumlah_string = jumlah_array.join(',');
                $("[name='jumlah_1']").val(jumlah_string);

                // Process the data to remove "Rp. " and "."
                data = data.map(function (item) {
                    item.price = item.price.replace("Rp. ", "").replace(/\./g, "");
                    return item;
                });

                // Update the cart item count
                updateCartItemCount(data.length);

                var table = $("#tabelKeranjang").DataTable({
                    destroy: true,
                    searching: false,
                    paging: false,
                    data: data,
                    columns: [{
                        data: "title"
                    },
                    {
                        data: "price"
                    },
                    {
                        data: "quantity"
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data, type, row) {
                            var total = row.price * row.quantity;
                            return total;
                        },
                    },
                    {
                        data: null,
                        className: "text-center",
                        render: function (data, type, row) {
                            return (
                                '<button class="btn btn-warning hapusKeranjang" title="hapus" data-id="' +
                                row.id +
                                '"><i class="fa-solid fa-trash-can"></i></button>'
                            );
                        },
                    },
                    ],
                    initComplete: function () {
                        // Set column titles alignment to center
                        $("th").css("text-align", "center");
                    },
                });

                // Add click event listener for delete buttons
                $('.hapusKeranjang').on('click', function () {
                    var itemId = $(this).data('id');
                    delete_keranjang(itemId);
                });
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.statusText);
            },
        });
    }

    function delete_keranjang(itemId) {
        $.ajax({
            url: base_url + _controller + "/delete_data_keranjang",
            method: "POST",
            data: {
                id: itemId
            },
            dataType: "json",
            success: function (response) {
                // Reload the cart data
                alertify.success("Berhasil menghapus data keranjang");
                get_keranjang();
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.statusText);
            },
        });
    }

    function insert_data_keranjang(id) {
        var formData = new FormData();
        formData.append("id", $("[name='id_produk']").val());

        $.ajax({
            type: "POST",
            url: base_url + "/" + _controller + "/insert_data_keranjang",
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (response) {
                delete_error();
                if (response.errors) {
                    for (var fieldName in response.errors) {
                        $("#error-" + fieldName).show();
                        $("#error-" + fieldName).html(response.errors[fieldName]);
                    }
                } else if (response.success) {
                    $("#exampleModal").modal("hide");
                    $("body").append(response.success);
                    get_keranjang();
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + error);
            },
        });
    }

</script>

</html>