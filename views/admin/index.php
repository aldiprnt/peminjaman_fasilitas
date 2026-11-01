<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Peminjaman Fasilitas</title>
    <style>
        .dashboard-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #8B5A2B;
            padding-bottom: 10px;
        }

        .page-title { color: #4A2E1B; margin: 0; font-size: 24px; font-weight: bold; }

        /* Stat Cards Layout */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #FFFFFF;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #E8DFD5;
            box-shadow: 0 4px 12px rgba(74, 46, 27, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .stat-info h4 { margin: 0; font-size: 13px; color: #777; text-transform: uppercase; font-weight: 600; }
        .stat-info span { font-size: 24px; font-weight: bold; color: #332211; }

        /* Card Colors */
        .bg-total { background: #EBF8FF; color: #2B6CB0; }
        .bg-pending { background: #FEF3C7; color: #D97706; }
        .bg-approved { background: #DCFCE7; color: #15803D; }
        .bg-rejected { background: #FEE2E2; color: #B91C1C; }

        /* Table Card Styling */
        .table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(74, 46, 27, 0.08);
            overflow: hidden;
            border: 1px solid #E8DFD5;
        }

        .table-header {
            padding: 16px 20px;
            background: #FAFAFA;
            border-bottom: 1px solid #E8DFD5;
            font-weight: bold;
            color: #4A2E1B;
            font-size: 16px;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background-color: #5C3A21; color: #FDFBF7; padding: 12px 14px; font-size: 13px; font-weight: 600; text-transform: uppercase; }
        td { padding: 12px 14px; border-bottom: 1px solid #F0E8DF; color: #332211; font-size: 14px; vertical-align: middle; }
        tr:hover { background-color: #FAF5EF; }

        .action-group { display: flex; gap: 6px; align-items: center; white-space: nowrap; }
        .btn-approve { background: #2E7D32; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 12px; font-weight: bold; transition: background 0.2s; }
        .btn-approve:hover { background: #1B5E20; }
        .btn-reject { background: #C62828; color: white; padding: 6px 12px; text-decoration: none; border-radius: 5px; font-size: 12px; font-weight: bold; transition: background 0.2s; }
        .btn-reject:hover { background: #B71C1C; }

        /* Badges */
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; }
        .status-Pending { color: #D97706; background: #FEF3C7; }
        .status-Disetujui { color: #15803D; background: #DCFCE7; }
        .status-Ditolak { color: #B91C1C; background: #FEE2E2; }
        .status-Dikembalikan { color: #1D4ED8; background: #DBEAFE; }

        .img-preview { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1.5px solid #D9A05B; transition: transform 0.2s; }
        .img-preview:hover { transform: scale(1.15); }
    </style>
</head>
<body>

    <!-- PEMANGGILAN HEADER & NAVBAR DARI FOLDER LAYOUTS -->
    <?php 
    require_once __DIR__ . '/../layouts/header.php'; 
    require_once __DIR__ . '/../layouts/navbar.php'; 

    // Hitung Ringkasan Statistik
    $total_pinjam = count($peminjaman ?? []);
    $total_pending = 0;
    $total_disetujui = 0;
    $total_ditolak = 0;

    if (!empty($peminjaman)) {
        foreach ($peminjaman as $item) {
            if ($item['status'] === 'Pending') $total_pending++;
            elseif ($item['status'] === 'Disetujui') $total_disetujui++;
            elseif ($item['status'] === 'Ditolak') $total_ditolak++;
        }
    }
    ?>

    <div class="dashboard-container my-4">
        <div class="page-header">
            <h2 class="page-title">📊 Dashboard Admin - Kelola Peminjaman</h2>
        </div>

        <!-- STATS CARDS RINGKASAN -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-total">📋</div>
                <div class="stat-info">
                    <h4>Total Pengajuan</h4>
                    <span><?= $total_pinjam; ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-pending">⏳</div>
                <div class="stat-info">
                    <h4>Menunggu (Pending)</h4>
                    <span><?= $total_pending; ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-approved">✅</div>
                <div class="stat-info">
                    <h4>Disetujui</h4>
                    <span><?= $total_disetujui; ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-rejected">❌</div>
                <div class="stat-info">
                    <h4>Ditolak</h4>
                    <span><?= $total_ditolak; ?></span>
                </div>
            </div>
        </div>

        <!-- TABEL DATA PEMINJAMAN -->
        <div class="table-card">
            <div class="table-header">Daftar Transaksi Peminjaman terbaru</div>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Fasilitas</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Jml</th>
                            <th>Bukti Pinjam</th>
                            <th>Bukti Kembali</th>
                            <th>Status</th>
                            <th style="min-width: 140px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; if (!empty($peminjaman)) : foreach ($peminjaman as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><b><?= htmlspecialchars($row['nim']); ?></b></td>
                                <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                                <td><b><?= htmlspecialchars($row['nama_item']); ?></b></td>
                                <td><?= htmlspecialchars($row['tgl_pinjam']); ?></td>
                                <td><?= htmlspecialchars($row['tgl_kembali']); ?></td>
                                <td><?= htmlspecialchars($row['jumlah']); ?></td>
                                
                                <td>
                                    <?php if (!empty($row['foto_pinjam'])) : ?>
                                        <a href="uploads/<?= htmlspecialchars($row['foto_pinjam']); ?>" target="_blank">
                                            <img src="uploads/<?= htmlspecialchars($row['foto_pinjam']); ?>" class="img-preview" alt="Foto Pinjam">
                                        </a>
                                    <?php else : ?>
                                        <span style="color: #999; font-size: 12px;">Tidak ada</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['foto_kembali'])) : ?>
                                        <a href="uploads/<?= htmlspecialchars($row['foto_kembali']); ?>" target="_blank">
                                            <img src="uploads/<?= htmlspecialchars($row['foto_kembali']); ?>" class="img-preview" alt="Foto Kembali">
                                        </a>
                                    <?php else : ?>
                                        <span style="color: #999; font-size: 12px;">Belum dikembalikan</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="badge-status status-<?= $row['status']; ?>">
                                        <?= htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                
                                <td style="text-align: center;">
                                    <?php if ($row['status'] === 'Pending') : ?>
                                        <div class="action-group" style="justify-content: center;">
                                            <a href="index.php?action=status_peminjaman&id=<?= $row['id_peminjaman']; ?>&status=Disetujui" class="btn-approve" onclick="return confirm('Setujui peminjaman ini?');">Setujui</a>
                                            <a href="index.php?action=status_peminjaman&id=<?= $row['id_peminjaman']; ?>&status=Ditolak" class="btn-reject" onclick="return confirm('Tolak peminjaman ini?');">Tolak</a>
                                        </div>
                                    <?php else : ?>
                                        <span style="color: #888; font-size: 13px;">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; else : ?>
                            <tr><td colspan="11" style="text-align: center; color: #888; padding: 25px;">Belum ada data peminjaman.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- PEMANGGILAN FOOTER DARI FOLDER LAYOUTS -->
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>