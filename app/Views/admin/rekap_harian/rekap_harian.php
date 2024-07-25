<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<a href="<?= base_url('admin/rekap_harian/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Data</a>

<table class="table table-striped table-bordered" id="datatables">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <!-- <th scope="col">NIP</th> -->
            <th scope="col">Nama Pegawai</th>
            <!-- <th scope="col">Tanggal</th> -->
            <th scope="col">Hari</th>
            <!-- <th scope="col">Jam Masuk</th> -->
            <!-- <th scope="col">Jam Keluar</th> -->
            <th scope="col">Status</th>
            <th scope="col">Keterlambatan</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($rekap_harian as $rh) : ?>
            <tr>
                <td><?= $no++ ?></td>

                <td><?= htmlspecialchars($rh['nama']) ?></td>

                <td><?= htmlspecialchars($rh['hari']) ?></td>

                <td><?= htmlspecialchars($rh['status']) ?></td>
                <td><?= htmlspecialchars($rh['keterlambatan']) ?></td>
                <td>
                    <a href="<?= base_url('admin/rekap_harian/detail/' . $rh['id']) ?>" class="badge bg-secondary">Detail</a>
                    <a href="<?= base_url('admin/rekap_harian/edit/' . $rh['id']) ?>" class="badge bg-primary">Edit</a>
                    <a href="<?= base_url('admin/rekap_harian/delete/' . $rh['id']) ?>" class="badge bg-danger delete-button">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>