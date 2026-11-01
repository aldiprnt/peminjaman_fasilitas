<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Fasilitas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-box { background: #f9f9f9; padding: 20px; border: 1px solid #ccc; max-width: 450px; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-submit { background: #007bff; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
        .btn-back { display: inline-block; margin-bottom: 15px; color: #333; text-decoration: none; }
    </style>
</head>
<body>

    <!-- PEMANGGILAN NAVBAR -->
    <?php include __DIR__ . '/../navbar.php'; ?>

    <h2>Edit Data Fasilitas</h2>
    <a href="index.php?action=kelola_fasilitas" class="btn-back">← Batal & Kembali</a>

    <div class="form-box">
        <form action="index.php?action=edit_fasilitas&id=<?= $data['id_fasilitas']; ?>" method="POST">
            
            <div class="form-group">
                <label>Nama Item / Fasilitas:</label>
                <input type="text" name="nama_item" value="<?= htmlspecialchars($data['nama_item']); ?>" required>
            </div>

            <div class="form-group">
                <label>Kategori:</label>
                <select name="id_kategori" required>
                    <option value="1" <?= ($data['id_kategori'] == 1) ? 'selected' : ''; ?>>Aula</option>
                    <option value="2" <?= ($data['id_kategori'] == 2) ? 'selected' : ''; ?>>Gamelan</option>
                    <option value="3" <?= ($data['id_kategori'] == 3) ? 'selected' : ''; ?>>Pakaian Tari</option>
                </select>
            </div>

            <div class="form-group">
                <label>Stok:</label>
                <input type="number" name="stok" value="<?= htmlspecialchars($data['stok']); ?>" min="0" required>
            </div>

            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
            </div>

            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>

</body>
</html>