<?= $this->extend('admin/layout.php'); ?>
<?= $this->section('content'); ?>

<style>
    .foto {
        width: 240px;
        height: 320px;
        border-radius: 5px;
    }
</style>

<div class="card col-md-6">
    <div class="card-body">
        <table class="table">
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['nip']) ?></td>
            </tr>
            <tr>
                <td>Nama Pegawai</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['nama']) ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['tanggal_masuk']) ?></td>
            </tr>
            <tr>
                <td>Hari</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['hari']) ?></td>
            </tr>
            <tr>
                <td>Jam Masuk</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['jam_masuk']) ?></td>
            </tr>
            <tr>
                <td>Jam Keluar</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['jam_keluar']) ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['status']) ?></td>
            </tr>
            <tr>
                <td>Keterlambatan</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['keterlambatan']) ?></td>
            </tr>
            <tr>
                <td>Catatan Masuk</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['catatan_masuk']) ?></td>
            </tr>
            <tr>
                <td>Foto Masuk</td>
                <td>:</td>
                <td>
                    <?php if ($rekap_harian['foto_masuk']) : ?>
                        <img src="<?= base_url('uploads/' . htmlspecialchars($rekap_harian['foto_masuk'])) ?>" alt="Foto Masuk" class="img-thumbnail foto">
                    <?php else : ?>
                        Tidak Ada Foto
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Catatan Keluar</td>
                <td>:</td>
                <td><?= htmlspecialchars($rekap_harian['catatan_keluar']) ?></td>
            </tr>
            <tr>
                <td>Foto Keluar</td>
                <td>:</td>
                <td>
                    <?php if ($rekap_harian['foto_keluar']) : ?>
                        <img src="<?= base_url('uploads/' . htmlspecialchars($rekap_harian['foto_keluar'])) ?>" alt="Foto Keluar" class="img-thumbnail foto">
                    <?php else : ?>
                        Tidak Ada Foto
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>


<?= $this->endSection(); ?>