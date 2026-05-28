<?php
// =====================================================
// FILE: middleware/AuthMiddleware.php
// FUNGSI: Memastikan user sudah login
// =====================================================

function authMiddleware() {
    if (!isLoggedIn()) {
        setFlash('error', 'Silakan login terlebih dahulu');
        redirect('index.php?action=login');
        exit();
    }
}

function guestMiddleware() {
    if (isLoggedIn()) {
        redirect('index.php?action=dashboard');
        exit();
    }
}
?>