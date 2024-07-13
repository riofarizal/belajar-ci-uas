<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
</head>
<body>
    <h1>Data Transaksi</h1>

    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Total Harga</th>
            <th>Alamat</th>
            <th>Ongkir</th>
            <th>Status</th>
        </tr>

        <?php
        foreach ($transactions as $index => $transaction) :
        ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $transaction['username'] ?></td>
                <td><?= number_to_currency($transaction['total_harga'], 'IDR') ?></td>
                <td><?= $transaction['alamat'] ?></td>
                <td><?= number_to_currency($transaction['ongkir'], 'IDR') ?></td>
                <td><?= $transaction['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>Downloaded on <?= date("Y-m-d H:i:s") ?></p>
</body>
</html>
