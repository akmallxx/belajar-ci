<?= $this->extend('pegawai/layout.php'); ?>
<?= $this->section('content'); ?>

<style>
    @media (max-width: 768px) {
        .table td,
        .table th {
            white-space: nowrap;
            /* Mencegah teks melintasi baris */
        }

        .status-center-mobile {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            /* Menjamin teks berada di tengah */
        }
    }
</style>

<form method="get" action="<?= base_url('rekap_presensi') ?>" class="mb-3">
    <?= csrf_field(); ?>
    <div class="row gx-2">
        <div class="col-6 col-md-3 mb-2">
            <select name="bulan" class="form-select" onchange="this.form.submit()">
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>" min="2000" max="<?= date('Y') ?>" onchange="this.form.submit()">
        </div>
    </div>
</form>

<?php foreach ($rekap_presensi as $rp) : ?>
    <div class="row my-2 mx-1 border" style="border-radius: 10px;">
        <div class="col-3 text-center pt-10 pb-15 d-flex flex-column status-center-mobile" style="border-left:10px solid <?= $rp['status'] == 'Tepat Waktu' ? 'green' : 'orange' ?>; border-radius: 10px;">
            <p class="mt-2 mt-md-0" style="font-size: 14px;"><?= htmlspecialchars($rp['hari']) ?><br><b><?= date('d', strtotime($rp['tanggal_masuk'])) ?></b></p>
        </div>
        <div class="col-5 d-flex pt-4 pb-0 text-center">
            <p style="font-size: 14px;"><?= htmlspecialchars(substr($rp['jam_masuk'], 0, 5) . '  -  ' . (substr($rp['jam_keluar'], 0, 5) == '00:00' ? '--:--' : substr($rp['jam_keluar'], 0, 5))) ?></p>
        </div>
        <div class="col-4 <?= $rp['status'] == 'Tepat Waktu' ? 'pt-4 pb-0' : 'pt-3 pb-0' ?>">
            <p style="font-size: 14px; color: <?= $rp['status'] == 'Tepat Waktu' ? 'green' : 'orange' ?>;"><?= htmlspecialchars($rp['status']) ?></p>
            <p style="font-size: 12px;"><?= htmlspecialchars($rp['keterlambatan']) ?></p>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>