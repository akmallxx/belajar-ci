<?= $this->extend('pegawai/layout.php'); ?>
<?= $this->section('content'); ?>
<?php
$session = session();
$pegawai = $session->get('pegawai');
$lokasi_presensi = $session->get('lokasi');                                                                            
?>


<style>
    .foto {
        width: 150px;
        height: 150px;
        border-radius: 10px;
    }   
</style>

<div class="card col-md-6">
    <div class="card-body">
        <img class="card-img-top foto" src="<?= base_url($pegawai['foto'] ? 'profile/' . $pegawai['foto'] : 'profile/nopp.png') ?>" alt="">
        <table class="table">
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?= $pegawai['nip'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $pegawai['nama'] ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><?= $pegawai['username'] ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= $pegawai['jenis_kelamin'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $pegawai['alamat'] ?></td>
            </tr>
            <tr>
                <td>No Handphone</td>
                <td>:</td>
                <td><?= $pegawai['no_handphone'] ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $pegawai['jabatan'] ?></td>
            </tr>
            <tr>
                <td>Lokasi Presensi</td>
                <td>:</td>
                <?php
                $jamMasuk = date('H:i', strtotime($lokasi_presensi['jam_masuk']));
                $jamPulang = date('H:i', strtotime($lokasi_presensi['jam_pulang']));
                ?>
                <td><?= $lokasi_presensi['nama_lokasi'] . ' (' . $jamMasuk . '-' . $jamPulang . ' ' . $lokasi_presensi['zona_waktu'] . ' ) ' ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><?= $pegawai['status'] ?></td>
            </tr>
            <tr>
                <td>Role</td>
                <td>:</td>
                <td><?= $pegawai['role'] ?></td>
            </tr>
        </table>
        <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary w-100 mt-20">Edit Profile</a>
    </div>
</div>

<?= $this->endSection(); ?>