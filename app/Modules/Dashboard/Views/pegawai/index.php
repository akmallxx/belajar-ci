<?= $this->extend('pegawai/layout.php') ?>
<?= $this->section('content') ?>

<div class="row g-4 justify-content-center">
  <!-- Presensi Masuk Card -->
  <div class="col-md-6 col-lg-5">
    <div class="card h-100 p-4 border-0 shadow-sm rounded-4 text-center">
      <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
        <i class="bi bi-box-arrow-in-right text-primary fs-4"></i>
        <h5 class="fw-bold mb-0">Presensi Masuk</h5>
      </div>
      <p class="text-muted text-sm mb-3"><i class="bi bi-calendar3 me-1"></i> <?= date('d F Y') ?></p>
      
      <div class="py-3 my-2 rounded-3 bg-light border">
        <?php if ($cek_presensi > 0) : ?>
          <div class="text-success fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> Anda sudah melakukan presensi masuk.</div>
        <?php else : ?>
          <div id="jam-masuk" class="display-6 fw-bold text-primary" style="font-family: 'Outfit', sans-serif;"></div>
        <?php endif ?>
      </div>

      <form method="post" action="<?= base_url('presensi_masuk') ?>">
        <?= csrf_field(); ?>
        <?php
        if ($lokasi_presensi['zona_waktu'] == 'WIB') {
          date_default_timezone_set('Asia/Jakarta');
        } else if ($lokasi_presensi['zona_waktu'] == 'WITA') {
          date_default_timezone_set('Asia/Pontianak');
        } else if ($lokasi_presensi['zona_waktu'] == 'WIT') {
          date_default_timezone_set('Asia/Jayapura');
        }
        ?>

        <input type="hidden" name="latitude_kantor" value="<?= $lokasi_presensi['latitude'] ?>">
        <input type="hidden" name="longitude_kantor" value="<?= $lokasi_presensi['longitude'] ?>">
        <input type="hidden" name="radius" value="<?= $lokasi_presensi['radius'] ?>">
        <input type="hidden" name="lokasi_presensi" value="<?= $lokpret ?>">
        <input type="hidden" name="latitude_pegawai" id="latitude_pegawai">
        <input type="hidden" name="longitude_pegawai" id="longitude_pegawai">
        <input type="hidden" name="tanggal_masuk" value="<?= date('Y-m-d') ?>">
        <input type="hidden" name="jam_masuk" value="<?= date('H:i:s') ?>">
        <input type="hidden" name="id_pegawai" value="<?= session()->get('id_pegawai') ?>">

        <?php if ($cek_presensi == 0) : ?>
          <button type="submit" class="btn btn-primary w-100 py-3 mt-3 shadow-sm">
            <i class="bi bi-camera me-2"></i> Presensi Masuk Sekarang
          </button>
        <?php endif ?>
      </form>
    </div>
  </div>

  <?php
  if (is_array($get_presensi) || is_object($get_presensi)) {
    $presensi_id = $get_presensi['id'] ?? 0;
  } else {
    $presensi_id = 0;
  }
  ?>

  <!-- Presensi Keluar Card -->
  <div class="col-md-6 col-lg-5">
    <div class="card h-100 p-4 border-0 shadow-sm rounded-4 text-center">
      <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
        <i class="bi bi-box-arrow-left text-danger fs-4"></i>
        <h5 class="fw-bold mb-0">Presensi Keluar</h5>
      </div>
      <p class="text-muted text-sm mb-3"><i class="bi bi-calendar3 me-1"></i> <?= date('d F Y') ?></p>

      <div class="py-3 my-2 rounded-3 bg-light border">
        <?php if ($get_presensi['foto_keluar'] ?? '' == '' && $presensi_id == '') : ?>
          <div class="text-muted fw-semibold">Anda belum presensi masuk / sudah keluar.</div>
        <?php else : ?>
          <div id="jam-keluar" class="display-6 fw-bold text-danger" style="font-family: 'Outfit', sans-serif;"></div>
        <?php endif ?>
      </div>

      <form method="post" action="<?= base_url('presensi_keluar/') . $presensi_id ?>">
        <?= csrf_field(); ?>
        <input type="hidden" name="latitude_kantor" value="<?= $lokasi_presensi['latitude'] ?>">
        <input type="hidden" name="longitude_kantor" value="<?= $lokasi_presensi['longitude'] ?>">
        <input type="hidden" name="radius" value="<?= $lokasi_presensi['radius'] ?>">
        <input type="hidden" name="latitude_pegawai" id="latitude_pegawai_keluar">
        <input type="hidden" name="longitude_pegawai" id="longitude_pegawai_keluar">
        <input type="hidden" name="tanggal_keluar" value="<?= date('Y-m-d') ?>">
        <input type="hidden" name="jam_keluar" value="<?= date('H:i:s') ?>">

        <?php if (!($get_presensi['foto_keluar'] ?? '' == '' && $presensi_id == '')) : ?>
          <button type="submit" class="btn btn-danger w-100 py-3 mt-3 shadow-sm" <?= $cek_presensi == 0 ? 'disabled' : '' ?>>
            <i class="bi bi-camera me-2"></i> Presensi Keluar Sekarang
          </button>
        <?php endif ?>
      </form>
    </div>
  </div>
</div>

<!-- Controls & Actions Row -->
<div class="row g-4 justify-content-center mt-3">
  <div class="col-md-10">
    <div class="card p-4 border-0 shadow-sm rounded-4">
      <div class="row align-items-center">
        <div class="col-md-6 mb-3 mb-md-0">
          <label class="form-label fw-bold mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Pilih Lokasi Presensi</label>
          <form method="get" action="<?= base_url('home') ?>" id="lokpresForm">
            <?= csrf_field(); ?>
            <select name="lokpres" class="form-select shadow-none" onchange="this.form.submit()">
              <option selected disabled>-- Pilih Lokasi --</option>
              <?php foreach ($lokprez as $lp): ?>
                <option value="<?= $lp['id']; ?>" <?= ($lp['id'] == $lokpret) ? 'selected' : ''; ?>>
                  <?= $lp['nama_lokasi']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </form>
        </div>
        <div class="col-md-6 text-md-end">
          <label class="form-label fw-bold mb-2 d-block"><i class="bi bi-file-earmark-person text-primary me-2"></i>Berhalangan Hadir?</label>
          <a class="btn btn-outline-primary px-4 py-2 rounded-3" href="<?= base_url('ketidakhadiran/form') ?>">
            <i class="bi bi-plus-circle me-2"></i> Ajukan Izin / Cuti
          </a>
        </div>
      </div>
      <div class="text-center mt-3">
        <small id="message" class="text-danger fw-500"></small>
      </div>
    </div>
  </div>
</div>

<script>
  function updateTime(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
      const time = new Date();
      element.innerHTML = `${timeFormat(time.getHours())}:${timeFormat(time.getMinutes())}:${timeFormat(time.getSeconds())}`;
    }
  }

  function timeFormat(time) {
    return time < 10 ? "0" + time : time;
  }

  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      alert('Browser anda tidak mendukung Geolocation');
    }
  }

  function showPosition(position) {
    const latInp1 = document.getElementById('latitude_pegawai');
    const lonInp1 = document.getElementById('longitude_pegawai');
    const latInp2 = document.getElementById('latitude_pegawai_keluar');
    const lonInp2 = document.getElementById('longitude_pegawai_keluar');

    if (latInp1) latInp1.value = position.coords.latitude;
    if (lonInp1) lonInp1.value = position.coords.longitude;
    if (latInp2) latInp2.value = position.coords.latitude;
    if (lonInp2) lonInp2.value = position.coords.longitude;
  }

  window.setInterval(() => {
    updateTime('jam-masuk');
    updateTime('jam-keluar');
  }, 100);

  getLocation();

  document.addEventListener("DOMContentLoaded", function() {
    const latitudeMasukField = document.getElementById("latitude_pegawai");
    const longitudeMasukField = document.getElementById("longitude_pegawai");
    const submitButton = document.querySelector("button[type='submit']");
    const messageElement = document.getElementById("message");

    function toggleButtonState() {
      if (latitudeMasukField && latitudeMasukField.value && longitudeMasukField && longitudeMasukField.value) {
        if(submitButton) submitButton.disabled = false;
        if(messageElement) messageElement.textContent = "";
      } else {
        if(submitButton) submitButton.disabled = true;
        if(messageElement) messageElement.textContent = "Mohon izinkan akses lokasi untuk melakukan presensi.";
      }
    }

    setInterval(toggleButtonState, 1000);
    toggleButtonState();
  });
</script>

<?= $this->endSection() ?>