<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? null;
$current_action = $_GET['action'] ?? ($role === 'admin' ? 'admin' : ($role === 'user' ? 'user_dashboard' : 'fasilitas'));
?>

<!-- Font Awesome untuk Ikon Modern -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .custom-navbar {
        background: linear-gradient(135deg, #3D2314, #5C3A21) !important;
        padding: 12px 28px !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        margin-bottom: 25px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .nav-left {
        display: flex !important;
        align-items: center !important;
        gap: 15px !important;
    }

    .nav-brand {
        color: #F3E5AB !important;
        font-size: 19px !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        margin-right: 15px !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        letter-spacing: 0.5px !important;
        white-space: nowrap !important;
    }

    .nav-brand:hover {
        color: #FFFFFF !important;
    }

    .nav-menu {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
    }

    .nav-menu a {
        color: #EEDC82 !important;
        text-decoration: none !important;
        padding: 8px 14px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center !important;
        gap: 7px !important;
        transition: all 0.25s ease !important;
        white-space: nowrap !important;
    }

    .nav-menu a:hover {
        color: #FFFFFF !important;
        background-color: rgba(255, 255, 255, 0.12) !important;
        transform: translateY(-1px) !important;
    }

    .nav-menu a.active {
        color: #FFFFFF !important;
        background-color: rgba(217, 160, 91, 0.3) !important;
        font-weight: 600 !important;
        border-bottom: 2px solid #F3E5AB !important;
    }

    .nav-user {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        margin-left: auto !important; /* Paksa menempel di pojok kanan */
    }

    .user-badge {
        color: #FDFBF7 !important;
        font-size: 13px !important;
        background: rgba(255, 255, 255, 0.12) !important;
        padding: 6px 14px !important;
        border-radius: 20px !important;
        border: 1px solid rgba(243, 229, 171, 0.2) !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        white-space: nowrap !important;
    }

    .btn-login-nav {
        background-color: #8B5A2B !important;
        color: white !important;
        padding: 7px 16px !important;
        border-radius: 6px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: background 0.2s ease !important;
        white-space: nowrap !important;
    }

    .btn-login-nav:hover {
        background-color: #A06D3B !important;
    }

    .btn-logout-nav {
        background-color: #B91C1C !important;
        color: white !important;
        padding: 7px 16px !important;
        border-radius: 6px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        transition: background 0.2s ease !important;
        white-space: nowrap !important;
    }

    .btn-logout-nav:hover {
        background-color: #991B1B !important;
    }
</style>

<div class="custom-navbar">
    <!-- GRUP KIRI: LOGO & MENU NAVIGASI -->
    <div class="nav-left">
        <a href="index.php?action=<?= ($role === 'admin') ? 'admin' : (($role === 'user') ? 'user_dashboard' : 'fasilitas'); ?>" class="nav-brand">
            <i class="fa-solid fa-building-columns"></i> SI-FASILITAS
        </a>
        
        <div class="nav-menu">
            <?php if ($role === 'admin') : ?>
                <a href="index.php?action=admin" class="<?= ($current_action === 'admin') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-chart-line"></i> Dashboard Admin
                </a>
                <a href="index.php?action=fasilitas" class="<?= ($current_action === 'fasilitas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-boxes-stacked"></i> Daftar Fasilitas
                </a>
                <a href="index.php?action=kelola_fasilitas" class="<?= ($current_action === 'kelola_fasilitas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-pen-to-square"></i> CRUD Fasilitas
                </a>
            
            <?php elseif ($role === 'user') : ?>
                <a href="index.php?action=user_dashboard" class="<?= ($current_action === 'user_dashboard') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                <a href="index.php?action=fasilitas" class="<?= ($current_action === 'fasilitas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-boxes-stacked"></i> Daftar Fasilitas
                </a>
                <a href="index.php?action=peminjaman" class="<?= ($current_action === 'peminjaman') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-file-pen"></i> Form Peminjaman
                </a>
                <a href="index.php?action=pengembalian" class="<?= ($current_action === 'pengembalian') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-box-archive"></i> Form Pengembalian
                </a>
                <a href="index.php?action=cek_status" class="<?= ($current_action === 'cek_status') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-magnifying-glass"></i> Cek Status
                </a>
            
            <?php else : ?>
                <a href="index.php?action=fasilitas" class="<?= ($current_action === 'fasilitas') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-boxes-stacked"></i> Daftar Fasilitas
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- GRUP KANAN: PROFIL RINGKAS & LOGOUT -->
    <div class="nav-user">
        <?php if (isset($_SESSION['username'])) : ?>
            <span class="user-badge">
                <i class="fa-solid fa-user-circle"></i> Mahasiswa (<b><?= strtoupper($role); ?></b>)
            </span>
            <a href="index.php?action=logout" class="btn-logout-nav">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        <?php else : ?>
            <a href="index.php?action=login" class="btn-login-nav">
                <i class="fa-solid fa-right-to-bracket"></i> Log In
            </a>
        <?php endif; ?>
    </div>
</div>