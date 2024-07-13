<?php
// Tampilkan layout dan konten
echo $this->extend('layout');
echo $this->section('content');
?>
<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
}
?>

<div class="table-responsive">
    <!-- Table with stripped rows -->
     <a type="button" class="btn btn-success" href="<?=base_url() ?>download">
    Download Data
</a>
    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Alamat</th>
                <th scope="col">Ongkir</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($buy)) :
                foreach ($buy as $index => $item) :
            ?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ?></th>
                        <td><?php echo $item['username'] ?></td>
                        <td><?php echo number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?php echo $item['alamat'] ?></td>
                        <td><?php echo number_to_currency($item['ongkir'], 'IDR') ?></td>
                        <td><?php echo $item['status'] ?></td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ubahStatus-<?php echo $item['id'] ?>">
                                Ubah Status
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="ubahStatus-<?php echo $item['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="update_status" method="POST">
                                        <input type="hidden" name="id_transaksi" value="<?php echo $item['id'] ?>">
                                        <div class="form-group">
                                            <label for="status-<?php echo $item['id'] ?>">Status</label>
                                            <select name="status" id="status-<?php echo $item['id'] ?>" class="form-select">
                                                <option value="1" <?php if ($item['status'] == "1") echo "selected"; ?>>1</option>
                                                <option value="0" <?php if ($item['status'] == "0") echo "selected"; ?>>0</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                    </form>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
</div>
<?php echo $this->endSection(); ?>
