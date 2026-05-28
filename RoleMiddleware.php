<?php
// =====================================================
// FILE: middleware/RoleMiddleware.php
// FUNGSI: Memastikan user memiliki role yang sesuai
// =====================================================

class RoleMiddleware {
    
    /**
     * Cek apakah user memiliki role yang diizinkan
     * @param array|string $allowedRoles Role yang diizinkan
     */
    public static function handle($allowedRoles) {
        // Pastikan user sudah login
        AuthMiddleware::handle();
        
        // Jika allowedRoles adalah string, ubah ke array
        if (!is_array($allowedRoles)) {
            $allowedRoles = [$allowedRoles];
        }
        
        $userRole = $_SESSION['user']['role'] ?? null;
        
        if (!in_array($userRole, $allowedRoles)) {
            setFlash('error', 'Anda tidak memiliki akses ke halaman ini');
            header('Location: index.php?action=dashboard');
            exit();
        }
        
        return true;
    }
    
    /**
     * Cek apakah user memiliki role tertentu (tanpa redirect)
     */
    public static function check($role) {
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
    }
}
?>