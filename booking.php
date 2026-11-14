<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_login();
$user = current_user();
$judul_halaman = 'Form Pemesanan – SlemanClean';
$halaman_aktif = 'booking';
$page_js = 'booking.js';
include __DIR__ . '/includes/header.php';
$pilih = $_GET['paket'] ?? 'standard';
?>
<main class="page"><div class="container">
  <nav class="small text-muted2 mb-2"><a href="index.php" class="text-muted2 text-decoration-none">Beranda</a> / <span class="text-dark fw-semibold">Form Pemesanan Kebersihan</span></nav>
  <h1 class="fw-bold">Formulir Pemesanan Home Cleaning</h1>
  <p class="text-muted2 mb-4" style="max-width:46rem">Lengkapi rincian pemesanan rumah Anda. Harga sama untuk seluruh kecamatan di Sleman. Sistem akan mengalokasikan tim kebersihan yang tersedia.</p>

  <!-- TODO backend: saat ini GET ke pembayaran.php (hanya untuk tampilan). Boleh diganti POST yang menyimpan pesanan lalu redirect ke pembayaran.php -->
  <form method="get" action="pembayaran.php" class="row g-4" id="formBooking">
    <div class="col-lg-8">
      <section class="panel p-4 mb-3">
        <div class="d-flex justify-content-between mb-3"><h2 class="h6 fw-bold"><i class="bi bi-person-fill text-success me-2"></i>1. Informasi Pemesan</h2><span class="pill pill-success"><i class="bi bi-check-circle-fill"></i> Data Sesi Terverifikasi</span></div>
        <div class="row g-3">
          <div class="col-md-6"><label class="lbl mb-1">Nama lengkap</label><input class="form-control" value="<?= htmlspecialchars($user['nama']) ?>" readonly></div>
          <div class="col-md-6"><label class="lbl mb-1">Nomor WhatsApp / HP</label><input class="form-control" value="<?= htmlspecialchars($user['wa'] ?? '085712345678') ?>" readonly></div>
        </div>
      </section>

      <section class="panel p-4 mb-3">
        <div class="d-flex justify-content-between mb-3"><h2 class="h6 fw-bold"><i class="bi bi-magic text-success me-2"></i>2. Pilih Paket Layanan Kebersihan</h2><small class="text-danger fw-bold">* Wajib Dipilih</small></div>
        <div class="row g-3 calc">
          <?php foreach ($paket as $k => $p): ?>
          <div class="col-md-6"><label class="opt h-100">
            <input class="form-check-input me-2" type="radio" name="paket" value="<?= $k ?>" data-nama="<?= $p['nama'] ?> (<?= $p['durasi'] ?>)" data-harga="<?= $p['harga'] ?>" <?= $pilih === $k ? 'checked' : '' ?>>
            <strong><?= $p['nama'] ?></strong><strong class="float-end text-success"><?= rupiah($p['harga']) ?></strong>
            <div class="small text-muted2 ps-4">Estimasi durasi: <?= $p['durasi'] ?></div><hr class="my-2"><div class="small"><?= $p['desk'] ?></div></label></div>
          <?php endforeach; ?>
        </div>
      </section>

      <section class="panel p-4 mb-3">
        <div class="d-flex justify-content-between mb-3"><h2 class="h6 fw-bold"><i class="bi bi-geo-alt-fill text-success me-2"></i>3. Lokasi Pengerjaan di Sleman</h2><small class="text-muted2">Pusat Hub: Kec. Depok</small></div>
        <label class="lbl mb-1">Kecamatan tujuan <span class="text-danger">*</span></label>
        <select name="kecamatan" id="kec" class="form-select" required>
          <?php foreach ($kecamatan as $k): ?>
          <option value="<?= $k ?>" <?= $k === 'Depok' ? 'selected' : '' ?>>Kec. <?= $k ?></option>
          <?php endforeach; ?>
        </select>
        <div class="form-text mb-3">Harga layanan sama untuk seluruh kecamatan di Sleman, tanpa biaya tambahan.</div>
        <label class="lbl mb-1">Alamat lengkap &amp; patokan rumah <span class="text-danger">*</span></label>
        <textarea name="alamat" rows="3" class="form-control" placeholder="Contoh: Perum Condongcatur Asri Blok B-4, Depok, Sleman" required></textarea>
      </section>

      <section class="panel p-4">
        <div class="d-flex justify-content-between mb-3"><h2 class="h6 fw-bold"><i class="bi bi-calendar-event-fill text-success me-2"></i>4. Jadwal &amp; Slot Waktu Pengerjaan</h2><small class="text-danger fw-bold">* Wajib Dipilih</small></div>
        <div class="row g-3 mb-3">
          <div class="col-md-6"><label class="lbl mb-1">Tanggal pengerjaan <span class="text-danger">*</span></label>
            <input type="date" name="tanggal" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required>
            <div class="form-text">Minimal pemesanan untuk hari ini.</div></div>
          <div class="col-md-6 calc"><label class="lbl mb-1">Pilihan slot jam <span class="text-danger">*</span></label>
            <?php foreach ($slots as $n => [$nm, $jam]): ?>
            <label class="opt py-2 mb-2"><input class="form-check-input me-2" type="radio" name="slot" value="<?= $n ?>" <?= $n === 1 ? 'checked' : '' ?>><?= $nm ?><span class="float-end small text-muted2"><?= $jam ?> WIB</span></label>
            <?php endforeach; ?>
          </div>
        </div>
        <label class="lbl mb-1">Catatan khusus untuk tim pembersih <small class="text-muted fw-normal text-lowercase">(opsional)</small></label>
        <input name="catatan" class="form-control" placeholder="Contoh: Fokuskan kebersihan kamar mandi utama &amp; kaca ruang tamu">
      </section>
    </div>

    <!-- Ringkasan -->
    <div class="col-lg-4"><aside class="panel p-4 sticky-sum">
      <div class="d-flex justify-content-between mb-3"><h2 class="h6 fw-bold mb-0">Rincian Pembayaran</h2><span class="badge text-bg-light">REAL-TIME</span></div>
      <div class="d-flex justify-content-between border-top pt-3"><span id="sPaket">–</span><strong id="sHargaPaket">–</strong></div>
      <small class="text-muted2">Tarif dasar paket</small>
      <div class="small text-muted2 mt-3"><i class="bi bi-geo-alt me-1"></i><span id="sKec">–</span></div>
      <div class="d-flex justify-content-between align-items-end border-top mt-3 pt-3 mb-3"><strong>Total Bayar</strong><span class="total" id="sTotal">–</span></div>
      <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-arrow-right-circle me-1"></i>Lanjut ke Pembayaran</button>
      <p class="small text-muted2 text-center mt-3 mb-0"><i class="bi bi-shield-check"></i> Pesanan baru diproses setelah pembayaran dikonfirmasi pada langkah berikutnya.</p>
    </aside></div>
  </form>
</div></main>

<?php include __DIR__ . '/includes/footer.php'; ?>
