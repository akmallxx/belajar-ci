<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<table class="table table-striped table-bordered" id="datatables">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">NIP Pegawai</th>
            <th scope="col">Nama Pegawai</th>
            <th scope="col">Jumlah Kehadiran</th>
            <th scope="col">Total Keterlambatan</th>
            <th scope="col">Total Jam Kerja</th>
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
