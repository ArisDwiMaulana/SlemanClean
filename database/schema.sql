-- =====================================================================
-- DATABASE SCHEMA & SEED DATA: SLEMANCLEAN
-- Web Layanan Jasa Kebersihan Rumah di Seluruh Kecamatan Kabupaten Sleman
-- =====================================================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS slemanclean_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE slemanclean_db;

-- ---------------------------------------------------------------------
-- 1. TABEL USERS (Pelanggan dan Super Admin)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    no_wa VARCHAR(20) NOT NULL,
    kecamatan_asal VARCHAR(50) NULL,
    alamat_asal TEXT NULL,
    role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 2. TABEL KECAMATAN (17 Kecamatan di Kabupaten Sleman)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS kecamatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 3. TABEL SLOT WAKTU (Sesi Pengerjaan Kebersihan)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS slot_waktu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL,
    jam VARCHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 4. TABEL PAKET LAYANAN
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS paket_layanan (
    id VARCHAR(20) PRIMARY KEY, -- 'standard' atau 'deep'
    nama VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    durasi VARCHAR(50) NOT NULL,
    deskripsi TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 5. TABEL TIM KEBERSIHAN (Armada Operasional Lapangan)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tim_kebersihan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    ketua VARCHAR(100) NOT NULL,
    email VARCHAR(100) NULL,
    wa VARCHAR(20) NOT NULL,
    status_operasional ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 6. TABEL PESANAN (Transaksi Booking Layanan)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_order VARCHAR(30) NOT NULL UNIQUE,
    user_id INT NOT NULL,
    paket_id VARCHAR(20) NOT NULL,
    kecamatan_id INT NOT NULL,
    slot_id INT NOT NULL,
    tim_id INT NULL,
    alamat_lengkap TEXT NOT NULL,
    tanggal DATE NOT NULL,
    catatan TEXT NULL,
    total_biaya INT NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    status_pembayaran ENUM('Lunas', 'Pending') NOT NULL DEFAULT 'Lunas',
    status_pesanan ENUM('Diproses', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Diproses',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pesanan_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_pesanan_paket FOREIGN KEY (paket_id) REFERENCES paket_layanan(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pesanan_kecamatan FOREIGN KEY (kecamatan_id) REFERENCES kecamatan(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pesanan_slot FOREIGN KEY (slot_id) REFERENCES slot_waktu(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pesanan_tim FOREIGN KEY (tim_id) REFERENCES tim_kebersihan(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =====================================================================
-- SEED DATA AWAL (Data Awal Sesuai Mock Data)
-- =====================================================================

-- 1. Akun Pengguna Awal
-- Catatan:
-- Password untuk admin: 'admin123'
-- Password untuk customer (siti, doni, juned): 'password123'
INSERT INTO users (id, nama, email, password, no_wa, kecamatan_asal, alamat_asal, role) VALUES
(1, 'Admin SlemanClean', 'admin@slemanclean.id', '$2y$10$oM0AXMzoyDpVXQahcMSI8OW1rnDNpNPILpItsltItiq2ixh0veU82', '081200000000', 'Depok', 'Kantor Operasional Depok, Sleman', 'admin'),
(2, 'Siti Rahmawati', 'siti@gmail.com', '$2y$10$if/vCc2wWzPSM/kLaMjb1en4ByKs774HL8zloCCxpsTKJk.eca5E2', '085712345678', 'Kalasan', 'Jl. Solo KM 12, Kalasan, Sleman', 'customer'),
(3, 'Doni Kusuma', 'doni@gmail.com', '$2y$10$if/vCc2wWzPSM/kLaMjb1en4ByKs774HL8zloCCxpsTKJk.eca5E2', '087890123456', 'Prambanan', 'Jl. Prambanan No. 5, Sleman', 'customer'),
(4, 'Juned', 'juned@gmail.com', '$2y$10$if/vCc2wWzPSM/kLaMjb1en4ByKs774HL8zloCCxpsTKJk.eca5E2', '081234567890', 'Depok', 'Perum Condongcatur Asri B-4, Depok, Sleman', 'customer')
ON DUPLICATE KEY UPDATE id=id;

-- 2. Daftar 17 Kecamatan di Sleman
INSERT INTO kecamatan (id, nama) VALUES
(1, 'Berbah'),
(2, 'Cangkringan'),
(3, 'Depok'),
(4, 'Gamping'),
(5, 'Godean'),
(6, 'Kalasan'),
(7, 'Minggir'),
(8, 'Mlati'),
(9, 'Moyudan'),
(10, 'Ngaglik'),
(11, 'Ngemplak'),
(12, 'Pakem'),
(13, 'Prambanan'),
(14, 'Seyegan'),
(15, 'Sleman'),
(16, 'Tempel'),
(17, 'Turi')
ON DUPLICATE KEY UPDATE nama=nama;

-- 3. Daftar Slot Waktu
INSERT INTO slot_waktu (id, nama, jam) VALUES
(1, 'Slot 1 (Pagi)', '08:00 - 11:00'),
(2, 'Slot 2 (Siang)', '13:00 - 16:00'),
(3, 'Slot 3 (Sore)', '16:30 - 19:30')
ON DUPLICATE KEY UPDATE id=id;

-- 4. Daftar Paket Layanan
INSERT INTO paket_layanan (id, nama, harga, durasi, deskripsi) VALUES
('standard', 'Standard Cleaning', 120000, '~3 Jam', 'Pembersihan rutin: sapu, pel, debu perabot, kamar, dan sampah.'),
('deep', 'Deep Cleaning', 250000, '~5 Jam', 'Pembersihan menyeluruh: kerak kamar mandi, noda dapur, disinfeksi sanitasi.')
ON DUPLICATE KEY UPDATE id=id;

-- 5. Daftar Tim Kebersihan
INSERT INTO tim_kebersihan (id, nama, ketua, email, wa, status_operasional) VALUES
(1, 'Tim Merapi Clean', 'Ahmad Fauzi', 'tim.merapi@slemanclean.id', '081223344550', 'aktif'),
(2, 'Tim Sleman Sembada', 'Bagus Pratama', 'tim.sembada@slemanclean.id', '081334455660', 'aktif'),
(3, 'Tim Kaliurang Bersih', 'Chandra Wijaya', 'tim.kaliurang@slemanclean.id', '081556677880', 'aktif')
ON DUPLICATE KEY UPDATE id=id;

-- 6. Riwayat Pesanan Contoh (Mock Orders)
INSERT INTO pesanan (no_order, user_id, paket_id, kecamatan_id, slot_id, tim_id, alamat_lengkap, tanggal, catatan, total_biaya, metode_pembayaran, status_pembayaran, status_pesanan) VALUES
('SC-20270125-1C34', 2, 'deep', 6, 2, 3, 'Jl. Solo KM 12, Kalasan', '2027-01-25', 'Fokus kamar mandi', 250000, 'QRIS', 'Lunas', 'Diproses'),
('SC-20270125-A2B2', 2, 'standard', 3, 2, 3, 'Condongcatur, Depok', '2027-01-25', NULL, 120000, 'Transfer Bank', 'Lunas', 'Dibatalkan'),
('SC-20270125-8148', 2, 'standard', 3, 2, 2, 'Condongcatur, Depok', '2027-01-25', NULL, 120000, 'QRIS', 'Lunas', 'Selesai'),
('SC-20270125-64EF', 2, 'standard', 3, 2, 1, 'Condongcatur, Depok', '2027-01-25', NULL, 120000, 'QRIS', 'Lunas', 'Diproses'),
('SC-20261109-9942', 3, 'standard', 13, 1, 1, 'Jl. Prambanan No. 5', '2026-11-09', 'Bersihkan ruang tamu', 120000, 'Transfer Bank', 'Lunas', 'Diproses'),
('SC-20261109-36AA', 4, 'standard', 3, 2, 2, 'Perum Condongcatur Asri B-4', '2026-11-09', NULL, 120000, 'QRIS', 'Lunas', 'Selesai')
ON DUPLICATE KEY UPDATE no_order=no_order;
