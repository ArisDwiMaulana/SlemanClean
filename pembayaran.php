<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/mock_data.php';
require_login();
// DEMO saja: konfirmasi bayar -> kembali ke dashboard. Backend: simpan pesanan + status pembayaran di sini.
if (DEMO_MODE && $_SERVER['REQUEST_METHOD'] === 'POST') { header('Location: dashboard.php?sukses=1'); exit; }

$pk  = $paket[$_GET['paket'] ?? ''] ?? null;
$kec = $_GET['kecamatan'] ?? '';
if (!$pk || !in_array($kec, $kecamatan, true)) { header('Location: booking.php'); exit; }   // data pesanan belum lengkap
$total = $pk['harga'];
$slot  = $slots[(int)($_GET['slot'] ?? 1)] ?? $slots[1];
$tgl   = $_GET['tanggal'] ?? date('Y-m-d');

$judul_halaman = 'Pembayaran – SlemanClean';
$halaman_aktif = 'booking';
include __DIR__ . '/includes/header.php';
$h = fn($k) => htmlspecialchars($_GET[$k] ?? '');
?>
<main class="page"><div class="container" style="max-width:980px">
  <nav class="small text-muted2 mb-2"><a href="booking.php" class="text-muted2 text-decoration-none">Form Pemesanan</a> / <span class="text-dark fw-semibold">Pembayaran</span></nav>
  <h1 class="fw-bold">Simulasi Pembayaran</h1>
  <p class="text-muted2 mb-4">Pilih metode pembayaran untuk menyelesaikan pesanan. Ini hanya simulasi, tidak ada uang yang dipindahkan.</p>

  <!-- TODO backend: POST ke pembayaran.php (field tersembunyi di bawah + metode) -->
  <form method="post" class="row g-4">
    <?php foreach (['paket', 'kecamatan', 'tanggal', 'slot', 'alamat', 'catatan'] as $f): ?><input type="hidden" name="<?= $f ?>" value="<?= $h($f) ?>"><?php endforeach; ?>
    <div class="col-lg-7">
      <section class="panel p-4 calc">
        <h2 class="h6 fw-bold mb-3"><i class="bi bi-credit-card-2-front text-success me-2"></i>Metode Pembayaran</h2>
        <label class="opt mb-2"><input class="form-check-input me-2" type="radio" name="metode" value="QRIS" checked>
          <i class="bi bi-qr-code-scan me-1"></i><strong>QRIS</strong><div class="small text-muted2 ps-4">Scan dengan e-wallet atau mobile banking</div></label>
        <label class="opt mb-3"><input class="form-check-input me-2" type="radio" name="metode" value="Transfer Bank">
          <i class="bi bi-bank me-1"></i><strong>Transfer Bank (Virtual Account)</strong><div class="small text-muted2 ps-4">BPD DIY / Mandiri</div></label>
        <div id="boxQris" class="text-center border rounded-4 p-4 bg-light"><i class="bi bi-qr-code" style="font-size:6rem"></i><div class="small text-muted2">QR contoh (simulasi) · berlaku 15 menit</div></div>
        <div id="boxVa" class="border rounded-4 p-4 bg-light" hidden>
          <div class="small text-muted2">Nomor Virtual Account (simulasi)</div><div class="mono fs-4">8808 1234 5678 9012</div><div class="small text-muted2">a.n. SlemanClean</div></div>
      </section>
    </div>
    <div class="col-lg-5"><aside class="panel p-4 sticky-sum">
      <h2 class="h6 fw-bold mb-3">Ringkasan Pesanan</h2>
      <div class="d-flex justify-content-between"><span><?= $pk['nama'] ?> (<?= $pk['durasi'] ?>)</span><strong><?= rupiah($pk['harga']) ?></strong></div>
      <div class="small text-muted2 mt-2"><i class="bi bi-geo-alt me-1"></i>Kec. <?= htmlspecialchars($kec) ?></div>
      <div class="small text-muted2 mt-3"><i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($tgl)) ?> · <?= $slot[0] ?> (<?= $slot[1] ?> WIB)</div>
      <?php if ($h('alamat')): ?><div class="small text-muted2"><i class="bi bi-geo-alt me-1"></i><?= $h('alamat') ?></div><?php endif; ?>
      <div class="d-flex justify-content-between align-items-end border-top mt-3 pt-3 mb-3"><strong>Total Bayar</strong><span class="total"><?= rupiah($total) ?></span></div>
      <button class="btn btn-primary w-100 py-2" type="submit"><i class="bi bi-check2-circle me-1"></i>Konfirmasi Pembayaran (Simulasi)</button>
      <a href="booking.php" class="btn btn-link w-100 text-muted2 mt-1">Ubah pesanan</a>
    </aside></div>
  </form>
</div></main>
<script>
document.querySelectorAll('input[name=metode]').forEach(r => r.addEventListener('change', () => {
  boxQris.hidden = r.value !== 'QRIS' || !r.checked; boxVa.hidden = !boxQris.hidden;
}));
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
