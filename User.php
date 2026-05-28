<?php
// =====================================================
// FILE: models/User.php
// FUNGSI: Model untuk tabel users
// =====================================================

class User {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Cari user lengkap dengan role name
    public function findByUsername($username) {
        $sql = "SELECT u.*, r.name as role_name 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                WHERE u.username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    // Update last login
    public function updateLastLogin($userId) {
        $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        return $stmt->execute([$userId]);
    }
}
?>