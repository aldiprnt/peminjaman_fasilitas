<?php
require_once 'config/database.php';
require_once 'models/peminjaman.php';
require_once 'models/fasilitas.php';

class MahasiswaController {
    private $db;
    private $peminjamanModel;
    private $fasilitasModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->peminjamanModel = new Peminjaman($this->db);
        $this->fasilitasModel = new Fasilitas($this->db);
    }

    // 1. Menampilkan Dashboard Mahasiswa dengan Hitungan Statistik Riil
    public function dashboard() {
        try {
            // Hitung statistik transaksi berdasarkan status di tabel peminjaman
            $stmt_pending = $this->db->query("SELECT COUNT(*) FROM peminjaman WHERE LOWER(status) = 'pending'");
            $total_pending = $stmt_pending->fetchColumn();

            $stmt_disetujui = $this->db->query("SELECT COUNT(*) FROM peminjaman WHERE LOWER(status) = 'disetujui'");
            $total_disetujui = $stmt_disetujui->fetchColumn();

            $stmt_dikembalikan = $this->db->query("SELECT COUNT(*) FROM peminjaman WHERE LOWER(status) = 'dikembalikan'");
            $total_dikembalikan = $stmt_dikembalikan->fetchColumn();

        } catch (Exception $e) {
            $total_pending = 0;
            $total_disetujui = 0;
            $total_dikembalikan = 0;
        }

        require_once 'views/mahasiswa/dashboard.php';
    }

    // 2. Menampilkan form peminjaman beserta pilihan fasilitas
    public function index() {
        $stmt = $this->fasilitasModel->readAll();
        $list_fasilitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/mahasiswa/index.php';
    }

    // 3. Memproses simpan pengajuan peminjaman
    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_fasilitas = $_POST['id_fasilitas'] ?? '';

            if (empty($id_fasilitas)) {
                echo "<script>alert('Silakan pilih fasilitas yang ingin dipinjam!'); window.history.back();</script>";
                return;
            }

            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $foto_pinjam = "";
            if (isset($_FILES['foto_pinjam']) && $_FILES['foto_pinjam']['error'] === UPLOAD_ERR_OK) {
                $foto_pinjam = time() . '_' . basename($_FILES['foto_pinjam']['name']);
                move_uploaded_file($_FILES['foto_pinjam']['tmp_name'], $target_dir . $foto_pinjam);
            }

            $this->peminjamanModel->create(
                $_POST['nim'],
                $_POST['nama_mahasiswa'],
                $id_fasilitas,
                $_POST['tgl_pinjam'],
                $_POST['tgl_kembali'],
                $_POST['jumlah'],
                $foto_pinjam
            );

            echo "<script>alert('Pengajuan peminjaman berhasil dikirim!'); window.location.href='index.php?action=cek_status&nim=" . urlencode($_POST['nim']) . "';</script>";
        }
    }

    // 4. Method untuk menampilkan pencarian status peminjaman mahasiswa
    public function status() {
        $nim = $_GET['nim'] ?? '';
        $riwayat = [];

        if (!empty($nim)) {
            $query = "SELECT p.*, f.nama_item 
                      FROM peminjaman p 
                      JOIN fasilitas f ON p.id_fasilitas = f.id_fasilitas 
                      WHERE p.nim = :nim 
                      ORDER BY p.id_peminjaman DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nim', $nim);
            $stmt->execute();
            $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        require_once 'views/mahasiswa/status.php';
    }
}
?>