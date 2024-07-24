<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<a href="<?= base_url('admin/lokasi_presensi/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Tambah Data</a>

<table class="table table-striped table-bordered " id="datatables">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Lokasi</th>
            <th scope="col">Alamat Lokasi</th>
            <th scope="col">Tipe Lokasi</th>
            <th scope="col">Detail</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($lokasi_presensi as $lk): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($lk['nama_lokasi']) ?></td>
                <td><?= htmlspecialchars($lk['alamat_lokasi']) ?></td>
                <td><?= htmlspecialchars($lk['tipe_lokasi']) ?></td>
                <td>
                    <a href="<?= base_url('admin/lokasi_presensi/detail/' . $lk['id']) ?>" class="badge bg-secondary">Klik untuk detail</a>
                </td>
                <td>
                    <a href="<?= base_url('admin/lokasi_presensi/edit/' . $lk['id']) ?>" class="badge bg-primary">Edit</a>
                    <a href="<?= base_url('admin/lokasi_presensi/delete/' . $lk['id']) ?>" class="badge bg-danger delete-button">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>