<?php
// controllers/LaporanController.php - Tanpa PDF, menggunakan Cetak Halaman & CSV

require_once __DIR__ . '/../models/Laporan.php';
// Hapus baris require_once PdfLaporan.php karena tidak digunakan lagi
// require_once __DIR__ . '/../helpers/PdfLaporan.php';

class LaporanController {
    private $laporanModel;
    
    public function __construct($pdo) {
        $this->laporanModel = new Laporan($pdo);
    }
    
    /**
     * Halaman laporan
     */
    public function index() {
        authMiddleware();
        if (!in_array($_SESSION['user']['role'], ['sekretaris', 'ketua_rt'])) {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        $tglMulai = $_GET['start_date'] ?? date('Y-m-01');
        $tglSelesai = $_GET['end_date'] ?? date('Y-m-t');
        
        $ringkasan = $this->laporanModel->getRingkasan($tglMulai, $tglSelesai);
        $statistikJenis = $this->laporanModel->getStatistikJenis($tglMulai, $tglSelesai);
        $detailSurat = $this->laporanModel->getDetailSurat($tglMulai, $tglSelesai);
        $trenBulanan = $this->laporanModel->getTrenBulanan();
        
        require_once __DIR__ . '/../views/laporan/index.php';
    }
    
    /**
     * Export ke PDF - Dinonaktifkan, arahkan ke halaman laporan dengan pesan
     */
    public function exportPdf() {
        authMiddleware();
        if (!in_array($_SESSION['user']['role'], ['sekretaris', 'ketua_rt'])) {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        // Set flash message bahwa PDF tidak tersedia, arahkan ke laporan
        setFlash('error', 'Fitur PDF sedang dalam perbaikan. Silakan gunakan tombol Cetak Halaman atau Export CSV.');
        redirect('index.php?action=laporan');
    }
    
    /**
     * Export ke CSV
     */
    public function exportCsv() {
        authMiddleware();
        if (!in_array($_SESSION['user']['role'], ['sekretaris', 'ketua_rt'])) {
            setFlash('error', 'Akses ditolak!');
            redirect('index.php?action=dashboard');
        }
        
        $tglMulai = $_GET['start_date'] ?? date('Y-m-01');
        $tglSelesai = $_GET['end_date'] ?? date('Y-m-t');
        $detailSurat = $this->laporanModel->getDetailSurat($tglMulai, $tglSelesai);
        
        // Set header CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="laporan_surat_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['No', 'Nomor Surat', 'Jenis Surat', 'Nama Warga', 'NIK', 'Tanggal Pengajuan', 'Tanggal Disetujui']);
        
        $no = 1;
        foreach ($detailSurat as $row) {
            fputcsv($output, [
                $no++,
                $row['nomor_surat'],
                $this->getJenisLabel($row['jenis_surat']),
                $row['nama_warga'],
                $row['nik'],
                date('d/m/Y', strtotime($row['tanggal_pengajuan'])),
                date('d/m/Y', strtotime($row['tanggal_setuju']))
            ]);
        }
        fclose($output);
        exit;
    }
    
    private function getJenisLabel($jenis) {
        $labels = [
            'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
            'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'surat_pengantar_ktp' => 'Surat Pengantar KTP',
            'surat_keterangan_kelahiran' => 'Surat Keterangan Kelahiran',
            'surat_keterangan_kematian' => 'Surat Keterangan Kematian'
        ];
        return $labels[$jenis] ?? $jenis;
    }
}
?>