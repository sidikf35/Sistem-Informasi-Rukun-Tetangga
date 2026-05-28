<?php
// =====================================================
// FILE: views/dashboard/sekretaris.php
// FUNGSI: Dashboard SEKRETARIS - Dengan menu Verifikasi, Arsip, Backup, Laporan
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sekretaris - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    /* (copy semua style dari file lama, tidak perlu diubah) */
    :root {
        --primary: #0d6efd;
        --primary-dark: #0b5ed7;
        --secondary: #6c757d;
        --success: #198754;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #0dcaf0;
        --dark: #212529;
        --light: #f8f9fa;
        --border-radius: 16px;
        --box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #eef2f7;
        min-height: 100vh;
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100%;
        background: #1e293b;
        color: white;
        transition: var(--transition);
        z-index: 100;
        overflow-y: auto;
    }

    .sidebar-header {
        padding: 30px 25px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header .logo {
        font-size: 28px;
        font-weight: 800;
        color: white;
    }

    .sidebar-header .logo-icon {
        font-size: 40px;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .sidebar-nav .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 25px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        margin: 5px 15px;
        border-radius: 12px;
        transition: var(--transition);
    }

    .sidebar-nav .nav-item i {
        width: 25px;
        margin-right: 12px;
    }

    .sidebar-nav .nav-item:hover {
        background: rgba(13, 110, 253, 0.2);
        color: white;
    }

    .sidebar-nav .nav-item.active {
        background: var(--primary);
        color: white;
    }

    .main-content {
        margin-left: 280px;
        padding: 25px 35px;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 15px 25px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .page-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--dark);
    }

    .page-title p {
        color: var(--secondary);
        font-size: 13px;
        margin-top: 5px;
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        color: white;
    }

    .role-badge {
        font-size: 11px;
        background: #e3f2fd;
        color: var(--primary);
        padding: 4px 10px;
        border-radius: 20px;
    }

    .logout-btn {
        background: #fee2e2;
        color: #dc2626;
        padding: 8px 15px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: var(--transition);
    }

    .logout-btn:hover {
        background: #dc2626;
        color: white;
    }

    .welcome-card {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 35px;
        color: white;
    }

    .welcome-card h2 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        background: #e3f2fd;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--primary);
    }

    .stat-info h3 {
        font-size: 28px;
        font-weight: 800;
        color: var(--dark);
    }

    .stat-info p {
        font-size: 12px;
        color: var(--secondary);
        margin-top: 5px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }

    .menu-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: var(--box-shadow);
        display: block;
    }

    .menu-card:hover {
        transform: translateY(-8px);
    }

    .menu-icon {
        width: 60px;
        height: 60px;
        background: #e3f2fd;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 24px;
        color: var(--primary);
    }

    .menu-card h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--dark);
    }

    .menu-card p {
        font-size: 11px;
        color: var(--secondary);
        margin-top: 5px;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
    }

    @media (max-width: 1024px) {

        .stats-grid,
        .menu-grid {
            gap: 15px;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 0;
            padding: 15px;
        }

        .stats-grid,
        .menu-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-building"></i></div>
            <div class="logo">SIRT</div>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?action=dashboard"
                class="nav-item <?= ($_GET['action'] ?? 'dashboard') == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="index.php?action=warga" class="nav-item <?= ($_GET['action'] ?? '') == 'warga' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Data Warga
            </a>
            <a href="index.php?action=pengajuan-list"
                class="nav-item <?= ($_GET['action'] ?? '') == 'pengajuan-list' ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list"></i> Daftar Pengajuan
            </a>
            <a href="index.php?action=arsip" class="nav-item <?= ($_GET['action'] ?? '') == 'arsip' ? 'active' : '' ?>">
                <i class="fas fa-archive"></i> Arsip Digital
            </a>
            <a href="index.php?action=arsip-backup"
                class="nav-item <?= ($_GET['action'] ?? '') == 'arsip-backup' ? 'active' : '' ?>">
                <i class="fas fa-database"></i> Backup Database
            </a>
            <a href="index.php?action=laporan"
                class="nav-item <?= ($_GET['action'] ?? '') == 'laporan' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            <a href="index.php?action=logout" class="nav-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Dashboard Sekretaris</h1>
                <p><i class="fas fa-calendar-alt"></i> <?= date('l, d F Y') ?></p>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <h4><?= htmlspecialchars($_SESSION['user']['fullname']) ?></h4>
                    <span class="role-badge"><i class="fas fa-file-alt"></i> Sekretaris</span>
                </div>
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['fullname'], 0, 1)) ?></div>
                <a href="index.php?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <?php $flash = getFlash(); ?>
        <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>

        <div class="welcome-card">
            <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['user']['fullname']) ?>! 👨‍💼</h2>
            <p>Anda memiliki akses penuh untuk mengelola administrasi RT.</p>
        </div>

        <!-- Statistik menggunakan $data dari controller -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3><?= $data['total_warga'] ?? 0 ?></h3>
                    <p>Total Warga</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <h3><?= $data['menunggu_verifikasi'] ?? 0 ?></h3>
                    <p>Menunggu Verifikasi</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3><?= $data['total_disetujui'] ?? 0 ?></h3>
                    <p>Disetujui</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-file-pdf"></i></div>
                <div class="stat-info">
                    <h3><?= $data['surat_bulan_ini'] ?? 0 ?></h3>
                    <p>Surat Bulan Ini</p>
                </div>
            </div>
        </div>

        <div class="section-title"><i class="fas fa-cog"></i> Menu Administrasi</div>
        <div class="menu-grid">
            <a href="index.php?action=warga" class="menu-card">
                <div class="menu-icon"><i class="fas fa-users"></i></div>
                <h3>Data Warga</h3>
                <p>Kelola data kependudukan</p>
            </a>
            <a href="index.php?action=pengajuan-list" class="menu-card">
                <div class="menu-icon"><i class="fas fa-check-double"></i></div>
                <h3>Verifikasi</h3>
                <p>Verifikasi pengajuan surat</p>
            </a>
            <a href="index.php?action=arsip" class="menu-card">
                <div class="menu-icon"><i class="fas fa-archive"></i></div>
                <h3>Arsip Surat</h3>
                <p>Lihat arsip digital</p>
            </a>
            <a href="index.php?action=arsip-backup" class="menu-card">
                <div class="menu-icon"><i class="fas fa-database"></i></div>
                <h3>Backup Database</h3>
                <p>Backup & restore data</p>
            </a>
        </div>
    </main>
</body>

</html>