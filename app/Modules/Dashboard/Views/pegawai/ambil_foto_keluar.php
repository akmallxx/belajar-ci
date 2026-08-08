<?= $this->extend('pegawai/layout.php'); ?>

<?= $this->section('content'); ?>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>

<input type="hidden" id="tanggal_keluar" value="<?= $tanggal_keluar ?>">
<input type="hidden" id="jam_keluar" value="<?= $jam_keluar ?>">

<div class="card col-4 align-items-center">
    <div class="card-body">
        <div class="position-relative">
            <div id="my_camera"></div>
            <div id="overlay" class="position-absolute"></div>
            <div style="display: none;" id="my_result"></div>
        </div>
        <div class="input-style-1 mt-3">
            <label>Catatan</label>
            <textarea name="catatan_keluar" id="catatan_keluar" placeholder="Tulis catatan"></textarea>
        </div>
        <button class="btn btn-danger mt-2" id="ambil-foto-keluar">Absensi Pulang</button>
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

        #catatan_keluar {
            width: 100%;
        }

        #ambil-foto-keluar {
            width: 100%;
        }
    }

    /* CSS untuk overlay oval */
    #overlay {
        top: 50%;
        left: 50%;
        width: 170px;
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

    document.getElementById('ambil-foto-keluar').addEventListener('click', function() {
        let tanggal_keluar = document.getElementById('tanggal_keluar').value;
        let jam_keluar = document.getElementById('jam_keluar').value;
        let catatan_keluar = document.getElementById('catatan_keluar').value;

        Webcam.snap(function(data_uri) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                document.getElementById('my_result').innerHTML = '<img src="' + data_uri + '"/>'
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    window.location.href = "<?= base_url('home') ?>"
                }
            };
            xhttp.open("POST", "<?= base_url('presensi_keluar_aksi/' . $id_presensi) ?>", true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send(
                'foto_keluar=' + encodeURIComponent(data_uri) +
                '&tanggal_keluar=' + tanggal_keluar +
                '&jam_keluar=' + jam_keluar +
                '&catatan_keluar=' + catatan_keluar
            );
            console.log(encodeURIComponent(data_uri));
        });
    });
</script>

<?= $this->endSection(); ?>