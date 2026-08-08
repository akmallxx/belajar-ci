<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/jabatan/save/' . ($jabatan['id'] ?? '')) ?>">
            <?= csrf_field(); ?>
            <div class="input-style-1">
                <label>Nama Jabatan</label>
                <input type="text" class="form-control" name="jabatan" placeholder="Nama Jabatan" value="<?= htmlspecialchars($jabatan['jabatan'] ?? '') ?>" required />
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="<?= base_url('admin/jabatan') ?>" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
