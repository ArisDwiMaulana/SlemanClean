<?php
// =====================================================================
// DATA SEMENTARA (mock) supaya tampilan bisa dilihat tanpa database.
// Teman backend: ganti variabel di bawah dengan hasil query MySQL.
// =====================================================================
$kecamatan = ['Berbah', 'Cangkringan', 'Depok', 'Gamping', 'Godean', 'Kalasan', 'Minggir', 'Mlati', 'Moyudan',
    'Ngaglik', 'Ngemplak', 'Pakem', 'Prambanan', 'Seyegan', 'Sleman', 'Tempel', 'Turi'];   // 17 kecamatan, harga sama semua
$paket = [
    'standard' => ['nama' => 'Standard Cleaning', 'harga' => 120000, 'durasi' => '~3 Jam', 'desk' => 'Pembersihan rutin: sapu, pel, debu perabot, kamar, dan sampah.'],
    'deep'     => ['nama' => 'Deep Cleaning', 'harga' => 250000, 'durasi' => '~5 Jam', 'desk' => 'Pembersihan menyeluruh: kerak kamar mandi, noda dapur, disinfeksi sanitasi.'],
];
$slots = [1 => ['Slot 1 (Pagi)', '08:00 - 11:00'], 2 => ['Slot 2 (Siang)', '13:00 - 16:00'], 3 => ['Slot 3 (Sore)', '16:30 - 19:30']];

$tim = [
    ['id' => 1, 'nama' => 'Tim Merapi Clean',    'ketua' => 'Ahmad Fauzi',   'email' => 'tim.merapi@slemanclean.id',   'wa' => '081223344550'],
    ['id' => 2, 'nama' => 'Tim Sleman Sembada',  'ketua' => 'Bagus Pratama', 'email' => 'tim.sembada@slemanclean.id',  'wa' => '081334455660'],
    ['id' => 3, 'nama' => 'Tim Kaliurang Bersih','ketua' => 'Chandra Wijaya','email' => 'tim.kaliurang@slemanclean.id','wa' => '081556677880'],
];
// no_order, tanggal, kecamatan, paket, tim, status, pelanggan, wa
$orders = [
    ['SC-20270125-1C34', '25 Jan 2027', 'Kalasan', 'deep',     'Tim Kaliurang Bersih', 'Diproses',   'Siti Rahmawati', '085712345678'],
    ['SC-20270125-A2B2', '25 Jan 2027', 'Depok',   'standard', 'Tim Kaliurang Bersih', 'Dibatalkan', 'Siti Rahmawati', '085712345678'],
    ['SC-20270125-8148', '25 Jan 2027', 'Depok',   'standard', 'Tim Sleman Sembada',   'Selesai',    'Siti Rahmawati', '085712345678'],
    ['SC-20270125-64EF', '25 Jan 2027', 'Depok',   'standard', 'Tim Merapi Clean',     'Diproses',   'Siti Rahmawati', '085712345678'],
    ['SC-20261109-9942', '09 Nov 2026', 'Prambanan','standard','Tim Merapi Clean',     'Diproses',   'Doni Kusuma',    '087890123456'],
    ['SC-20261109-36AA', '09 Nov 2026', 'Depok',   'standard', 'Tim Sleman Sembada',   'Selesai',    'Juned',          '08123456789'],
];

function rupiah(int $n): string { return 'Rp ' . number_format($n, 0, ',', '.'); }
function order_total(array $o): int { global $paket; return $paket[$o[3]]['harga']; }
function status_badge(string $s): string {
    $m = ['Diproses' => ['warning', 'bi-hourglass-split'], 'Selesai' => ['success', 'bi-check-circle-fill'], 'Dibatalkan' => ['danger', 'bi-slash-circle']];
    [$c, $i] = $m[$s];
    return "<span class=\"pill pill-$c\"><i class=\"bi $i\"></i> $s</span>";
}
