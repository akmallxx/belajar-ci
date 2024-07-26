<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo/loco.svg') ?>" type="image/x-icon" />
  <title><?= $title ?> | Presensi</title>

  <!-- ========== All CSS files linkup ========= -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/lineicons.css') ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/materialdesignicons.min.css') ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?= base_url('assets/css/fullcalendar.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/fullcalendar.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- ========== Data Tables =========== -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>

<body>
  <!-- ======== Preloader =========== -->
  <div id="preloader">
    <div class="spinner"></div>
  </div>
  <!-- ======== Preloader =========== -->

  <!-- ======== sidebar-nav start =========== -->
  <aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
      <a href="index.html">
        <img src="<?= base_url('assets/images/logo/LOGO.png') ?>" class="img-fluid" alt="logo" />
      </a>
    </div>
    <nav class="sidebar-nav">
      <ul>
        <li class="nav-item">
          <a href="<?= base_url('admin/home') ?>">
            <span class="icon">
              <i class="bi bi-house-door"></i>
            </span>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/data_pegawai') ?>">
            <span class="icon">
              <i class="bi bi-people"></i>
            </span>
            <span class="text">Data Pegawai</span>
          </a>
        </li>
        <li class="nav-item nav-item-has-children">
          <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#rekapPresensi" aria-controls="rekapPresensi" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon">
              <i class="bi bi-journal-text"></i>
            </span>
            <span class="text">Rekap Presensi</span>
          </a>
          <ul id="rekapPresensi" class="collapse dropdown-nav">
            <li>
              <a href="<?= base_url('admin/rekap_harian') ?>"> Detail Presensi</a>
            </li>
            <li>
              <a href="rekap_bulanan"> Rekap Bulanan </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="invoice.html">
            <span class="icon">
              <i class="bi bi-person-x"></i>
            </span>
            <span class="text">Ketidakhadiran</span>
          </a>
        </li>
        <li class="nav-item nav-item-has-children">
          <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#masterData" aria-controls="masterData" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon">
              <i class="bi bi-database"></i>
            </span>
            <span class="text">Master Data</span>
          </a>
          <ul id="masterData" class="collapse dropdown-nav">
            <li>
              <a href="<?= base_url('admin/jabatan') ?>"> Data Jabatan </a>
            </li>
            <li>
              <a href="<?= base_url('admin/lokasi_presensi') ?>"> Lokasi Presensi </a>
            </li>
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
        <div class="row">
          <div class="col-lg-5 col-md-5 col-6">
            <div class="header-left d-flex align-items-center">
              <div class="menu-toggle-btn mr-15">
                <button id="menu-toggle" class="main-btn btn-secondary btn-hover">
                  <i class="lni lni-chevron-left"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-7 col-6">
            <div class="header-right">

              <!-- profile start -->
              <div class="profile-box ml-15">
                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="profile-info">
                    <div class="info">
                      <div class="image">
                        <img src="<?= session()->get('foto') ?>" alt="" />
                      </div>
                      <!-- <div>
                          <h6 class="fw-500"><?= session()->get('nama') ?></h6>
                          <p><?= session()->get('role_id') ?></p>
                        </div> -->
                    </div>
                  </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                  <li>
                    <div class="author-info flex items-center !p-1">
                      <div class="image">
                        <img src="<?= session()->get('foto') ?>" alt="image" />
                      </div>
                      <div class="content">
                        <h4 class="text-sm"><?= session()->get('nama') ?></h4>
                        <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#"><?= session()->get('username') . '  (' . session()->get('role_id') . ')' ?></a>
                      </div>
                    </div>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="#0">
                      <i class="lni lni-user"></i> View Profile
                    </a>
                  </li>
                  <li>
                    <a href="#0">
                      <i class="lni lni-alarm"></i> Notifications
                    </a>
                  </li>
                  <li>
                    <a href="#0"> <i class="lni lni-inbox"></i> Messages </a>
                  </li>
                  <li>
                    <a href="#0"> <i class="lni lni-cog"></i> Settings </a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="<?= base_url('logout') ?>"> <i class="lni lni-exit"></i> Sign Out </a>
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
        <div class="title-wrapper pt-30">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="title">
                <h2><?= $title ?></h2>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->
        <?= $this->renderSection('content') ?>
      </div>
      <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

    <!-- ========== footer start =========== -->
    <footer class="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 order-last order-md-first">
            <div class="copyright text-center text-md-start">
              <p class="text-sm">
                Designed and Developed by
                <a href="" rel="nofollow" target="_blank" disabled>
                  AbsensiKu
                </a>
              </p>
            </div>
          </div>
          <!-- end col-->
          <div class="col-md-6">
            <div class="terms d-flex justify-content-center justify-content-md-end">
              <!-- <a href="#0" class="text-sm">Term & Conditions</a>
              <a href="#0" class="text-sm ml-15">Privacy & Policy</a> -->
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
      <!-- end container -->
    </footer>
    <!-- ========== footer end =========== -->
  </main>
  <!-- ======== main-wrapper end =========== -->

  <!-- ========= All Javascript files linkup ======== -->
  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/Chart.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/dynamic-pie-chart.js') ?>"></script>
  <script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/fullcalendar.js') ?>"></script>
  <script src="<?= base_url('assets/js/jvectormap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/world-merc.js') ?>"></script>
  <script src="<?= base_url('assets/js/polyfill.js') ?>"></script>
  <script src="<?= base_url('assets/js/main.js') ?>"></script>

  <!-- jquery -->
  <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>

  <!-- datatables.net -->
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

  <!-- Sweetalert 2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // datatables.net
    $(document).ready(function() {
      $('#datatables').DataTable();
    });

    // sweetaler success
    $(function() {
      <?php if (session()->has('success')) { ?>
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "success",
          title: "<?= $_SESSION['success'] ?>"
        });
      <?php } ?>
    });

    //sweetalert delete confirm
    $('.delete-button').on('click', function() {
      var getLink = $(this).attr('href');

      Swal.fire({
        title: "Anda yakin?",
        text: "Anda tidak dapat mengembalikan data yang sudah dihapus!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = getLink

        }
      });
      return false
    });
  </script>
</body>

</html>