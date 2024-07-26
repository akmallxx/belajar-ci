<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="mb-3">
    <form method="get" action="<?= base_url('admin/rekap_bulanan') ?>">
        <div class="row form-row">
            <div class="col-2">
                <label for="month">Pilih Bulan:</label>
                <select name="month" id="month" class="form-control">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= sprintf('%02d', $m) ?>" <?= $selected_month == sprintf('%02d', $m) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="year">Pilih Tahun:</label>
                <select name="year" id="year" class="form-control">
                    <?php for ($y = date('Y'); $y >= date('Y') - 10; $y--): ?>
                        <option value="<?= $y ?>" <?= $selected_year == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-2">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Tampilkan</button>
            </div>
        </div>
    </form>
</div>

<table class="table table-striped table-bordered" id="datatables">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">NIP Pegawai</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Jumlah Kehadiran</th>
            <th scope="col">Jumlah Keterlambatan (Jam:Menit:Detik)</th>
            <th scope="col">Total Jam Kerja (Jam:Menit:Detik)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($rekap_bulanan as $rb): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($rb['nip_pegawai']) ?></td>
                <td><?= htmlspecialchars($rb['nama_pegawai']) ?></td>
                <td><?= htmlspecialchars($rb['jumlah_kehadiran']) ?></td>
                <td><?= htmlspecialchars($rb['total_lateness']) ?></td>
                <td><?= htmlspecialchars($rb['total_hours_worked']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>
