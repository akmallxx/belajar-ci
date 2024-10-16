<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon purple">
                <i class="bi bi-people"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Total Pegawai</h6>
                  <h3 class="text-bold mb-10"><?= $total_pegawai ?></h3>
                  <p class="text-sm text-success">
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon success">
                <i class="bi bi-check-circle"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Hadir</h6>
                  <h3 class="text-bold mb-10"><?= $total_presensi ?></h3>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon orange">
                <i class="bi bi-x-circle"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Terlambat Bulan Ini</h6>
                  <h3 class="text-bold mb-10"> <?= $total_alpha ?> </h3>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="icon-card mb-30">
                <div class="icon primary">
                  <i class="lni lni-user"></i>
                </div>
                <div class="content">
                  <h6 class="mb-10">Izin Bulan Ini</h6>
                  <h3 class="text-bold mb-10"> <?= $ketidakhadiran ?> </h3>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            <!-- End Col -->
          </div>

<?= $this->endSection() ?>