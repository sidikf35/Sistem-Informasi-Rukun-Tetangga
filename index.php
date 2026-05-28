<?php
// =====================================================
// FILE: views/warga/index.php
// FUNGSI: Halaman daftar warga
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1f2937;
        --gray: #6b7280;
        --light: #f9fafb;
        --border-radius: 16px;
        --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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

    /* ========== SIDEBAR ========== */
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
        transition: var(--transition);
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

    .sidebar-header p {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
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
        margin: 5px 15px;
        border-radius: 12px;
        transition: var(--transition);
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
        transition: var(--transition);
    }

    .logout-btn:hover {
        background: #dc2626;
        color: white;
    }

    /* ========== STATS CARD ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        background: #e8f0fe;
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
        font-size: 13px;
        color: var(--gray);
        margin-top: 5px;
    }

    /* ========== FILTER & TABLE ========== */
    .filter-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: var(--box-shadow);
    }

    .filter-form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-form input {
        flex: 1;
        min-width: 250px;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        transition: var(--transition);
    }

    .filter-form input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .btn-search {
        background: var(--primary);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-search:hover {
        background: var(--primary-dark);
    }

    .btn-reset {
        background: var(--gray);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-reset:hover {
        background: #4b5563;
    }

    .btn-add {
        background: var(--success);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
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
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-aktif {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-pindah {
        background: #fed7aa;
        color: #92400e;
    }

    .badge-meninggal {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-edit {
        background: #fef3c7;
        color: #d97706;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit:hover {
        background: #fbbf24;
        color: #78350f;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: 8px;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
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

    .alert {
        padding: 15px 20px;
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

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        color: var(--primary);
        text-decoration: none;
        font-size: 14px;
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

        .filter-form {
            flex-direction: column;
        }

        .filter-form input {
            width: 100%;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
    }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-users"></i></div>
            <div class="logo">SIRT</div>
            <p>Sistem Informasi Rukun Tetangga</p>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?action=dashboard" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
            <a href="index.php?action=warga" class="nav-item active"><i class="fas fa-users"></i> Data Warga</a>
            <?php if ($_SESSION['user']['role'] == 'sekretaris'): ?>
            <a href="index.php?action=warga-create" class="nav-item"><i class="fas fa-user-plus"></i> Tambah Warga</a>
            <?php endif; ?>
            <a href="index.php?action=logout" class="nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1><i class="fas fa-users"></i> Data Warga</h1>
                <p><i class="fas fa-calendar-alt"></i> <?= date('l, d F Y') ?></p>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <h4><?= htmlspecialchars($_SESSION['user']['fullname']) ?></h4>
                    <span class="role-badge"><?= ucfirst($_SESSION['user']['role']) ?></span>
                </div>
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['fullname'], 0, 1)) ?></div>
                <a href="index.php?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3><?= $totalWarga ?? 0 ?></h3>
                    <p>Total Warga</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3><?= $totalAktif ?? 0 ?></h3>
                    <p>Warga Aktif</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-building"></i></div>
                <div class="stat-info">
                    <h3><?= count($wargaList) ?></h3>
                    <p>Total KK</p>
                </div>
            </div>
        </div>

        <!-- Filter & Tombol Tambah -->
        <div class="filter-section">
            <div
                style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
                <h3 style="color: var(--dark);"><i class="fas fa-filter"></i> Filter Data</h3>
                <?php if ($_SESSION['user']['role'] == 'sekretaris'): ?>
                <a href="index.php?action=warga-create" class="btn-add"><i class="fas fa-plus"></i> Tambah Warga</a>
                <?php endif; ?>
            </div>

            <form method="GET" action="" class="filter-form">
                <input type="hidden" name="action" value="warga">
                <input type="text" name="search" placeholder="Cari NIK, Nama, atau No KK..."
                    value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit" class="btn-search"><i class="fas fa-search"></i> Cari</button>
                <?php if (!empty($search)): ?>
                <a href="index.php?action=warga" class="btn-reset"><i class="fas fa-undo"></i> Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Alert -->
        <?php $flash = getFlash(); ?>
        <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>

        <!-- Tabel Data Warga -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>No KK</th>
                        <th>Alamat</th>
                        <th>RT/RW</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($wargaList)): ?>
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-database"></i>
                            <p>Belum ada data warga</p>
                            <?php if ($_SESSION['user']['role'] == 'sekretaris'): ?>
                            <a href="index.php?action=warga-create" class="btn-add"
                                style="margin-top: 15px; display: inline-block;">Tambah Warga Sekarang</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; foreach ($wargaList as $warga): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($warga['nik']) ?></td>
                        <td><strong><?= htmlspecialchars($warga['nama_lengkap']) ?></strong></td>
                        <td><?= htmlspecialchars($warga['no_kk']) ?></td>
                        <td><?= htmlspecialchars(substr($warga['alamat'], 0, 40)) ?>...</td>
                        <td><?= $warga['rt'] . '/' . $warga['rw'] ?></td>
                        <td><span class="badge badge-<?= $warga['status'] ?>"><?= ucfirst($warga['status']) ?></span>
                        </td>
                        <td class="action-buttons">
                            <?php if ($_SESSION['user']['role'] == 'sekretaris'): ?>
                            <a href="index.php?action=warga-edit&id=<?= $warga['id'] ?>" class="btn-edit"><i
                                    class="fas fa-edit"></i> Edit</a>
                            <a href="index.php?action=warga-delete&id=<?= $warga['id'] ?>" class="btn-delete"
                                onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i> Hapus</a>
                            <?php else: ?>
                            <a href="#" class="btn-edit" onclick="alert('Hanya Sekretaris yang dapat mengedit')"><i
                                    class="fas fa-eye"></i> Lihat</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?action=dashboard" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke
            Dashboard</a>
    </main>
</body>

</html>