<?php
$u = current_user();
$a = $halaman_aktif ?? '';
$menu = ['beranda' => ['Beranda', 'index.php#beranda'], 'paket' => ['Paket Layanan', 'index.php#paket'],
         'booking' => ['Pesan Kebersihan', 'booking.php']];
$label = ['admin' => 'Super Admin', 'customer' => 'Pelanggan'];
?>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="SlemanClean" height="60"></a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Buka menu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav mx-auto gap-lg-2">
        <?php foreach ($menu as $k => [$t, $h]): ?>
        <li class="nav-item"><a class="nav-link <?= $a === $k ? 'active fw-bold text-success' : '' ?>" href="<?= $h ?>"><?= $t ?></a></li>
        <?php endforeach; ?>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <?php if ($u): ?>
          <div class="nav-user d-flex align-items-center gap-2">
            <span class="avatar"><?= strtoupper($u['nama'][0]) ?></span>
            <span class="lh-sm"><strong class="small d-block"><?= htmlspecialchars($u['nama']) ?></strong><small class="text-success"><?= $label[$u['role']] ?></small></span>
          </div>
          <a href="dashboard.php" class="btn btn-dark rounded-pill px-3"><i class="bi bi-grid-fill me-1"></i>Dashboard</a>
          <a href="logout.php" class="btn btn-link text-muted" title="Keluar"><i class="bi bi-box-arrow-right fs-5"></i></a>
        <?php else: ?>
          <a href="login.php" class="btn btn-link text-decoration-none text-dark fw-semibold">Masuk</a>
          <a href="register.php" class="btn btn-primary rounded-pill px-3"><i class="bi bi-person-plus me-1"></i>Daftar Akun</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
