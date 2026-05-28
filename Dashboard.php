<?php
// models/Dashboard.php - Sprint 8 Final

class Dashboard {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // ========== WARGA ==========
    public function getDataWarga($userId) {
        // Cari warga_id dari user_id
        $stmt = $this->pdo->prepare("SELECT id FROM warga WHERE user_id = ?");
        $stmt->execute([$userId]);
        $warga = $stmt->fetch();
        if (!$warga) {
            return [
                'total_pengajuan' => 0,
                'disetujui' => 0,
                'menunggu' => 0,
                'riwayat' => []
            ];
        }
        $wargaId = $warga['id'];
        
        // Total pengajuan
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pengajuan_surat WHERE warga_id = ?");
        $stmt->execute([$wargaId]);
        $total = $stmt->fetchColumn();
        
        // Disetujui
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pengajuan_surat WHERE warga_id = ? AND status = 'disetujui'");
        $stmt->execute([$wargaId]);
        $disetujui = $stmt->fetchColumn();
        
        // Menunggu
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pengajuan_surat WHERE warga_id = ? AND status = 'menunggu'");
        $stmt->execute([$wargaId]);
        $menunggu = $stmt->fetchColumn();
        
        // Riwayat 5 terbaru
        $stmt = $this->pdo->prepare("SELECT * FROM pengajuan_surat WHERE warga_id = ? ORDER BY tanggal_pengajuan DESC LIMIT 5");
        $stmt->execute([$wargaId]);
        $riwayat = $stmt->fetchAll();
        
        return [
            'total_pengajuan' => $total,
            'disetujui' => $disetujui,
            'menunggu' => $menunggu,
            'riwayat' => $riwayat
        ];
    }
    
    // ========== SEKRETARIS ==========
    public function getDataSekretaris() {
        // Total warga aktif
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM warga WHERE status = 'aktif'");
        $totalWarga = $stmt->fetchColumn();
        
        // Menunggu verifikasi
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM pengajuan_surat WHERE status = 'menunggu'");
        $menunggu = $stmt->fetchColumn();
        
        // Total disetujui
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM pengajuan_surat WHERE status = 'disetujui'");
        $totalDisetujui = $stmt->fetchColumn();
        
        // Surat bulan ini
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pengajuan_surat WHERE status = 'disetujui' AND MONTH(tanggal_setuju) = MONTH(CURRENT_DATE()) AND YEAR(tanggal_setuju) = YEAR(CURRENT_DATE())");
        $stmt->execute();
        $suratBulanIni = $stmt->fetchColumn();
        
        // Pengajuan terbaru (5)
        $stmt = $this->pdo->query("SELECT p.*, w.nama_lengkap FROM pengajuan_surat p JOIN warga w ON p.warga_id = w.id ORDER BY p.tanggal_pengajuan DESC LIMIT 5");
        $pengajuanTerbaru = $stmt->fetchAll();
        
        return [
            'total_warga' => $totalWarga,
            'menunggu_verifikasi' => $menunggu,
            'total_disetujui' => $totalDisetujui,
            'surat_bulan_ini' => $suratBulanIni,
            'pengajuan_terbaru' => $pengajuanTerbaru
        ];
    }
    
    // ========== KETUA RT (Method ini yang dipanggil di controller) ==========
    public function getDataKetua() {
        // Total warga aktif
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM warga WHERE status = 'aktif'");
        $totalWarga = $stmt->fetchColumn();
        
        // Menunggu persetujuan (status verifikasi)
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM pengajuan_surat WHERE status = 'verifikasi'");
        $menunggu = $stmt->fetchColumn();
        
        // Total disetujui
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM pengajuan_surat WHERE status = 'disetujui'");
        $totalDisetujui = $stmt->fetchColumn();
        
        // Surat bulan ini
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pengajuan_surat WHERE status = 'disetujui' AND MONTH(tanggal_setuju) = MONTH(CURRENT_DATE()) AND YEAR(tanggal_setuju) = YEAR(CURRENT_DATE())");
        $stmt->execute();
        $suratBulanIni = $stmt->fetchColumn();
        
        // Pengajuan terbaru (5)
        $stmt = $this->pdo->query("SELECT p.*, w.nama_lengkap FROM pengajuan_surat p JOIN warga w ON p.warga_id = w.id ORDER BY p.tanggal_pengajuan DESC LIMIT 5");
        $pengajuanTerbaru = $stmt->fetchAll();
        
        // Data grafik 6 bulan terakhir
        $stmt = $this->pdo->query("SELECT DATE_FORMAT(tanggal_setuju, '%Y-%m') as bulan, COUNT(*) as jumlah FROM pengajuan_surat WHERE status='disetujui' AND tanggal_setuju >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH) GROUP BY DATE_FORMAT(tanggal_setuju, '%Y-%m') ORDER BY bulan ASC");
        $grafik = $stmt->fetchAll();
        
        return [
            'total_warga' => $totalWarga,
            'menunggu_persetujuan' => $menunggu,
            'total_disetujui' => $totalDisetujui,
            'surat_bulan_ini' => $suratBulanIni,
            'pengajuan_terbaru' => $pengajuanTerbaru,
            'grafik' => $grafik
        ];
    }
}
?>