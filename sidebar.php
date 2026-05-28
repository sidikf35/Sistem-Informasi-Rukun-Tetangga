<?php
// =====================================================
// FILE: views/partials/sidebar.php
// FUNGSI: Sidebar navigasi (berlaku untuk dashboard)
// =====================================================

$userRole = $_SESSION['user']['role'] ?? '';
$currentUrl = $_GET['action'] ?? 'dashboard';
?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-people-arrows"></i>
            <span>SIRT</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <img src="<?= ASSETS_URL ?>/images/default/avatar.png" alt="Avatar">
        </div>
        <div class="user-info">
            <h4><?= htmlspecialchars($_SESSION['user']['fullname'] ?? 'User') ?></h4>
            <span class="user-role">
                <i
                    class="fas fa-<?= $userRole == 'warga' ? 'user' : ($userRole == 'sekretaris' ? 'file-alt' : 'crown') ?>"></i>
                <?= ucfirst(str_replace('_', ' ', $userRole)) ?>
            </span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="index