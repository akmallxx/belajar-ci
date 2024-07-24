<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
    <form  method="post" action="<?= base_url('admin/jabatan/store') ?>">
    <div class="input-style-1">
        <label>Nama Jabatan</label>
        <input type="text" class="form-control" name="jabatan" placeholder="Nama Jabatan" required />
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
    </div>
</div>

<?= $this->endSection(); ?>