<?php
// models/Laporan.php

class Laporan {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
 * Ringkasan laporan per periode
 */
public function getRingkasan($tglMulai, $tglSelesai) {
    // Total surat disetujui
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pengajuan_surat WHERE status='disetujui' AND tanggal_setuju BETWEEN ? AND ?");
    $stmt->execute([$tglMulai, $tglSelesai]);
    $totalSurat = $stmt->fetchColumn();

    // Total warga aktif
    $stmtWarga = $this->pdo->query("SELECT COUNT(*) FROM warga WHERE status='aktif'");
    $totalWarga = $stmtWarga->fetchColumn();

    // Rata-rata waktu proses (hari)
    $stmtAvg = $this->pdo->prepare("SELECT AVG(DATEDIFF(tanggal_setuju, tanggal_pengajuan)) FROM pengajuan_surat WHERE status='disetujui' AND tanggal_setuju BETWEEN ? AND ?");
    $stmtAvg->execute([$tglMulai, $tglSelesai]);
    $avg = $stmtAvg->fetchColumn();
    $rataHari = ($avg !== null && $avg !== false) ? round($avg, 1) : 0;

    return [
        'total_surat' => $totalSurat,
        'total_warga' => $totalWarga,
        'rata_hari' => $rataHari,
        'tgl_mulai' => $tglMulai,
        'tgl_selesai' => $tglSelesai
    ];
}
    /**
     * Statistik jenis surat
     */
    public function getStatistikJenis($tglMulai, $tglSelesai) {
        $sql = "SELECT 
                    jenis_surat,
                    COUNT(*) as jumlah,
                    CASE jenis_surat
                        WHEN 'surat_keterangan_domisili' THEN 'Surat Keterangan Domisili'
                        WHEN 'surat_keterangan_usaha' THEN 'Surat Keterangan Usaha'
                        WHEN 'surat_keterangan_tidak_mampu' THEN 'Surat Keterangan Tidak Mampu'
                        WHEN 'surat_pengantar_ktp' THEN 'Surat Pengantar KTP'
                        WHEN 'surat_keterangan_kelahiran' THEN 'Surat Keterangan Kelahiran'
                        WHEN 'surat_keterangan_kematian' THEN 'Surat Keterangan Kematian'
                    END as label
                FROM pengajuan_surat
                WHERE status='disetujui' AND tanggal_setuju BETWEEN ? AND ?
                GROUP BY jenis_surat
                ORDER BY jumlah DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tglMulai, $tglSelesai]);
        return $stmt->fetchAll();
    }
    
    /**
     * Detail surat disetujui per periode
     */
    public function getDetailSurat($tglMulai, $tglSelesai) {
        $sql = "SELECT 
                    p.nomor_surat,
                    p.jenis_surat,
                    p.keperluan,
                    p.tanggal_pengajuan,
                    p.tanggal_setuju,
                    w.nama_lengkap as nama_warga,
                    w.nik
                FROM pengajuan_surat p
                JOIN warga w ON p.warga_id = w.id
                WHERE p.status='disetujui' AND p.tanggal_setuju BETWEEN ? AND ?
                ORDER BY p.tanggal_setuju DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tglMulai, $tglSelesai]);
        return $stmt->fetchAll();
    }
    
    /**
     * Data untuk grafik tren bulanan (6 bulan terakhir)
     */
    public function getTrenBulanan() {
        $sql = "SELECT 
                    DATE_FORMAT(tanggal_setuju, '%Y-%m') as bulan,
                    COUNT(*) as jumlah
                FROM pengajuan_surat
                WHERE status='disetujui' 
                    AND tanggal_setuju >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
                GROUP BY DATE_FORMAT(tanggal_setuju, '%Y-%m')
                ORDER BY bulan ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>