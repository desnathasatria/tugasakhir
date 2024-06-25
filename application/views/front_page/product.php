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
         /* Atur tinggi gambar yang diinginkan */
         object-fit: cover;
     }

     .fruite-item {
         margin-bottom: 20px;
         padding: 10px;
         /* Jarak di semua sisi produk */
     }
 </style>
 <!-- Fruits Shop Start-->
 <div class="container-fluid fruite py-5">
     <div class="container py-5">
         <h1 class="mb-4">Fresh fruits shop</h1>
         <div class="row">
             <?php
                $count = 0;
                foreach ($produk as $pr) :
                    if ($count % 3 == 0) {
                        echo ($count > 0) ? '</div><div class="row">' : '<div class="row">';
                    }
                ?>
                 <div class="col-md-4">
                     <div class="rounded position-relative fruite-item">
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
                ?>
         </div>
         <div class="col-12">
         </div>
     </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
 <!-- Fruits Shop End-->