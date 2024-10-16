<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
    <form  method="post" action="<?= base_url('admin/lokasi_presensi/store') ?>">
        <?= csrf_field(); ?>

    <div class="input-style-1">
        <label>Nama Lokasi</label>
        <input type="text" class="form-control" name="nama_lokasi" placeholder="Nama Lokasi" required />
    </div>
    <div class="input-style-1">
        <label>Alamat Lokasi</label>
        <textarea class="form-control" name="alamat_lokasi" rows="5" placeholder="Alamat Lokasi" required></textarea>
    </div>
    <div class="input-style-1">
        <label>Tipe Lokasi</label>
        <input type="text" class="form-control" name="tipe_lokasi" placeholder="Tipe Lokasi" required />
    </div>

    <div class="input-style-1">
        <label>Latitude</label>
        <input type="text" class="form-control" name="latitude" placeholder="Latitude" required />
    </div>
    <div class="input-style-1">
        <label>Longitude</label>
        <input type="text" class="form-control" name="longitude" placeholder="Longitude" required />
    </div>
    <div class="input-style-1">
        <label>Radius (Meter)</label>
        <input type="number" class="form-control" name="radius" placeholder="Radius" required />
    </div>
    <div class="input-style-1">
        <label>Zona Waktu</label>
        <select class="form-control" name="zona_waktu" required>
            <option value="">--- Pilih ---</option>
            <option value="WIB">WIB</option>
            <option value="WITA">WITA</option>
            <option value="WIT">WIT</option>
        </select>
    </div>
    <div class="input-style-1">
        <label>Jam Masuk</label>
        <input type="time" class="form-control" name="jam_masuk" placeholder="Jam Masuk" required />
    </div>
    <div class="input-style-1">
        <label>jam Pulang</label>
        <input type="time" class="form-control" name="jam_pulang" placeholder="Jam Pulang" required />
    </div>



    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
    </div>
</div>

<?= $this->endSection(); ?>