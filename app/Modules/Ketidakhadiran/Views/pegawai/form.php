<?= $this->extend('pegawai/layout') ?>
<?= $this->section('content') ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('ketidakhadiran/save/' . ($ketidakhadiran['id'] ?? '')) ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="existing_file" value="<?= $ketidakhadiran['file'] ?? '' ?>">
            
            <div class="input-style-1">
                <label>Keterangan</label>
                <select name="keterangan" class="form-control" required>
                    <?php $ket = $ketidakhadiran['keterangan'] ?? ''; ?>
                    <option value="">-- Pilih Keterangan --</option>
                    <option value="Izin" <?= $ket == 'Izin' ? 'selected' : '' ?>>Izin</option>
                    <option value="Sakit" <?= $ket == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                    <option value="Cuti" <?= $ket == 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                </select>
            </div>

            <div class="input-style-1">
                <label>Tanggal Awal</label>
                <input type="date" class="form-control" name="tanggal_awal" value="<?= htmlspecialchars($ketidakhadiran['tanggal_awal'] ?? '') ?>" required />
            </div>

            <div class="input-style-1">
                <label>Tanggal Akhir</label>
                <input type="date" class="form-control" name="tanggal_akhir" value="<?= htmlspecialchars($ketidakhadiran['tanggal_akhir'] ?? '') ?>" required />
            </div>

            <div class="input-style-1">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" placeholder="Deskripsi Alasan" required><?= htmlspecialchars($ketidakhadiran['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="input-style-1">
                <label>File Lampiran/Bukti <?= !empty($ketidakhadiran['file']) ? '(' . $ketidakhadiran['file'] . ')' : '' ?></label>
                <input type="file" class="form-control" name="files" />
            </div>

            <button type="submit" class="btn btn-primary mt-3">Kirim Pengajuan</button>
            <a href="<?= base_url('ketidakhadiran') ?>" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
