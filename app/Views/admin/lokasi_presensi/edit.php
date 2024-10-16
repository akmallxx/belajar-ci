<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
    <form  method="post" action="<?= base_url('admin/lokasi_presensi/update/' . $lokasi_presensi['id']) ?>">
        <?= csrf_field(); ?>

    <div class="input-style-1">
        <label>Nama Lokasi</label>
        <input type="text" class="form-control" name="nama_lokasi" placeholder="Nama Lokasi" value="<?= $lokasi_presensi['nama_lokasi'] ?>" required />
    </div>
    <div class="input-style-1">
        <label>Alamat Lokasi</label>
        <textarea class="form-control" name="alamat_lokasi" rows="5" placeholder="Alamat Lokasi" required><?= $lokasi_presensi['alamat_lokasi'] ?></textarea>
    </div>
    <div class="input-style-1">
        <label>Tipe Lokasi</label>
        <input type="text" class="form-control" name="tipe_lokasi" placeholder="Tipe Lokasi" value="<?= $lokasi_presensi['tipe_lokasi'] ?>" required />
    </div>

    <div class="input-style-1">
        <label>Latitude</label>
        <input type="text" class="form-control" name="latitude" placeholder="Latitude" value="<?= $lokasi_presensi['latitude'] ?>" required />
    </div>
    <div class="input-style-1">
        <label>Longitude</label>
        <input type="text" class="form-control" name="longitude" placeholder="Longitude" value="<?= $lokasi_presensi['longitude'] ?>" required />
    </div>
    <div class="input-style-1">
        <label>Radius (Meter)</label>
        <input type="number" class="form-control" name="radius" placeholder="Radius" value="<?= $lokasi_presensi['radius'] ?>" required />
    </div>
    <div class="input-style-1">
        <label>Zona Waktu</label>
        <select name="zona_waktu" required>
            <option value="">--- Pilih ---</option>
            <option <?php if ($lokasi_presensi['zona_waktu'] == 'WIB') {
                echo "selected";
            } ?> value="WIB">WIB</option>
            <option <?php if ($lokasi_presensi['zona_waktu'] == 'WITA') {
                echo "selected";
            } ?> value="WITA">WITA</option>
            <option <?php if ($lokasi_presensi['zona_waktu'] == 'WIT') {
                echo "selected";
            } ?> value="WIT">WIT</option>
        </select>
    </div>
    <div class="input-style-1">
        <label>Jam Masuk</label>
        <input type="time" class="form-control" name="jam_masuk" placeholder="Jam Masuk" value="<?= $lokasi_presensi['jam_masuk'] ?>" required />
    </div>
    <div class="input-style-1">
        <label>jam Pulang</label>
        <input type="time" class="form-control" name="jam_pulang" placeholder="Jam Pulang" value="<?= $lokasi_presensi['jam_pulang'] ?>" required />
    </div>



    <button type="submit" class="btn btn-primary">Update</button>
</form>
    </div>
</div>

<?= $this->endSection(); ?>