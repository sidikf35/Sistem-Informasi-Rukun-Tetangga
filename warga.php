<?php
// =====================================================
// FILE: views/dashboard/warga.php
// FUNGSI: Dashboard WARGA - Dengan statistik realtime dan riwayat pengajuan
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --secondary: #7209b7;
        --success: #06ffa5;
        --warning: #f9c74f;
        --danger: #f94144;
        --dark: #2b2d42;
        --light: #f8f9fa;
        --gray: #6c757d;
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
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        min-height: 100vh;
    }

    /* ========== SIDEBAR ========== */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100%;
        background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
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
        background: linear-gradient(135deg, #4361ee, #7209b7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .sidebar-header .logo-icon {
        font-size: 40px;
        color: #4361ee;
        margin-bottom: 10px;
    }

    .sidebar-header p {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 5px;
    }

    .sidebar-nav {
        padding: 20px 0;
    }

    .sidebar-nav .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 25px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: var(--transition);
        margin: 5px 15px;
        border-radius: 12px;
    }

    .sidebar-nav .nav-item i {
        width: 25px;
        margin-right: 12px;
        font-size: 18px;
    }

    .sidebar-nav .nav-item:hover {
        background: rgba(67, 97, 238, 0.2);
        color: white;
    }

    .sidebar-nav .nav-item.active {
        background: linear-gradient(135deg, #4361ee, #7209b7);
        color: white;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }

    /* ========== MAIN CONTENT ========== */
    .main-content {
        margin-left: 280px;
        padding: 25px 35px;
    }

    /* ========== TOP BAR ========== */
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
        color: var(--gray);
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
        background: linear-gradient(135deg, #4361ee, #7209b7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 18px;
    }

    .user-info h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
    }

    .user-info .role-badge {
        font-size: 11px;
        background: #e8f0fe;
        color: #4361ee;
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

    /* ========== WELCOME CARD ========== */
    .welcome-card {
        background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 35px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-card h2 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .welcome-card p {
        opacity: 0.9;
        font-size: 14px;
    }

    /* ========== STATS CARD ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, #e8f0fe, #dbeafe);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #4361ee;
    }

    .stat-info h3 {
        font-size: 28px;
        font-weight: 800;
        color: var(--dark);
    }

    .stat-info p {
        color: var(--gray);
        font-size: 13px;
        margin-top: 5px;
    }

    /* ========== TABLE RIWAYAT ========== */
    .content-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-top: 20px;
        box-shadow: var(--box-shadow);
    }

    .content-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .status-verifikasi {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-disetujui {
        background: #d1fae5;
        color: #065f46;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 12px;
        transition: var(--transition);
    }

    .btn-view:hover {
        background: #138496;
    }

    /* ========== MENU GRID ========== */
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .menu-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: var(--box-shadow);
        display: block;
    }

    .menu-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .menu-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #e8f0fe, #dbeafe);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 30px;
        color: #4361ee;
    }

    .menu-card h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .menu-card p {
        font-size: 12px;
        color: var(--gray);
    }

    /* ========== ALERT ========== */
    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: #e6f7e6;
        color: #2e7d32;
        border-left: 4px solid #2e7d32;
    }

    /* ========== RESPONSIVE ========== */
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

        .top-bar {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #4361ee;
        border-radius: 10px;
    }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-people-arrows"></i></div>
            <div class="logo">SIRT</div>
            <p>Sistem Informasi Rukun Tetangga</p>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?action=dashboard"
                class="nav-item <?= ($_GET['action'] ?? 'dashboard') == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="index.php?action=pengajuan-create"
                class="nav-item <?= ($_GET['action'] ?? '') == 'pengajuan-create' ? 'active' : '' ?>">
                <i class="fas fa-file-signature"></i> Pengajuan Surat
            </a>
            <a href="index.php?action=pengajuan-riwayat"
                class="nav-item <?= ($_GET['action'] ?? '') == 'pengajuan-riwayat' ? 'active' : '' ?>">
                <i class="fas fa-history"></i> Riwayat Saya
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-user-circle"></i> Profil Saya
            </a>
            <a href="index.php?action=logout" class="nav-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Dashboard Warga</h1>
                <p><i class="fas fa-calendar-alt"></i> <?= date('l, d F Y') ?></p>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <h4><?= htmlspecialchars($_SESSION['user']['fullname']) ?></h4>
                    <span class="role-badge"><i class="fas fa-user"></i> Warga</span>
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
            <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['user']['fullname']) ?>! 👋</h2>
            <p>Selamat datang di Sistem Informasi Rukun Tetangga. Silakan gunakan layanan pengajuan surat secara online.
            </p>
        </div>

        <!-- STATISTIK (menggunakan $data dari controller) -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                <div class="stat-info">
                    <h3><?= $data['total_pengajuan'] ?? 0 ?></h3>
                    <p>Total Pengajuan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3><?= $data['disetujui'] ?? 0 ?></h3>
                    <p>Disetujui</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <h3><?= $data['menunggu'] ?? 0 ?></h3>
                    <p>Menunggu Verifikasi</p>
                </div>
            </div>
        </div>

        <!-- RIWAYAT PENGAJUAN TERBARU -->
        <div class="content-card">
            <h3><i class="fas fa-history"></i> Riwayat Pengajuan Terbaru</h3>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Jenis Surat</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['riwayat'])): ?>
                        <?php foreach ($data['riwayat'] as $r): ?>
                        <tr>
                            <td><?= str_replace('_', ' ', ucfirst($r['jenis_surat'])) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($r['tanggal_pengajuan'])) ?></td>
                            <td>
                                <span class="status-badge status-<?= $r['status'] ?>">
                                    <?= ucfirst($r['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?action=pengajuan-detail&id=<?= $r['id'] ?>" class="btn-view">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center;">Belum ada pengajuan surat</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MENU LAYANAN -->
        <div class="section-title"><i class="fas fa-star"></i> Layanan Online</div>
        <div class="menu-grid">
            <a href="index.php?action=pengajuan-create" class="menu-card">
                <div class="menu-icon"><i class="fas fa-file-signature"></i></div>
                <h3>Pengajuan Surat</h3>
                <p>Ajukan surat keterangan secara online</p>
            </a>
            <a href="index.php?action=pengajuan-riwayat" class="menu-card">
                <div class="menu-icon"><i class="fas fa-history"></i></div>
                <h3>Riwayat Pengajuan</h3>
                <p>Lihat status pengajuan surat Anda</p>
            </a>
            <a href="#" class="menu-card">
                <div class="menu-icon"><i class="fas fa-download"></i></div>
                <h3>Download Surat</h3>
                <p>Unduh surat yang sudah disetujui</p>
            </a>
        </div>
    </main>
</body>

</html>