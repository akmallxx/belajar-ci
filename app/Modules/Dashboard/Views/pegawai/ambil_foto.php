<?= $this->extend('pegawai/layout.php'); ?>

<?= $this->section('content'); ?>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>

<input type="hidden" id="id_pegawai" value="<?= $id_pegawai ?>">
<input type="hidden" id="tanggal_masuk" value="<?= $tanggal_masuk ?>">
<input type="hidden" id="jam_masuk" value="<?= $jam_masuk ?>">
<input type="hidden" id="lokasi_presensi" value="<?= $lokasi_presensi ?>">

<div class="card col-4 align-items-center">
    <div class="card-body">
        <div class="position-relative">
            <div id="my_camera"></div>
            <div id="overlay" class="position-absolute"></div>
            <div style="display: none;" id="my_result"></div>
        </div>
        <div class="input-style-1 mt-3">
            <label>Catatan</label>
            <textarea name="catatan_masuk" id="catatan_masuk" placeholder="Tulis catatan"></textarea>
        </div>
        <button class="btn btn-primary mt-2" id="ambil-foto">Absensi Masuk</button>
    </div>
</div>

<style>
    /* CSS untuk tampilan mobile */
    @media (max-width: 767px) {
        .card {
            width: 100%;
            padding: 20px;
            margin: 0 auto;
            box-shadow: none;
            /* Menghilangkan shadow agar lebih simpel */
        }

        #my_camera {
            width: 100% !important;
            height: auto !important;
        }

        .input-style-1 {
            width: 100%;
            margin-bottom: 15px;
        }

        #catatan_masuk {
            width: 100%;
        }

        #ambil-foto {
            width: 100%;
        }
    }

    /* CSS untuk overlay oval */
    #overlay {
        top: 50%;
        left: 50%;
        width: 160px;
        height: 200px;
        border: 2px solid white;
        /* Warna border putih */
        border-radius: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        /* Agar overlay tidak mengganggu interaksi kamera */
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.3);
        /* Opsi background semi-transparan */
    }
</style>

<script>
    Webcam.set({
        width: 320,
        height: 240,
        dest_width: 320,
        dest_height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90,
        force_flash: false
    });
    Webcam.attach('#my_camera');

    document.getElementById('ambil-foto').addEventListener('click', function() {
        // Disable button setelah diklik
        this.disabled = true;
        this.textContent = "Sedang Diproses..."; // Optional: Ubah teks tombol untuk indikasi
        // Lakukan tindakan lain yang diinginkan di sini

        let id = document.getElementById('id_pegawai').value;
        let tanggal_masuk = document.getElementById('tanggal_masuk').value;
        let jam_masuk = document.getElementById('jam_masuk').value;
        let catatan_masuk = document.getElementById('catatan_masuk').value;
        let lokasi_presensi = document.getElementById('lokasi_presensi').value;

        Webcam.snap(function(data_uri) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"/>'
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    window.location.href = "<?= base_url('home') ?>"
                }
            };
            xhttp.open("POST", "<?= base_url('presensi_masuk_aksi') ?>", true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send(
                'foto_masuk=' + encodeURIComponent(data_uri) +
                '&id_pegawai=' + id +
                '&tanggal_masuk=' + tanggal_masuk +
                '&jam_masuk=' + jam_masuk +
                '&catatan_masuk=' + catatan_masuk +
                '&lokasi_presensi=' +lokasi_presensi
            );
            
            console.log(lokasi_presensi);
        });
    });
</script>

<?= $this->endSection(); ?>