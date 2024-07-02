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
     <h1 class="text-center text-white display-6">Checkout</h1>
     <ol class="breadcrumb justify-content-center mb-0">
         <li class="breadcrumb-item"><a href="#">Home</a></li>
         <li class="breadcrumb-item"><a href="#">Pages</a></li>
         <li class="breadcrumb-item active text-white">Checkout</li>
     </ol>
 </div>
 <!-- Single Page Header End -->

 <div class="row">
     <div class="col-lg-12">
         <!-- Checkout Page Start -->
         <div class="container-fluid py-5">
             <div class="container py-5">
                 <h1 class="mb-4">Billing details</h1>
                 <form action="#">
                     <div class="row g-5">
                         <div class="col-md-12 col-lg-12 col-xl-12 mx-auto"> <!-- Center content in medium and larger screens -->
                             <div class="table-responsive">
                                 <table class="table border">
                                     <thead>
                                         <tr>
                                             <th scope="col">Products</th>
                                             <th scope="col">Name</th>
                                             <th scope="col">Price</th>
                                             <th scope="col">Quantity</th>
                                             <th scope="col">Total</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $multiple_jumlah = is_array($jumlah) && count($jumlah) >= 1;
                                            $sub_total = 0;
                                            $jumlah_total = 0;
                                            $total_id = '';
                                            foreach ($produk as $index => $pr) : ?>
                                             <?php
                                                $hargaTanpaRpTitik = str_replace("Rp. ", "", $pr->price);
                                                $hargaTanpaRpTitik = str_replace(".", "", $hargaTanpaRpTitik);

                                                if ($multiple_jumlah) {
                                                    $jumlah = isset($this->app_data['jumlah'][$index]) ? $this->app_data['jumlah'][$index] : 0;
                                                } else {
                                                    $jumlah = $this->app_data['jumlah'];
                                                }

                                                $total_per_item = $hargaTanpaRpTitik * $jumlah;
                                                $sub_total += $total_per_item;
                                                $jumlah_total += $jumlah;
                                                $total_id .= ($total_id ? ',' : '') . $pr->id;
                                                ?>
                                             <tr>
                                                 <td>
                                                     <div class="d-flex align-items-center mt-2">
                                                         <img src="<?= base_url('assets/image/product/') . $pr->image ?>" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                                     </div>
                                                 </td>
                                                 <td class="py-5"><?= $pr->title ?></td>
                                                 <td class="py-5"><?= $hargaTanpaRpTitik ?></td>
                                                 <td class="py-5"><?= $jumlah ?></td>
                                                 <td class="py-5"><?= $hargaTanpaRpTitik * $jumlah ?></td>
                                                 <td style="display:none;" id='weight' name='weight'><?= $pr->weight ?></td>
                                             </tr>
                                         <?php endforeach; ?>
                                         <tr>
                                             <td colspan="3" class="px-3 py-5">
                                                 <select class="" name="courierName" id="courierName">
                                                     <option value="">Pilih Kurir</option>
                                                     <option value="jne">JNE</option>
                                                     <option value="pos">POS</option>
                                                     <option value="tiki">Tiki</option>
                                                 </select>
                                                 <select class="" name="courierService" id="courierService">
                                                     <option selected>Loading...</option>
                                                 </select>
                                             </td>
                                             <td class="py-5">
                                                 <p class="mb-0 text-dark py-4">Shipping</p>
                                             </td>
                                             <td class="py-5">
                                                 <div class="py-3 border-bottom border-top">
                                                     <p class="mb-0 text-dark" id="shippingPrice"></p>
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td colspan="3" class="px-3 py-5">
                                                 <p class="mb-0 text-dark py-3">Subtotal</p>
                                             </td>
                                             <td class="py-5"></td>
                                             <td class="py-5">
                                                 <div class="py-3 border-bottom border-top">
                                                     <p class="mb-0 text-dark" id="productPrice"><?= $sub_total ?></p>
                                                 </div>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td colspan="3" class="px-3 py-5">
                                                 <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                             </td>
                                             <td class="py-5"></td>
                                             <td class="py-5">
                                                 <div class="py-3 border-bottom border-top">
                                                     <p class="mb-0 text-dark" id="totalPrice"></p>
                                                 </div>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>

                             <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                 <button type="button" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" onclick="createPayment('<?= $total_id ?>', <?= $jumlah_total ?>)">Place Order</button>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- Checkout Page End -->
 <script>
     var base_url = '<?php echo base_url() ?>';
     var _controller = '<?= $this->router->fetch_class() ?>';
 </script>