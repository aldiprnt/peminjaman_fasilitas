<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa - SI-FASILITAS</title>
    <style>
        .user-dashboard { max-width: 1100px; margin: 0 auto; padding: 0 20px; }
        
        /* Banner Welcoming */
        .welcome-banner {
            background: linear-gradient(135deg, #5C3A21, #8B5A2B);
            color: #FFFFFF;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(74, 46, 27, 0.15);
            margin-bottom: 30px;
        }

        .welcome-banner h2 { margin: 0 0 8px 0; font-size: 26px; }
        .welcome-banner p { margin: 0; opacity: 0.9; font-size: 15px; }

        /* Stats Cards */
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

        .bg-pending { background: #FEF3C7; color: #D97706; }
        .bg-approved { background: #DCFCE7; color: #15803D; }
        .bg-returned { background: #DBEAFE; color: #1D4ED8; }

        /* Quick Action Cards */
        .section-title { color: #4A2E1B; margin-bottom: 15px; font-size: 18px; font-weight: bold; }
        
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .action-card {
            background: #FFFFFF;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #E8DFD5;
            box-shadow: 0 4px 12px rgba(74, 46, 27, 0.05);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(74, 46, 27, 0.12);
        }

        .action-icon { font-size: 38px; margin-bottom: 12px; }
        .action-card h3 { margin: 0 0 10px 0; color: #4A2E1B; font-size: 18px; }
        .action-card p { color: #666; font-size: 14px; margin-bottom: 18px; line-height: 1.4; }

        .btn-action {
            display: inline-block;
            background: #8B5A2B;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-action:hover { background: #5C3A21; }
    </style>
</head>
<body>

    <!-- PEMANGGILAN HEADER & NAVBAR DARI FOLDER LAYOUTS -->
    <?php 
    require_once __DIR__ . '/../layouts/header.php'; 
    require_once __DIR__ . '/../layouts/navbar.php'; 

    // Ambil Nama User dari Session
    $nama_user = $_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? 'Mahasiswa';
    
    // Fallback Hitungan Statistik jika dikirim dari Controller atau dihitung dari $riwayat
    if (!isset($total_pending) || !isset($total_disetujui) || !isset($total_dikembalikan)) {
        $total_pending = 0;
        $total_disetujui = 0;
        $total_dikembalikan = 0;

        if (!empty($riwayat)) {
            foreach ($riwayat as $item) {
                $status_clean = strtolower(trim($item['status'] ?? ''));
                if ($status_clean === 'pending') {
                    $total_pending++;
                } elseif ($status_clean === 'disetujui') {
                    $total_disetujui++;
                } elseif ($status_clean === 'dikembalikan') {
                    $total_dikembalikan++;
                }
            }
        }
    }
    ?>

    <div class="user-dashboard my-4">
        
        <!-- BANNER UCAPAN SELAMAT DATANG -->
        <div class="welcome-banner">
            <h2>👋 Selamat Datang, <?= htmlspecialchars($nama_user); ?>!</h2>
            <p>Sistem Informasi Peminjaman Aula & Fasilitas Kampus. Gunakan menu di bawah untuk mulai membuat pengajuan atau mengecek status peminjamanmu.</p>
        </div>

        <!-- RINGKASAN STATISTIK PEMINJAMAN USER -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-pending">⏳</div>
                <div class="stat-info">
                    <h4>Pengajuan Pending</h4>
                    <span><?= (int) $total_pending; ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-approved">✅</div>
                <div class="stat-info">
                    <h4>Peminjaman Disetujui</h4>
                    <span><?= (int) $total_disetujui; ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-returned">📦</div>
                <div class="stat-info">
                    <h4>Sudah Dikembalikan</h4>
                    <span><?= (int) $total_dikembalikan; ?></span>
                </div>
            </div>
        </div>

        <!-- AKSES CEPAT / MENU UTAMA -->
        <h3 class="section-title">Menu Utama Mahasiswa</h3>
        <div class="action-grid">
            
            <div class="action-card">
                <div class="action-icon">🏛️</div>
                <h3>Daftar Fasilitas</h3>
                <p>Lihat ketersediaan aula, alat gamelan, dan busana tari yang bisa dipinjam.</p>
                <a href="index.php?action=fasilitas" class="btn-action">Lihat Katalog</a>
            </div>

            <div class="action-card">
                <div class="action-icon">📝</div>
                <h3>Form Peminjaman</h3>
                <p>Isi formulir pengajuan untuk meminjam fasilitas kampus sesuai jadwal event.</p>
                <a href="index.php?action=peminjaman" class="btn-action">Ajukan Pinjaman</a>
            </div>

            <div class="action-card">
                <div class="action-icon">🔍</div>
                <h3>Cek Status</h3>
                <p>Pantau persetujuan admin dan upload bukti foto pengembalian barang.</p>
                <a href="index.php?action=cek_status" class="btn-action">Cek Status Saya</a>
            </div>

        </div>
    </div>

    <!-- PEMANGGILAN FOOTER DARI FOLDER LAYOUTS -->
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>