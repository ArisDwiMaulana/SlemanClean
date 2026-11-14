<?php
$judul_halaman = 'SlemanClean – Jasa Kebersihan Rumah di Sleman';
$halaman_aktif = 'beranda';
$page_js = 'home.js';
include __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<header class="hero py-5" id="beranda">
  <div class="container py-lg-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge rounded-pill text-bg-light mb-3 px-3 py-2"><i class="bi bi-geo-alt-fill text-success me-1"></i>Berbasis di Depok, melayani 17 kecamatan</span>
        <h1 class="fw-bold mb-3">Rumah rapi dan wangi, tanpa repot di Sleman.</h1>
        <p class="lead opacity-75 mb-4" style="max-width:34rem">Pesan petugas kebersihan profesional untuk rumah, kos, atau apartemen. Jadwal dipilih sendiri, harga sama untuk seluruh kecamatan di Sleman.</p>
        <div class="d-flex flex-wrap gap-2 mb-5">
          <a href="booking.php" class="btn btn-primary btn-lg rounded-pill px-4"><i class="bi bi-calendar-check me-2"></i>Pesan sekarang</a>
          <a href="#paket" class="btn btn-outline-primary btn-lg rounded-pill px-4">Lihat paket</a>
        </div>
        <div class="row g-3 hero-stat">
          <div class="col-4"><strong>17</strong><span>Kecamatan terlayani</span></div>
          <div class="col-4"><strong>100%</strong><span>Tim terlatih</span></div>
          <div class="col-4"><strong>3 sesi</strong><span>Pagi, siang, sore</span></div>
        </div>
      </div>

      <!-- Kalkulator estimasi -->
      <div class="col-lg-6" id="pesan">
        <div class="calc p-4 p-md-4">
          <h2 class="h5 fw-bold mb-1">Hitung biaya pesanan</h2>
          <p class="text-muted2 small mb-3">Pilih paket dan slot waktu, harga langsung terlihat.</p>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="opt"><input class="form-check-input me-2" type="radio" name="paket" value="120000" checked>
                <strong>Standard</strong><div class="small text-muted2 ps-4">±3 jam · Rp 120.000</div></label>
            </div>
            <div class="col-6">
              <label class="opt"><input class="form-check-input me-2" type="radio" name="paket" value="250000">
                <strong>Deep Cleaning</strong><div class="small text-muted2 ps-4">±5 jam · Rp 250.000</div></label>
            </div>
          </div>

          <label class="form-label small fw-bold">Slot waktu</label>
          <div class="btn-group w-100 mb-4" role="group">
            <input type="radio" class="btn-check" name="slot" id="s1" checked><label class="btn btn-outline-primary" for="s1">Pagi 08.00</label>
            <input type="radio" class="btn-check" name="slot" id="s2"><label class="btn btn-outline-primary" for="s2">Siang 13.00</label>
            <input type="radio" class="btn-check" name="slot" id="s3"><label class="btn btn-outline-primary" for="s3">Sore 16.30</label>
          </div>

                              <div class="d-flex justify-content-between align-items-end border-top pt-2 mb-3">
            <span class="fw-bold">Total</span><span class="total" id="rTotal">Rp 120.000</span>
          </div>
          <a href="booking.php" class="btn btn-primary w-100 py-2 rounded-pill">Lanjut ke pemesanan <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- KEUNGGULAN -->
<section class="section">
  <div class="container">
    <div class="row mb-5"><div class="col-lg-7">
      <h2 class="section-title">Kenapa warga Sleman memilih kami</h2>
      <p class="text-muted2">Dari rumah keluarga, kos mahasiswa, sampai apartemen, standar kerja kami sama: bersih, higienis, dan tepat waktu.</p>
    </div></div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3 why-item"><i class="bi bi-pin-map mb-3"></i><h3 class="h5">Dekat dengan Anda</h3><p class="text-muted2 small">Armada berpusat di Depok, jadi tim cepat sampai ke seluruh 17 kecamatan.</p></div>
      <div class="col-md-6 col-lg-3 why-item"><i class="bi bi-droplet-half mb-3"></i><h3 class="h5">Alat dan bahan higienis</h3><p class="text-muted2 small">Cairan pembersih aman untuk anak dan hewan, lap microfiber dibedakan per area.</p></div>
      <div class="col-md-6 col-lg-3 why-item"><i class="bi bi-calendar2-week mb-3"></i><h3 class="h5">Jadwal otomatis</h3><p class="text-muted2 small">Sistem memeriksa slot yang masih kosong, sehingga tidak ada jadwal bentrok.</p></div>
      <div class="col-md-6 col-lg-3 why-item"><i class="bi bi-receipt mb-3"></i><h3 class="h5">Harga flat</h3><p class="text-muted2 small">Satu harga untuk seluruh kecamatan di Sleman, tanpa biaya tambahan di akhir.</p></div>
    </div>
  </div>
</section>

<!-- PAKET -->
<section class="section" id="paket" style="background:var(--sc-mint)">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Dua paket, sesuai kebutuhan rumah Anda</h2>
      <p class="text-muted2">Harga sama untuk seluruh kecamatan di Sleman, tanpa biaya tambahan.</p>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-lg-5">
        <div class="pkg p-4 h-100 d-flex flex-column">
          <div class="d-flex justify-content-between align-items-start">
            <div><h3 class="h4 mb-0">Standard Cleaning</h3><small class="text-muted2"><i class="bi bi-clock"></i> Sekitar 3 jam</small></div>
            <span class="badge text-bg-dark">Paling populer</span>
          </div>
          <div class="price my-3">Rp 120.000</div>
          <p class="text-muted2 small">Pembersihan rutin harian: menyapu, mengepel, membersihkan debu perabot, merapikan kamar, dan membuang sampah.</p>
          <ul class="list-unstyled small mb-4">
            <li><i class="bi bi-check-circle-fill me-2"></i>Menyapu dan mengepel seluruh lantai</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Membersihkan debu meja, kursi, dan kabinet</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Merapikan kasur dan kamar tidur</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Membersihkan wastafel dan area dapur</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Mengumpulkan sampah ke tempat penampungan</li>
          </ul>
          <a href="booking.php?paket=standard" class="btn btn-dark rounded-pill mt-auto">Pilih Standard</a>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="pkg featured p-4 h-100 d-flex flex-column">
          <div class="d-flex justify-content-between align-items-start">
            <div><h3 class="h4 mb-0">Deep Cleaning</h3><small class="text-muted2"><i class="bi bi-clock"></i> Sekitar 5 jam</small></div>
            <span class="badge text-bg-success">Paling menyeluruh</span>
          </div>
          <div class="price my-3">Rp 250.000</div>
          <p class="text-muted2 small">Menyasar kerak kamar mandi, noda membandel, dapur berminyak, dan sudut yang jarang tersentuh.</p>
          <ul class="list-unstyled small mb-4">
            <li><i class="bi bi-check-circle-fill me-2"></i>Semua cakupan paket Standard</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Menyikat kerak kamar mandi dan dinding</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Disinfeksi sanitasi kloset dan area lembap</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Menghilangkan minyak kompor dan dinding dapur</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Vakum sudut sempit, kolong perabot, dan kusen jendela</li>
            <li><i class="bi bi-check-circle-fill me-2"></i>Membersihkan sarang laba-laba dan plafon</li>
          </ul>
          <a href="booking.php?paket=deep" class="btn btn-primary rounded-pill mt-auto">Pilih Deep Cleaning</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ALUR -->
<section class="section" id="alur">
  <div class="container">
    <h2 class="section-title mb-5">Pesan dalam 4 langkah</h2>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3"><div class="step-num mb-3">1</div><h3 class="h5">Pilih paket dan lokasi</h3><p class="text-muted2 small">Tentukan paket, kecamatan, dan tulis alamat lengkap Anda.</p></div>
      <div class="col-md-6 col-lg-3"><div class="step-num mb-3">2</div><h3 class="h5">Pilih jadwal</h3><p class="text-muted2 small">Pesan minimal H-1, lalu ambil slot pagi, siang, atau sore.</p></div>
      <div class="col-md-6 col-lg-3"><div class="step-num mb-3">3</div><h3 class="h5">Simulasi pembayaran</h3><p class="text-muted2 small">Bayar lewat QRIS atau transfer bank, ringkasannya dikirim sebelum final.</p></div>
      <div class="col-md-6 col-lg-3"><div class="step-num mb-3">4</div><h3 class="h5">Tim datang</h3><p class="text-muted2 small">Petugas dialokasikan otomatis dan tiba sesuai jadwal. Rumah bersih, Anda tinggal duduk.</p></div>
    </div>
  </div>
</section>

<!-- TESTIMONI -->
<section class="section" style="background:var(--sc-mint)">
  <div class="container">
    <h2 class="section-title mb-2">Kata pelanggan kami</h2>
    <p class="text-muted2 mb-5">Pengalaman warga Sleman yang sudah mencoba layanan SlemanClean.</p>
    <div class="row g-3">
      <div class="col-md-6 col-lg-3"><div class="quote p-4"><div class="stars mb-2">★★★★★</div><p class="small">“Dapur saya penuh bekas minyak, setelah Deep Cleaning jadi kinclong. Timnya ramah dan rapi.”</p><strong class="d-block small">Amanda Putri</strong><small class="text-muted2">Condongcatur, Depok</small></div></div>
      <div class="col-md-6 col-lg-3"><div class="quote p-4"><div class="stars mb-2">★★★★★</div><p class="small">“Booking lewat web gampang, slot jelas, dan timnya datang tepat waktu.”</p><strong class="d-block small">Rizky Firmansyah</strong><small class="text-muted2">Sariharjo, Ngaglik</small></div></div>
      <div class="col-md-6 col-lg-3"><div class="quote p-4"><div class="stars mb-2">★★★★★</div><p class="small">“Kamar mandi yang tadinya berkerak sekarang bersih lagi. Harganya sepadan.”</p><strong class="d-block small">Ibu Heni Wahyuni</strong><small class="text-muted2">Sinduadi, Mlati</small></div></div>
      <div class="col-md-6 col-lg-3"><div class="quote p-4"><div class="stars mb-2">★★★★★</div><p class="small">“Rumah saya di Kalasan, harganya sama dengan yang di Depok. Jelas dan tanpa biaya tambahan.”</p><strong class="d-block small">Danang Setiawan</strong><small class="text-muted2">Purwomartani, Kalasan</small></div></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="pb-5">
  <div class="container">
    <div class="cta p-5 text-center">
      <h2 class="section-title mb-3">Siap melihat rumah bersih lagi?</h2>
      <p class="opacity-75 mx-auto mb-4" style="max-width:34rem">Serahkan urusan bersih-bersih ke tim SlemanClean, Anda fokus ke hal lain.</p>
      <a href="booking.php" class="btn btn-sun btn-lg rounded-pill px-4"><i class="bi bi-calendar-check me-2"></i>Pesan sekarang</a>
    </div>
  </div>
</section>


<?php include __DIR__ . '/includes/footer.php'; ?>
