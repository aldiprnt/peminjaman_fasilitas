<?php
require_once 'config/database.php';
require_once 'models/fasilitas.php';

class FasilitasController {
    private $db;
    private $fasilitasModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->fasilitasModel = new Fasilitas($this->db);
    }

    public function index() {
        // Tangkap pencarian dan halaman aktif
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $limit = 10; // Syarat UTS: Maksimal 10 data per halaman
        $offset = ($page - 1) * $limit;

        // Hitung total data & total halaman
        $totalData = $this->fasilitasModel->getTotalFasilitas($keyword);
        $totalPages = ceil($totalData / $limit);

        // Ambil data yang sudah terpaginasi
        $stmt = $this->fasilitasModel->getFasilitasPaged($keyword, $limit, $offset);
        $fasilitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kirim variabel ke view
        require_once 'views/fasilitas/index.php';
    }

    public function kelola() {
        $stmt = $this->fasilitasModel->readAll();
        $fasilitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/fasilitas/kelola.php';
    }

    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->fasilitasModel->create(
                $_POST['nama_item'],
                $_POST['id_kategori'],
                $_POST['stok'],
                $_POST['deskripsi']
            );
            header("Location: index.php?action=kelola_fasilitas");
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->fasilitasModel->update(
                $id,
                $_POST['nama_item'],
                $_POST['id_kategori'],
                $_POST['stok'],
                $_POST['deskripsi']
            );
            header("Location: index.php?action=kelola_fasilitas");
            exit();
        } else {
            $data = $this->fasilitasModel->getById($id);
            require_once 'views/fasilitas/edit.php';
        }
    }

    public function hapus() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->fasilitasModel->delete($id);
        }
        header("Location: index.php?action=kelola_fasilitas");
        exit();
    }
}
?>