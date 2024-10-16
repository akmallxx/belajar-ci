<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo/loco.svg'); ?>" type="image/x-icon" />
    <title>Sign In | AbsensiKu</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/lineicons.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/materialdesignicons.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/fullcalendar.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>" />
    
    <style>
        @media (max-width: 768px) {
            .auth-cover {
                margin-top: 20px;
                margin-bottom: 0px;
            }
        }
        .auth-cover::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 10%; /* Sesuaikan tinggi gradasi sesuai kebutuhan */
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1)); /* Gradasi dari transparan ke putih */
            pointer-events: none; /* Agar tidak mengganggu interaksi pengguna */
        }
    </style>
  </head>
  <body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
      <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->

      <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-15">Selamat Datang</h1>
                    <p class="text-medium">
                    Masuk ke akun Anda untuk melanjutkan
                    </p>
                  </div>
                  <div class="cover-image">
                    <img src="<?= base_url('assets/images/auth/login.png') ?>" class="img-fluid" alt="" />
                  </div>
                  <div class="shape-image">
                    <!-- <img src="<?= base_url('assets/images/auth/') ?>" alt="" /> -->
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signin-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Sign In Form</h6>
                  <p class="text-sm mb-25">
                  Mulailah menciptakan pengalaman pengguna terbaik untuk anda
                  
                  </p>

                  <?php if(!empty(session()->getFlashData('pesan'))): ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= session()->getFlashData('pesan') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif ?>
                  <form action="<?= base_url('login_action'); ?>" method="post">
                      <?= csrf_field(); ?>
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Username</label>
                          <input type="text" placeholder="Username" name="username" maxlength="30" class="form-control" required />
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Password</label>
                          <input type="password" placeholder="Password" name="password" class="form-control" required/>
                          <!-- <div class="invalid-feedback">Password is required</div> -->
                        </div>
                      </div>
                    <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                            Masuk
                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <!-- <div class="singin-option pt-40">
                    <p class="text-sm text-medium text-dark text-center">
                      Don’t have any account yet?
                      <a href="<?= base_url('register') ?>">Create an account</a>
                    </p>
                  </div> -->
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== --> 

    <!-- ========= All Javascript files linkup ======== -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>
    <script src="https://website-widgets.pages.dev/dist/sienna.min.js" defer></script>
</body>
</html>
