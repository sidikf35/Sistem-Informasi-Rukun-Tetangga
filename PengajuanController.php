<?php
// =====================================================
// FILE: controllers/PengajuanController.php
// FUNGSI: Controller untuk pengajuan surat warga
// =====================================================

require_once __DIR__ . '/../models/Pengajuan.php';
require_once __DIR__ . '/../models/Warga.php';

class PengajuanController {
    private $pengajuanModel;
    private $wargaModel;
    
    public function __construct($pdo) {
        $this->pengajuanModel = new Pengajuan($pdo);
        $this->wargaModel = new Warga($pdo);
    }
    
    /**
     * ========== SPRINT 3: PENGAJUAN WARGA ==========
     */
    
    /**
     * Form pengajuan surat
     */
    public function create() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'warga') {
            setFlash('error', 'Hanya warga yang dapat mengajukan surat!');
            redirect('index.php?action=dashboard');
        }
        
        require_once __DIR__ . '/../views/pengajuan/create.php';
    }
    
    /**
     * Proses simpan pengajuan
     */
    public function store() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'warga') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=pengajuan-create');
        }
        
        // Validasi field wajib
        if (empty($_POST['jenis_surat']) || empty($_POST['keperluan'])) {
            setFlash('error', 'Harap lengkapi semua field yang wajib diisi!');
            redirect('index.php?action=pengajuan-create');
        }
        
        // Upload file pendukung
        $filePendukung = null;
        if (isset($_FILES['file_pendukung']) && $_FILES['file_pendukung']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            $fileType = $_FILES['file_pendukung']['type'];
            $fileSize = $_FILES['file_pendukung']['size'];
            
            if (in_array($fileType, $allowedTypes) && $fileSize <= 2097152) {
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $_FILES['file_pendukung']['name']);
                $targetDir = __DIR__ . '/../uploads/pendukung/';
                
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                
                $targetPath = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES['file_pendukung']['tmp_name'], $targetPath)) {
                    $filePendukung = $fileName;
                }
            } else {
                setFlash('error', 'File harus PDF/JPG/PNG dan maksimal 2MB!');
                redirect('index.php?action=pengajuan-create');
            }
        }
        
        // Cari warga_id dari user yang login
        $warga = $this->wargaModel->getByUserId($_SESSION['user']['id']);
        
        if (!$warga) {
            setFlash('error', 'Data warga tidak ditemukan! Silakan hubungi sekretaris RT untuk mendaftarkan data diri Anda.');
            redirect('index.php?action=dashboard');
        }
        
        $wargaId = $warga['id'];
        
        $data = [
            'warga_id' => $wargaId,
            'jenis_surat' => $_POST['jenis_surat'],
            'keperluan' => $_POST['keperluan'],
            'data_pendukung' => $_POST['data_pendukung'] ?? null,
            'file_pendukung' => $filePendukung
        ];
        
        if ($this->pengajuanModel->create($data)) {
            setFlash('success', 'Pengajuan surat berhasil dikirim! Silakan tunggu verifikasi.');
            redirect('index.php?action=pengajuan-riwayat');
        } else {
            setFlash('error', 'Gagal mengirim pengajuan! Silakan coba lagi.');
            redirect('index.php?action=pengajuan-create');
        }
    }
    
    /**
     * Riwayat pengajuan warga
     */
    public function riwayat() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'warga') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        // Cari warga_id dari user yang login
        $warga = $this->wargaModel->getByUserId($_SESSION['user']['id']);
        
        $pengajuanList = [];
        if ($warga) {
            $pengajuanList = $this->pengajuanModel->getByWargaId($warga['id']);
        }
        
        require_once __DIR__ . '/../views/pengajuan/riwayat.php';
    }
    
    /**
     * Detail pengajuan
     */
    public function detail() {
        authMiddleware();
        
        $id = $_GET['id'] ?? 0;
        
        if ($id == 0) {
            setFlash('error', 'ID pengajuan tidak valid!');
            redirect('index.php?action=dashboard');
        }
        
        $pengajuan = $this->pengajuanModel->getById($id);
        
        if (!$pengajuan) {
            setFlash('error', 'Data pengajuan tidak ditemukan!');
            redirect('index.php?action=dashboard');
        }
        
        // Cek akses: hanya pemilik data yang bisa lihat
        if ($_SESSION['user']['role'] == 'warga') {
            $warga = $this->wargaModel->getByUserId($_SESSION['user']['id']);
            if (!$warga || $pengajuan['warga_id'] != $warga['id']) {
                setFlash('error', 'Akses ditolak! Anda tidak memiliki akses ke data ini.');
                redirect('index.php?action=dashboard');
            }
        }
        
        require_once __DIR__ . '/../views/pengajuan/detail.php';
    }
    
    /**
     * ========== SPRINT 4: VERIFIKASI SEKRETARIS ==========
     */
    
    /**
     * Halaman daftar pengajuan untuk sekretaris
     */
    public function listPengajuan() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak! Hanya Sekretaris yang dapat mengakses.');
            redirect('index.php?action=dashboard');
        }
        
        $pengajuanList = $this->pengajuanModel->getAllForSekretaris();
        
        require_once __DIR__ . '/../views/pengajuan/list.php';
    }
    
    /**
     * Halaman verifikasi pengajuan
     */
    public function verifikasiPage() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        $id = $_GET['id'] ?? 0;
        $pengajuan = $this->pengajuanModel->getById($id);
        
        if (!$pengajuan || $pengajuan['status'] != 'menunggu') {
            setFlash('error', 'Pengajuan tidak ditemukan atau sudah diproses!');
            redirect('index.php?action=pengajuan-list');
        }
        
        require_once __DIR__ . '/../views/pengajuan/verifikasi.php';
    }
    
    /**
     * Proses verifikasi (setujui/tolak)
     */
    public function prosesVerifikasi() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=pengajuan-list');
        }
        
        $id = $_POST['id'] ?? 0;
        $action = $_POST['action'] ?? '';
        $catatan = $_POST['catatan'] ?? '';
        
        if ($action === 'setujui') {
            if ($this->pengajuanModel->verifikasiSetujui($id, $_SESSION['user']['id'])) {
                setFlash('success', '✅ Pengajuan diverifikasi dan diteruskan ke Ketua RT!');
            } else {
                setFlash('error', 'Gagal memverifikasi pengajuan!');
            }
        } 
        elseif ($action === 'tolak') {
            if (empty($catatan)) {
                setFlash('error', 'Harap isi alasan penolakan!');
                redirect("index.php?action=pengajuan-verifikasi&id=$id");
                return;
            }
            
            if ($this->pengajuanModel->verifikasiTolak($id, $catatan, $_SESSION['user']['id'])) {
                setFlash('success', '❌ Pengajuan ditolak! Alasan telah dicatat.');
            } else {
                setFlash('error', 'Gagal menolak pengajuan!');
            }
        }
        
        redirect('index.php?action=pengajuan-list');
    }
    
    /**
     * ========== SPRINT 5: PERSETUJUAN KETUA RT ==========
     */
    
    /**
     * Halaman daftar pengajuan untuk Ketua RT
     */
    public function listForKetua() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'ketua_rt') {
            setFlash('error', 'Akses ditolak! Hanya Ketua RT yang dapat mengakses.');
            redirect('index.php?action=dashboard');
        }
        
        $pengajuanList = $this->pengajuanModel->getAllForKetua();
        
        require_once __DIR__ . '/../views/pengajuan/list_ketua.php';
    }
    
    /**
     * Halaman persetujuan pengajuan untuk Ketua RT
     */
    public function persetujuanPage() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'ketua_rt') {
            setFlash('error', 'Akses ditolak! Hanya Ketua RT yang dapat menyetujui.');
            redirect('index.php?action=dashboard');
        }
        
        $id = $_GET['id'] ?? 0;
        $pengajuan = $this->pengajuanModel->getById($id);
        
        if (!$pengajuan || $pengajuan['status'] != 'verifikasi') {
            setFlash('error', 'Pengajuan tidak ditemukan atau sudah diproses!');
            redirect('index.php?action=pengajuan-ketua');
        }
        
        require_once __DIR__ . '/../views/pengajuan/persetujuan.php';
    }
    
    /**
     * Proses persetujuan oleh Ketua RT
     */
    public function prosesPersetujuan() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'ketua_rt') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=pengajuan-ketua');
        }
        
        $id = $_POST['id'] ?? 0;
        $action = $_POST['action'] ?? '';
        $catatan = $_POST['catatan'] ?? '';
        
        $pengajuan = $this->pengajuanModel->getById($id);
        
        if (!$pengajuan || $pengajuan['status'] != 'verifikasi') {
            setFlash('error', 'Pengajuan tidak ditemukan!');
            redirect('index.php?action=pengajuan-ketua');
        }
        
        if ($action === 'setujui') {
            $nomorSurat = $this->pengajuanModel->generateNomorSurat($pengajuan['jenis_surat']);
            
            if ($this->pengajuanModel->setujuiOlehKetua($id, $_SESSION['user']['id'], $nomorSurat)) {
                setFlash('success', "✅ Pengajuan DISETUJUI!<br>Nomor Surat: <strong>$nomorSurat</strong>");
            } else {
                setFlash('error', 'Gagal menyetujui pengajuan!');
            }
        } 
        elseif ($action === 'tolak') {
            if (empty($catatan)) {
                setFlash('error', 'Harap isi alasan penolakan!');
                redirect("index.php?action=pengajuan-persetujuan&id=$id");
                return;
            }
            
            if ($this->pengajuanModel->updateStatus($id, 'ditolak', $catatan)) {
                setFlash('success', '❌ Pengajuan ditolak! Alasan telah dicatat.');
            } else {
                setFlash('error', 'Gagal menolak pengajuan!');
            }
        }
        
        redirect('index.php?action=pengajuan-ketua');
    }
}
?>