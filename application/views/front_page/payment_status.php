<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Status Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
        }
        h1 {
            color: #4CAF50;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .status {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Status Pembayaran</h1>
        <p><strong>Order ID:</strong> <span class="status"><?php echo $order_id; ?></span></p>
        <p><strong>Status Pembayaran:</strong> <span class="status"><?php echo $transaction_status; ?></span></p>

        <?php if ($transaction_status == 'capture' || $transaction_status == 'settlement'): ?>
            <p>Pembayaran berhasil.</p>
            <!-- Tambahkan informasi tambahan untuk pembayaran berhasil -->
        <?php elseif ($transaction_status == 'pending'): ?>
            <p>Pembayaran sedang diproses.</p>
            <!-- Tambahkan informasi tambahan untuk pembayaran pending -->
        <?php elseif ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel'): ?>
            <p>Pembayaran tidak berhasil.</p>
            <!-- Tambahkan informasi tambahan untuk pembayaran tidak berhasil -->
        <?php endif; ?>
        <a href="<?= base_url('history') ?>" class="btn">Cek pemesanan</a>
    </div>
</body>
</html>
