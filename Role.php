<?php
// =====================================================
// FILE: models/Role.php
// FUNGSI: Model untuk tabel roles
// =====================================================

class Role {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Get semua roles
     */
    public function getAll() {
        $sql = "SELECT * FROM roles ORDER BY id ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Cari role berdasarkan ID
     */
    public function findById($id) {
        $sql = "SELECT * FROM roles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Cari role berdasarkan name
     */
    public function findByName($name) {
        $sql = "SELECT * FROM roles WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
        return $stmt->fetch();
    }
    
    /**
     * Get ID role berdasarkan name
     */
    public function getIdByName($name) {
        $role = $this->findByName($name);
        return $role ? $role['id'] : null;
    }
    
    /**
     * Create role baru
     */
    public function create($data) {
        $sql = "INSERT INTO roles (name, description) VALUES (:name, :description)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'] ?? null
        ]);
    }
    
    /**
     * Update role
     */
    public function update($id, $data) {
        $sql = "UPDATE roles SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'id' => $id
        ]);
    }
    
    /**
     * Delete role
     */
    public function delete($id) {
        $sql = "DELETE FROM roles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>