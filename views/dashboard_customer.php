<?php
$mine = array_values(array_filter($orders, fn($o) => $o[6] === $user['nama']));
$hitung = fn($s) => count(array_filter($mine, fn($o) => $o[5] === $s));
?>
<?php if (isset($_GET['sukses'])): ?><div class="alert alert-success"><i class="bi bi-check-circle-fill me-1"></i> Pembayaran (simulasi) berhasil. Pesanan Anda sudah dialokasikan ke tim kebersihan.</div><?php endif; ?>
<div class="dash-hero d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
  <div><span class="badge text-bg-light text-success mb-2">DASHBOARD PELANGGAN</span>
    <h1 class="h2 fw-bold">Halo, <?= htmlspecialchars($user['nama']) ?>!</h1>
    <p class="mb-0 opacity-75" style="max-width:36rem">Pantau progres pengerjaan kebersihan rumah Anda di Sleman. Tim profesional kami siap melayani hunian Anda.</p></div>
  <a href="booking.php" class="btn btn-sun btn-lg"><i class="bi bi-plus-lg me-1"></i>Pesan Layanan Baru</a>
</div>
<div class="row g-3 mb-4">
  <?php foreach ([['Total Pesanan Dibuat', count($mine), 'bi-receipt', 'dark'], ['Dalam Proses Pengerjaan', $hitung('Diproses'), 'bi-hourglass-split', 'warning'], ['Layanan Telah Selesai', $hitung('Selesai'), 'bi-check-circle-fill', 'success']] as [$t, $n, $i, $c]): ?>
  <div class="col-md-4"><div class="panel stat p-3 d-flex align-items-center gap-3"><i class="bi <?= $i ?> fs-3 text-<?= $c ?>"></i><div><div class="num text-<?= $c ?>"><?= $n ?></div><small class="text-muted2"><?= $t ?></small></div></div></div>
  <?php endforeach; ?>
</div>
<section class="panel overflow-hidden">
  <div class="p-4 pb-3"><h2 class="h5 fw-bold mb-0">Riwayat Layanan Kebersihan</h2><small class="text-muted2">Daftar seluruh pesanan kebersihan rumah yang telah Anda daftarkan</small></div>
  <div class="table-responsive"><table class="table tbl mb-0">
    <thead><tr><th>No. Pesanan</th><th>Paket Layanan</th><th>Jadwal &amp; Slot</th><th>Kecamatan</th><th>Tim Bertugas</th><th>Total Biaya</th><th>Status</th></tr></thead>
    <tbody>
    <?php foreach ($mine as $o): ?>
      <tr><td class="mono"><?= $o[0] ?></td>
        <td><strong><?= $paket[$o[3]]['nama'] ?></strong><br><small class="text-muted2"><?= $paket[$o[3]]['durasi'] ?> pengerjaan</small></td>
        <td><?= $o[1] ?><br><small class="text-muted2">13:00 - 16:00 WIB</small></td>
        <td><strong>Kec. <?= $o[2] ?></strong></td>
        <td><span class="team-tag"><i class="bi bi-people-fill"></i> <?= $o[4] ?></span></td>
        <td><strong><?= rupiah(order_total($o)) ?></strong><br><small class="text-success">✓ Lunas (Simulasi)</small></td>
        <td><?= status_badge($o[5]) ?></td></tr>
    <?php endforeach; ?>
    <?php if (!$mine): ?><tr><td colspan="7" class="text-center text-muted2 py-4">Belum ada pesanan. Klik "Pesan Layanan Baru" untuk memulai.</td></tr><?php endif; ?>
    </tbody></table></div>
</section>
