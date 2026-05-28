<?php
// views/pengajuan/verifikasi.php - Halaman verifikasi
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi - SIRT</title>
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
        background: #f3f4f6;
    }

    .header {
        background: #2c3e50;
        color: white;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header a {
        color: white;
        background: #dc3545;
        padding: 8px 15px;
        border-radius: 8px;
        text-decoration: none;
    }

    .container {
        max-width: 800px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        margin-bottom: 20px;
        color: #2c3e50;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }

    .detail-item {
        margin-bottom: 15px;
        display: flex;
    }

    .detail-label {
        font-weight: 600;
        width: 150px;
        color: #555;
    }

    .detail-value {
        flex: 1;
        color: #333;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        background: #fef3c7;
        color: #92400e;
    }

    .form-group {
        margin-top: 25px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-approve {
        background: #28a745;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-reject {
        background: #dc3545;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
    }

    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
    }
    </style>
</head>

<body>
    <div class="header">
        <h1>SIRT - Verifikasi Pengajuan</h1>
        <a href="index.php?action=logout">Logout</a>
    </div>
    <div class="container">
        <div class="card">
            <h2><i class="fas fa-check-double"></i> Verifikasi Pengajuan</h2>

            <?php $flash = getFlash(); ?>
            <?php if ($flash && $flash['type'] == 'error'): ?>
            <div class="alert alert-error"><?= $flash['message'] ?></div>
            <?php endif; ?>

            <div class="detail-item">
                <div class="detail-label">Nama Pemohon</div>
                <div class="detail-value"><?= htmlspecialchars($pengajuan['nama_warga']) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Jenis Surat</div>
                <div class="detail-value"><?= str_replace('_', ' ', ucfirst($pengajuan['jenis_surat'])) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Tanggal Pengajuan</div>
                <div class="detail-value"><?= date('d/m/Y H:i', strtotime($pengajuan['tanggal_pengajuan'])) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Keperluan</div>
                <div class="detail-value"><?= nl2br(htmlspecialchars($pengajuan['keperluan'])) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value"><span class="badge">Menunggu Verifikasi</span></div>
            </div>

            <form method="POST" action="index.php?action=pengajuan-proses-verifikasi">
                <input type="hidden" name="id" value="<?= $pengajuan['id'] ?>">

                <div class="form-group">
                    <label>Catatan (wajib jika ditolak)</label>
                    <textarea name="catatan" rows="3"
                        placeholder="Isi catatan verifikasi atau alasan penolakan..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" name="action" value="setujui" class="btn-approve"
                        onclick="return confirm('Setujui pengajuan ini?')">✅ Setujui & Lanjutkan</button>
                    <button type="submit" name="action" value="tolak" class="btn-reject"
                        onclick="return confirm('Tolak pengajuan ini? Pastikan sudah mengisi catatan.')">❌
                        Tolak</button>
                    <a href="index.php?action=pengajuan-list" class="btn-back">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>