<?php
// =====================================================
// FILE: config/constants.php
// FUNGSI: Konstanta global dan konfigurasi aplikasi
// =====================================================

// =====================================================
// PATH DIRECTORY
// =====================================================
define('BASE_PATH', dirname(__DIR__));
define('ASSETS_PATH', BASE_PATH . '/assets');
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('BACKUP_PATH', BASE_PATH . '/backup');

// =====================================================
// URL
// =====================================================
$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false && strpos($line, 'APP_URL') !== false) {
            list($key, $value) = explode('=', $line, 2);
            define('BASE_URL', rtrim(trim($value), '/'));
            break;
        }
    }
}
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/SIRT_APP');
}
define('ASSETS_URL', BASE_URL . '/assets');

// =====================================================
// UPLOAD FOLDERS
// =====================================================
define('UPLOAD_KTP', UPLOAD_PATH . '/ktp');
define('UPLOAD_FOTO_WARGA', UPLOAD_PATH . '/foto_warga');
define('UPLOAD_PENDUKUNG', UPLOAD_PATH . '/pendukung');
define('UPLOAD_SURAT', UPLOAD_PATH . '/surat');

// Buat folder upload jika belum ada
$uploadFolders = [UPLOAD_KTP, UPLOAD_FOTO_WARGA, UPLOAD_PENDUKUNG, UPLOAD_SURAT, BACKUP_PATH];
foreach ($uploadFolders as $folder) {
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }
}

// =====================================================
// ROLE CONSTANTS
// =====================================================
define('ROLE_WARGA', 'warga');
define('ROLE_SEKRETARIS', 'sekretaris');
define('ROLE_KETUA_RT', 'ketua_rt');

// =====================================================
// STATUS CONSTANTS
// =====================================================
define('STATUS_MENUNGGU', 'menunggu');
define('STATUS_VERIFIKASI', 'verifikasi');
define('STATUS_DISETUJUI', 'disetujui');
define('STATUS_DITOLAK', 'ditolak');

// =====================================================
// JENIS SURAT
// =====================================================
$JENIS_SURAT = [
    'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
    'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
    'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
    'surat_pengantar_ktp' => 'Surat Pengantar KTP',
    'surat_keterangan_kelahiran' => 'Surat Keterangan Kelahiran',
    'surat_keterangan_kematian' => 'Surat Keterangan Kematian'
];

// =====================================================
// KONSTANTA LAINNYA
// =====================================================
define('APP_NAME', getenv('APP_NAME') ?: 'SIRT');
define('MAX_FILE_SIZE', (int)(getenv('MAX_FILE_SIZE') ?: 2097152));
define('ALLOWED_EXTENSIONS', explode(',', getenv('ALLOWED_EXTENSIONS') ?: 'jpg,jpeg,png,pdf'));
?>