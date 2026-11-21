<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/koneksi.php';

if (current_user()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$info = isset($_GET['daftar']) ? 'Pendaftaran berhasil. Silakan masuk dengan akun Anda.' : '';

if (isset($_POST['login'])) {
    $username = trim(mysqli_real_escape_string($koneksi, $_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';
    $query = "SELECT * FROM users
                WHERE email = '$username'
                   OR (role = 'admin' AND '$username' = 'admin')
                LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => (int) $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
                'wa' => $user['no_wa'],
                'kecamatan' => $user['kecamatan_asal'],
                'alamat' => $user['alamat_asal'],
                'role' => $user['role'], // 'admin' atau 'customer'
            ];
            header('Location: dashboard.php');
            exit();
        }
    }
    $error = 'Email/username atau kata sandi salah.';
}

$judul_halaman = 'Masuk – SlemanClean';
include __DIR__ . '/includes/header.php';
?>
<main class="page">
    <div class="auth-wrap text-center">
        <div class="icon-badge"><i class="bi bi-lock-fill"></i></div>
        <h1 class="h2 fw-bold">Selamat Datang Kembali</h1>
        <p class="text-muted2">Masuk untuk memesan layanan kebersihan atau memantau status pengerjaan rumah Anda di
            Sleman.</p>

        <?php if ($info): ?><div class="alert alert-success text-start mt-3 mb-0"><i
                class="bi bi-check-circle-fill me-1"></i> <?= $info ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger text-start mt-3 mb-0"><i
                class="bi bi-exclamation-circle-fill me-1"></i> <?= $error ?></div><?php endif; ?>

        <!-- TODO backend: proses di login.php (POST: username/email, password) -->
        <form method="post" class="panel p-4 text-start my-4">
            <label class="lbl mb-1" for="username">Email / Username <span class="text-danger">*</span></label>
            <div class="input-group mb-3"><span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" id="username" name="username" class="form-control" placeholder="nama@email.com"
                    autocomplete="username" required>
            </div>
            <label class="lbl mb-1" for="password">Kata sandi <span class="text-danger">*</span></label>
            <div class="input-group mb-4"><span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••"
                    autocomplete="current-password" required>
                <button class="btn btn-outline-secondary" type="button" id="toggle" aria-label="Tampilkan sandi"><i
                        class="bi bi-eye"></i></button>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit" name="login"><i
                    class="bi bi-box-arrow-in-right me-1"></i>Masuk ke Akun</button>
            <hr>
            <p class="text-center mb-0 small">Belum memiliki akun SlemanClean? <a href="register.php"
                    class="fw-bold text-success text-decoration-none">Daftar Sekarang</a></p>
        </form>
    </div>
</main>
<script>
    document.getElementById('toggle').onclick = () => {
        const p = document.getElementById('password');
        p.type = p.type === 'password' ? 'text' : 'password';
    };
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
