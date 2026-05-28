<?php
// views/pengajuan/list.php - Daftar pengajuan untuk sekretaris
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan - SIRT</title>
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

    .btn-verifikasi {
        background: #4361ee;
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-verifikasi:hover,
    .btn-view:hover {
        opacity: 0.9;
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
        <h1>SIRT - Daftar Pengajuan Surat</h1>
        <a href="index.php?action=logout">Logout</a>
    </div>
    <div class="container">
        <div class="card">
            <h2><i class="fas fa-clipboard-list"></i> Daftar Pengajuan</h2>

            <?php $flash = getFlash(); ?>
            <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>"><?= $flash['message'] ?></div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Tgl Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengajuanList)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada pengajuan surat</td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; foreach ($pengajuanList as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($item['nama_warga']) ?> (RT <?= $item['rt'] ?>)</td>
                        <td><?= str_replace('_', ' ', ucfirst($item['jenis_surat'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($item['tanggal_pengajuan'])) ?></td>
                        <td>
                            <span class="badge badge-<?= $item['status'] ?>">
                                <?php
                                    $status = [
                                        'menunggu' => 'Menunggu Verifikasi',
                                        'verifikasi' => 'Diverifikasi',
                                        'disetujui' => 'Disetujui',
                                        'ditolak' => 'Ditolak'
                                    ];
                                    echo $status[$item['status']] ?? $item['status'];
                                    ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?action=pengajuan-detail&id=<?= $item['id'] ?>"
                                class="btn-view">Detail</a>
                            <?php if ($item['status'] == 'menunggu'): ?>
                            <a href="index.php?action=pengajuan-verifikasi&id=<?= $item['id'] ?>"
                                class="btn-verifikasi">Verifikasi</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>