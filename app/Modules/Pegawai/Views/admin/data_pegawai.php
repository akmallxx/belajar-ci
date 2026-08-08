<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<a href="<?= base_url('admin/data_pegawai/form') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Data</a>

<table class="table table-striped table-bordered " id="datatables">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Detail</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($pegawai as $peg): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($peg['nip']) ?></td>
                <td><?= htmlspecialchars($peg['nama']) ?></td>
                <td><?= htmlspecialchars($peg['jabatan']) ?></td>
                <td>
                    <a href="<?= base_url('admin/data_pegawai/detail/' . $peg['id']) ?>" class="badge bg-secondary">Klik untuk detail</a>
                </td>
                <td>
                    <a href="<?= base_url('admin/data_pegawai/form/' . $peg['id']) ?>" class="badge bg-primary">Edit</a>
                    <a href="<?= base_url('admin/data_pegawai/delete/' . $peg['id']) ?>" class="badge bg-danger delete-button">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>