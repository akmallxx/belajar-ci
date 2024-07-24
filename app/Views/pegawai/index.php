<?= $this->extend('pegawai/layout.php') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
  <div class="col-md-4 mb-3">
    <div class="card h-100">
      <div class="card-header">Presensi Masuk</div>
      <div class="card-body text-center">
        <div class="fw-bold"><?= date(('d F Y')) ?></div>
        <div class="parent-clock fs-2 fw-bold">
          <?php if($cek_presensi > 0): ?>
              <div id="emailHelp" class="form-text fs-5 mb-2">Anda sudah melakukan presensi masuk.</div>
            <?php else: ?>
              <div id="jam-masuk"></div>
          <?php endif ?>
        </div>
        <form method="post" action="<?= base_url('pegawai/presensi_masuk') ?>">
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
          <input type="hidden" name="latitude_pegawai" id="latitude_pegawai">
          <input type="hidden" name="longitude_pegawai" id="longitude_pegawai">

          <input type="hidden" name="tanggal_masuk" value="<?= date('Y-m-d') ?>">
          <input type="hidden" name="jam_masuk" value="<?= date('h:i:s') ?>">
          <input type="hidden" name="id_pegawai" value="<?= session()->get('id_pegawai') ?>">
          <!-- <button type="submit" class="<?= $cek_presensi > 0 ? "btn btn-secondary" : "btn btn-primary"; ?> mt-2" <?= $cek_presensi > 0 ? "disabled" : ""; ?>>Masuk</button> -->
          <?php if($cek_presensi > 0): ?>
            <?php else: ?>
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

          <?php if($get_presensi['foto_keluar'] ?? '' == '' && $presensi_id == ''): ?>
              <div id="emailHelp" class="form-text fs-5 mb-2">Anda sudah melakukan presensi keluar.</div>
            <?php else: ?>
              <div id="jam-keluar"></div>
          <?php endif ?>
        </div>
        <form method="post" action="<?= base_url('pegawai/presensi_keluar/') . $presensi_id ?>">
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
          <input type="hidden" name="jam_keluar" value="<?= date('h:i:s') ?>">

          <!-- <button type="submit" class="<?= $presensi_id = '' ? 'btn btn-secondary' : 'btn btn-danger' ?> mt-2" <?= $presensi_id == '' ? 'disabled' : ''; ?>>Keluar</button> -->

          <?php if($get_presensi['foto_keluar'] ?? '' == '' && $presensi_id == ''): ?>
            <?php else: ?>
              <button type="submit" class="btn btn-danger mt-2" <?= $cek_presensi == 0 ? 'disabled' : '' ?>>Keluar</button>
          <?php endif ?>
        </form>
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


<?= $this->endSection() ?>