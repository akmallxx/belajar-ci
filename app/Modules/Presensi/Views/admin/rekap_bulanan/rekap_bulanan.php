<?= $this->extend('admin/layout.php'); ?> 
<?= $this->section('content'); ?>

<form class="row g-3" method="get" action="<?= base_url('admin/rekap_bulanan') ?>">
    <?= csrf_field(); ?>
    <div class="col-md-auto">
        <label for="month">Pilih Bulan</label>
        <select id="month" name="month" class="form-control">
            <option value="">Semua Bulan</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= $m == $selected_month ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $m, 10)) ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-md-auto">
        <label for="year">Pilih Tahun</label>
        <select id="year" name="year" class="form-control">
            <option value="">Semua Tahun</option>
            <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
                <option value="<?= $y ?>" <?= $y == $selected_year ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-md-auto">
        <label>&nbsp;</label>
        <button type="submit" class="btn btn-primary form-control">Tampilkan</button>
    </div>
</form> 
 
<table class="table table-striped table-bordered" id="datatables">
    <thead class="thead-dark">
        <tr>
            <th scope="col">NIP Pegawai</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Jumlah Kehadiran</th>
            <th scope="col">Total Keterlambatan</th>
            <th scope="col">Total Jam Kerja</th>
            <th scope="col">Total Cuti/Izin/Sakit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rekap_bulanan as $rb): ?>
            <tr>
                <td><?= htmlspecialchars($rb['nip_pegawai']) ?></td>
                <td><?= htmlspecialchars($rb['nama_pegawai']) ?></td>
                <td><?= htmlspecialchars($rb['jumlah_kehadiran']) ?></td>
                <td><?= htmlspecialchars(gmdate('H:i:s', $rb['total_lateness'])) ?></td>
                <td><?= htmlspecialchars(gmdate('H:i:s', $rb['total_hours_worked'])) ?></td>
                <td><?= htmlspecialchars($rb['total_absences']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= base_url('admin/rekap_bulanan/exportToCSV?month=' . $selected_month . '&year=' . $selected_year) ?>" class="btn btn-danger">Export to CSV</a>

<?= $this->endSection(); ?>