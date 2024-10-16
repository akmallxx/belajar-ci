<?= $this->extend('pegawai/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-6">
    <div class="card-body">
        <form method="post" action="<?= base_url('ketidakhadiran/store') ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" class="form-control" name="id_pegawai" placeholder="ID Pegawai" value="<?= session()->get('id_pegawai') ?>" />

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
                <div class="col-6">
                    <div class="input-style-1">
                        <label>Dari</label>
                        <input type="date" class="form-control" name="tanggal_awal" required />
                    </div>
                </div>
                <div class="col-6">
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
                <input type="file" name="files" id="files" class="form-control">
            </div>
            <div class="input-style-1" hidden>
                <label>Status Pengajuan</label>
                <input type="text" name="status_pengajuan" id="" value="menunggu">
            </div>

            <button type="submit" class="btn btn-primary">Ajukan</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>