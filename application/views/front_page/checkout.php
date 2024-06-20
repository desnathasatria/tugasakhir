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


 <!-- Checkout Page Start -->
 <div class="container-fluid py-5">
     <?php foreach ($produk as $pr) : ?>
         <div class="container py-5">
             <h1 class="mb-4">Billing details</h1>
             <form action="#">
                 <div class="row g-5">
                     <div class="col-md-12 col-lg-4 col-xl-6">
                         <div class="row">
                             <div class="col-md-12 col-lg-6">
                                 <div class="form-item w-100">
                                     <label class="form-label my-3">First Name<sup>*</sup></label>
                                     <input type="text" class="form-control">
                                 </div>
                             </div>
                             <div class="col-md-12 col-lg-6">
                                 <div class="form-item w-100">
                                     <label class="form-label my-3">Last Name<sup>*</sup></label>
                                     <input type="text" class="form-control">
                                 </div>
                             </div>
                         </div>
                         <div class="form-item">
                             <label class="form-label my-3">Company Name<sup>*</sup></label>
                             <input type="text" class="form-control">
                         </div>
                         <div class="form-item">
                             <label class="form-label my-3">Address <sup>*</sup></label>
                             <input type="text" class="form-control" placeholder="House Number Street Name">
                         </div>
                         <div class="form-item">
                             <label class="form-label my-3">Town/City<sup>*</sup></label>
                             <input type="text" class="form-control">
                         </div>
                         <div class="form-item">
                             <label class="form-label my-3">Country<sup>*</sup></label>
                             <input type="text" class="form-control">
                         </div>
                         <div class="form-item">
                             <label class="form-label my-3">Postcode/Zip<sup>*</sup></label>
                             <input type="text" class="form-control">
                         </div>
                         <div class="form-item">
                             <label class="form-label my-3">Mobile<sup>*</sup></label>
                             <input type="tel" class="form-control">
                         </div>
                         <div class="form-item">
                             <label class="form-label my-3">Email Address<sup>*</sup></label>
                             <input type="email" class="form-control">
                         </div>
                         <div class="form-check my-3">
                             <input type="checkbox" class="form-check-input" id="Account-1" name="Accounts" value="Accounts">
                             <label class="form-check-label" for="Account-1">Create an account?</label>
                         </div>
                         <hr>
                         <div class="form-check my-3">
                             <input class="form-check-input" type="checkbox" id="Address-1" name="Address" value="Address">
                             <label class="form-check-label" for="Address-1">Ship to a different address?</label>
                         </div>
                         <div class="form-item">
                             <textarea name="text" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Oreder Notes (Optional)"></textarea>
                         </div>
                     </div>
                     <div class="col-md-12 col-lg-8 col-xl-6">
                         <div class="table-responsive">
                             <table class="table" border='1'>
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
                                     <tr>
                                         <?php
                                            $hargaTanpaRpTitik = str_replace("Rp. ", "", $pr->price);
                                            $hargaTanpaRpTitik = str_replace(".", "", $hargaTanpaRpTitik);
                                            ?>
                                         <th scope="row">
                                             <div class="d-flex align-items-center mt-2">
                                                 <img src="<?= base_url('assets/image/product/') . $pr->image ?>" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                             </div>
                                         </th>
                                         <td class="py-5"><?= $pr->title ?></td>
                                         <td class="py-5"><?= $hargaTanpaRpTitik ?></td>
                                         <td class="py-5"><?= $jumlah ?></td>
                                         <td class="py-5"><?= $hargaTanpaRpTitik * $jumlah ?></td>
                                         <td style="display:none;" id='weight' name='weight'><?= $pr->weight ?></td>
                                     </tr>
                                     <tr>
                                         <th scope="row">
                                         </th>
                                         <td class="py-5"></td>
                                         <td class="py-5"></td>
                                         <td class="py-5">
                                             <p class="mb-0 text-dark py-3">Subtotal</p>
                                         </td>
                                         <td class="py-5">
                                             <div class="py-3 border-bottom border-top">
                                                 <p class="mb-0 text-dark" id="productPrice"><?= $hargaTanpaRpTitik * $jumlah ?></p>
                                             </div>
                                         </td>
                                     </tr>
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
                                         <th scope="row">
                                         </th>
                                         <td class="py-5">
                                             <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                         </td>
                                         <td class="py-5"></td>
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
                             <button type="button" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" onclick="createPayment(<?= $pr->id ?>)">Place Order</button>
                         </div>
                     </div>
                 </div>
             </form>
         </div>
     <?php endforeach; ?>
 </div>
 <!-- Checkout Page End -->
 <script>
     var base_url = '<?php echo base_url() ?>';
     var _controller = '<?= $this->router->fetch_class() ?>';
 </script>