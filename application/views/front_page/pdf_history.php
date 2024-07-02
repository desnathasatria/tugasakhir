<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>History Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>History Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Pelanggan</th>
                <th>Harga</th>
                <th>Tanggal</th>
                <th>Pembayaran</th>
                <th>Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($history as $row): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row->title; ?></td>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->harga_transaksi; ?></td>
                <td><?php echo $row->created_date; ?></td>
                <td><?php echo $row->status_pembayaran; ?></td>
                <td><?php echo $row->status_pengiriman; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
