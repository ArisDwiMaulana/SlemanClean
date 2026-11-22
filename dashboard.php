<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/koneksi.php';
require_login();
$user = current_user();
if ($user['role'] === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';
    if ($aksi === 'ubah_status') {
        $no_order = mysqli_real_escape_string($koneksi, $_POST['no_order'] ?? '');
        $status = mysqli_real_escape_string($koneksi, $_POST['status'] ?? 'Diproses');
        mysqli_query($koneksi, "UPDATE pesanan SET status_pesanan = '$status' WHERE no_order = '$no_order'");
        header('Location: dashboard.php');
        exit();
    }
    if ($aksi === 'tambah_tim') {
        $nama_tim = mysqli_real_escape_string($koneksi, $_POST['nama_tim'] ?? '');
        $ketua = mysqli_real_escape_string($koneksi, $_POST['ketua'] ?? '');
        $wa = mysqli_real_escape_string($koneksi, $_POST['wa'] ?? '');
        mysqli_query($koneksi, "INSERT INTO tim_kebersihan (nama, ketua, wa, status_operasional) VALUES ('$nama_tim', '$ketua', '$wa', 'aktif')");
        header('Location: dashboard.php');
        exit();
    }
    if ($aksi === 'toggle_tim') {
        $tim_id = (int) ($_POST['tim_id'] ?? 0);
        mysqli_query($koneksi, "UPDATE tim_kebersihan SET status_operasional = IF(status_operasional = 'aktif', 'nonaktif', 'aktif') WHERE id = $tim_id");
        header('Location: dashboard.php');
        exit();
    }
    if ($aksi === 'hapus_tim') {
        $tim_id = (int)($_POST['tim_id'] ?? 0);
        if ($tim_id > 0) {
            mysqli_query($koneksi, "DELETE FROM tim_kebersihan WHERE id = $tim_id");
        }
        header('Location: dashboard.php?sukses_hapus_tim=1');
        exit;
    }
}

$judul_halaman = 'Dashboard – SlemanClean';
$halaman_aktif = 'dashboard';
include __DIR__ . '/includes/header.php';
$view = $user['role'] === 'admin' ? 'admin' : 'customer';
?>
<main class="page">
    <div class="container">
        <?php include __DIR__ . "/views/dashboard_$view.php"; ?>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
