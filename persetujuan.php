<?php
// =====================================================
// FILE: views/pengajuan/persetujuan.php
// FUNGSI: Halaman persetujuan surat oleh Ketua RT
// =====================================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Surat - Ketua RT</title>
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
        flex-wrap: wrap;
    }

    .detail-label {
        font-weight: 600;
        width: 180px;
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
        background: #dbeafe;
        color: #1e40af;
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
        font-family: inherit;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .btn-approve {
        background: #28a745;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-approve:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .btn-reject {
        background: #dc3545;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-reject:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-back:hover {
        background: #5a6268;
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

    @media (max-width: 768px) {
        .detail-label {
            width: 100%;
            margin-bottom: 5px;
        }

        .form-actions {
            flex-direction: column;
        }
    }
    </style>
</head>

<body>
    <div class="header">
        <h1><i class="fas fa-crown"></i> SIRT - Persetujuan Surat</h1>
        <a href="index.php?action=logout">Logout</a>
    </div>
    <div class="container">
        <div class="card">
            <h2><i class="fas fa-stamp"></i> Detail Pengajuan</h2>

            <?php $flash = getFlash(); ?>
            <?php if ($flash && $flash['type'] == 'error'): ?>
            <div class="alert alert-error"><?= $flash['message'] ?></div>
            <?php endif; ?>

            <div class="detail-item">
                <div class="detail-label">Nama Pemohon</div>
                <div class="detail-value"><strong><?= htmlspecialchars($pengajuan['nama_warga']) ?></strong></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">NIK</div>
                <div class="detail-value"><?= htmlspecialchars($pengajuan['nik']) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Alamat</div>
                <div class="detail-value"><?= htmlspecialchars($pengajuan['alamat']) ?></div>
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
            <?php if ($pengajuan['data_pendukung']): ?>
            <div class="detail-item">
                <div class="detail-label">Data Pendukung</div>
                <div class="detail-value"><?= nl2br(htmlspecialchars($pengajuan['data_pendukung'])) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($pengajuan['catatan_verifikasi']): ?>
            <div class="detail-item">
                <div class="detail-label">Catatan Sekretaris</div>
                <div class="detail-value"><?= nl2br(htmlspecialchars($pengajuan['catatan_verifikasi'])) ?></div>
            </div>
            <?php endif; ?>
            <div class="detail-item">
                <div class="detail-label">Status Saat Ini</div>
                <div class="detail-value"><span class="badge">Menunggu Persetujuan Ketua RT</span></div>
            </div>

            <form method="POST" action="index.php?action=pengajuan-proses-persetujuan">
                <input type="hidden" name="id" value="<?= $pengajuan['id'] ?>">

                <div class="form-group" id="alasanGroup" style="display: none;">
                    <label>Alasan Penolakan <span style="color: red;">*</span></label>
                    <textarea name="catatan" id="alasan" rows="3" placeholder="Isi alasan penolakan..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-approve" onclick="confirmSetujui()">
                        <i class="fas fa-check"></i> Setujui & Terbitkan Surat
                    </button>
                    <button type="button" class="btn-reject" onclick="showAlasanForm()">
                        <i class="fas fa-times"></i> Tolak Pengajuan
                    </button>
                    <a href="index.php?action=pengajuan-ketua" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function confirmSetujui() {
        if (confirm('Apakah Anda yakin ingin MENYETUJUI pengajuan ini?\n\nSurat akan digenerate secara otomatis.')) {
            let form = document.querySelector('form');
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'action';
            input.value = 'setujui';
            form.appendChild(input);
            form.submit();
        }
    }

    function showAlasanForm() {
        let alasanGroup = document.getElementById('alasanGroup');
        let alasanTextarea = document.getElementById('alasan');
        let rejectBtn = document.querySelector('.btn-reject');

        if (alasanGroup.style.display === 'none') {
            alasanGroup.style.display = 'block';
            alasanTextarea.focus();
            rejectBtn.textContent = '✋ Konfirmasi Tolak';
            rejectBtn.style.background = '#c82333';

            rejectBtn.onclick = function() {
                let alasan = document.getElementById('alasan').value.trim();
                if (!alasan) {
                    alert('⚠️ Alasan penolakan wajib diisi!');
                    alasanTextarea.focus();
                    return;
                }

                if (confirm('Apakah Anda yakin ingin MENOLAK pengajuan ini?')) {
                    let form = document.querySelector('form');
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'action';
                    input.value = 'tolak';
                    form.appendChild(input);
                    form.submit();
                }
            };
        } else {
            let alasan = document.getElementById('alasan').value.trim();
            if (!alasan) {
                alert('⚠️ Alasan penolakan wajib diisi!');
                alasanTextarea.focus();
                return;
            }

            if (confirm('Apakah Anda yakin ingin MENOLAK pengajuan ini?')) {
                let form = document.querySelector('form');
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'action';
                input.value = 'tolak';
                form.appendChild(input);
                form.submit();
            }
        }
    }
    </script>
</body>

</html>