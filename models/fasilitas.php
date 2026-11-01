<?php
class Fasilitas {
    private $db;
    private $table = 'fasilitas';

    public function __construct($db) {
        $this->db = $db;
    }

    // --- FITUR UNTUK SEARCH & PAGINATION ---

    // Hitung total data untuk pencarian dan pagination
    public function getTotalFasilitas($keyword = '') {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE nama_item LIKE :keyword OR deskripsi LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $searchKey = "%$keyword%";
        $stmt->bindParam(':keyword', $searchKey);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Ambil data dengan LIMIT 10 dan OFFSET
    public function getFasilitasPaged($keyword = '', $limit = 10, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE nama_item LIKE :keyword OR deskripsi LIKE :keyword 
                  ORDER BY id_fasilitas DESC 
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $searchKey = "%$keyword%";
        $stmt->bindParam(':keyword', $searchKey);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // --- FITUR CRUD BAWAAN ---

    public function readAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id_fasilitas DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_fasilitas = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nama_item, $id_kategori, $stok, $deskripsi) {
        $query = "INSERT INTO " . $this->table . " (nama_item, id_kategori, stok, deskripsi) 
                  VALUES (:nama_item, :id_kategori, :stok, :deskripsi)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama_item', $nama_item);
        $stmt->bindParam(':id_kategori', $id_kategori);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':deskripsi', $deskripsi);
        return $stmt->execute();
    }

    public function update($id, $nama_item, $id_kategori, $stok, $deskripsi) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_item = :nama_item, id_kategori = :id_kategori, stok = :stok, deskripsi = :deskripsi 
                  WHERE id_fasilitas = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama_item', $nama_item);
        $stmt->bindParam(':id_kategori', $id_kategori);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':deskripsi', $deskripsi);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_fasilitas = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>