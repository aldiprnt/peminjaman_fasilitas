<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Status Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .content-container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .status-Pending { color: orange; font-weight: bold; }
        .status-Disetujui { color: green; font-weight: bold; }
        .status-Ditolak { color: red; font-weight: bold; }
        .status-Dikembalikan { color: blue; font-weight: bold; }
        .btn-search { padding: 8px 12px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body>

    <!-- PEMANGGILAN HEADER & NAVBAR DARI FOLDER LAYOUTS -->
    <?php 
    require_once __DIR__ . '/../layouts/header.php'; 
    require_once __DIR__ . '/../layouts/navbar.php'; 
    ?>

    <div class="content-container my-4">
        <h2>Cek Status Peminjaman Mahasiswa</h2>

        <form action="index.php" method="GET" class="mb-4">
            <input type="hidden" name="action" value="cek_status">
            <input type="text" name="nim" placeholder="Masukkan NIM Anda..." value="<?= htmlspecialchars($_GET['nim'] ?? ''); ?>" required style="padding: 8px; width: 250px;">
            <button type="submit" class="btn-search">Cari Status</button>
        </form>

        <?php if (isset($_GET['nim'])) : ?>
            <h3>Hasil Pencarian untuk NIM: <?= htmlspecialchars($_GET['nim']); ?></h3>
            
            <?php if (!empty($riwayat)) : ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Fasilitas</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Jumlah</th>
                            <th>Status Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($riwayat as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                                <td><b><?= htmlspecialchars($row['nama_item']); ?></b></td>
                                <td><?= htmlspecialchars($row['tgl_pinjam']); ?></td>
                                <td><?= htmlspecialchars($row['tgl_kembali']); ?></td>
                                <td><?= htmlspecialchars($row['jumlah']); ?></td>
                                <td class="status-<?= $row['status']; ?>"><?= htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p style="color: red;">Data peminjaman tidak ditemukan untuk NIM tersebut.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- PEMANGGILAN FOOTER DARI FOLDER LAYOUTS -->
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>