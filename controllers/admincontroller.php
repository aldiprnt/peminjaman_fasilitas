<?php
require_once 'config/database.php';
require_once 'models/peminjaman.php';
require_once 'models/user.php';

class AdminController {
    private $db;
    private $peminjamanModel;
    private $userModel;

    public function __construct($db = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($db !== null) {
            $this->db = $db;
        } else {
            $database = new Database();
            $this->db = $database->getConnection();
        }

        $this->peminjamanModel = new Peminjaman($this->db);
        $this->userModel = new User($this->db);
    }

    // Menampilkan halaman login
    public function login() {
        require_once 'views/auth/login.php';
    }

    // Memproses login tunggal multi-role
    public function proses_login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id']      = $user['id_user'];
                $_SESSION['username']     = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role']         = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: index.php?action=admin");
                } else {
                    header("Location: index.php?action=user_dashboard");
                }
                exit();
            } else {
                echo "<script>alert('Username atau Password salah!'); window.location.href='index.php?action=login';</script>";
            }
        }
    }

    // Memproses logout
    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }

    // Halaman Dashboard Admin
    public function index() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo "<script>alert('Akses khusus Admin!'); window.location.href='index.php?action=login';</script>";
            exit();
        }
        $stmt = $this->peminjamanModel->readAll();
        $peminjaman = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/admin/index.php';
    }

    // METHOD UNTUK MENGUBAH STATUS (SETUJUI / TOLAK) + AUTO POTONG STOK
    public function set_status() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo "<script>alert('Akses khusus Admin!'); window.location.href='index.php?action=login';</script>";
            exit();
        }

        $id = $_GET['id'] ?? $_POST['id_peminjaman'] ?? null;
        $status_baru = $_GET['status'] ?? $_POST['status'] ?? null;

        if ($id && $status_baru) {
            try {
                // 1. Ambil detail transaksi peminjaman saat ini
                $stmt_info = $this->db->prepare("SELECT id_fasilitas, jumlah, status FROM peminjaman WHERE id_peminjaman = :id");
                $stmt_info->execute([':id' => $id]);
                $data_pinjam = $stmt_info->fetch(PDO::FETCH_ASSOC);

                if ($data_pinjam) {
                    $id_fasilitas      = $data_pinjam['id_fasilitas'];
                    $jumlah_pinjam     = (int) $data_pinjam['jumlah'];
                    $status_sebelumnya = strtolower(trim($data_pinjam['status']));
                    $status_target     = strtolower(trim($status_baru));

                    // Mulai Transaksi Database untuk keamanan data
                    $this->db->beginTransaction();

                    // 2. Jika disetujui dan sebelumnya berstatus 'Pending'
                    if ($status_target === 'disetujui' && $status_sebelumnya !== 'disetujui') {
                        // Cek stok fasilitas terlebih dahulu
                        $stmt_stok = $this->db->prepare("SELECT stok, nama_item FROM fasilitas WHERE id_fasilitas = :id_fasilitas");
                        $stmt_stok->execute([':id_fasilitas' => $id_fasilitas]);
                        $fasilitas = $stmt_stok->fetch(PDO::FETCH_ASSOC);

                        if (!$fasilitas || $fasilitas['stok'] < $jumlah_pinjam) {
                            $this->db->rollBack();
                            $stok_ada = $fasilitas['stok'] ?? 0;
                            echo "<script>alert('Gagal menyetujui! Stok tidak mencukupi (Tersisa: $stok_ada).'); window.location.href='index.php?action=admin';</script>";
                            exit();
                        }

                        // Kurangi stok fasilitas
                        $stmt_potong = $this->db->prepare("UPDATE fasilitas SET stok = stok - :jumlah WHERE id_fasilitas = :id_fasilitas");
                        $stmt_potong->execute([
                            ':jumlah'      => $jumlah_pinjam,
                            ':id_fasilitas' => $id_fasilitas
                        ]);
                    } 
                    // 3. Jika status diubah ke 'Ditolak' dari yang tadinya sudah 'Disetujui', kembalikan stoknya
                    elseif ($status_target === 'ditolak' && $status_sebelumnya === 'disetujui') {
                        $stmt_kembali = $this->db->prepare("UPDATE fasilitas SET stok = stok + :jumlah WHERE id_fasilitas = :id_fasilitas");
                        $stmt_kembali->execute([
                            ':jumlah'      => $jumlah_pinjam,
                            ':id_fasilitas' => $id_fasilitas
                        ]);
                    }

                    // 4. Update status peminjaman pada model/tabel
                    $this->peminjamanModel->updateStatus($id, $status_baru);

                    $this->db->commit();
                }
            } catch (Exception $e) {
                if ($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                echo "<script>alert('Terjadi kesalahan database: " . addslashes($e->getMessage()) . "');</script>";
            }
        }

        header("Location: index.php?action=admin");
        exit();
    }
}
?>