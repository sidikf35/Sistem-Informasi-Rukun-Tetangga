<?php
// views/pengajuan/riwayat.php - Riwayat Pengajuan Warga
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --primary: #4361ee;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --dark: #1f2937;
        --gray: #6b7280;
        --border-radius: 16px;
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
        font-size: 24px;
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
        transition: all 0.3s ease;
    }

    .sidebar-nav .nav-item i {
        width: 25px;
        margin-right: 12px;
    }

    .sidebar-nav .nav-item:hover {
        background: rgba(67, 97, 238, 0.2);
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
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
        background: #e8f0fe;
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
    }

    .table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8fafc;
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: var(--dark);
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    tr:hover {
        background: #f8fafc;
    }

    .badge {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-verifikasi {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-disetujui {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-detail {
        background: var(--primary);
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .btn-detail:hover {
        background: #3a56d4;
    }

    .empty-state {
        text-align: center;
        padding: 60px;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        display: inline-block;
        margin-top: 15px;
    }

    .alert {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 0;
            padding: 15px;
        }

        .table-container {
            overflow-x: auto;
        }
    }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-history"></i></div>
            <div class="logo">SIRT</div>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?action=dashboard" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
            <a href="index.php?action=pengajuan-create" class="nav-item"><i class="fas fa-file-signature"></i> Pengajuan
                Surat</a>
            <a href="index.php?action=pengajuan-riwayat" class="nav-item active"><i class="fas fa-history"></i> Riwayat
                Saya</a>
            <a href="index.php?action=logout" class="nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1><i class="fas fa-history"></i> Riwayat Pengajuan</h1>
                <p>Lihat status pengajuan surat Anda</p>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <h4><?= htmlspecialchars($_SESSION['user']['fullname']) ?></h4>
                    <span class="role-badge">Warga</span>
                </div>
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['fullname'], 0, 1)) ?></div>
                <a href="index.php?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <?php $flash = getFlash(); ?>
        <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <i class="fas fa-check-circle"></i> <?= $flash['message'] ?>
        </div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengajuanList)): ?>
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada pengajuan surat</p>
                            <a href="index.php?action=pengajuan-create" class="btn-primary"><i class="fas fa-plus"></i>
                                Ajukan Surat</a>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; foreach ($pengajuanList as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= str_replace('_', ' ', ucfirst($item['jenis_surat'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($item['tanggal_pengajuan'])) ?></td>
                        <td>
                            <span class="badge badge-<?= $item['status'] ?>">
                                <?php
                                    $statusLabel = [
                                        'menunggu' => 'Menunggu Verifikasi',
                                        'verifikasi' => 'Sedang Diverifikasi',
                                        'disetujui' => 'Disetujui',
                                        'ditolak' => 'Ditolak'
                                    ];
                                    echo $statusLabel[$item['status']] ?? $item['status'];
                                    ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?action=pengajuan-detail&id=<?= $item['id'] ?>" class="btn-detail"><i
                                    class="fas fa-eye"></i> Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>