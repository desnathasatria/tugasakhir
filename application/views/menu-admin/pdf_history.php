<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/image/logo-umkm.png') ?>" rel="icon">
    <title>GTT Data History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .content {
            margin: 20px;
        }

        .content h3 {
            margin-top: 0px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .content th,
        .content td {
            border: 1px solid #000;
            padding: 8px;
        }

        .content th {
            background-color: #f2f2f2;
        }

        .content th:first-child,
        .content td:first-child {
            width: 20%;
        }

        .content th:nth-child(2),
        .content td:nth-child(2) {
            width: 30%;
        }

        .content th:nth-child(3),
        .content td:nth-child(3) {
            width: 20%;
        }

        .content th:last-child,
        .content td:last-child {
            width: 30%;
        }

        @media print {
            .header {
                margin-bottom: 10px;
            }
        }

        .centered {
            text-align: center;
        }
    </style>

</head>

<body>
    <div class=" content">
        <center>
            <h3>Data History Pembelian</h3>
        </center>
        <hr>
        <table>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Produk</th>
                <th width="20%">Pelanggan</th>
                <th width="15%">Harga</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pembayaran</th>
                <th width="10%">Pengiriman</th>
            </tr>
            <?php $no = 1;
            foreach ($history as $h): ?>
                <tr>
                    <td class="centered"><?= $no ?></td>
                    <td class="centered"><?php echo $h->title; ?></td>
                    <td class="centered"><?php echo $h->name; ?></td>
                    <td class="centered"><?php echo $h->harga_transaksi; ?></td>
                    <td class="centered"><?php echo $h->created_date; ?></td>
                    <td class="centered"><?php echo $h->status_pembayaran; ?></td>
                    <td class="centered"><?php echo $h->status_pengiriman; ?></td>
                </tr>
                <?php $no++; endforeach; ?>
        </table>
    </div>
</body>

</html>