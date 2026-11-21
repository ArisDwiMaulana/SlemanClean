<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/koneksi.php';
require_login();
$user = current_user();

// Ambil data paket
$res_pkt = mysqli_query($koneksi, 'SELECT * FROM paket_layanan');
$paket = [];
while ($row = mysqli_fetch_assoc($res_pkt)) {
    $paket[$row['id']] = [
        'nama' => $row['nama'],
        'harga' => (int) $row['harga'],
        'durasi' => $row['durasi'],
    ];
}

// Ambil data kecamatan
$res_kec = mysqli_query($koneksi, 'SELECT id, nama FROM kecamatan');
$kecamatan = [];
$kec_map = []; // Memetakan Nama Kecamatan -> ID Kecamatan di database
while ($row = mysqli_fetch_assoc($res_kec)) {
    $kecamatan[] = $row['nama'];
    $kec_map[$row['nama']] = (int) $row['id'];
}

// Ambil data slot waktu
$res_slot = mysqli_query($koneksi, 'SELECT * FROM slot_waktu');
$slots = [];
while ($row = mysqli_fetch_assoc($res_slot)) {
    $slots[$row['id']] = [$row['nama'], $row['jam']];
}

// Menyimpan data pesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate kode unik, contoh: SC-20261121-4F2A
    $no_order = 'SC-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

    $user_id = (int) $user['id'];
    $paket_id = mysqli_real_escape_string($koneksi, $_POST['paket'] ?? 'standard');
    $nama_kec = $_POST['kecamatan'] ?? '';
    $kecamatan_id = $kec_map[$nama_kec] ?? 1;
    $slot_id = (int) ($_POST['slot'] ?? 1);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat'] ?? '');
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? date('Y-m-d'));
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan'] ?? '');
    $total_biaya = (int) ($paket[$paket_id]['harga'] ?? 120000);
    $metode = mysqli_real_escape_string($koneksi, $_POST['metode'] ?? 'QRIS');

    // Pilih tim yang TIDAK bentrok di tanggal & slot yang sama
    $q_tim = mysqli_query(
        $koneksi,
        "
        SELECT t.id FROM tim_kebersihan t
        LEFT JOIN pesanan p ON t.id = p.tim_id AND p.status_pesanan = 'Diproses'
        WHERE t.status_operasional = 'aktif'
          AND t.id NOT IN (
              -- Abaikan tim yang sudah punya jadwal di tanggal & slot jam yang sama
              SELECT tim_id FROM pesanan
              WHERE tanggal = '$tanggal'
                AND slot_id = $slot_id
                AND status_pesanan = 'Diproses'
                AND tim_id IS NOT NULL
          )
        GROUP BY t.id
        ORDER BY COUNT(p.id) ASC
        LIMIT 1
    ",
    );

    // Jika semua tim sedang penuh di slot tersebut,
    // sistem tetap menugaskan ke tim dengan beban terendah agar order tidak gagal
    if (mysqli_num_rows($q_tim) === 0) {
        $q_tim = mysqli_query(
            $koneksi,
            "
            SELECT t.id FROM tim_kebersihan t
            LEFT JOIN pesanan p ON t.id = p.tim_id AND p.status_pesanan = 'Diproses'
            WHERE t.status_operasional = 'aktif'
            GROUP BY t.id
            ORDER BY COUNT(p.id) ASC
            LIMIT 1
        ",
        );
    }

    $row_tim = mysqli_fetch_assoc($q_tim);
    $tim_id = $row_tim ? (int) $row_tim['id'] : 'NULL';

    // Simpan ke tabel pesanan
    $tim_sql = $tim_id === 'NULL' ? 'NULL' : "$tim_id";
    $sql_insert = "INSERT INTO pesanan
            (no_order, user_id, paket_id, kecamatan_id, slot_id, tim_id, alamat_lengkap, tanggal, catatan, total_biaya, metode_pembayaran, status_pembayaran,
            status_pesanan)
            VALUES
            ('$no_order', $user_id, '$paket_id', $kecamatan_id, $slot_id, $tim_sql, '$alamat', '$tanggal', '$catatan', $total_biaya, '$metode', 'Lunas', 'Diproses')";

    if (mysqli_query($koneksi, $sql_insert)) {
        header('Location: dashboard.php?sukses=1');
        exit();
    } else {
        die('Gagal memproses pesanan: ' . mysqli_error($koneksi));
    }
}

// Validasi awal data yang dikirim dari booking.php
$pk = $paket[$_GET['paket'] ?? ''] ?? null;
$kec = $_GET['kecamatan'] ?? '';
if (!$pk || !in_array($kec, $kecamatan, true)) {
    header('Location: booking.php');
    exit();
}
$total = $pk['harga'];
$slot = $slots[(int) ($_GET['slot'] ?? 1)] ?? $slots[1];
$tgl = $_GET['tanggal'] ?? date('Y-m-d');

$judul_halaman = 'Pembayaran – SlemanClean';
$halaman_aktif = 'booking';
include __DIR__ . '/includes/header.php';
$h = fn($k) => htmlspecialchars($_GET[$k] ?? '');
?>
<main class="page">
    <div class="container" style="max-width:980px">
        <nav class="small text-muted2 mb-2"><a href="booking.php" class="text-muted2 text-decoration-none">Form
                Pemesanan</a> / <span class="text-dark fw-semibold">Pembayaran</span></nav>
        <h1 class="fw-bold">Simulasi Pembayaran</h1>
        <p class="text-muted2 mb-4">Pilih metode pembayaran untuk menyelesaikan pesanan. Ini hanya simulasi, tidak
            ada
            uang yang dipindahkan.</p>

        <!-- TODO backend: POST ke pembayaran.php (field tersembunyi di bawah + metode) -->
        <form method="post" class="row g-4">
            <?php foreach (['paket', 'kecamatan', 'tanggal', 'slot', 'alamat', 'catatan'] as $f): ?><input type="hidden" name="<?= $f ?>" value="<?= $h($f) ?>"><?php endforeach; ?>
            <div class="col-lg-7">
                <section class="panel p-4 calc">
                    <h2 class="h6 fw-bold mb-3"><i class="bi bi-credit-card-2-front text-success me-2"></i>Metode
                        Pembayaran</h2>
                    <label class="opt mb-2"><input class="form-check-input me-2" type="radio" name="metode"
                            value="QRIS" checked>
                        <i class="bi bi-qr-code-scan me-1"></i><strong>QRIS</strong>
                        <div class="small text-muted2 ps-4">Scan dengan e-wallet atau mobile banking</div>
                    </label>
                    <label class="opt mb-3"><input class="form-check-input me-2" type="radio" name="metode"
                            value="Transfer Bank">
                        <i class="bi bi-bank me-1"></i><strong>Transfer Bank (Virtual Account)</strong>
                        <div class="small text-muted2 ps-4">BPD DIY / Mandiri</div>
                    </label>
                    <div id="boxQris" class="text-center border rounded-4 p-4 bg-light"><i class="bi bi-qr-code"
                            style="font-size:6rem"></i>
                        <div class="small text-muted2">QR contoh (simulasi) · berlaku 15 menit</div>
                    </div>
                    <div id="boxVa" class="border rounded-4 p-4 bg-light" hidden>
                        <div class="small text-muted2">Nomor Virtual Account (simulasi)</div>
                        <div class="mono fs-4">8808 1234 5678 9012</div>
                        <div class="small text-muted2">a.n. SlemanClean</div>
                    </div>
                </section>
            </div>
            <div class="col-lg-5">
                <aside class="panel p-4 sticky-sum">
                    <h2 class="h6 fw-bold mb-3">Ringkasan Pesanan</h2>
                    <div class="d-flex justify-content-between"><span><?= $pk['nama'] ?>
                            (<?= $pk['durasi'] ?>)</span><strong><?= rupiah($pk['harga']) ?></strong></div>
                    <div class="small text-muted2 mt-2"><i class="bi bi-geo-alt me-1"></i>Kec.
                        <?= htmlspecialchars($kec) ?></div>
                    <div class="small text-muted2 mt-3"><i
                            class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($tgl)) ?> ·
                        <?= $slot[0] ?> (<?= $slot[1] ?> WIB)</div>
                    <?php if ($h('alamat')): ?><div class="small text-muted2"><i
                            class="bi bi-geo-alt me-1"></i><?= $h('alamat') ?></div><?php endif; ?>
                    <div class="d-flex justify-content-between align-items-end border-top mt-3 pt-3 mb-3">
                        <strong>Total
                            Bayar</strong><span class="total"><?= rupiah($total) ?></span>
                    </div>
                    <button class="btn btn-primary w-100 py-2" type="submit"><i
                            class="bi bi-check2-circle me-1"></i>Konfirmasi Pembayaran (Simulasi)</button>
                    <a href="booking.php?<?= http_build_query($_GET) ?>"
                        class="btn btn-link w-100 text-muted2 mt-1">Ubah pesanan</a>
                </aside>
            </div>
        </form>
    </div>
</main>
<script>
    document.querySelectorAll('input[name=metode]').forEach(r => r.addEventListener('change', () => {
        boxQris.hidden = r.value !== 'QRIS' || !r.checked;
        boxVa.hidden = !boxQris.hidden;
    }));
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
