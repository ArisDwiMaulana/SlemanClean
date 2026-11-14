<?php
// =====================================================================
// AUTH GUARD (versi tampilan/demo). Teman backend: ganti isi file ini
// dengan pengecekan session login yang asli, lalu set DEMO_MODE = false.
// Aturan yang dipakai view: $_SESSION['user'] = ['nama','email','role']
// role: 'admin' | 'customer'
// =====================================================================
if (session_status() === PHP_SESSION_NONE) session_start();
const DEMO_MODE = true;

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}
function require_login(): void {
    if (!current_user()) { header('Location: login.php'); exit; }
}
