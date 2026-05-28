<?php
// =====================================================
// FILE: models/Pengajuan.php
// FUNGSI: Model untuk tabel pengajuan_surat
// =====================================================

class Pengajuan {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Cari warga_id berdasarkan user_id
     */
    public function getWargaIdByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT id FROM warga WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        return $result ? $result['id'] : null;
    }
    
    /**
     * Simpan pengajuan baru
     */
    public function create($data) {
        $sql = "INSERT INTO pengajuan_surat (warga_id, jenis_surat, keperluan, data_pendukung, file_pendukung) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['warga_id'], 
            $data['jenis_surat'], 
            $data['keperluan'],
            $data['data_pendukung'] ?? null, 
            $data['file_pendukung'] ?? null
        ]);
    }
    
    /**
     * Ambil riwayat pengajuan warga
     */
    public function getByWargaId($wargaId) {
        $stmt = $this->pdo->prepare("SELECT * FROM pengajuan_surat WHERE warga_id = ? ORDER BY tanggal_pengajuan DESC");
        $stmt->execute([$wargaId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Ambil semua pengajuan (untuk sekretaris) - SPRINT 4
     */
    public function getAllForSekretaris() {
        $stmt = $this->pdo->query("
            SELECT p.*, 
                   w.nama_lengkap as nama_warga, 
                   w.nik, 
                   w.rt, 
                   w.rw,
                   v.fullname as nama_verifikator
            FROM pengajuan_surat p
            JOIN warga w ON p.warga_id = w.id
            LEFT JOIN users v ON p.verifikasi_oleh = v.id
            ORDER BY FIELD(p.status, 'menunggu', 'verifikasi', 'disetujui', 'ditolak'), p.tanggal_pengajuan DESC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Ambil semua pengajuan (untuk ketua RT) - SPRINT 5
     */
    public function getAllForKetua() {
        $stmt = $this->pdo->query("
            SELECT p.*, 
                   w.nama_lengkap as nama_warga, 
                   w.nik, 
                   w.rt, 
                   w.rw,
                   v.fullname as nama_verifikator
            FROM pengajuan_surat p
            JOIN warga w ON p.warga_id = w.id
            LEFT JOIN users v ON p.verifikasi_oleh = v.id
            WHERE p.status = 'verifikasi'
            ORDER BY p.tanggal_verifikasi ASC
        ");
        return $stmt->fetchAll();
    }
    
    /**
     * Ambil pengajuan by ID
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, 
                   w.nama_lengkap as nama_warga, 
                   w.nik, 
                   w.alamat, 
                   w.rt, 
                   w.rw,
                   v.fullname as nama_verifikator,
                   s.fullname as nama_setuju
            FROM pengajuan_surat p
            JOIN warga w ON p.warga_id = w.id
            LEFT JOIN users v ON p.verifikasi_oleh = v.id
            LEFT JOIN users s ON p.setuju_oleh = s.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Update status
     */
    public function updateStatus($id, $status, $catatan = null) {
        $sql = "UPDATE pengajuan_surat SET status = ?, catatan_verifikasi = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $catatan, $id]);
    }
    
    /**
     * ========== SPRINT 4: VERIFIKASI ==========
     */
    
    /**
     * Verifikasi pengajuan (setujui - lanjut ke Ketua RT)
     */
    public function verifikasiSetujui($id, $verifikatorId) {
        $sql = "UPDATE pengajuan_surat 
                SET status = 'verifikasi', 
                    catatan_verifikasi = 'Telah diverifikasi oleh Sekretaris, menunggu persetujuan Ketua RT',
                    verifikasi_oleh = ?,
                    tanggal_verifikasi = NOW() 
                WHERE id = ? AND status = 'menunggu'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$verifikatorId, $id]);
    }
    
    /**
     * Verifikasi pengajuan (tolak dengan catatan)
     */
    public function verifikasiTolak($id, $catatan, $verifikatorId) {
        $sql = "UPDATE pengajuan_surat 
                SET status = 'ditolak', 
                    catatan_verifikasi = ?,
                    verifikasi_oleh = ?,
                    tanggal_verifikasi = NOW() 
                WHERE id = ? AND status = 'menunggu'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$catatan, $verifikatorId, $id]);
    }
    
    /**
     * ========== SPRINT 5: PERSETUJUAN KETUA RT ==========
     */
    
    /**
     * Setujui pengajuan oleh Ketua RT
     */
    public function setujuiOlehKetua($id, $ketuaId, $nomorSurat) {
        $sql = "UPDATE pengajuan_surat 
                SET status = 'disetujui', 
                    nomor_surat = ?,
                    setuju_oleh = ?,
                    tanggal_setuju = NOW() 
                WHERE id = ? AND status = 'verifikasi'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nomorSurat, $ketuaId, $id]);
    }
    
    /**
     * Generate nomor surat otomatis
     */
    public function generateNomorSurat($jenisSurat) {
        $prefix = [
            'surat_keterangan_domisili' => 'SKD',
            'surat_keterangan_usaha' => 'SKU',
            'surat_keterangan_tidak_mampu' => 'SKTM',
            'surat_pengantar_ktp' => 'SPKTP',
            'surat_keterangan_kelahiran' => 'SKKL',
            'surat_keterangan_kematian' => 'SKKM'
        ];
        
        $code = $prefix[$jenisSurat] ?? 'SRT';
        $tahun = date('Y');
        $bulan = date('m');
        $no = rand(1, 999);
        
        return sprintf("%s/%03d/%02d/%s", $code, $no, $bulan, $tahun);
    }
}
?>