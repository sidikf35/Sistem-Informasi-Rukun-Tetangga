<?php
// =====================================================
// FILE: views/dashboard/ketua_rt.php
// FUNGSI: Dashboard KETUA RT - Dengan menu Persetujuan dan Statistik Realtime
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ketua RT - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --primary: #d97706;
        --primary-dark: #b45309;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #111827;
        --light: #f9fafb;
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
        background: #f3f4f6;
        min-height: 100vh;
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100%;
        background: linear-gradient(180deg, #111827 0%, #1f2937 100%);
        color: white;
        z-index: 100;
        overflow-y: auto;
    }

    .sidebar-header {
        padding: 30px 25px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header .logo-icon {
        font-size: 40px;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .sidebar-header .logo {
        font-size: 28px;
        font-weight: 800;
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
        background: rgba(217, 119, 6, 0.2);
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
        color: #6b7280;
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
        color: white;
    }

    .role-badge {
        font-size: 11px;
        background: #fef3c7;
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
        transition: var(--transition);
    }

    .logout-btn:hover {
        background: #dc2626;
        color: white;
    }

    .welcome-card {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
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
        grid-template-columns: repeat(3, 1fr);
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
        background: #fef3c7;
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
        color: #6b7280;
        margin-top: 5px;
    }

    .content-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: var(--box-shadow);
    }

    .content-card h3 {
        margin-bottom: 15px;
        color: var(--dark);
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
        .stats-grid {
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

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-crown"></i></div>
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
            <a href="index.php?action=pengajuan-ketua"
                class="nav-item <?= ($_GET['action'] ?? '') == 'pengajuan-ketua' ? 'active' : '' ?>">
                <i class="fas fa-stamp"></i> Persetujuan Surat
            </a>
            <a href="index.php?action=laporan"
                class="nav-item <?= ($_GET['action'] ?? '') == 'laporan' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> Laporan
            </a>
            <a href="index.php?action=logout" class="nav-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Dashboard Ketua RT</h1>
                <p><i class="fas fa-calendar-alt"></i> <?= date('l, d F Y') ?></p>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <h4><?= htmlspecialchars($_SESSION['user']['fullname']) ?></h4>
                    <span class="role-badge"><i class="fas fa-crown"></i> Ketua RT</span>
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
            <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['user']['fullname']) ?>! 👑</h2>
            <p>Selamat datang di dashboard Ketua RT. Silakan kelola persetujuan surat.</p>
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
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-info">
                    <h3><?= $data['menunggu_persetujuan'] ?? 0 ?></h3>
                    <p>Menunggu Persetujuan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3><?= $data['total_disetujui'] ?? 0 ?></h3>
                    <p>Total Disetujui</p>
                </div>
            </div>
        </div>

        <!-- Grafik Tren 6 Bulan -->
        <?php if (!empty($data['grafik'])): ?>
        <div class="content-card">
            <h3><i class="fas fa-chart-line"></i> Tren Pengajuan 6 Bulan Terakhir</h3>
            <canvas id="trenChart" width="400" height="200"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        const ctx = document.getElementById('trenChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    <?php foreach ($data['grafik'] as $g) { echo "'" . date('M Y', strtotime($g['bulan'] . '-01')) . "', "; } ?>
                ],
                datasets: [{
                    label: 'Jumlah Surat Disetujui',
                    data: [<?php foreach ($data['grafik'] as $g) { echo $g['jumlah'] . ", "; } ?>],
                    borderColor: '#d97706',
                    backgroundColor: 'rgba(217,119,6,0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
        </script>
        <?php endif; ?>

        <!-- Pengajuan Terbaru -->
        <div class="content-card">
            <h3><i class="fas fa-clock"></i> Pengajuan Terbaru</h3>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pemohon</th>
                            <th>Jenis Surat</th>
                            <th>Tgl Pengajuan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['pengajuan_terbaru'] as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                            <td><?= str_replace('_', ' ', ucfirst($p['jenis_surat'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($p['tanggal_pengajuan'])) ?></td>
                            <td><span
                                    class="status-badge status-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($data['pengajuan_terbaru'])): ?>
                        <tr>
                            <td colspan="4" style="text-align:center;">Belum ada pengajuan</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>