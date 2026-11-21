# SlemanClean – Web Jasa Kebersihan Rumah (Kabupaten Sleman)

> **SlemanClean** adalah aplikasi web pemesanan jasa kebersihan rumah (_home cleaning_) yang melayani seluruh **17 kecamatan di wilayah Kabupaten Sleman**. Didesain dengan tarif transparan dan sistem alokasi armada cerdas yang otomatis mencegah jadwal bentrok.

---

## Gambaran Umum Proyek

Proyek ini dibangun sebagai bagian dari tugas perkuliahan pemrograman web. Mengusung arsitektur **PHP Native Prosedural** yang ringan dan modular, web ini memisahkan peran antara **Pelanggan (Customer)** dan **Super Admin** dalam satu ekosistem terpadu.

### Keunggulan Utama:

- **Tarif Flat & Transparan**: Harga paket pembersihan tetap sama untuk seluruh kecamatan di Kabupaten Sleman tanpa ada biaya tersembunyi.
- **Auto-Allocation & Collision Prevention**: Sistem backend secara otomatis memilih tim kebersihan yang sedang lowong pada tanggal dan jam kerja yang dipilih pelanggan untuk menghindari tugas ganda.
- **Simulasi Pembayaran Interaktif**: Terintegrasi dengan simulasi QRIS dan Virtual Account Transfer Bank.
- **Panel Manajemen Admin**: Kontrol penuh status pesanan, pantauan omzet riil, serta manajemen armada tim kebersihan lapangan.

---

## Fitur Aplikasi

### 1. Pengguna / Pelanggan

- **Autentikasi Akun**: Pendaftaran akun baru dan login aman dengan enkripsi kata sandi `password_hash()` (BCRYPT).
- **Kalkulator Biaya di Beranda**: Estimasi tarif cepat langsung di halaman depan.
- **Pemesanan Kebersihan (_Booking_)**:
  - Pilihan paket: _Standard Cleaning_ (±3 Jam) dan _Deep Cleaning_ (±5 Jam).
  - Pilihan 17 kecamatan di Sleman dan alamat detail rumah.
  - Pilihan tanggal dan 3 sesi slot waktu kerja (Pagi, Siang, Sore).
- **Simulasi Pembayaran**:
  - Konfirmasi metode QRIS (scan e-wallet) atau Transfer Bank (Virtual Account).
  - Fitur ubah pesanan yang mempertahankan data isian formulir sebelumnya tanpa reset.
- **Dashboard Pelanggan**:
  - Statistik total pesanan, layanan dalam proses, dan layanan selesai.
  - Tabel riwayat pemesanan lengkap dengan nomor invoice berformat unik (`SC-YYYYMMDD-XXXX`), tim bertugas, dan status pengerjaan.

### 2. Admin

- **Panel Metrik Eksekutif**: Ringkasan omzet simulasi, total pesanan, progres layanan, dan jumlah armada aktif.
- **Master Transaksi**:
  - Monitoring transaksi lintas seluruh pelanggan dan tim kebersihan.
  - Filter cepat status (_Semua_, _Diproses_, _Selesai_, _Dibatalkan_).
  - Intervensi administratif untuk memperbarui status pesanan.
- **Manajemen Armada Tim**:
  - Memantau daftar tim pembersih beserta beban tugas aktif & tuntas.
  - Kontrol operasional: fitur satu-klik untuk mengaktifkan / menonaktifkan tim.
  - Modal tambah armada tim baru.

---

## Tech Stack

- **Bahasa Pemrograman**: PHP 8.2 (Procedural Style)
- **Ekstensi Basis Data**: MySQLi (`mysqli_connect`, `mysqli_query`, `mysqli_real_escape_string`)
- **Basis Data**: MySQL 8.0
- **Frontend**: HTML5, CSS3 kustom (`assets/css/style.css`), JavaScript Vanilla (`booking.js`, `home.js`)
- **Framework UI**: Bootstrap 5.3.3 & Bootstrap Icons 1.11.3
- **Container / Dev Environment**: Docker Compose (Apache, MySQL, phpMyAdmin) / Kompatibel dengan XAMPP

---

## Struktur Direktori Proyek

```text
SlemanClean/
├── assets/
│   ├── css/
│   │   └── style.css            # Styling visual & tema SlemanClean
│   ├── js/
│   │   ├── booking.js          # Kalkulasi real-time ringkasan booking
│   │   └── home.js             # Kalkulator estimasi biaya di hero beranda
│   └── img/
│       └── logo.png            # Aset logo aplikasi
├── database/
│   └── slemanclean_db.sql      # Skema tabel relasional & seed data awal
├── includes/
│   ├── auth_guard.php          # Manajemen sesi login & proteksi hak akses
│   ├── footer.php              # Komponen footer halaman
│   ├── functions.php           # Fungsi pembantu umum (format rupiah & badge)
│   ├── header.php              # Komponen header & pemanggilan stylesheet
│   └── navbar.php              # Navigasi atas dinamis berbasis role
├── views/
│   ├── dashboard_admin.php     # Tampilan panel kontrol Super Admin
│   └── dashboard_customer.php  # Tampilan riwayat pengerjaan Pelanggan
├── booking.php                 # Halaman formulir pemesanan kebersihan
├── dashboard.php               # Pengendali utama dashboard & aksi admin
├── docker-compose.yml          # Konfigurasi container Apache, MySQL, phpMyAdmin
├── index.php                   # Halaman beranda utama
├── koneksi.php                 # Koneksi database MySQLi (fleksibel Docker/XAMPP)
├── login.php                   # Halaman masuk akun
├── logout.php                  # Proses pembersihan sesi
├── pembayaran.php              # Simulasi pembayaran & pencatatan pesanan
├── register.php                # Halaman pendaftaran akun baru pelanggan
└── README.md                   # Dokumentasi proyek
```

---

## Skema Basis Data

Sistem menggunakan database **`slemanclean_db`** dengan 6 tabel berelasi:

1. **`users`**: Menyimpan identitas akun pelanggan dan admin.
2. **`kecamatan`**: Daftar 17 kecamatan di Kabupaten Sleman.
3. **`slot_waktu`**: Sesi pengerjaan (Slot 1: 08:00–11:00, Slot 2: 13:00–16:00, Slot 3: 16:30–19:30).
4. **`paket_layanan`**: Paket pembersihan (_Standard Cleaning_ & _Deep Cleaning_).
5. **`tim_kebersihan`**: Daftar armada operasional, ketua, kontak WA, dan status aktif/nonaktif.
6. **`pesanan`**: Data transaksi pemesanan dengan relasi Foreign Key ke pelanggan, paket, kecamatan, slot, dan tim.

---

## Panduan Menjalankan Proyek

### Cara 1: Menggunakan Docker Compose (Direkomendasikan)

1. Pastikan Docker Desktop / Docker Engine sudah berjalan.
2. Buka terminal di direktori proyek dan jalankan:
   ```bash
   docker compose up -d
   ```
3. Akses aplikasi:
   - **Web SlemanClean**: [http://localhost](http://localhost)
   - **phpMyAdmin**: [http://localhost:8080](http://localhost:8080) _(Database `slemanclean_db` otomatis terinisialisasi dari `database/slemanclean_db.sql`)_

### Cara 2: Menggunakan XAMPP

1. Salin folder proyek `SlemanClean` ke dalam folder `htdocs` XAMPP Anda.
2. Nyalakan modul **Apache** dan **MySQL** di XAMPP Control Panel.
3. Buka browser ke `http://localhost/phpmyadmin`:
   - Buat database baru bernama `slemanclean_db`.
   - Pilih menu **Import**, lalu unggah file `database/slemanclean_db.sql`.
4. Buka aplikasi di browser:
   - [http://localhost/SlemanClean](http://localhost/SlemanClean)

---

## Akun Pengujian (_Demo Credentials_)

Gunakan akun berikut untuk menguji seluruh alur fungsionalitas sistem:

| Peran (_Role_)     | Email / Username                        | Kata Sandi (_Password_) | Keterangan                                         |
| ------------------ | --------------------------------------- | ----------------------- | -------------------------------------------------- |
| **Super Admin**    | `admin` _(atau `admin@slemanclean.id`)_ | `admin123`              | Akses panel admin, ubah status pesanan, kelola tim |
| **Pelanggan 1**    | `siti@gmail.com`                        | `password123`           | Memiliki riwayat pesanan contoh                    |
| **Pelanggan 2**    | `doni@gmail.com`                        | `password123`           | Pelanggan wilayah Prambanan                        |
| **Pelanggan Baru** | _(Daftar di `register.php`)_            | _(Sesuai pendaftaran)_  | Akun baru untuk uji alur pemesanan awal            |
