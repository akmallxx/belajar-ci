<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/data_pegawai/save/' . ($pegawai['id'] ?? '')) ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="foto_digunakan" value="<?= $pegawai['foto'] ?? '' ?>">
            <input type="hidden" name="password_digunakan" value="<?= $pegawai['password'] ?? '' ?>">
            
            <div class="input-style-1">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Nama Pegawai" value="<?= htmlspecialchars($pegawai['nama'] ?? '') ?>" required />
            </div>
            
            <div class="input-style-1">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <?php $jk = $pegawai['jenis_kelamin'] ?? ''; ?>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" <?= $jk == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $jk == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="input-style-1">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" placeholder="Alamat" required><?= htmlspecialchars($pegawai['alamat'] ?? '') ?></textarea>
            </div>

            <div class="input-style-1">
                <label>No. Handphone</label>
                <input type="text" class="form-control" name="no_handphone" placeholder="No Handphone" value="<?= htmlspecialchars($pegawai['no_handphone'] ?? '') ?>" required />
            </div>

            <div class="input-style-1">
                <label>Jabatan</label>
                <select name="jabatan" class="form-control" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php $jbtSelected = $pegawai['jabatan'] ?? ''; ?>
                    <?php foreach ($jabatan as $jbt): ?>
                        <option value="<?= $jbt['jabatan'] ?>" <?= $jbtSelected == $jbt['jabatan'] ? 'selected' : '' ?>><?= $jbt['jabatan'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-style-1">
                <label>Lokasi Presensi</label>
                <select name="lokasi_presensi" class="form-control" required>
                    <option value="">-- Pilih Lokasi Presensi --</option>
                    <?php $lokSelected = $pegawai['lokasi_presensi'] ?? ''; ?>
                    <?php foreach ($lokasi_presensi as $lok): ?>
                        <option value="<?= $lok['id'] ?>" <?= $lokSelected == $lok['id'] ? 'selected' : '' ?>><?= $lok['nama_lokasi'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-style-1">
                <label>Username</label>
                <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" name="username" placeholder="Username" value="<?= htmlspecialchars($pegawai['username'] ?? '') ?>" required />
                <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
            </div>

            <div class="input-style-1">
                <label>Password <?= !empty($pegawai) ? '(Kosongkan jika tidak diubah)' : '' ?></label>
                <input type="password" class="form-control" name="password" placeholder="Password" <?= empty($pegawai) ? 'required' : '' ?> />
            </div>

            <div class="input-style-1">
                <label>Konfirmasi Password</label>
                <input type="password" class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>" name="konfirmasi_password" placeholder="Konfirmasi Password" <?= empty($pegawai) ? 'required' : '' ?> />
                <div class="invalid-feedback"><?= $validation->getError('konfirmasi_password') ?></div>
            </div>

            <div class="input-style-1">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <?php $role = $pegawai['role'] ?? ''; ?>
                    <option value="">-- Pilih Role --</option>
                    <option value="Admin" <?= $role == 'Admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="Pegawai" <?= $role == 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
                </select>
            </div>

            <div class="input-style-1">
                <label>Foto <?= !empty($pegawai['foto']) ? '(' . $pegawai['foto'] . ')' : '' ?></label>
                <input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" name="foto" />
                <div class="invalid-feedback"><?= $validation->getError('foto') ?></div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="<?= base_url('admin/data_pegawai') ?>" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
