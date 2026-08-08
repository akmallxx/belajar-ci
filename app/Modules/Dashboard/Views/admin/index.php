<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="row g-4">
  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="card p-3 border-0 shadow-sm">
      <div class="d-flex align-items-center gap-3">
        <div class="p-3 rounded-4" style="background: rgba(99, 102, 241, 0.1); color: #4f46e5;">
          <i class="bi bi-people-fill fs-3"></i>
        </div>
        <div>
          <span class="text-muted text-sm fw-500">Total Pegawai</span>
          <h3 class="fw-bold text-dark mb-0"><?= $total_pegawai ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="card p-3 border-0 shadow-sm">
      <div class="d-flex align-items-center gap-3">
        <div class="p-3 rounded-4" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
          <i class="bi bi-check-circle-fill fs-3"></i>
        </div>
        <div>
          <span class="text-muted text-sm fw-500">Hadir Hari Ini</span>
          <h3 class="fw-bold text-dark mb-0"><?= $total_presensi ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="card p-3 border-0 shadow-sm">
      <div class="d-flex align-items-center gap-3">
        <div class="p-3 rounded-4" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
          <i class="bi bi-clock-history fs-3"></i>
        </div>
        <div>
          <span class="text-muted text-sm fw-500">Terlambat Bulan Ini</span>
          <h3 class="fw-bold text-dark mb-0"><?= $total_alpha ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="card p-3 border-0 shadow-sm">
      <div class="d-flex align-items-center gap-3">
        <div class="p-3 rounded-4" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
          <i class="bi bi-file-earmark-person-fill fs-3"></i>
        </div>
        <div>
          <span class="text-muted text-sm fw-500">Izin Bulan Ini</span>
          <h3 class="fw-bold text-dark mb-0"><?= $ketidakhadiran ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>