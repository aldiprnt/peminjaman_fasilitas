<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Fasilitas (CRUD)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .content-container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-box { background: #f9f9f9; padding: 20px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 6px; }
        .form-box input, .form-box select { padding: 8px; margin-right: 5px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .form-box button { padding: 8px 15px; background: #0d6efd; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .form-box button:hover { background: #0b5ed7; }
    </style>
</head>
<body>

    <!-- PEMANGGILAN HEADER & NAVBAR DARI FOLDER LAYOUTS -->
    <?php 
    require_once __DIR__ . '/../layouts/header.php'; 
    require_once __DIR__ . '/../layouts/navbar.php'; 
    ?>

    <div class="content-container my-4">
        <h2>Kelola Data Fasilitas (CRUD)</h2>

        <div class="form-box">
            <h3>Tambah Fasilitas Baru</h3>
            <form action="index.php?action=tambah_fasilitas" method="POST" class="d-flex flex-wrap gap-2 align-items-center">
                <input type="text" name="nama_item" placeholder="Nama Barang / Aula" required>
                <select name="id_kategori" required>
                    <option value="1">Aula</option>
                    <option value="2">Gamelan</option>
                    <option value="3">Pakaian Tari</option>
                </select>
                <input type="number" name="stok" placeholder="Jumlah Stok" value="1" required style="width: 100px;">
                <input type="text" name="deskripsi" placeholder="Deskripsi Singkat" required style="width: 250px;">
                <button type="submit">Simpan Data</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama Item</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($fasilitas)): ?>
                    <?php foreach ($fasilitas as $item): ?>
                    <tr>
                        <td><?= $item['id_fasilitas']; ?></td>
                        <td><?= htmlspecialchars($item['nama_item']); ?></td>
                        <td><?= htmlspecialchars($item['nama_kategori'] ?? $item['kategori'] ?? '-'); ?></td>
                        <td><?= $item['stok']; ?></td>
                        <td><?= htmlspecialchars($item['deskripsi']); ?></td>
                        <td>
                            <a href="index.php?action=edit_fasilitas&id=<?= $item['id_fasilitas']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="index.php?action=hapus_fasilitas&id=<?= $item['id_fasilitas']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data fasilitas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- PEMANGGILAN FOOTER DARI FOLDER LAYOUTS -->
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>