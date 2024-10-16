<?= $this->extend('pegawai/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('profile/update') ?>" enctype="multipart/form-data">

            <!-- CSRF FORM -->
            <?= csrf_field() ?>

            <div class="input-style-1">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= $pegawai['nama'] ?>" />
            </div>
            <div class="input-style-1">
                <label>Jenis Kelamin</label>                
                <select class="form-control" name="jenis_kelamin">
                    <option value="">--- Pilih ---</option>
                    <option <?php if ($pegawai['jenis_kelamin'] == 'Laki-Laki') {
                                echo "selected";
                            } ?> value="Laki-Laki">Laki-Laki</option>
                    <option <?php if ($pegawai['jenis_kelamin'] == 'Perempuan') {
                                echo "selected";
                            } ?> value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="input-style-1">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" rows="5" placeholder="Alamat"><?= $pegawai['alamat'] ?></textarea>
            </div>
            <div class="input-style-1">
                <label>No. Handphone</label>
                <input type="text" class="form-control" name="no_handphone" placeholder="No. handphone" value="<?= $pegawai['no_handphone'] ?>" />
            </div>

            <div class="input-style-1">
                <label>Sistem Kerja</label>
                <select class="form-control" name="lokasi_presensi">
                    <?php foreach ($lokasi_presensi as $lp): ?>
                        <option value="<?= $lp['id']; ?>" <?= ($lp['id'] == $pegawai['lokasi_presensi']) ? 'selected' : ''; ?>>
                            <?= $lp['nama_lokasi']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-style-1">
                <label>Foto</label>
                <input type="hidden" value="<?= $pegawai['foto'] ?>" name="foto_digunakan">
                <input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" name="foto" accept=".jpg .jpeg .png" />
                <div id="fileHelp" class="form-text">Max 20MB.</div>
                <div class="invalid-feedback"><?= $validation->getError('foto') ?></div>
            </div>
            <div class="input-style-1">
                <label>Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" value="<?= $pegawai['username'] ?>" />
            </div>

            <div class="input-style-1">
                <label>Password</label>
                <input type="hidden" value="<?= $pegawai['password'] ?>" name="password_digunakan">
                <input type="password" class="form-control" name="password" placeholder="Password" />
                <div id="emailHelp" class="form-text"><span class="text-danger">*</span> Kosongi jika tidak ingin diubah.</div>
            </div>
            <div class="input-style-1">
                <label>Konfirmasi Password</label>
                <input type="hidden" value="<?= $pegawai['password'] ?>" name="konfirmasi_password_digunakan">
                <input type="password" class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>" name="konfirmasi_password" placeholder="Konfirmasi Password" />
                <div class="invalid-feedback"><?= $validation->getError('konfirmasi_password') ?></div>
            </div>

            <button type="submit" class="btn btn-primary">Konfirmasi</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>