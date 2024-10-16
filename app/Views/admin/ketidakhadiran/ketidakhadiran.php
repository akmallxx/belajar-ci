<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<!-- Form untuk memilih bulan dan tahun -->
<form method="get" action="<?= base_url('admin/ketidakhadiran') ?>">
    <?= csrf_field(); ?>
    <div class="row gx-2 mb-3">
        <div class="col-6 col-md-3 mb-2">
            <select name="bulan" class="form-select" onchange="this.form.submit()">
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>" min="2000" max="<?= date('Y') ?>" onchange="this.form.submit()">
        </div>
    </div>
</form>

<a href="<?= base_url('admin/ketidakhadiran/create') ?>" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i>Tambah Data</a>

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="datatables">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Pegawai</th> <!-- Ubah dari ID Pegawai ke Nama Pegawai -->
                <th scope="col">Keterangan</th>
                <th scope="col">Tanggal Izin</th>
                <th scope="col">Sampai Tanggal</th>
                <th scope="col">Detail</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($ketidakhadiran as $kh) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($kh['nama_pegawai']) ?></td> <!-- Ubah dari $kh['id_pegawai'] ke $kh['nama_pegawai'] -->
                    <td><?= htmlspecialchars($kh['keterangan']) ?></td>
                    <td><?= htmlspecialchars($kh['tanggal_awal']) ?></td>
                    <td><?= htmlspecialchars($kh['tanggal_akhir']) ?></td>
    
                    <td>
                        <a href="<?= base_url('admin/ketidakhadiran/detail/' . $kh['id']) ?>" class="badge bg-secondary">Klik untuk detail</a>
                    </td>
                    <td>
                        <?php if ($kh['status_pengajuan'] == 'menunggu'): ?>
                            <a href="<?= base_url('admin/ketidakhadiran/statuses/' . $kh['id'] . '/' . 'disetujui') ?>" class="badge bg-success">Setujui</a>
                            <a href="<?= base_url('admin/ketidakhadiran/statuses/' . $kh['id'] . '/' . 'ditolak') ?>" class="badge bg-danger">Tolak</a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/ketidakhadiran/edit/' . $kh['id']) ?>" class="badge bg-primary">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>