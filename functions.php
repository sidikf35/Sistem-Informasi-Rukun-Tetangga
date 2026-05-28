<?php
// =====================================================
// FILE: helpers/functions.php
// FUNGSI: Fungsi global helper
// =====================================================

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function getStatusBadge($status) {
    $badges = [
        'menunggu' => '<span class="badge badge-warning">Menunggu</span>',
        'verifikasi' => '<span class="badge badge-info">Diverifikasi</span>',
        'disetujui' => '<span class="badge badge-success">Disetujui</span>',
        'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
        'aktif' => '<span class="badge badge-success">Aktif</span>',
        'pindah' => '<span class="badge badge-warning">Pindah</span>',
        'meninggal' => '<span class="badge badge-danger">Meninggal</span>'
    ];
    return $badges[$status] ?? '<span class="badge badge-secondary">' . $status . '</span>';
}
?>