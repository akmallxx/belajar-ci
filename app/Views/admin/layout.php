<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo/loco.svg') ?>" type="image/x-icon" />
  <title><?= $title ?> | AbsensiKu</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- ========== All CSS files linkup ========= -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/lineicons.css') ?>" type="text/css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/materialdesignicons.min.css') ?>" type="text/css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/fullcalendar.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/custom-modern.css') ?>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- ========== Data Tables =========== -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
  <link rel="manifest" href="<?= base_url('manifest.json') ?>">
</head>

<body>
  <!-- ======== Preloader =========== -->
  <div id="preloader">
    <div class="spinner"></div>
  </div>
  <!-- ======== Preloader =========== -->

  <?php
    $uri = service('uri')->getPath();
    $isDashboard = (strpos($uri, 'admin/home') !== false || $uri == 'admin');
    $isPegawai = (strpos($uri, 'admin/data_pegawai') !== false);
    $isRekapHarian = (strpos($uri, 'admin/rekap_harian') !== false);
    $isRekapBulanan = (strpos($uri, 'admin/rekap_bulanan') !== false);
    $isRekap = (strpos($uri, 'admin/rekap') !== false);
    $isKetidakhadiran = (strpos($uri, 'admin/ketidakhadiran') !== false);
    $isJabatan = (strpos($uri, 'admin/jabatan') !== false);
    $isLokasi = (strpos($uri, 'admin/lokasi_presensi') !== false);
    $isMaster = ($isJabatan || $isLokasi);
    $isApi = (strpos($uri, 'admin/api') !== false);
  ?>

  <!-- ======== sidebar-nav start =========== -->
  <aside class="sidebar-nav-wrapper">
    <div class="navbar-logo d-flex align-items-center justify-content-between">
      <a href="<?= $isDashboard ? 'javascript:void(0)' : base_url('admin/home') ?>" class="d-flex align-items-center text-decoration-none">
        <h4 class="fw-bold text-primary mb-0">Absensi<span class="text-dark">Ku</span></h4>
      </a>
    </div>
    <nav class="sidebar-nav mt-3">
      <ul>
        <li class="nav-item <?= $isDashboard ? 'active' : '' ?>">
          <a href="<?= $isDashboard ? 'javascript:void(0)' : base_url('admin/home') ?>" style="<?= $isDashboard ? 'pointer-events: none;' : '' ?>">
            <span class="icon"><i class="bi bi-grid-1x2-fill"></i></span>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item <?= $isPegawai ? 'active' : '' ?>">
          <a href="<?= $isPegawai ? 'javascript:void(0)' : base_url('admin/data_pegawai') ?>" style="<?= $isPegawai ? 'pointer-events: none;' : '' ?>">
            <span class="icon"><i class="bi bi-people-fill"></i></span>
            <span class="text">Data Pegawai</span>
          </a>
        </li>
        <li class="nav-item nav-item-has-children <?= $isRekap ? 'active' : '' ?>">
          <a href="#0" class="<?= $isRekap ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#rekapPresensi" aria-controls="rekapPresensi" aria-expanded="<?= $isRekap ? 'true' : 'false' ?>">
            <span class="icon"><i class="bi bi-card-checklist"></i></span>
            <span class="text">Rekap Presensi</span>
          </a>
          <ul id="rekapPresensi" class="collapse dropdown-nav <?= $isRekap ? 'show' : '' ?>">
            <li><a href="<?= $isRekapHarian ? 'javascript:void(0)' : base_url('admin/rekap_harian') ?>" class="<?= $isRekapHarian ? 'active' : '' ?>" style="<?= $isRekapHarian ? 'pointer-events: none;' : '' ?>">Rekap Harian</a></li>
            <li><a href="<?= $isRekapBulanan ? 'javascript:void(0)' : base_url('admin/rekap_bulanan') ?>" class="<?= $isRekapBulanan ? 'active' : '' ?>" style="<?= $isRekapBulanan ? 'pointer-events: none;' : '' ?>">Rekap Bulanan</a></li>
          </ul>
        </li>
        <li class="nav-item <?= $isKetidakhadiran ? 'active' : '' ?>">
          <a href="<?= $isKetidakhadiran ? 'javascript:void(0)' : base_url('admin/ketidakhadiran') ?>" style="<?= $isKetidakhadiran ? 'pointer-events: none;' : '' ?>">
            <span class="icon"><i class="bi bi-person-x-fill"></i></span>
            <span class="text">Ketidakhadiran</span>
          </a>
        </li>
        <li class="nav-item nav-item-has-children <?= $isMaster ? 'active' : '' ?>">
          <a href="#0" class="<?= $isMaster ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#masterData" aria-controls="masterData" aria-expanded="<?= $isMaster ? 'true' : 'false' ?>">
            <span class="icon"><i class="bi bi-folder-symlink-fill"></i></span>
            <span class="text">Master Data</span>
          </a>
          <ul id="masterData" class="collapse dropdown-nav <?= $isMaster ? 'show' : '' ?>">
            <li><a href="<?= $isJabatan ? 'javascript:void(0)' : base_url('admin/jabatan') ?>" class="<?= $isJabatan ? 'active' : '' ?>" style="<?= $isJabatan ? 'pointer-events: none;' : '' ?>">Data Jabatan</a></li>
            <li><a href="<?= $isLokasi ? 'javascript:void(0)' : base_url('admin/lokasi_presensi') ?>" class="<?= $isLokasi ? 'active' : '' ?>" style="<?= $isLokasi ? 'pointer-events: none;' : '' ?>">Lokasi Presensi</a></li>
          </ul>
        </li>
        <li class="nav-item nav-item-has-children <?= $isApi ? 'active' : '' ?>">
          <a href="#0" class="<?= $isApi ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#apiDocs" aria-controls="apiDocs" aria-expanded="<?= $isApi ? 'true' : 'false' ?>">
              <span class="icon"><i class="bi bi-code-slash"></i></span>
              <span class="text">API Docs</span>
          </a>
          <ul id="apiDocs" class="collapse dropdown-nav <?= $isApi ? 'show' : '' ?>">
              <li><a href="<?= base_url('admin/api/rekap_presensi') ?>">Rekap Presensi</a></li>
              <li><a href="<?= base_url('admin/api/jabatan') ?>">Jabatan</a></li>
              <li><a href="<?= base_url('admin/api/lokasi_presensi') ?>">Lokasi Presensi</a></li>
              <li><a href="<?= base_url('admin/api/pegawai') ?>">Pegawai</a></li>
              <li><a href="<?= base_url('admin/api/ketidakhadiran') ?>">Ketidakhadiran</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </aside>
  <div class="overlay"></div>
  <!-- ======== sidebar-nav end =========== -->

  <!-- ======== main-wrapper start =========== -->
  <main class="main-wrapper">
    <!-- ========== header start ========== -->
    <header class="header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-5 col-6">
            <div class="header-left d-flex align-items-center">
              <div class="menu-toggle-btn mr-15">
                <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                  <i class="lni lni-chevron-left"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-7 col-6">
            <div class="header-right d-flex justify-content-end align-items-center">
              <!-- profile start -->
              <div class="profile-box ml-15">
                <button class="dropdown-toggle bg-transparent border-0 d-flex align-items-center gap-2" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="profile-info">
                    <div class="info d-flex align-items-center gap-2">
                      <div class="image">
                        <img src="<?= session()->get('foto') ?: base_url('assets/images/profile/profile-image.png') ?>" alt="User" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
                      </div>
                      <div class="d-none d-md-block text-start">
                        <h6 class="fw-600 mb-0" style="font-size: 0.9rem;"><?= session()->get('nama') ?></h6>
                        <span class="text-xs text-muted"><?= session()->get('role_id') ?></span>
                      </div>
                    </div>
                  </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" aria-labelledby="profile">
                  <li class="px-3 py-2 border-bottom">
                    <h6 class="mb-0 text-sm fw-bold"><?= session()->get('nama') ?></h6>
                    <small class="text-muted"><?= session()->get('username') ?></small>
                  </li>
                  <li>
                    <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger py-2">
                      <i class="lni lni-exit me-2"></i> Sign Out
                    </a>
                  </li>
                </ul>
              </div>
              <!-- profile end -->
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- ========== header end ========== -->

    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30 pb-20">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="title">
                <h2 class="fw-bold text-dark mb-0"><?= $title ?></h2>
              </div>
            </div>
          </div>
        </div>
        <!-- ========== title-wrapper end ========== -->
        <?= $this->renderSection('content') ?>
      </div>
    </section>
    <!-- ========== section end ========== -->

    <!-- ========== footer start =========== -->
    <footer class="footer mt-auto py-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 text-center text-md-start">
            <p class="text-sm text-muted mb-0">
              © <?= date('Y') ?> <strong class="text-primary">AbsensiKu</strong>. All rights reserved.
            </p>
          </div>
        </div>
      </div>
    </footer>
    <!-- ========== footer end =========== -->
  </main>
  <!-- ======== main-wrapper end =========== -->

  <!-- ========= All Javascript files linkup ======== -->
  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/Chart.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/main.js') ?>"></script>

  <!-- jquery -->
  <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
  <!-- datatables.net -->
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
  <!-- Sweetalert 2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      if($('#datatables').length) {
        $('#datatables').DataTable({
          responsive: true,
          language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari data..."
          }
        });
      }
    });

    $(function() {
      <?php if (session()->has('success')) { ?>
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true
        });
        Toast.fire({
          icon: "success",
          title: "<?= $_SESSION['success'] ?>"
        });
      <?php } ?>
    });

    $('.delete-button').on('click', function(e) {
      e.preventDefault();
      var getLink = $(this).attr('href');
      Swal.fire({
        title: "Konfirmasi Hapus",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#4f46e5",
        cancelButtonColor: "#ef4444",
        confirmButtonText: "Ya, Hapus Data!"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = getLink;
        }
      });
    });
  </script>
</body>

</html>