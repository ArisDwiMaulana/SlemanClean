<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_login();
$user = current_user();
$judul_halaman = 'Dashboard – SlemanClean';
$halaman_aktif = 'dashboard';
include __DIR__ . '/includes/header.php';
$view = $user['role'] === 'admin' ? 'admin' : 'customer';
?>
<main class="page"><div class="container">
  <?php include __DIR__ . "/views/dashboard_$view.php"; ?>
</div></main>
<?php include __DIR__ . '/includes/footer.php'; ?>
