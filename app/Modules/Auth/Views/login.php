<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="<?= base_url('assets/images/logo/loco.svg'); ?>" type="image/x-icon" />
  <title>Sign In | AbsensiKu</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom-modern.css'); ?>" />

  <style>
    body {
      background-color: #f1f5f9;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      width: 100%;
      max-width: 440px;
      padding: 40px 32px;
    }

    .brand-title {
      font-weight: 700;
      font-size: 1.75rem;
      color: #0f172a;
    }

    .brand-accent {
      color: #2563eb;
    }
  </style>
</head>

<body>
  <div class="login-card">
    <div class="text-center mb-4">
      <div class="brand-title mb-1">Absensi<span class="brand-accent">Ku</span></div>
      <p class="text-muted text-sm mb-0">Masukkan akun Anda untuk melanjutkan</p>
    </div>

    <?php if (!empty(session()->getFlashData('pesan'))): ?>
      <div class="alert alert-danger border-0 d-flex align-items-center gap-2 mb-4 py-2 px-3" role="alert" style="background-color: #fee2e2; color: #991b1b; font-size: 0.9rem; border-radius: 8px;">
        <i class="bi bi-exclamation-circle-fill fs-6"></i>
        <div><?= session()->getFlashData('pesan') ?></div>
      </div>
    <?php endif ?>

    <form action="<?= base_url('login_action'); ?>" method="post">
      <?= csrf_field(); ?>
      <div class="mb-3">
        <label class="form-label fw-600 text-dark small mb-1">Username</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
          <input type="text" placeholder="Masukkan username" name="username" maxlength="30" class="form-control border-start-0" required />
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label fw-600 text-dark small mb-1">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
          <input type="password" placeholder="Masukkan password" name="password" class="form-control border-start-0" required />
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
        Masuk Akun
      </button>
    </form>
  </div>

  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>
