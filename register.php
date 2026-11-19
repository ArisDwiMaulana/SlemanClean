<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/koneksi.php';

if (current_user()) {
  header("location: dashboard.php");
  exit();
}

$query = mysqli_query($koneksi, "SELECT nama FROM kecamatan ORDER BY id ASC");
$kecamatan = [];
while($row = mysqli_fetch_assoc($query)){
  $kecamatan[] = $row["nama"];
}

if (isset($_POST["register"])) {
      // Ambil dan bersihkan data input agar aman dari karakter berbahaya (SQL Injection)
      $nama      = trim(mysqli_real_escape_string($koneksi, $_POST['nama'] ?? ''));
      $email     = strtolower(trim(mysqli_real_escape_string($koneksi, $_POST['email'] ?? '')));
      $whatsapp  = trim(mysqli_real_escape_string($koneksi, $_POST['whatsapp'] ?? ''));
      $kec_input = trim(mysqli_real_escape_string($koneksi, $_POST['kecamatan'] ?? ''));
      $alamat    = trim(mysqli_real_escape_string($koneksi, $_POST['alamat'] ?? ''));
      $password  = $_POST['password'] ?? '';
      $password2 = $_POST['password2'] ?? '';

      if ($password !== $password2) {
          $error = 'Kata sandi dan ulangi sandi tidak cocok.';
      } elseif (strlen($password) < 6) {
          $error = 'Kata sandi minimal harus 6 karakter.';
      } else {
          $cek_email = mysqli_query($koneksi, "SELECT id FROM users WHERE email = '$email'");
          if (mysqli_num_rows($cek_email) > 0) {
              $error = 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.';
          } else {
              $hash_password = password_hash($password, PASSWORD_DEFAULT);
              $sql_insert = "INSERT INTO users (nama, email, password, no_wa, kecamatan_asal, alamat_asal, role)
                             VALUES ('$nama', '$email', '$hash_password', '$whatsapp', '$kec_input', '$alamat', 'customer')";
  
              if (mysqli_query($koneksi, $sql_insert)) {
                  header('Location: login.php?daftar=1');
                  exit;
              } else {
                  $error = 'Terjadi kesalahan sistem: ' . mysqli_error($koneksi);
              }
          }
      }
  }

$judul_halaman = 'Daftar Akun – SlemanClean';
include __DIR__ . '/includes/header.php';
?>
<main class="page"><div class="auth-wrap text-center" style="max-width:620px">
  <div class="icon-badge"><i class="bi bi-person-plus-fill"></i></div>
  <h1 class="h2 fw-bold">Pendaftaran Akun Baru</h1>
  <p class="text-muted2">Buat akun SlemanClean untuk menikmati kemudahan pemesanan jasa kebersihan rumah di seluruh area Kabupaten Sleman.</p>

  <?php if ($error): ?><div class="alert alert-danger text-start mt-3 mb-0"><i class="bi bi-exclamation-circle-fill me-1"></i> <?= $error ?></div><?php endif; ?>
  <!-- TODO backend: proses di register.php (POST: nama, email, whatsapp, kecamatan, alamat, password, password2) -->
  <form method="post" class="panel p-4 text-start my-4" id="formDaftar">
    <label class="lbl mb-1">Nama lengkap <span class="text-danger">*</span></label>
    <div class="input-group mb-3"><span class="input-group-text"><i class="bi bi-person"></i></span><input name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required></div>
    <div class="row g-3 mb-3">
      <div class="col-md-6"><label class="lbl mb-1">Alamat email <span class="text-danger">*</span></label>
        <div class="input-group"><span class="input-group-text"><i class="bi bi-envelope"></i></span><input type="email" name="email" class="form-control" placeholder="nama@email.com" required></div></div>
      <div class="col-md-6"><label class="lbl mb-1">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
        <div class="input-group"><span class="input-group-text"><i class="bi bi-whatsapp"></i></span><input name="whatsapp" class="form-control" placeholder="Contoh: 081234567890" pattern="[0-9+]{9,15}" required></div></div>
    </div>
    <label class="lbl mb-1">Kecamatan domisili di Sleman <span class="text-danger">*</span></label>
    <div class="input-group mb-3"><span class="input-group-text"><i class="bi bi-map"></i></span>
      <select name="kecamatan" class="form-select" required><option value="">-- Pilih Kecamatan di Kabupaten Sleman --</option>
        <?php foreach ($kecamatan as $k): ?><option value="<?= $k ?>">Kec. <?= $k ?></option><?php endforeach; ?>
      </select></div>
    <label class="lbl mb-1">Alamat lengkap / patokan rumah <span class="text-danger">*</span></label>
    <textarea name="alamat" rows="2" class="form-control mb-3" placeholder="Contoh: Jl. Kaliurang KM 5, Gg. Megatruh No. 10 (Depan Masjid)" required></textarea>
    <div class="row g-3 mb-4">
      <div class="col-md-6"><label class="lbl mb-1">Kata sandi <span class="text-danger">*</span></label>
        <div class="input-group"><span class="input-group-text"><i class="bi bi-lock-fill"></i></span><input type="password" name="password" id="p1" minlength="6" class="form-control" placeholder="Min. 6 karakter" required></div></div>
      <div class="col-md-6"><label class="lbl mb-1">Ulangi sandi <span class="text-danger">*</span></label>
        <div class="input-group"><span class="input-group-text"><i class="bi bi-check2-all"></i></span><input type="password" name="password2" id="p2" class="form-control" placeholder="Ketik ulang kata sandi" required></div></div>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit" name="register"><i class="bi bi-person-check me-1"></i>Daftar Sekarang</button>
    <hr><p class="text-center mb-0 small">Sudah memiliki akun SlemanClean? <a href="login.php" class="fw-bold text-success text-decoration-none">Masuk ke Akun Anda</a></p>
  </form>
</div></main>
<?php include __DIR__ . '/includes/footer.php'; ?>
