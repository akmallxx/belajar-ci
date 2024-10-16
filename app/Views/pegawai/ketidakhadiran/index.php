<?= $this->extend('pegawai/layout') ?>
<?= $this->section('content') ?>

<style>
    @media (max-width: 768px) {

        .status-center-mobile {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            /* Menjamin teks berada di tengah */
        }
    }
</style>

<a href="<?= base_url('ketidakhadiran/create') ?>" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Ajukan Izin</a>


<form method="get" action="<?= base_url('ketidakhadiran') ?>" class="mb-3">
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

<?php foreach ($ketidakhadiran as $kh) : ?>
    <div class="row my-2 mx-1 border" style="border-radius: 10px;">
        <div class="col-2 text-center pt-10 pb-15 d-flex flex-column status-center-mobile" style="border-left:10px solid <?= $kh['status_pengajuan'] == 'disetujui' ? 'green' : ($kh['status_pengajuan'] == 'ditolak' ? 'red' : 'orange') ?>; border-radius: 10px;">
            <p style="font-size:small"><?= strtoupper(substr(date('F', strtotime($kh['tanggal_awal'])), 0, 3)) ?><br><b><?= date('d', strtotime($kh['tanggal_awal'])) ?></b></p>
        </div>
        <div class="col-7 pt-4 pb-0">
            <?php $text = $kh['deskripsi'] ?>
            <p><b>(<?= htmlspecialchars($kh['keterangan']) ?>)</b> <?= htmlspecialchars((strlen($text) > 15) ? substr($text, 0, 15) . '...' : $text) ?></p>
        </div>
        <div class="col-2 pt-2">
            <p style="font-size: small; color: <?= $kh['status_pengajuan'] == 'disetujui' ? 'green' : ($kh['status_pengajuan'] == 'ditolak' ? 'red' : 'orange') ?>;"><?= htmlspecialchars($kh['status_pengajuan']) ?></p>
            <p style="font-size: currently;">
                <a href="<?= base_url('ketidakhadiran/detail/' . $kh['id']) ?>" class="badge bg-secondary">Detail</a>
            </p>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection() ?>