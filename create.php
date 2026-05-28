<?php
// =====================================================
// FILE: views/warga/create.php
// FUNGSI: Form tambah warga
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Warga - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --primary: #4361ee;
        --success: #10b981;
        --danger: #ef4444;
        --dark: #1f2937;
        --gray: #6b7280;
        --border-radius: 16px;
        --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
    }

    .form-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: var(--box-shadow);
    }

    .form-container h2 {
        color: var(--dark);
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e5e7eb;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .required {
        color: var(--danger);
        margin-left: 3px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-save {
        background: var(--success);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: var(--gray);
        color: white;
        padding: 12px 30px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #4b5563;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 0;
            padding: 15px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-save,
        .btn-cancel {
            text-align: center;
        }
    }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="fas fa-user-plus"></i></div>
            <div class="logo">SIRT</div>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php?action=dashboard" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
            <a href="index.php?action=warga" class="nav-item"><i class="fas fa-users"></i> Data Warga</a>
            <a href="index.php?action=warga-create" class="nav-item active"><i class="fas fa-user-plus"></i> Tambah
                Warga</a>
            <a href="index.php?action=logout" class="nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1><i class="fas fa-user-plus"></i> Tambah Warga</h1>
                <p>Isi formulir di bawah ini untuk menambahkan data warga baru</p>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <h4><?= htmlspecialchars($_SESSION['user']['fullname']) ?></h4>
                    <span class="role-badge">Sekretaris</span>
                </div>
                <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['fullname'], 0, 1)) ?></div>
                <a href="index.php?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <div class="form-container">
            <h2><i class="fas fa-edit"></i> Form Data Warga</h2>

            <?php $flash = getFlash(); ?>
            <?php if ($flash && $flash['type'] == 'error'): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= $flash['message'] ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=warga-store">
                <div class="form-row">
                    <div class="form-group">
                        <label>NIK <span class="required">*</span></label>
                        <input type="text" name="nik" maxlength="16" placeholder="16 digit angka" required>
                    </div>
                    <div class="form-group">
                        <label>No KK <span class="required">*</span></label>
                        <input type="text" name="no_kk" maxlength="16" placeholder="Nomor Kartu Keluarga" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama_lengkap" placeholder="Nama lengkap sesuai KTP" required>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir <span class="required">*</span></label>
                        <input type="text" name="tempat_lahir" placeholder="Kota/Kabupaten lahir" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" name="tanggal_lahir" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin <span class="required">*</span></label>
                        <select name="jenis_kelamin" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat <span class="required">*</span></label>
                    <textarea name="alamat" rows="3" placeholder="Alamat lengkap" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>RT</label>
                        <input type="text" name="rt" value="001" maxlength="3">
                    </div>
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" name="rw" value="002" maxlength="3">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan Data</button>
                    <a href="index.php?action=warga" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                </div>
            </form>
        </div>
    </main>
</body>

</html>