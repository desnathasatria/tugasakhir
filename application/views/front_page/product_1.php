
    <style>
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-md-4 {
            padding-right: 15px;
            padding-left: 15px;
        }
        .fruite-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .fruite-item {
            margin-bottom: 20px;
            padding: 10px;
        }
    </style>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Produk</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= base_url('') ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">Produk</li>
    </ol>
</div>
<!-- Single Page Header End -->
<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="mb-3">
            <select id="category-filter" class="form-select">
                <option value="all">Semua Kategori</option>
                <?php foreach ($select as $category) : ?>
                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="product-container">
            <?php
            $count = 0;
            foreach ($produk as $pr) :
                if ($count % 3 == 0) {
                    echo ($count > 0) ? '</div><div class="row">' : '<div class="row">';
                }
            ?>
                <div class="col-md-4">
                    <div class="rounded position-relative fruite-item" data-category="<?= $pr->id_category_product ?>">
                        <a href="<?= base_url("Front_page/product_detail/$pr->id") ?>">
                            <div class="fruite-img">
                                <img src="<?= base_url('assets/image/product/') . $pr->image ?>" class="img-fluid w-100 rounded-top" alt="">
                            </div>
                        </a>
                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                            <h4><?= $pr->title ?></h4>
                            <p><?= $pr->name ?></p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0"><?= $pr->price ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                $count++;
            endforeach;
            if ($count > 0) echo '</div>'; // Close the last row if there are products
            ?>
        </div>
    </div>
</div>
<!-- Fruits Shop End-->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Store all products
    var $products = $('.col-md-4').clone();

    // Handle category filter change
    $('#category-filter').on('change', function() {
        var selectedCategory = $(this).val();
        var $filteredProducts;

        if (selectedCategory === 'all') {
            // Show all products
            $filteredProducts = $products;
        } else {
            // Filter products by category
            $filteredProducts = $products.filter(function() {
                return $(this).find('.fruite-item').data('category') == selectedCategory;
            });
        }

        // Clear current products and append filtered ones
        $('#product-container').empty();

        if ($filteredProducts.length > 0) {
            var $currentRow;
            $filteredProducts.each(function(index) {
                if (index % 3 === 0) {
                    $currentRow = $('<div class="row"></div>');
                    $('#product-container').append($currentRow);
                }
                $currentRow.append($(this));
            });
        } else {
            $('#product-container').append('<p>No products found in this category.</p>');
        }
    });
});
</script>