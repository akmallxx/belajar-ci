<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<a href="<?= base_url('admin/jabatan/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Tambah Data</a>

<table class="table table-striped table-bordered " id="datatables">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Jabatan</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($jabatan as $jab): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($jab['jabatan']) ?></td>
                <td>
                    <a href="<?= base_url('admin/jabatan/edit/' . $jab['id']) ?>" class="badge bg-primary">Edit</a>
                    <a href="<?= base_url('admin/jabatan/delete/' . $jab['id']) ?>" class="badge bg-danger delete-button">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>