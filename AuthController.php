<?php
// =====================================================
// FILE: controllers/AuthController.php
// FUNGSI: Controller untuk autentikasi
// =====================================================

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;
    
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }
    
    // Tampilkan halaman login
    public function showLogin() {
        // Jika sudah login, redirect sesuai role
        if (isLoggedIn()) {
            redirect('index.php?action=dashboard');
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
    // Proses login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?action=login');
        }
        
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validasi input kosong
        if (empty($username) || empty($password)) {
            setFlash('error', 'Username dan password harus diisi!');
            redirect('index.php?action=login');
        }
        
        // Cari user di database
        $user = $this->userModel->findByUsername($username);
        
        // Verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            
            // Set session dengan role yang benar
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'role' => $user['role_name']  // 'warga', 'sekretaris', atau 'ketua_rt'
            ];
            
            // Update last login
            $this->userModel->updateLastLogin($user['id']);
            
            setFlash('success', 'Selamat datang, ' . $user['fullname']);
            redirect('index.php?action=dashboard');
        } else {
            setFlash('error', 'Username atau password salah!');
            redirect('index.php?action=login');
        }
    }
    
    // Logout
    public function logout() {
        doLogout();
        setFlash('success', 'Anda telah logout');
        redirect('index.php?action=login');
    }
}
?>