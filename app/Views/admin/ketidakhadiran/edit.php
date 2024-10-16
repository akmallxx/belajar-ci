<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/ketidakhadiran/update/' . $ketidakhadiran['id']) ?>" enctype="multipart/form-data">
            <!-- Token CSRF untuk keamanan -->
            <?= csrf_field(); ?>

            <!-- Nama Pegawai (tidak bisa diedit) -->
            <div class="input-style-1">
                <label>Pegawai</label>
                <p class="form-control-static"><?= htmlspecialchars($pegawai['nama']); ?></p>
                <input type="hidden" name="id_pegawai" value="<?= $pegawai['id']; ?>">
            </div>

            <div class="input-style-1">
                <label>Keterangan</label>
                <select class="form-control" name="keterangan" required>
                    <option value="">--- Pilih ---</option>
                    <option value="Izin" <?= $ketidakhadiran['keterangan'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                    <option value="Sakit" <?= $ketidakhadiran['keterangan'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                    <option value="Cuti" <?= $ketidakhadiran['keterangan'] == 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-style-1">
                        <label>Dari</label>
                        <input type="date" class="form-control" name="tanggal_awal" value="<?= date('Y-m-d', strtotime($ketidakhadiran['tanggal_awal'])) ?>" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-style-1">
                        <label>Sampai</label>
                        <input type="date" class="form-control" name="tanggal_akhir" value="<?= date('Y-m-d', strtotime($ketidakhadiran['tanggal_akhir'])) ?>" required />
                    </div>
                </div>
            </div>

            <div class="input-style-1">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="5" placeholder="Deskripsi" required><?= htmlspecialchars($ketidakhadiran['deskripsi']) ?></textarea>
            </div>

            <div class="input-style-1">
                <label>File</label>
                <input type="file" class="form-control" name="file" />
                <?php if (!empty($ketidakhadiran['file'])): ?>
                    <p>File saat ini: <a href="<?= base_url('uploads/ketidakhadiran/' . $ketidakhadiran['file']) ?>" target="_blank">Lihat File</a></p>
                <?php endif; ?>
            </div>

            <div class="input-style-1">
                <label>Status Pengajuan</label>
                <select class="form-control" name="status_pengajuan" required>
                    <option value="">--- Pilih ---</option>
                    <option value="menunggu" <?= $ketidakhadiran['status_pengajuan'] == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="disetujui" <?= $ketidakhadiran['status_pengajuan'] == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="ditolak" <?= $ketidakhadiran['status_pengajuan'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>