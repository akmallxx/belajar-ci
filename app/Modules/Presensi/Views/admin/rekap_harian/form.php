<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/rekap_harian/save/' . ($rekap_harian['id'] ?? '')) ?>">
            <?= csrf_field(); ?>
            <div class="input-style-1">
                <label>Pegawai</label>
                <select name="id_pegawai" class="form-control" required>
                    <option value="">-- Pilih Pegawai --</option>
                    <?php $pegSelected = $rekap_harian['id_pegawai'] ?? ''; ?>
                    <?php foreach ($pegawai as $peg): ?>
                        <option value="<?= $peg['id'] ?>" <?= $pegSelected == $peg['id'] ? 'selected' : '' ?>><?= $peg['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-style-1">
                <label>Tanggal Masuk</label>
                <input type="date" class="form-control" name="tanggal_masuk" value="<?= htmlspecialchars($rekap_harian['tanggal_masuk'] ?? date('Y-m-d')) ?>" required />
            </div>

            <div class="input-style-1">
                <label>Jam Masuk</label>
                <input type="time" class="form-control" name="jam_masuk" value="<?= htmlspecialchars($rekap_harian['jam_masuk'] ?? '') ?>" required />
            </div>

            <div class="input-style-1">
                <label>Tanggal Keluar</label>
                <input type="date" class="form-control" name="tanggal_keluar" value="<?= htmlspecialchars($rekap_harian['tanggal_keluar'] ?? date('Y-m-d')) ?>" />
            </div>

            <div class="input-style-1">
                <label>Jam Keluar</label>
                <input type="time" class="form-control" name="jam_keluar" value="<?= htmlspecialchars($rekap_harian['jam_keluar'] ?? '') ?>" />
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="<?= base_url('admin/rekap_harian') ?>" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
