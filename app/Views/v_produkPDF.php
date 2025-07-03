<h1>Data Produk</h1>

<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Foto</th>
    </tr>

    <?php
    $no = 1;
    foreach ($product as $index => $produk) :
        // Path absolut ke gambar
        $path = FCPATH . 'img/' . $produk['foto'];
        $base64 = '';

        // Cek apakah file ada
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            // Gambar default atau kosongkan
            $base64 = ''; // atau pakai: 'https://via.placeholder.com/50'
        }
    ?>
        <tr>
            <td align="center"><?= $index + 1 ?></td>
            <td><?= $produk['nama'] ?></td>
            <td align="right"><?= "Rp " . number_format($produk['harga'], 2, ",", ".") ?></td>
            <td align="center"><?= $produk['jumlah'] ?></td>
            <td align="center">
                <?php if ($base64 != '') : ?>
                    <img src="<?= $base64 ?>" width="50px">
                <?php else : ?>
                    Tidak ada gambar
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p>Download on <?= date("Y-m-d H:i:s") ?></p>
