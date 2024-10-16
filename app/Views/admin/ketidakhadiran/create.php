<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/ketidakhadiran/store') ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <!-- Dropdown untuk memilih Pegawai -->
            <div class="input-style-1">
                <label>Pegawai</label>
                <select class="form-control" name="id_pegawai" required>
                    <option value="">--- Pilih Pegawai ---</option>
                    <?php foreach ($pegawaiList as $pegawai): ?>
                        <option value="<?= $pegawai['id']; ?>"><?= $pegawai['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-style-1">
                <label>Keterangan</label>
                <select class="form-control" name="keterangan" required>
                    <option value="">--- Pilih ---</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Cuti">Cuti</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-style-1">
                        <label>Dari</label>
                        <input type="date" class="form-control" name="tanggal_awal" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-style-1">
                        <label>Sampai</label>
                        <input type="date" class="form-control" name="tanggal_akhir" required />
                    </div>
                </div>
            </div>

            <div class="input-style-1">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="5" placeholder="Deskripsi" required></textarea>
            </div>

            <div class="input-style-1">
                <label>File</label>
                <input type="file" class="form-control" name="file" />
            </div>

            <div class="input-style-1">
                <label>Status Pengajuan</label>
                <select class="form-control" name="status_pengajuan" required>
                    <option value="">--- Pilih ---</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>