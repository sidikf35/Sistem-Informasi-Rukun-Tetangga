<?php
// controllers/ArsipController.php

require_once __DIR__ . '/../models/Arsip.php';
require_once __DIR__ . '/../helpers/BackupHelper.php';

class ArsipController {
    private $pdo;
    private $arsipModel;
    
    public function __construct($pdo) {
        $this->pdo = $pdo; // Simpan koneksi database
        $this->arsipModel = new Arsip($pdo);
    }
    
    // Halaman arsip
    public function index() {
        authMiddleware();
        if (!in_array($_SESSION['user']['role'], ['sekretaris', 'ketua_rt'])) {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        $search = $_GET['search'] ?? '';
        $jenis = $_GET['jenis'] ?? '';
        $bulan = $_GET['bulan'] ?? '';
        $tahun = $_GET['tahun'] ?? '';
        $arsipList = $this->arsipModel->getAll($search, $jenis, $bulan, $tahun);
        $statistik = $this->arsipModel->getStatistik();
        $tahunList = $this->arsipModel->getTahunList();
        require_once __DIR__ . '/../views/arsip/index.php';
    }
    
    // Download file arsip
    public function download() {
        authMiddleware();
        $id = $_GET['id'] ?? 0;
        $arsip = $this->arsipModel->getById($id);
        if (!$arsip) {
            setFlash('error', 'Arsip tidak ditemukan');
            redirect('index.php?action=arsip');
        }
        $filePath = __DIR__ . '/../uploads/surat/' . $arsip['file_path'];
        if (file_exists($filePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $arsip['nomor_surat'] . '.pdf"');
            readfile($filePath);
            exit;
        } else {
            setFlash('error', 'File tidak ditemukan');
            redirect('index.php?action=arsip');
        }
    }
    
    // Hapus arsip (hanya sekretaris)
    public function delete() {
        authMiddleware();
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        $id = $_GET['id'] ?? 0;
        if ($this->arsipModel->delete($id)) {
            setFlash('success', 'Arsip berhasil dihapus');
        } else {
            setFlash('error', 'Gagal hapus arsip');
        }
        redirect('index.php?action=arsip');
    }
    
    // Halaman backup
    public function backupPage() {
        authMiddleware();
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        $backupDir = __DIR__ . '/../backup/';
        $backupFiles = [];
        if (file_exists($backupDir)) {
            $files = scandir($backupDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'sql') {
                    $backupFiles[] = [
                        'name' => $file,
                        'size' => filesize($backupDir . $file),
                        'date' => date('d/m/Y H:i:s', filemtime($backupDir . $file))
                    ];
                }
            }
            usort($backupFiles, function($a, $b) { return strtotime($b['date']) - strtotime($a['date']); });
        }
        require_once __DIR__ . '/../views/arsip/backup.php';
    }
    
    // Proses backup
    public function prosesBackup() {
        authMiddleware();
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        // Kirim koneksi PDO ke BackupHelper
        $result = BackupHelper::backupDatabase($this->pdo);
        if ($result['success']) {
            setFlash('success', 'Backup berhasil: ' . $result['filename']);
        } else {
            setFlash('error', 'Backup gagal: ' . $result['error']);
        }
        redirect('index.php?action=arsip-backup');
    }
    
    // Download backup
    public function downloadBackup() {
        authMiddleware();
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        $filename = $_GET['file'] ?? '';
        $backupDir = __DIR__ . '/../backup/';
        $filePath = $backupDir . $filename;
        if (file_exists($filePath) && pathinfo($filename, PATHINFO_EXTENSION) == 'sql') {
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            readfile($filePath);
            exit;
        } else {
            setFlash('error', 'File tidak ditemukan');
            redirect('index.php?action=arsip-backup');
        }
    }
    
    // Hapus backup
    public function deleteBackup() {
        authMiddleware();
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        $filename = $_GET['file'] ?? '';
        $backupDir = __DIR__ . '/../backup/';
        $filePath = $backupDir . $filename;
        if (file_exists($filePath) && pathinfo($filename, PATHINFO_EXTENSION) == 'sql') {
            unlink($filePath);
            setFlash('success', 'Backup dihapus');
        } else {
            setFlash('error', 'File tidak ditemukan');
        }
        redirect('index.php?action=arsip-backup');
    }
}
?>