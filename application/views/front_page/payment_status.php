<!-- application/views/payment_status.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Status Pembayaran</title>
</head>
<body>
    <h1>Status Pembayaran</h1>
    <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
    <p><strong>Status Pembayaran:</strong> <?php echo $transaction_status; ?></p>

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
</body>
</html>
