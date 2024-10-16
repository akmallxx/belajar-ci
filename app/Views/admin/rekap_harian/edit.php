<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/rekap_harian/update/' . $rekap_harian['id']) ?>">
            <?= csrf_field(); ?>

            <div class="input-style-1">
                <label>Nama Pegawai</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($rekap_harian['nama']) ?>" readonly />
                <input type="hidden" name="id_pegawai" value="<?= $rekap_harian['id_pegawai'] ?>" />
            </div>
        
            <div class="input-style-1">
                <label>Jam Masuk</label>
                <input type="time" class="form-control" name="jam_masuk" value="<?= $rekap_harian['jam_masuk'] ?>" required />
            </div>

            <div class="input-style-1">
                <label>Jam Keluar</label>
                <input type="time" class="form-control" name="jam_keluar" value="<?= $rekap_harian['jam_keluar'] ?>" required />
            </div>
            <div class="input-style-1">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>