<?php
class Peminjaman {
    private $conn;
    private $table_name = "peminjaman";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Simpan pengajuan peminjaman baru beserta nama file foto
    public function create($nim, $nama_mahasiswa, $id_fasilitas, $tgl_pinjam, $tgl_kembali, $jumlah, $foto_pinjam) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nim, nama_mahasiswa, id_fasilitas, tgl_pinjam, tgl_kembali, jumlah, foto_pinjam, status) 
                  VALUES (:nim, :nama, :id_fasilitas, :tgl_pinjam, :tgl_kembali, :jumlah, :foto_pinjam, 'Pending')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nim', $nim);
        $stmt->bindParam(':nama', $nama_mahasiswa);
        $stmt->bindParam(':id_fasilitas', $id_fasilitas);
        $stmt->bindParam(':tgl_pinjam', $tgl_pinjam);
        $stmt->bindParam(':tgl_kembali', $tgl_kembali);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':foto_pinjam', $foto_pinjam);

        return $stmt->execute();
    }

    // Ambil semua data peminjaman untuk admin
    public function readAll() {
        $query = "SELECT p.*, f.nama_item, f.kategori 
                  FROM " . $this->table_name . " p 
                  JOIN fasilitas f ON p.id_fasilitas = f.id_fasilitas 
                  ORDER BY p.id_peminjaman DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update status peminjaman (Disetujui/Ditolak)
    public function updateStatus($id_peminjaman, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id_peminjaman = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id_peminjaman);
        return $stmt->execute();
    }
}
?>