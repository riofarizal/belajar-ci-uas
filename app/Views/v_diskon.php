<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?= $title ?></h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus"></i> Tambah Diskon
                    </button>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nominal</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($diskons)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data diskon</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($diskons as $index => $diskon): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= date('d/m/Y', strtotime($diskon['tanggal'])) ?></td>
                                    <td>Rp <?= number_format($diskon['nominal'], 0, ',', '.') ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($diskon['created_at'])) ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($diskon['updated_at'])) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                onclick="editDiskon('<?= $diskon['id'] ?>', '<?= $diskon['tanggal'] ?>', '<?= $diskon['nominal'] ?>')">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('<?= $diskon['id'] ?>', '<?= date('d/m/Y', strtotime($diskon['tanggal'])) ?>')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('diskon/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="create_tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_nominal" class="form-label">Nominal Diskon</label>
                        <input type="number" class="form-control" id="create_nominal" name="nominal" 
                               placeholder="Masukkan nominal diskon" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="post" id="editForm">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" readonly>
                        <small class="form-text text-muted">Tanggal tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nominal" class="form-label">Nominal Diskon</label>
                        <input type="number" class="form-control" id="edit_nominal" name="nominal" 
                               placeholder="Masukkan nominal diskon" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus diskon untuk tanggal <span id="deleteDateText"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
function editDiskon(id, tanggal, nominal) {
    document.getElementById('edit_tanggal').value = tanggal;
    document.getElementById('edit_nominal').value = nominal;
    document.getElementById('editForm').action = '<?= base_url('diskon/update/') ?>' + id;

    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

function confirmDelete(id, tanggal) {
    document.getElementById('deleteDateText').textContent = tanggal;
    document.getElementById('deleteConfirmBtn').href = '<?= base_url('diskon/delete/') ?>' + id;

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Reset form when create modal is closed
document.getElementById('createModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('create_tanggal').value = '';
    document.getElementById('create_nominal').value = '';
});
</script>
<?= $this->endSection() ?>