<?php
// =====================================================
// FILE: models/Warga.php
// FUNGSI: Model untuk tabel warga
// =====================================================

class Warga {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Ambil semua warga dengan pencarian
    public function getAll($search = '') {
        if ($search) {
            $stmt = $this->pdo->prepare("SELECT * FROM warga WHERE nama_lengkap LIKE ? OR nik LIKE ? OR no_kk LIKE ? ORDER BY nama_lengkap ASC");
            $stmt->execute(["%$search%", "%$search%", "%$search%"]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM warga ORDER BY nama_lengkap ASC");
        }
        return $stmt->fetchAll();
    }
    
    // Ambil warga by ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM warga WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ========== BARU: Ambil warga by User ID ==========
    public function getByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM warga WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    // =================================================
    
    // Cek NIK duplikat
    public function isNikExist($nik, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM warga WHERE nik = ? AND id != ?");
            $stmt->execute([$nik, $excludeId]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM warga WHERE nik = ?");
            $stmt->execute([$nik]);
        }
        return $stmt->fetchColumn() > 0;
    }
    
    // Tambah warga
    public function create($data) {
        $sql = "INSERT INTO warga (nik, no_kk, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, rt, rw, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nik'], $data['no_kk'], $data['nama_lengkap'],
            $data['tempat_lahir'], $data['tanggal_lahir'], $data['jenis_kelamin'],
            $data['alamat'], $data['rt'], $data['rw'], $data['status']
        ]);
    }
    
    // Update warga
    public function update($id, $data) {
        $sql = "UPDATE warga SET nik=?, no_kk=?, nama_lengkap=?, tempat_lahir=?, tanggal_lahir=?, 
                jenis_kelamin=?, alamat=?, rt=?, rw=?, status=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nik'], $data['no_kk'], $data['nama_lengkap'],
            $data['tempat_lahir'], $data['tanggal_lahir'], $data['jenis_kelamin'],
            $data['alamat'], $data['rt'], $data['rw'], $data['status'], $id
        ]);
    }
    
    // Hapus warga
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM warga WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    // Hitung total warga
    public function countAll() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM warga");
        return $stmt->fetchColumn();
    }
}
?>