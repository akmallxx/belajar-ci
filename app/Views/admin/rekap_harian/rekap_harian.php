<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="mb-3">
    <form method="get" action="<?= base_url('admin/rekap_harian'); ?>">
        <?= csrf_field(); ?>
        <div class="row form-row">
            <div class="col-md-2">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $tanggal ?>">
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Tampilkan</button>
            </div>
        </div>
    </form>
</div>

<a href="<?= base_url('admin/rekap_harian/create') ?>" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i>Tambah Data</a>

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="datatables">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pegawai</th>
                <th scope="col">Jam Masuk</th> 
                <th scope="col">Jam Keluar</th> 
                <th scope="col">Lokasi Presensi</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($rekap_harian as $rh) : ?>
                <tr>
                    <td><?= $no++ ?></td>
    
                    <td><?= htmlspecialchars($rh['nama']) ?></td>
                    <td><?= htmlspecialchars($rh['jam_masuk']) ?></td>
                    <td><?= htmlspecialchars($rh['jam_keluar']) ?></td>
                    <td><?= htmlspecialchars($rh['lokpres']['nama_lokasi']) ?></td>
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
</div>

<?= $this->endSection(); ?>