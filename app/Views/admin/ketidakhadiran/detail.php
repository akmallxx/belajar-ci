<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<div class="card col-md-8">
    <div class="card-body">
        <table class="table">
            <tr>
                <td>Nama Pegawai</td>
                <td>:</td>
                <td><?= htmlspecialchars($ketidakhadiran['nama_pegawai']) ?></td>
            </tr>

            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?= htmlspecialchars($ketidakhadiran['keterangan']) ?></td>
            </tr>

            <tr>
                <td>Dari</td>
                <td>:</td>
                <td><?= $ketidakhadiran['tanggal_awal'] ?></td>
            </tr>
            <tr>
                <td>Sampai</td>
                <td>:</td>
                <td><?= $ketidakhadiran['tanggal_akhir'] ?></td>
            </tr>

            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td><?= htmlspecialchars($ketidakhadiran['deskripsi']) ?></td>
            </tr>

            <tr>
                <td>File</td>
                <td>:</td>
                <td>
                    <?php if (!empty($ketidakhadiran['file'])): ?>
                        <a href="<?= base_url('uploads/ketidakhadiran/' . $ketidakhadiran['file']) ?>" target="_blank">Lihat File</a>
                    <?php else: ?>
                        Tidak ada file
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <td>Status Pengajuan</td>
                <td>:</td>
                <td><?= htmlspecialchars($ketidakhadiran['status_pengajuan']) ?></td>
            </tr>
        </table>
    </div>
</div>


<?= $this->endSection(); ?>