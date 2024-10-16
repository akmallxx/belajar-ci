<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form  method="post" action="<?= base_url('admin/data_pegawai/store') ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <!-- CSRF FORM -->
            <?= csrf_field() ?>

            <div class="input-style-1">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama" required />
            </div>
            <div class="input-style-1">
                <label>Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin" required>
                    <option value="">--- Pilih ---</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="input-style-1">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" rows="5" placeholder="Alamat" required></textarea>
            </div>
            <div class="input-style-1">
                <label>No. Handphone</label>
                <input type="text" class="form-control" name="no_handphone" placeholder="No. handphone" required />
            </div>

            <div class="input-style-1">
                <label>Jabatan</label>
                <select class="form-control" name="jabatan" required>
                <option value="">--- Pilih ---</option>
                    <?php foreach ($jabatan as $jab) : ?>
                        <option value="<?= $jab['jabatan'] ?>"><?= $jab['jabatan'] ?></option>"
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input-style-1">
                <label>Lokasi Presensi</label>
                <select class="form-control" name="lokasi_presensi" required>
                <option value="">--- Pilih ---</option>
                    <?php foreach ($lokasi_presensi as $lp) : ?>
                        <option value="<?=$lp['id'] ?>"><?=$lp['nama_lokasi'] ?></option>"
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input-style-1">
                <label>Foto</label>
                <input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" name="foto" accept=".jpg .jpeg .png" />
                <div id="fileHelp" class="form-text">Max 20MB.</div>
                <div class="invalid-feedback"><?= $validation->getError('foto') ?></div>
            </div>
            <div class="input-style-1">
                <label>Username</label>
                <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" name="username" placeholder="Username" required />
                <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
            </div>
            <div class="input-style-1">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required />
            </div>
            <div class="input-style-1">
                <label>Konfirmasi Password</label>
                <input type="password" class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>" name="konfirmasi_password" placeholder="Konfirmasi Password" required />
                <div class="invalid-feedback"><?= $validation->getError('konfirmasi_password') ?></div>
            </div>
            <div class="input-style-1">
                <label>Role</label>
                <select class="form-control" name="role" required>
                    <option value="">--- Pilih ---</option>
                    <option value="Admin">Admin</option>
                    <option value="Pegawai">Pegawai</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>


<?= $this->endSection(); ?>