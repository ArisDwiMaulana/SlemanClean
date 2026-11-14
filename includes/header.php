<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/mock_data.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($judul_halaman ?? 'SlemanClean – Jasa Kebersihan Rumah di Sleman') ?></title>
<link rel="icon" href="assets/img/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include __DIR__ . '/navbar.php'; ?>
