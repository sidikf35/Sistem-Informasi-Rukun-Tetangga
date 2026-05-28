<?php
// =====================================================
// FILE: views/auth/reset-password.php
// FUNGSI: Halaman reset password
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIRT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .reset-container {
        width: 100%;
        max-width: 450px;
    }

    .reset-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo i {
        font-size: 48px;
        color: #667eea;
    }

    .logo h1 {
        font-size: 28px;
        color: #333;
        margin-top: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .input-group {
        position: relative;
    }

    .input-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .input-group input {
        width: 100%;
        padding: 14px 15px 14px 45px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .input-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-reset {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .btn-reset:hover {
        transform: translateY(-2px);
    }

    .alert {
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error {
        background: #fee;
        color: #c33;
        border: 1px solid #fcc;
    }

    .alert-success {
        background: #efe;
        color: #3c3;
        border: 1px solid #cfc;
    }

    .reset-footer {
        text-align: center;
        margin-top: 20px;
    }

    .reset-footer a {
        color: #667eea;
        text-decoration: none;
        font-size: 14px;
    }

    @media (max-width: 480px) {
        .reset-card {
            padding: 30px 20px;
        }
    }
    </style>
</head>

<body>
    <div class="reset-container">
        <div class="reset-card">
            <div class="logo">
                <i class="fas fa-key"></i>
                <h1>Reset Password</h1>
            </div>

            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=reset-password">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="new_password" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" name="confirm_password" placeholder="Ketik ulang password" required>
                    </div>
                </div>

                <button type="submit" class="btn-reset">
                    <i class="fas fa-sync-alt"></i> Reset Password
                </button>

                <div class="reset-footer">
                    <a href="index.php?action=login">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>