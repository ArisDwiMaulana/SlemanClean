<?php
if (session_status() === PHP_SESSION_NONE){
    session_start();
} 

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}
function require_login(): void {
    if (!current_user()) { 
        header('Location: login.php'); 
        exit(); 
    }
}

function is_admin(): void {
        require_login();
        $user = current_user();
        if (($user['role'] ?? '') !== 'admin') {
            header('Location: dashboard.php');
            exit;
        }
    }
