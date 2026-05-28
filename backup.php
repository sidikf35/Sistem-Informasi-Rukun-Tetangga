<?php
// views/arsip/backup.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Backup Database - SIRT</title>
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
        max-width: 1000px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .btn-backup {
        background: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .btn-download {
        background: #17a2b8;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 12px;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 12px;
    }
    </style>
</head>

<body>
    <div class="header">
        <h1><i class="fas fa-database"></i> Backup & Restore</h1>
        <a href="index.php?action=logout">Logout</a>
    </div>
    <div class="container">
        <div class="card">
            <h2>Backup Database</h2>
            <form method="POST" action="index.php?action=arsip-proses-backup">
                <button type="submit" class="btn-backup"><i class="fas fa-database"></i> Backup Sekarang</button>
            </form>
        </div>
        <div class="card">
            <h2>Daftar File Backup</h2>
            <?php if (empty($backupFiles)): ?>
            <p>Belum ada file backup.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama File</th>
                        <th>Ukuran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($backupFiles as $bf): ?>
                    <tr>
                        <td><?= htmlspecialchars($bf['name']) ?></td>
                        <td><?= number_format($bf['size']/1024,2) ?> KB</td>
                        <td><?= $bf['date'] ?></td>
                        <td>
                            <a href="index.php?action=arsip-download-backup&file=<?= urlencode($bf['name']) ?>"
                                class="btn-download">Download</a>
                            <a href="index.php?action=arsip-delete-backup&file=<?= urlencode($bf['name']) ?>"
                                class="btn-delete" onclick="return confirm('Hapus file backup?')">Hapus</a>
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