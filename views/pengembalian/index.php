<?php 
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../layouts/navbar.php'; 
?>

<div class="container my-4" style="max-width: 700px;">
    <h2>Halaman Input Pengembalian Barang</h2>
    <p class="text-muted">Silakan pilih barang yang sedang dipinjam dan unggah foto kondisi saat dikembalikan.</p>

    <div class="card p-4 shadow-sm border-0">
        <form action="index.php?action=simpan_pengembalian" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Transaksi Peminjaman:</label>
                <select name="id_peminjaman" class="form-select" required>
                    <option value="">-- Pilih Transaksi --</option>
                    <?php if (!empty($list_pinjam)) : ?>
                        <?php foreach ($list_pinjam as $item) : ?>
                            <option value="<?= $item['id_peminjaman']; ?>">
                                Transaksi #<?= $item['id_peminjaman']; ?> - <?= htmlspecialchars($item['nama_mahasiswa']); ?> (<?= htmlspecialchars($item['nama_item']); ?>) [Status: <?= htmlspecialchars($item['status'] ?? 'Aktif'); ?>]
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="" disabled>Tidak ada data peminjaman di database</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Upload Foto Bukti Pengembalian (Kondisi Barang):</label>
                <input type="file" name="foto_kembali" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Proses Input Pengembalian</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>