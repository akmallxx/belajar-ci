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
    $isDashboard = ($uri == 'home' || $uri == '');
    $isRekap = (strpos($uri, 'rekap_presensi') !== false);
    $isKetidakhadiran = (strpos($uri, 'ketidakhadiran') !== false);
  ?>

  <!-- ======== sidebar-nav start =========== -->
  <aside class="sidebar-nav-wrapper">
    <div class="navbar-logo d-flex align-items-center justify-content-between">
      <a href="<?= $isDashboard ? 'javascript:void(0)' : base_url('home') ?>" class="d-flex align-items-center text-decoration-none">
        <h4 class="fw-bold text-primary mb-0">Absensi<span class="text-dark">Ku</span></h4>
      </a>
    </div>
    <nav class="sidebar-nav mt-3">
      <ul>
        <li class="nav-item <?= $isDashboard ? 'active' : '' ?>">
          <a href="<?= $isDashboard ? 'javascript:void(0)' : base_url('home') ?>" style="<?= $isDashboard ? 'pointer-events: none;' : '' ?>">
            <span class="icon"><i class="bi bi-house-door-fill"></i></span>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item <?= $isRekap ? 'active' : '' ?>">
          <a href="<?= $isRekap ? 'javascript:void(0)' : base_url('rekap_presensi') ?>" style="<?= $isRekap ? 'pointer-events: none;' : '' ?>">
            <span class="icon"><i class="bi bi-journal-check"></i></span>
            <span class="text">Rekap Presensi</span>
          </a>
        </li>
        <li class="nav-item <?= $isKetidakhadiran ? 'active' : '' ?>">
          <a href="<?= $isKetidakhadiran ? 'javascript:void(0)' : base_url('ketidakhadiran') ?>" style="<?= $isKetidakhadiran ? 'pointer-events: none;' : '' ?>">
            <span class="icon"><i class="bi bi-person-x-fill"></i></span>
            <span class="text">Ketidakhadiran</span>
          </a>
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
                    <a href="<?= base_url('profile') ?>" class="dropdown-item py-2">
                      <i class="lni lni-user me-2"></i> View Profile
                    </a>
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
  </script>
</body>

</html>