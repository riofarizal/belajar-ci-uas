<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="row">
    <div class="col-lg-6">
        <?= form_open('buy', 'class="row g-3"') ?>
        <?= form_hidden('username', session()->get('username')) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>

        <div class="col-12">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" value="<?= session()->get('username') ?>" readonly>
        </div>

        <div class="col-12">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat">
        </div>

        <div class="col-12">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <select class="form-control" id="kelurahan" name="kelurahan" required style="width: 100%;">
                <option value="">Ketik nama kelurahan...</option>
            </select>
        </div>

        <div class="col-12">
            <label for="destination" class="form-label">Tujuan Kota</label>
            <select class="form-control" id="destination" name="destination" required>
                <option value="">-- Pilih Kota --</option>
            </select>
        </div>

        <div class="col-12">
            <label for="layanan" class="form-label">Layanan</label>
            <select class="form-control" id="courier" name="courier" required>
                <option value="">-- Pilih Kurir --</option>
                <option value="jne">JNE</option>
                <option value="tiki">TIKI</option>
                <option value="pos">POS</option>
            </select>

            <select class="form-control mt-2" id="layanan" name="layanan" required>
                <option value="">-- Pilih Layanan --</option>
            </select>
        </div>

        <div class="col-12">
            <label for="ongkir" class="form-label">Ongkir</label>
            <input type="text" class="form-control" id="ongkir" name="ongkir" readonly>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td><?= number_to_currency($item['price'] * $item['qty'], 'IDR') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2"></td>
                        <td>Subtotal</td>
                        <td><?= number_to_currency($total, 'IDR') ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>Total</td>
                        <td><span id="total"><?= number_to_currency($total, 'IDR') ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
        </div>
    </div>
    <?= form_close() ?>
</div>

<!-- JS Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const originCityId = 444;

    $(document).ready(function () {
        // Inisialisasi Select2
        $('#kelurahan').select2({
            placeholder: 'Ketik nama kelurahan...',
            minimumInputLength: 3,
            ajax: {
                url: '<?= base_url('transaksi/searchKelurahan') ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.kelurahan_id,
                            text: item.nama
                        }))
                    };
                }
            }
        });

        // Load kota tujuan
        $.get("<?= base_url('transaksi/getCity') ?>", function(response) {
            const results = response.rajaongkir.results;
            results.forEach(function(city) {
                $('#destination').append(`<option value="${city.city_id}">${city.city_name}</option>`);
            });
        });

        // Hitung ongkir saat pilih kurir dan kota
        $('#courier, #destination').on('change', function() {
            const courier = $('#courier').val();
            const destination = $('#destination').val();

            if (courier && destination) {
                $.post("<?= base_url('transaksi/getCost') ?>", {
                    origin: originCityId,
                    destination: destination,
                    weight: 1000,
                    courier: courier
                }, function(response) {
                    const services = response.rajaongkir.results[0].costs;
                    $('#layanan').empty().append(`<option value="">-- Pilih Layanan --</option>`);
                    services.forEach(service => {
                        const cost = service.cost[0].value;
                        $('#layanan').append(`<option value="${cost}">${service.service} - Rp${cost}</option>`);
                    });
                });
            }
        });

        // Isi ongkir dan total saat pilih layanan
        $('#layanan').on('change', function () {
            const ongkir = $(this).val();
            $('#ongkir').val(ongkir);

            const subtotal = <?= $total ?>;
            const totalHarga = parseInt(subtotal) + parseInt(ongkir);
            $('#total').text(`Rp${totalHarga.toLocaleString('id-ID')}`);
            $('#total_harga').val(totalHarga);
        });
    });
</script>

<?= $this->endSection() ?>