<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
    <form  method="post" action="<?= base_url('admin/rekap_harian/store') ?>">
        <?= csrf_field(); ?>

    <div class="input-style-1">
        <label>Pegawai</label>
        <select class="form-control" name="id_pegawai" required>
            <option value="">--- Pilih Pegawai ---</option>
            <?php foreach ($pegawai as $pg): ?>
                <option value="<?= $pg['id']; ?>">[<?= $pg['nip']; ?>] <?= $pg['nama']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="input-style-1">
                <label>Tanggal Masuk</label>
                <input type="date" class="form-control" name="tanggal_masuk" required>
            </div>
        </div>
        <div class="col-6">
            <div class="input-style-1">
                <label>Jam Masuk</label>
                <input type="time" class="form-control" name="jam_masuk" required>
            </div>
        </div>
    </div>
    <div class="input-style-1">
        <label>Foto Masuk (Opsional)</label>
        <input type="file" class="form-control" name="foto_masuk">
    </div>
    <div class="input-style-1">
        <label>Catatan Masuk (Opsional)</label>
        <textarea name="catatan_masuk" id="catatan_masuk" class="form-control"></textarea>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="input-style-1">
                <label>Tanggal Keluar</label>
                <input type="date" class="form-control" name="tanggal_keluar" required>
            </div>
        </div>
        <div class="col-6">
            <div class="input-style-1">
                <label>Jam Keluar</label>
                <input type="time" class="form-control" name="jam_keluar" required>
            </div>
        </div>
    </div>
    <div class="input-style-1">
        <label>Foto Keluar (Opsional)</label>
        <input type="file" class="form-control" name="foto_keluar">
    </div>
    <div class="input-style-1">
        <label>Catatan Keluar (Opsional)</label>
        <textarea name="catatan_keluar" id="catatan_keluar" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
    </div>
</div>

<?= $this->endSection(); ?>