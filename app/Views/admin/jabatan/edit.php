<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
    <form  method="post" action="<?= base_url('admin/jabatan/update/'. $jabatan['id']) ?>">
        <?= csrf_field(); ?>
    <div class="input-style-1">
        <label>Nama Jabatan</label>
        <input type="text" name="jabatan" placeholder="Nama Jabatan" value="<?= $jabatan['jabatan'] ?>" required />
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
    </div>
</div>

<?= $this->endSection(); ?>