<?= $this->extend('pegawai/layout.php') ?>
<?= $this->section('content') ?>

<style>
  /* Divider for desktop (vertical) */
  .divider {
    width: 1px;
    height: 100px;
    background-color: #ddd;
  }

  /* Divider for mobile (horizontal) */
  @media (max-width: 768px) {
    .divider {
      width: 100%;
      height: 1px;
    }
  }
</style>

<div class="row justify-content-center">
  <div class="col-md-4 mb-3">
    <div class="card h-100">
      <div class="card-header">Presensi Masuk</div>
      <div class="card-body text-center">
        <div class="fw-bold"><?= date(('d F Y')) ?></div>
        <div class="parent-clock fs-2 fw-bold">
          <?php if ($cek_presensi > 0) : ?>
            <div id="emailHelp" class="form-text fs-5 mb-2">Anda sudah melakukan presensi masuk.</div>
          <?php else : ?>
            <div id="jam-masuk"></div>
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
          <!-- <button type="submit" class="<?= $cek_presensi > 0 ? "btn btn-secondary" : "btn btn-primary"; ?> mt-2" <?= $cek_presensi > 0 ? "disabled" : ""; ?>>Masuk</button> -->
          <?php if ($cek_presensi > 0) : ?>
          <?php else : ?>
            <button type="submit" class="btn btn-primary mt-2">Masuk</button>
          <?php endif ?>
        </form>
      </div>
    </div>
  </div>

  <?php
  if (is_array($get_presensi) || is_object($get_presensi)) {
    $presensi_id = $get_presensi['id'] ?? 0;
  } else {
    $presensi_id = 0;
  }
  ?>

  <div class="col-md-4 mb-3">
    <div class="card h-100">
      <div class="card-header">Presensi Keluar</div>
      <div class="card-body text-center">
        <div class="fw-bold"><?= date(('d F Y')) ?></div>
        <div class="parent-clock fs-2 fw-bold">
          <!-- <div id="jam-keluar"></div> -->

          <?php if ($get_presensi['foto_keluar'] ?? '' == '' && $presensi_id == '') : ?>
            <div id="emailHelp" class="form-text fs-5 mb-2">Anda sudah melakukan presensi keluar.</div>
          <?php else : ?>
            <div id="jam-keluar"></div>
          <?php endif ?>
        </div>
        <form method="post" action="<?= base_url('presensi_keluar/') . $presensi_id ?>">
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
          <input type="hidden" name="latitude_pegawai" id="latitude_pegawai_keluar">
          <input type="hidden" name="longitude_pegawai" id="longitude_pegawai_keluar">
          <input type="hidden" name="tanggal_keluar" value="<?= date('Y-m-d') ?>">
          <input type="hidden" name="jam_keluar" value="<?= date('H:i:s') ?>">

          <!-- <button type="submit" class="<?= $presensi_id = '' ? 'btn btn-secondary' : 'btn btn-danger' ?> mt-2" <?= $presensi_id == '' ? 'disabled' : ''; ?>>Keluar</button> -->

          <?php if ($get_presensi['foto_keluar'] ?? '' == '' && $presensi_id == '') : ?>
            <button style="display: none;" type="submit">Keluar</button>
          <?php else : ?>
            <button type="submit" class="btn btn-danger mt-2" <?= $cek_presensi == 0 ? 'disabled' : '' ?>>Keluar</button>
          <?php endif ?>
        </form>
      </div>
    </div>
  </div>

  <!-- Message section -->
  <div class="mt-4">
      <p class="text-center" id="message" style="color: red;"></p>
    </div>

  <div class="container my-5">
    <div class="card shadow-sm p-4 mx-auto" style="max-width: 700px;">
      <div class="row">
        <!-- Lokasi Presensi Section (Left) -->
        <div class="col-12 col-md-5 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">Pilih Lokasi Presensi</h5>
            <form method="get" action="<?= base_url('home') ?>" id="lokpresForm">
              <?= csrf_field(); ?>
              <div class="mb-3">
                <select name="lokpres" class="form-select form-select" onchange="this.form.submit()">
                  <option selected disabled>Pilih Lokasi Presensi</option>
                  <?php foreach ($lokprez as $lp): ?>
                    <option value="<?= $lp['id']; ?>" <?= ($lp['id'] == $lokpret) ? 'selected' : ''; ?>>
                      <?= $lp['nama_lokasi']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </form>
          </div>
        </div>

        <!-- Divider -->
        <div class="col-12 col-md-2 my-3 d-flex justify-content-center align-items-center">
          <!-- Vertical for Desktop, Horizontal for Mobile -->
          <div class="divider"></div>
        </div>

        <!-- Ajukan Izin Section (Right) -->
        <div class="col-12 col-md-5 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">Ajukan Izin</h5>
            <a class="btn btn-outline-primary" href="<?= base_url('ketidakhadiran/create') ?>">
              <i class="bi bi-plus-circle me-2"></i> Ajukan
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Message section -->
  <div class="mt-4">
    <p class="text-center" id="message" style="color: red;"></p>
  </div>
</div>


<script>
  console.log(<?= $lokpret ?>)
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
    document.getElementById('latitude_pegawai').value = position.coords.latitude;
    document.getElementById('longitude_pegawai').value = position.coords.longitude;

    document.getElementById('latitude_pegawai_keluar').value = position.coords.latitude;
    document.getElementById('longitude_pegawai_keluar').value = position.coords.longitude;
    console.log('Coordinates: Latitude ' + position.coords.latitude + ', Longitude ' + position.coords.longitude);
  }

  // Update both clocks every second if they exist
  window.setInterval(() => {
    updateTime('jam-masuk');
    updateTime('jam-keluar');
  }, 100);

  // Get coordinates of the pegawai
  getLocation();
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const latitudeMasukField = document.getElementById("latitude_pegawai");
    const longitudeMasukField = document.getElementById("longitude_pegawai");
    const latitudeKeluarField = document.getElementById("latitude_pegawai_keluar");
    const longitudeKeluarField = document.getElementById("longitude_pegawai_keluar");
    const submitButton = document.querySelector("button[type='submit']");
    const messageElement = document.getElementById("message");

    function toggleButtonState() {
      if (latitudeMasukField.value && longitudeMasukField.value && latitudeKeluarField.value && longitudeKeluarField.value) {
        submitButton.disabled = false;
        messageElement.textContent = "";
      } else {
        submitButton.disabled = true;
        messageElement.textContent = "Mohon izinkan akses lokasi dan refresh halaman anda untuk melakukan presensi.";
      }
    }

    // Check fields every second
    setInterval(toggleButtonState, 1000);

    // Initial check
    toggleButtonState();
  });
</script>


<?= $this->endSection() ?>