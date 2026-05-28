<?php
// views/pengajuan/detail.php - Detail Pengajuan
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --primary: #4361ee;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
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

    .detail-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e5e7eb;
    }

    .detail-header h2 {
        color: var(--dark);
    }

    .badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
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

    .detail-table {
        width: 100%;
        margin-bottom: 20px;
    }

    .detail-table tr td {
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-table tr td:first-child {
        width: 200px;
        font-weight: 600;
        color: var(--dark);
    }

    .btn-back {
        background: var(--gray);
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-download {
        background: var(--success);
        color: white;
        padding: 10px 24px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-block;
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 0;
            padding: 15px;
        }

        .detail-table tr td:first-child {
            width: 120px;
        }
    }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-info-circle"></i></div>
            <div class="logo">SIRT</div>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?action=dashboard" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
            <a href="index.php?action=pengajuan-create" class="nav-item"><i class="fas fa-file-signature"></i> Pengajuan
                Surat</a>
            <a href="index.php?action=pengajuan-riwayat" class="nav-item"><i class="fas fa-history"></i> Riwayat
                Saya</a>
            <a href="index.php?action=logout" class="nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1><i class="fas fa-info-circle"></i> Detail Pengajuan</h1>
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

        <div class="detail-container">
            <div class="detail-header">
                <h2>Informasi Pengajuan</h2>
                <span class="badge badge-<?= $pengajuan['status'] ?>">
                    <?php
                    $statusLabel = [
                        'menunggu' => 'Menunggu Verifikasi',
                        'verifikasi' => 'Sedang Diverifikasi',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak'
                    ];
                    echo $statusLabel[$pengajuan['status']] ?? $pengajuan['status'];
                    ?>
                </span>
            </div>

            <table class="detail-table">
                <tr>
                    <td>Jenis Surat</td>
                    <td>: <strong><?= str_replace('_', ' ', ucfirst($pengajuan['jenis_surat'])) ?></strong></td>
                </tr>
                <tr>
                    <td>Tanggal Pengajuan</td>
                    <td>: <?= date('d/m/Y H:i:s', strtotime($pengajuan['tanggal_pengajuan'])) ?></td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>: <?= nl2br(htmlspecialchars($pengajuan['keperluan'])) ?></td>
                </tr>
                <tr>
                    <td>Data Pendukung</td>
                    <td>: <?= nl2br(htmlspecialchars($pengajuan['data_pendukung'] ?? '-')) ?></td>
                </tr>
                <?php if ($pengajuan['file_pendukung']): ?>
                <tr>
                    <td>File Pendukung</td>
                    <td>: <a href="uploads/pendukung/<?= $pengajuan['file_pendukung'] ?>" target="_blank"
                            style="color: var(--primary);">📎 Lihat File</a></td>
                </tr>
                <?php endif; ?>
                <?php if ($pengajuan['catatan_verifikasi']): ?>
                <tr>
                    <td>Catatan Verifikasi</td>
                    <td>: <?= nl2br(htmlspecialchars($pengajuan['catatan_verifikasi'])) ?></td>
                </tr>
                <?php endif; ?>
                <?php if ($pengajuan['status'] == 'disetujui' && $pengajuan['nomor_surat']): ?>
                <tr>
                    <td>Nomor Surat</td>
                    <td>: <strong><?= $pengajuan['nomor_surat'] ?></strong></td>
                </tr>
                <?php endif; ?>
            </table>

            <div style="margin-top: 20px;">
                <a href="index.php?action=pengajuan-riwayat" class="btn-back"><i class="fas fa-arrow-left"></i>
                    Kembali</a>
                <?php if ($pengajuan['status'] == 'disetujui' && $pengajuan['file_surat']): ?>
                <a href="uploads/surat/<?= $pengajuan['file_surat'] ?>" class="btn-download" download><i
                        class="fas fa-download"></i> Download Surat</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>