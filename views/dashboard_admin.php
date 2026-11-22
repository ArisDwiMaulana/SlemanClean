<?php
// 1. Ambil semua pesanan dari DB
$q_orders = mysqli_query(
    $koneksi,
    "
    SELECT p.*, u.nama AS nama_pelanggan, u.no_wa AS wa_pelanggan, pl.nama AS nama_paket, k.nama AS nama_kecamatan, s.jam AS jam_slot, COALESCE(t.nama, 'Belum
    Ditugaskan') AS nama_tim
    FROM pesanan p
    JOIN users u ON p.user_id = u.id
    JOIN paket_layanan pl ON p.paket_id = pl.id
    JOIN kecamatan k ON p.kecamatan_id = k.id
    JOIN slot_waktu s ON p.slot_id = s.id
    LEFT JOIN tim_kebersihan t ON p.tim_id = t.id
    ORDER BY p.created_at DESC
",
);

$orders = [];
while ($row = mysqli_fetch_assoc($q_orders)) {
    $orders[] = $row;
}

// 2. Ambil data tim dari DB
$q_tim = mysqli_query($koneksi, 'SELECT * FROM tim_kebersihan ORDER BY id ASC');
$tim = [];
while ($row = mysqli_fetch_assoc($q_tim)) {
    $tim[] = $row;
}

// 3. Hitung omzet dan status
$row_omzet = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(total_biaya) AS total FROM pesanan WHERE status_pesanan != 'Dibatalkan'"));
$omzet = (int) ($row_omzet['total'] ?? 0);
$hitung = fn($s) => count(array_filter($orders, fn($o) => $o['status_pesanan'] === $s));
?>

<div class="dash-hero admin d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div><span class="badge text-bg-danger mb-2">PANEL MANAJEMEN EKSEKUTIF</span> <small class="opacity-75 ms-1">Pusat
            Depok, Sleman</small>
        <h1 class="h2 fw-bold">Super Admin Dashboard</h1>
        <p class="mb-0 opacity-75" style="max-width:40rem">Pantau seluruh perputaran transaksi, verifikasi simulasi
            keuangan, kelola status pesanan, dan manajemen armada tim kebersihan se-Kabupaten Sleman.</p>
    </div>
    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalTim"><i
            class="bi bi-person-plus me-1"></i>Tambah Tim Baru</button>
</div>
<div class="row g-3 mb-4">
    <!-- Kartu 1: Omzet Simulasi -->
    <div class="col-md-6 col-lg-3">
        <div class="panel stat p-3 h-100">
            <small class="text-muted2 fw-bold text-uppercase">Omzet Simulasi</small>
            <div class="num fs-3 mt-2 text-success"><?= rupiah($omzet) ?></div>
            <small class="text-muted2">Akumulasi pesanan non-batal</small>
        </div>
    </div>

    <!-- Kartu 2: Total Transaksi -->
    <div class="col-md-6 col-lg-3">
        <div class="panel stat p-3 h-100">
            <small class="text-muted2 fw-bold text-uppercase">Total Transaksi</small>
            <div class="num fs-3 mt-2"><?= count($orders) ?></div>
            <small class="text-muted2">Pesanan dari seluruh 17 kecamatan</small>
        </div>
    </div>

    <!-- Kartu 3: Progres Layanan (3 Status dengan Ukuran Sama Rata) -->
    <div class="col-md-6 col-lg-3">
        <div class="panel stat p-3 h-100 d-flex flex-column justify-content-between">
            <small class="text-muted2 fw-bold text-uppercase">Progres Layanan</small>

            <div class="d-flex justify-content-between text-center my-1 py-1">
                <div>
                    <div class="fw-bold fs-5 text-warning"><?= $hitung('Diproses') ?></div>
                    <small class="text-muted2">Diproses</small>
                </div>
                <div class="border-start border-end px-2">
                    <div class="fw-bold fs-5 text-success"><?= $hitung('Selesai') ?></div>
                    <small class="text-muted2">Selesai</small>
                </div>
                <div>
                    <div class="fw-bold fs-5 text-danger"><?= $hitung('Dibatalkan') ?></div>
                    <small class="text-muted2">Dibatalkan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu 4: Armada Tim -->
    <div class="col-md-6 col-lg-3">
        <div class="panel stat p-3 h-100">
            <small class="text-muted2 fw-bold text-uppercase">Armada Tim</small>
            <div class="num fs-3 mt-2"><?= count($tim) ?></div>
            <small class="text-muted2">Tim pembersih siap operasional</small>
        </div>
    </div>
</div>

<section class="panel overflow-hidden mb-4">
    <div class="p-4 pb-3 d-flex flex-wrap justify-content-between gap-2">
        <div>
            <h2 class="h5 fw-bold mb-0">Master Transaksi Lintas Seluruh Tim</h2><small class="text-muted2">Monitor dan
                lakukan intervensi administratif perubahan status pada setiap pesanan</small>
        </div>
        <div class="d-flex gap-1 flex-wrap align-items-start" id="filter">
            <button class="btn btn-sm btn-dark rounded-pill" data-f="">Semua (<?= count($orders) ?>)</button>
            <?php foreach (['Diproses' => 'warning', 'Selesai' => 'success', 'Dibatalkan' => 'danger'] as $s => $c): ?>
            <button class="btn btn-sm btn-outline-<?= $c ?> rounded-pill" data-f="<?= $s ?>"><?= $s ?>
                (<?= $hitung($s) ?>)</button><?php endforeach; ?>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table tbl mb-0">
            <thead>
                <tr>
                    <th>No. Order</th>
                    <th>Pelanggan &amp; Kontak</th>
                    <th>Jadwal &amp; Slot</th>
                    <th>Paket &amp; Biaya</th>
                    <th>Tim Bertugas</th>
                    <th>Status Saat Ini</th>
                    <th>Intervensi Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr data-status="<?= $o['status_pesanan'] ?>">
                    <td class="mono"><?= $o['no_order'] ?></td>
                    <td><strong><?= $o['nama_pelanggan'] ?></strong><br><small class="text-success"><i
                                class="bi bi-whatsapp"></i> <?= $o['wa_pelanggan'] ?></small></td>
                    <td><?= date('d M Y', strtotime($o['tanggal'])) ?><br><small
                            class="text-muted2"><?= $o['jam_slot'] ?> · Kec. <?= $o['nama_kecamatan'] ?></small></td>
                    <td><strong><?= $o['nama_paket'] ?></strong><br><span
                            class="text-success fw-bold"><?= rupiah($o['total_biaya']) ?></span></td>
                    <td><span class="team-tag"><i class="bi bi-people-fill"></i> <?= $o['nama_tim'] ?></span></td>
                    <td><?= status_badge($o['status_pesanan']) ?></td>
                    <td><!-- TODO backend: POST ke dashboard.php (aksi=ubah_status) -->
                        <form method="post" class="d-flex gap-1">
                            <input type="hidden" name="aksi" value="ubah_status">
                            <input type="hidden" name="no_order" value="<?= $o['no_order'] ?>">
                            <select name="status" class="form-select form-select-sm" style="width:125px">
                                <?php foreach (['Diproses', 'Selesai', 'Dibatalkan'] as $s): ?>
                                <option value="<?= $s ?>" <?= $s === $o['status_pesanan'] ? 'selected' : '' ?>><?= $s ?>
                                </option>
                                <?php endforeach; ?>
                            </select>

                            <button class="btn btn-sm btn-dark" type="submit" title="Simpan"><i
                                    class="bi bi-floppy-fill"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="panel overflow-hidden">
    <div class="p-4 pb-3 d-flex justify-content-between flex-wrap gap-2">
        <div>
            <h2 class="h5 fw-bold mb-0">Manajemen Armada Tim</h2><small class="text-muted2">Daftar tim pembersih,
                penanggung jawab, dan kontrol status operasional</small>
        </div>
        <button class="btn btn-dark btn-sm align-self-start" data-bs-toggle="modal" data-bs-target="#modalTim"><i
                class="bi bi-plus-lg"></i> Tambah Armada Tim</button>
    </div>
    <div class="table-responsive">
        <table class="table tbl mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Tim</th>
                    <th>Penanggung Jawab</th>
                    <th>Kontak WhatsApp</th>
                    <th>Beban Tugas</th>
                    <th>Status Operasional</th>
                    <th>Toggle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tim as $t):
      $ak = count(array_filter($orders, fn($o) => $o['nama_tim'] === $t['nama'] && $o['status_pesanan'] === 'Diproses'));
      $ts = count(array_filter($orders, fn($o) => $o['nama_tim'] === $t['nama'] && $o['status_pesanan'] === 'Selesai')); ?>
                <tr>
                    <td class="text-muted2">#<?= $t['id'] ?></td>
                    <td><strong><?= $t['nama'] ?></strong></td>
                    <td><strong><?= $t['ketua'] ?></strong></td>
                    <td><span class="team-tag"><i class="bi bi-whatsapp"></i> <?= $t['wa'] ?></span></td>
                    <td><span class="pill pill-warning"><?= $ak ?> Aktif</span> <span
                            class="pill pill-success"><?= $ts ?> Tuntas</span></td>
                    <td>
                        <?php if ($t['status_operasional'] === 'aktif'): ?>
                        <span class="pill pill-success">● Aktif Menerima Order</span>
                        <?php else: ?>
                        <span class="pill pill-danger">○ Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="aksi" value="toggle_tim">
                            <input type="hidden" name="tim_id" value="<?= $t['id'] ?>">
                            <?php if ($t['status_operasional'] === 'aktif'): ?>
                            <button class="btn btn-sm btn-outline-danger" type="submit">Nonaktifkan</button>
                            <?php else: ?>
                            <button class="btn btn-sm btn-outline-success" type="submit">Aktifkan</button>
                            <?php endif; ?>
                        </form>
                    </td>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="modalTim" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" class="modal-content"> <!-- TODO backend: simpan tim baru -->
            <input type="hidden" name="aksi" value="tambah_tim">
            <div class="modal-header">
                <h2 class="modal-title h5">Tambah Tim Baru</h2><button type="button" class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="lbl mb-1">Nama tim</label><input name="nama_tim" class="form-control mb-3" required>
                <label class="lbl mb-1">Nama penanggung jawab</label><input name="ketua" class="form-control mb-3"
                    required>
                <label class="lbl mb-1">WhatsApp</label><input name="wa" class="form-control" required>
            </div>
            <div class="modal-footer"><button class="btn btn-primary">Simpan Tim</button></div>
        </form>
    </div>
</div>
<script>
    document.querySelectorAll('#filter button').forEach(b => b.onclick = () => document.querySelectorAll(
        'tbody tr[data-status]').forEach(r => r.hidden = b.dataset.f && r.dataset.status !== b.dataset.f));
</script>
