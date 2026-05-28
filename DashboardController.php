<?php
// =====================================================
// FILE: controllers/DashboardController.php
// FUNGSI: Mengelola halaman dashboard sesuai role (Sprint 8)
// =====================================================

require_once __DIR__ . '/../models/Dashboard.php';

class DashboardController {
    private $dashboardModel;
    
    public function __construct($pdo) {
        $this->dashboardModel = new Dashboard($pdo);
    }
    
    /**
     * Tampilkan dashboard sesuai role user dengan data statistik realtime
     */
    public function index() {
        // Cek apakah user sudah login
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit();
        }
        
        $role = $_SESSION['user']['role'];
        
        // Ambil data berdasarkan role
        switch ($role) {
            case 'warga':
                $data = $this->dashboardModel->getDataWarga($_SESSION['user']['id']);
                $view = __DIR__ . '/../views/dashboard/warga.php';
                break;
            case 'sekretaris':
                $data = $this->dashboardModel->getDataSekretaris();
                $view = __DIR__ . '/../views/dashboard/sekretaris.php';
                break;
            case 'ketua_rt':
                // Perbaiki: panggil method getDataKetua (bukan getDataKetuaRt)
                $data = $this->dashboardModel->getDataKetua();
                $view = __DIR__ . '/../views/dashboard/ketua_rt.php';
                break;
            default:
                $view = __DIR__ . '/../views/dashboard/warga.php';
                $data = [];
        }
        
        // Pastikan view ada
        if (!file_exists($view)) {
            // Fallback jika view tidak ditemukan
            require_once __DIR__ . '/../views/partials/header.php';
            echo '<div class="dashboard-container"><div class="sidebar"><h2>SIRT</h2><nav><a href="index.php?action=logout">🚪 Logout</a></nav></div>';
            echo '<div class="main-content"><div class="top-bar"><h3>Dashboard</h3></div>';
            echo '<div class="content-card"><h2>Selamat Datang, ' . htmlspecialchars($_SESSION['user']['fullname']) . '!</h2>';
            echo '<p>Dashboard untuk role <strong>' . $role . '</strong> sedang dalam pengembangan.</p></div></div></div>';
            require_once __DIR__ . '/../views/partials/footer.php';
            return;
        }
        
        // Load view dengan data
        require_once __DIR__ . '/../views/partials/header.php';
        require $view;
        require_once __DIR__ . '/../views/partials/footer.php';
    }
}
?>