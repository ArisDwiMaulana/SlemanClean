<footer class="pt-5 pb-4">
  <div class="container">
    <div class="row g-4 mb-4">
      <div class="col-lg-5">
        <a href="index.php" class="footer-logo mb-3"><img src="assets/img/logo.png" alt="SlemanClean" height="70"></a>
        <p class="small">Layanan jasa kebersihan rumah (home cleaning service) modern dan profesional berbasis di Kecamatan Depok, melayani seluruh 17 kecamatan di Kabupaten Sleman, D.I. Yogyakarta dengan standar higienis tinggi dan transparansi biaya tanpa beban tersembunyi.</p>
        <span class="badge text-bg-secondary me-1"><i class="bi bi-geo-alt-fill"></i> Hub: Kec. Depok, Sleman, DIY</span>
        <span class="badge text-bg-secondary"><i class="bi bi-clock-fill"></i> 08:00 - 19:30 WIB</span>
      </div>
      <div class="col-6 col-lg-3 offset-lg-1">
        <h3 class="h6 text-white mb-3 text-uppercase">Navigasi Cepat</h3>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="index.php#beranda">Beranda Utama</a></li>
          <li class="mb-2"><a href="index.php#paket">Paket Layanan Kebersihan</a></li>
          <li class="mb-2"><a href="booking.php">Form Pemesanan Online</a></li>
          <li><a href="dashboard.php">Dashboard Pesanan</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-3">
        <h3 class="h6 text-white mb-3 text-uppercase">Kontak Layanan</h3>
        <ul class="list-unstyled small">
          <li class="mb-2"><i class="bi bi-geo-alt me-2 text-success"></i>Jl. Ring Road Utara No. 88, Condongcatur, Kec. Depok, Kab. Sleman, D.I. Yogyakarta 55281</li>
          <li class="mb-2"><i class="bi bi-telephone me-2 text-success"></i>(0274) 8899-7711</li>
          <li class="mb-2"><i class="bi bi-whatsapp me-2 text-success"></i>+62 812-3456-7890 (Customer Care)</li>
          <li><i class="bi bi-envelope me-2 text-success"></i>layanan@slemanclean.id</li>
        </ul>
      </div>
    </div>
    <div class="border-top border-secondary pt-3 small d-flex flex-wrap justify-content-between gap-2">
      <span>© <?= date('Y') ?> <strong class="text-white">SlemanClean</strong>. Hak cipta dilindungi undang-undang.</span>
      <span>Spesialis Kebersihan Sleman · Depok Hub Operasional</span>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($page_js)): ?><script src="assets/js/<?= $page_js ?>"></script><?php endif; ?>
</body>
</html>
