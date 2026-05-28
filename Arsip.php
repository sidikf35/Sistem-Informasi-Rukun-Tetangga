<?php
// models/Arsip.php

class Arsip {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Simpan arsip
    public function simpan($data) {
        $sql = "INSERT INTO arsip_surat (surat_id, nomor_surat, jenis_surat, nama_warga, nik, file_path, tahun, bulan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['surat_id'],
            $data['nomor_surat'],
            $data['jenis_surat'],
            $data['nama_warga'],
            $data['nik'],
            $data['file_path'],
            date('Y'),
            date('m')
        ]);
    }
    
    // Get semua arsip dengan filter
    public function getAll($search = '', $jenis = '', $bulan = '', $tahun = '') {
        $sql = "SELECT * FROM arsip_surat WHERE 1=1";
        $params = [];
        if (!empty($search)) {
            $sql .= " AND (nomor_surat LIKE ? OR nama_warga LIKE ? OR nik LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm; $params[] = $searchTerm; $params[] = $searchTerm;
        }
        if (!empty($jenis) && $jenis != 'semua') {
            $sql .= " AND jenis_surat = ?";
            $params[] = $jenis;
        }
        if (!empty($bulan) && $bulan != 'semua') {
            $sql .= " AND bulan = ?";
            $params[] = $bulan;
        }
        if (!empty($tahun) && $tahun != 'semua') {
            $sql .= " AND tahun = ?";
            $params[] = $tahun;
        }
        $sql .= " ORDER BY tanggal_arsip DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    // Get arsip by ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM arsip_surat WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Hapus arsip
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM arsip_surat WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    // Statistik
    public function getStatistik() {
        $stats = [];
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM arsip_surat");
        $stats['total'] = $stmt->fetchColumn();
        $stmt = $this->pdo->query("SELECT jenis_surat, COUNT(*) as jumlah FROM arsip_surat GROUP BY jenis_surat");
        $stats['per_jenis'] = $stmt->fetchAll();
        return $stats;
    }
    
    // Daftar tahun untuk filter
    public function getTahunList() {
        $stmt = $this->pdo->query("SELECT DISTINCT tahun FROM arsip_surat ORDER BY tahun DESC");
        return $stmt->fetchAll();
    }
}
?>