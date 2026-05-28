<?php
// =====================================================
// FILE: controllers/WargaController.php
// FUNGSI: Controller untuk CRUD data warga
// =====================================================

require_once __DIR__ . '/../models/Warga.php';

class WargaController {
    private $wargaModel;
    
    public function __construct($pdo) {
        $this->wargaModel = new Warga($pdo);
    }
    
    // Halaman daftar warga
    public function index() {
        authMiddleware();
        
        // Hanya sekretaris dan ketua RT yang bisa akses
        if (!in_array($_SESSION['user']['role'], ['sekretaris', 'ketua_rt'])) {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        $search = $_GET['search'] ?? '';
        $wargaList = $this->wargaModel->getAll($search);
        
        // Untuk statistik
        $totalWarga = count($wargaList);
        $totalAktif = count(array_filter($wargaList, function($w) { return $w['status'] == 'aktif'; }));
        
        require_once __DIR__ . '/../views/warga/index.php';
    }
    
    // Halaman form tambah warga
    public function create() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Hanya Sekretaris yang dapat menambah warga!');
            redirect('index.php?action=dashboard');
        }
        
        require_once __DIR__ . '/../views/warga/create.php';
    }
    
    // Proses simpan warga
    public function store() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=warga');
        }
        
        $nik = sanitize($_POST['nik'] ?? '');
        
        // Validasi NIK
        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            setFlash('error', 'NIK harus 16 digit angka!');
            redirect('index.php?action=warga-create');
        }
        
        // Cek duplikat NIK
        if ($this->wargaModel->isNikExist($nik)) {
            setFlash('error', 'NIK sudah terdaftar!');
            redirect('index.php?action=warga-create');
        }
        
        $data = [
            'nik' => $nik,
            'no_kk' => sanitize($_POST['no_kk'] ?? ''),
            'nama_lengkap' => sanitize($_POST['nama_lengkap'] ?? ''),
            'tempat_lahir' => sanitize($_POST['tempat_lahir'] ?? ''),
            'tanggal_lahir' => $_POST['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $_POST['jenis_kelamin'] ?? '',
            'alamat' => sanitize($_POST['alamat'] ?? ''),
            'rt' => sanitize($_POST['rt'] ?? '001'),
            'rw' => sanitize($_POST['rw'] ?? '002'),
            'status' => 'aktif'
        ];
        
        if ($this->wargaModel->create($data)) {
            setFlash('success', 'Data warga berhasil ditambahkan!');
            redirect('index.php?action=warga');
        } else {
            setFlash('error', 'Gagal menambahkan data warga!');
            redirect('index.php?action=warga-create');
        }
    }
    
    // Halaman form edit warga
    public function edit() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Hanya Sekretaris yang dapat mengedit warga!');
            redirect('index.php?action=dashboard');
        }
        
        $id = $_GET['id'] ?? 0;
        $warga = $this->wargaModel->getById($id);
        
        if (!$warga) {
            setFlash('error', 'Data warga tidak ditemukan!');
            redirect('index.php?action=warga');
        }
        
        require_once __DIR__ . '/../views/warga/edit.php';
    }
    
    // Proses update warga
    public function update() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=warga');
        }
        
        $id = $_POST['id'] ?? 0;
        $nik = sanitize($_POST['nik'] ?? '');
        
        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            setFlash('error', 'NIK harus 16 digit angka!');
            redirect("index.php?action=warga-edit&id=$id");
        }
        
        if ($this->wargaModel->isNikExist($nik, $id)) {
            setFlash('error', 'NIK sudah terdaftar!');
            redirect("index.php?action=warga-edit&id=$id");
        }
        
        $data = [
            'nik' => $nik,
            'no_kk' => sanitize($_POST['no_kk'] ?? ''),
            'nama_lengkap' => sanitize($_POST['nama_lengkap'] ?? ''),
            'tempat_lahir' => sanitize($_POST['tempat_lahir'] ?? ''),
            'tanggal_lahir' => $_POST['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $_POST['jenis_kelamin'] ?? '',
            'alamat' => sanitize($_POST['alamat'] ?? ''),
            'rt' => sanitize($_POST['rt'] ?? '001'),
            'rw' => sanitize($_POST['rw'] ?? '002'),
            'status' => $_POST['status'] ?? 'aktif'
        ];
        
        if ($this->wargaModel->update($id, $data)) {
            setFlash('success', 'Data warga berhasil diupdate!');
            redirect('index.php?action=warga');
        } else {
            setFlash('error', 'Gagal mengupdate data warga!');
            redirect("index.php?action=warga-edit&id=$id");
        }
    }
    
    // Proses hapus warga
    public function delete() {
        authMiddleware();
        
        if ($_SESSION['user']['role'] != 'sekretaris') {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        $id = $_GET['id'] ?? 0;
        
        if ($this->wargaModel->delete($id)) {
            setFlash('success', 'Data warga berhasil dihapus!');
        } else {
            setFlash('error', 'Gagal menghapus data warga!');
        }
        redirect('index.php?action=warga');
    }
}
?>