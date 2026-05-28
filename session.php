<?php
// =====================================================
// FILE: config/session.php
// FUNGSI: Konfigurasi session
// =====================================================

if (session_status() === PHP_SESSION_NONE) {
    session_name('sirt_session');
    session_set_cookie_params([
        'lifetime' => 7200,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// Fungsi cek login
function isLoggedIn() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

// Fungsi get user login
function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

// Fungsi set flash message
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

// Fungsi get flash message
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Fungsi logout
function doLogout() {
    $_SESSION = [];
    session_destroy();
}
?>