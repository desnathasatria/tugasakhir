<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Penjualan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard Penjualan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $produk['jumlah'] ?></h3>
              <p>Jumlah produk</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?= base_url('manage-product') ?>" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $kategori['jumlah'] ?></h3>
              <p>Kategori produk</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?= base_url('manage-category-product') ?>" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $transaksi['jumlah'] ?></h3>
              <p>History transaksi</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?= base_url('manage-history') ?>" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $jml_user['jumlah'] ?></h3>
              <p>Jumlah user</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?= base_url('profil-admin') ?>" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header border-0">
              <div class="d-flex justify-content-between">
                <h3 class="card-title">Grafik data produk per transaksi</h3>
                <a href="<?= base_url('manage-purchase') ?>">View Report</a>
              </div>
            </div>
            <div class="card-body mb">
              <div class="d-flex">
                <p class="d-flex flex-column">
                  <span class="text-bold text-lg"><?= $total_transaksi['jumlah'] ?> transaksi</span>
                  <span>Total transaksi</span>
                </p>
              </div>

              <div class="position-relative mb-4">
                <canvas id="visitors-chart" height="200"></canvas>
              </div>

              <div class="d-flex flex-row justify-content-end">
                <span class="mr-2">
                  <i class="fas fa-square text-primary"></i> Total transaksi produk
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var base_url = '<?php echo base_url() ?>';
  var _controller = '<?= $this->router->fetch_class() ?>';

  var dataFromPHP = <?php echo json_encode($grafik); ?>;

  var title = [];
  var jumlahTransaksi = [];

  dataFromPHP.forEach(function (item) {
    title.push(item.title);
    jumlahTransaksi.push(item.jumlah_transaksi);
  });

  console.log("Title Array:", title);
  console.log("Jumlah Transaksi Array:", jumlahTransaksijumlahTransaksi);

</script>