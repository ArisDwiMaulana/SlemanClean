<?php
$aktif = array_filter($orders, fn($o) => $o[5] !== 'Dibatalkan');
$omzet = array_sum(array_map('order_total', $aktif));
$hitung = fn($s) => count(array_filter($orders, fn($o) => $o[5] === $s));
?>
<div class="dash-hero admin d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
  <div><span class="badge text-bg-danger mb-2">PANEL MANAJEMEN EKSEKUTIF</span> <small class="opacity-75 ms-1">Pusat Depok, Sleman</small>
    <h1 class="h2 fw-bold">Super Admin Dashboard</h1>
    <p class="mb-0 opacity-75" style="max-width:40rem">Pantau seluruh perputaran transaksi, verifikasi simulasi keuangan, kelola status pesanan, dan manajemen armada tim kebersihan se-Kabupaten Sleman.</p></div>
  <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalTim"><i class="bi bi-person-plus me-1"></i>Tambah Tim Baru</button>
</div>
<div class="row g-3 mb-4">
  <?php foreach ([['Omzet Simulasi', rupiah($omzet), 'Total akumulasi transaksi non-batal'], ['Total Transaksi', count($orders), 'Pesanan dari seluruh 17 kecamatan'],
      ['Progres Layanan', $hitung('Diproses') . ' diproses / ' . $hitung('Selesai') . ' selesai', $hitung('Dibatalkan') . ' pesanan dibatalkan'], ['Armada Tim', count($tim), 'Tim pembersih siap operasional']] as [$t, $n, $d]): ?>
  <div class="col-md-6 col-lg-3"><div class="panel stat p-3 h-100"><small class="text-muted2 fw-bold text-uppercase"><?= $t ?></small><div class="num fs-3 mt-2"><?= $n ?></div><small class="text-muted2"><?= $d ?></small></div></div>
  <?php endforeach; ?>
</div>

<section class="panel overflow-hidden mb-4">
  <div class="p-4 pb-3 d-flex flex-wrap justify-content-between gap-2">
    <div><h2 class="h5 fw-bold mb-0">Master Transaksi Lintas Seluruh Tim</h2><small class="text-muted2">Monitor dan lakukan intervensi administratif perubahan status pada setiap pesanan</small></div>
    <div class="d-flex gap-1 flex-wrap align-items-start" id="filter">
      <button class="btn btn-sm btn-dark rounded-pill" data-f="">Semua (<?= count($orders) ?>)</button>
      <?php foreach (['Diproses' => 'warning', 'Selesai' => 'success', 'Dibatalkan' => 'danger'] as $s => $c): ?>
      <button class="btn btn-sm btn-outline-<?= $c ?> rounded-pill" data-f="<?= $s ?>"><?= $s ?> (<?= $hitung($s) ?>)</button><?php endforeach; ?>
    </div>
  </div>
  <div class="table-responsive"><table class="table tbl mb-0">
    <thead><tr><th>No. Order</th><th>Pelanggan &amp; Kontak</th><th>Jadwal &amp; Slot</th><th>Paket &amp; Biaya</th><th>Tim Bertugas</th><th>Status Saat Ini</th><th>Intervensi Status</th></tr></thead>
    <tbody>
    <?php foreach ($orders as $o): ?>
      <tr data-status="<?= $o[5] ?>"><td class="mono"><?= $o[0] ?></td>
        <td><strong><?= $o[6] ?></strong><br><small class="text-success"><i class="bi bi-whatsapp"></i> <?= $o[7] ?></small></td>
        <td><?= $o[1] ?><br><small class="text-muted2">13:00 - 16:00 WIB · Kec. <?= $o[2] ?></small></td>
        <td><strong><?= $paket[$o[3]]['nama'] ?></strong><br><span class="text-success fw-bold"><?= rupiah(order_total($o)) ?></span></td>
        <td><span class="team-tag"><i class="bi bi-people-fill"></i> <?= $o[4] ?></span></td>
        <td><?= status_badge($o[5]) ?></td>
        <td><!-- TODO backend: POST ke dashboard.php (aksi=ubah_status) -->
          <form method="post" class="d-flex gap-1"><input type="hidden" name="no_order" value="<?= $o[0] ?>">
            <select name="status" class="form-select form-select-sm" style="width:125px"><?php foreach (['Diproses', 'Selesai', 'Dibatalkan'] as $s): ?><option <?= $s === $o[5] ? 'selected' : '' ?>><?= $s ?></option><?php endforeach; ?></select>
            <button class="btn btn-sm btn-dark" title="Simpan"><i class="bi bi-floppy-fill"></i></button></form></td></tr>
    <?php endforeach; ?>
    </tbody></table></div>
</section>

<section class="panel overflow-hidden">
  <div class="p-4 pb-3 d-flex justify-content-between flex-wrap gap-2"><div><h2 class="h5 fw-bold mb-0">Manajemen Armada Tim</h2><small class="text-muted2">Daftar tim pembersih, penanggung jawab, dan kontrol status operasional</small></div>
    <button class="btn btn-dark btn-sm align-self-start" data-bs-toggle="modal" data-bs-target="#modalTim"><i class="bi bi-plus-lg"></i> Tambah Armada Tim</button></div>
  <div class="table-responsive"><table class="table tbl mb-0">
    <thead><tr><th>ID</th><th>Nama Tim</th><th>Penanggung Jawab</th><th>Kontak WhatsApp</th><th>Beban Tugas</th><th>Status Operasional</th><th>Toggle</th></tr></thead>
    <tbody>
    <?php foreach ($tim as $t):
      $ak = count(array_filter($orders, fn($o) => $o[4] === $t['nama'] && $o[5] === 'Diproses'));
      $ts = count(array_filter($orders, fn($o) => $o[4] === $t['nama'] && $o[5] === 'Selesai')); ?>
      <tr><td class="text-muted2">#<?= $t['id'] ?></td><td><strong><?= $t['nama'] ?></strong></td>
        <td><strong><?= $t['ketua'] ?></strong></td>
        <td><span class="team-tag"><i class="bi bi-whatsapp"></i> <?= $t['wa'] ?></span></td>
        <td><span class="pill pill-warning"><?= $ak ?> Aktif</span> <span class="pill pill-success"><?= $ts ?> Tuntas</span></td>
        <td><span class="pill pill-success">● Aktif Menerima Order</span></td>
        <td><button class="btn btn-sm btn-outline-danger">Nonaktifkan</button></td></tr>
    <?php endforeach; ?>
    </tbody></table></div>
</section>

<div class="modal fade" id="modalTim" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><form method="post" class="modal-content"> <!-- TODO backend: simpan tim baru -->
  <div class="modal-header"><h2 class="modal-title h5">Tambah Tim Baru</h2><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
  <div class="modal-body">
    <label class="lbl mb-1">Nama tim</label><input name="nama_tim" class="form-control mb-3" required>
    <label class="lbl mb-1">Nama penanggung jawab</label><input name="ketua" class="form-control mb-3" required>
    <label class="lbl mb-1">WhatsApp</label><input name="wa" class="form-control" required></div>
  <div class="modal-footer"><button class="btn btn-primary">Simpan Tim</button></div>
</form></div></div>
<script>
document.querySelectorAll('#filter button').forEach(b => b.onclick = () => document.querySelectorAll('tbody tr[data-status]').forEach(r => r.hidden = b.dataset.f && r.dataset.status !== b.dataset.f));
</script>
