<?php 
// Panggil Partial Template (Header & Navbar)
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/navbar.php'; 

// Cek status role admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Fasilitas Kampus</h2>
        <?php if ($isAdmin): ?>
            <a href="index.php?action=kelola_fasilitas" class="btn btn-primary">
                <i class="fas fa-plus"></i> Kelola / Tambah Fasilitas
            </a>
        <?php endif; ?>
    </div>

    <!-- Form Pencarian (Search) -->
    <form action="index.php" method="GET" class="row g-2 mb-3">
        <input type="hidden" name="action" value="fasilitas">
        <div class="col-md-5">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari nama fasilitas / deskripsi..." value="<?= htmlspecialchars($keyword ?? ''); ?>">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
                <?php if (!empty($keyword)): ?>
                    <a href="index.php?action=fasilitas" class="btn btn-outline-danger">Reset</a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Tabel Data Fasilitas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Item</th>
                    <th>Kategori ID</th>
                    <th>Stok</th>
                    <th>Deskripsi</th>
                    <?php if ($isAdmin): ?>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($fasilitas)): ?>
                    <tr>
                        <td colspan="<?= $isAdmin ? '6' : '5'; ?>" class="text-center">Data fasilitas tidak ditemukan.</td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $no = (($page - 1) * 10) + 1;
                    foreach ($fasilitas as $row): 
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($row['nama_item']); ?></strong></td>
                            <td><span class="badge bg-secondary">ID: <?= htmlspecialchars($row['id_kategori']); ?></span></td>
                            <td><?= htmlspecialchars($row['stok']); ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                            <?php if ($isAdmin): ?>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="index.php?action=edit_fasilitas&id=<?= $row['id_fasilitas']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="index.php?action=hapus_fasilitas&id=<?= $row['id_fasilitas']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi (Pagination) -->
    <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <!-- Tombol Previous -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?action=fasilitas&page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword ?? ''); ?>">Previous</a>
                </li>
                
                <!-- Angka Halaman -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?action=fasilitas&page=<?= $i; ?>&keyword=<?= urlencode($keyword ?? ''); ?>"><?= $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Tombol Next -->
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?action=fasilitas&page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword ?? ''); ?>">Next</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php 
// Panggil Partial Template (Footer)
require_once __DIR__ . '/../layouts/footer.php'; 
?>