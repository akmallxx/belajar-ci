<?= $this->extend('pegawai/layout.php'); ?>
<?= $this->section('content'); ?>

<style>
    .foto {
        width: 150px;
        height: 150px;
        border-radius: 10px;
    }
</style>

<div class="card col-md-6">
    <div class="card-body">
        <table class="table">
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?= $ketidakhadiran['keterangan'] ?></td>
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
                <td><?= $ketidakhadiran['deskripsi'] ?></td>
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
                <td><?= $ketidakhadiran['status_pengajuan'] ?></td>
            </tr>
        </table>
        <?php if ($ketidakhadiran['status_pengajuan'] == 'menunggu') { ?>
            <a href="<?= base_url('ketidakhadiran/delete/' . $ketidakhadiran['id']) ?>" class="btn btn-outline-secondary w-100 mt-20">Batalkan Pengajuan</a>
        <?php } ?>
    </div>
</div>

<?= $this->endSection(); ?>