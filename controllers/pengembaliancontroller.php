<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class PengembalianController {
    private $db;

    public function __construct($db = null) {
        if ($db !== null) {
            $this->db = $db;
        } else {
            global $db, $koneksi, $conn, $pdo;
            $this->db = $db ?? $koneksi ?? $conn ?? $pdo;
        }

        if (!$this->db) {
            try {
                $host = 'localhost';
                $dbname = 'peminjaman_aula';
                $username = 'root';
                $password = '';

                $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Koneksi Database Gagal: " . $e->getMessage());
            }
        }
    }

    // 1. Menampilkan Halaman Form Pengembalian (Hanya Transaksi Berstatus 'Disetujui')
    public function index() {
        try {
            // Filter hanya peminjaman yang sudah disetujui admin
            $query = "SELECT p.id_peminjaman, 
                             p.nama_mahasiswa, 
                             p.nim, 
                             COALESCE(f.nama_item, 'Fasilitas Kampus') AS nama_item,
                             p.status
                      FROM peminjaman p
                      LEFT JOIN fasilitas f ON p.id_fasilitas = f.id_fasilitas
                      WHERE LOWER(p.status) = 'disetujui'
                      ORDER BY p.id_peminjaman DESC";

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $list_pinjam = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $list_pinjam = [];
        }

        require_once __DIR__ . '/../views/pengembalian/index.php';
    }

    // 2. Memproses Simpan Pengembalian & Retur Stok
    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_peminjaman = $_POST['id_peminjaman'] ?? null;
            $foto = $_FILES['foto_kembali'] ?? null;

            if (!$id_peminjaman || !$foto || $foto['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Gagal mengunggah foto bukti pengembalian!";
                header('Location: index.php?action=pengembalian');
                exit;
            }

            $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
            $file_ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowed_ext)) {
                $_SESSION['error'] = "Format file tidak valid! Harap upload foto (JPG, PNG, WEBP).";
                header('Location: index.php?action=pengembalian');
                exit;
            }

            $nama_foto_baru = 'kembali_' . time() . '_' . rand(100, 999) . '.' . $file_ext;
            $target_dir = __DIR__ . '/../uploads/' . $nama_foto_baru;

            if (move_uploaded_file($foto['tmp_name'], $target_dir)) {
                try {
                    $this->db->beginTransaction();

                    $query_info = "SELECT id_fasilitas, jumlah FROM peminjaman WHERE id_peminjaman = :id";
                    $stmt_info = $this->db->prepare($query_info);
                    $stmt_info->execute([':id' => $id_peminjaman]);
                    $data_pinjam = $stmt_info->fetch(PDO::FETCH_ASSOC);

                    if ($data_pinjam) {
                        $id_fasilitas = $data_pinjam['id_fasilitas'];
                        $jumlah_kembali = $data_pinjam['jumlah'];

                        $query_update = "UPDATE peminjaman 
                                        SET status = 'Dikembalikan', foto_kembali = :foto 
                                        WHERE id_peminjaman = :id";
                        $stmt_update = $this->db->prepare($query_update);
                        $stmt_update->execute([
                            ':foto' => $nama_foto_baru,
                            ':id'   => $id_peminjaman
                        ]);

                        $query_stok = "UPDATE fasilitas 
                                       SET stok = stok + :jumlah 
                                       WHERE id_fasilitas = :id_fasilitas";
                        $stmt_stok = $this->db->prepare($query_stok);
                        $stmt_stok->execute([
                            ':jumlah'       => $jumlah_kembali,
                            ':id_fasilitas' => $id_fasilitas
                        ]);

                        $this->db->commit();
                        $_SESSION['success'] = "Pengembalian barang berhasil diproses! Stok fasilitas telah diperbarui.";
                    } else {
                        $this->db->rollBack();
                        $_SESSION['error'] = "Data peminjaman tidak ditemukan.";
                    }

                } catch (Exception $e) {
                    $this->db->rollBack();
                    $_SESSION['error'] = "Terjadi kesalahan database: " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Gagal menyimpan file ke folder uploads.";
            }

            header('Location: index.php?action=cek_status');
            exit;
        }
    }
}