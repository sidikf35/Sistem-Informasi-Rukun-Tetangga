<?php
// =====================================================
// FILE: views/pengajuan/list_ketua.php
// FUNGSI: Daftar pengajuan untuk Ketua RT
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan - Ketua RT</title>
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
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        margin-bottom: 20px;
        color: #2c3e50;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        border-bottom: 1px solid #dee2e6;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    tr:hover {
        background: #f8f9fa;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-verifikasi {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-approve {
        background: #28a745;
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        transition: 0.3s;
    }

    .btn-approve:hover {
        background: #218838;
    }

    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 60px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        table {
            display: block;
            overflow-x: auto;
        }
    }
    </style>
</head>

<body>
    <div class="header">
        <h1><i class="fas fa-crown"></i> SIRT - Daftar Pengajuan (Ketua RT)</h1>
        <a href="index.php?action=logout">Logout</a>
    </div>
    <div class="container">
        <div class="card">
            <h2><i class="fas fa-clipboard-list"></i> Pengajuan Menunggu Persetujuan</h2>

            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>"><?= $flash['message'] ?></div>
            <?php endif; ?>

            <?php if (empty($pengajuanList)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Tidak ada pengajuan yang menunggu persetujuan</p>
            </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Keperluan</th>
                        <th>Tgl Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pengajuanList as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($item['nama_warga']) ?></strong><br><small>RT
                                <?= $item['rt'] ?></small></td>
                        <td><?= str_replace('_', ' ', ucfirst($item['jenis_surat'])) ?></td>
                        <td><?= htmlspecialchars(substr($item['keperluan'], 0, 50)) ?>...</td>
                        <td><?= date('d/m/Y H:i', strtotime($item['tanggal_pengajuan'])) ?></td>
                        <td><span class="badge badge-verifikasi">Menunggu Persetujuan</span></td>
                        <td>
                            <a href="index.php?action=pengajuan-persetujuan&id=<?= $item['id'] ?>" class="btn-approve">
                                <i class="fas fa-check-circle"></i> Setujui
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>