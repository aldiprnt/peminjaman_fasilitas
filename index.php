<?php
// Pastikan Session Aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. PANGGIL KONEKSI DATABASE TERLEBIH DAHULU
if (file_exists(__DIR__ . '/config/database.php')) {
    require_once __DIR__ . '/config/database.php';
} elseif (file_exists(__DIR__ . '/config/koneksi.php')) {
    require_once __DIR__ . '/config/koneksi.php';
}

// Tangkap objek koneksi (bisa $db, $koneksi, atau $conn)
$db = $db ?? $koneksi ?? $conn ?? null;

// 2. REQUIRE SELURUH CONTROLLER (SESUAIKAN DENGAN NAMA FILE ASLI)
require_once __DIR__ . '/controllers/fasilitasController.php';
require_once __DIR__ . '/controllers/aboutcontroller.php';
require_once __DIR__ . '/controllers/mahasiswacontroller.php';
require_once __DIR__ . '/controllers/admincontroller.php';
require_once __DIR__ . '/controllers/pengembaliancontroller.php';

// 3. INSTANSIASI CONTROLLER (DISESUAIKAN KEBUTUHAN CONSTRUCTOR PASING PARAMETER $db)
$fasilitasController    = new FasilitasController();
$aboutController        = new AboutController();
$mahasiswaController    = new MahasiswaController();
$adminController        = new AdminController($db);
$pengembalianController = new PengembalianController($db);

// Tentukan Action Default Berdasarkan Status Login
$defaultAction = 'fasilitas';
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $defaultAction = 'admin';
    } elseif ($_SESSION['role'] === 'user') {
        $defaultAction = 'user_dashboard';
    }
}

$action = $_GET['action'] ?? $defaultAction;

// RUTE DASHBOARD USER MAHASISWA
if ($action === 'user_dashboard' || $action === 'dashboard') {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
        $mahasiswaController->dashboard();
    } else {
        $mahasiswaController->dashboard();
    }

// RUTE FASILITAS & CRUD
} elseif ($action === 'fasilitas') {
    $fasilitasController->index();
} elseif ($action === 'kelola_fasilitas') {
    $fasilitasController->kelola();
} elseif ($action === 'tambah_fasilitas') {
    $fasilitasController->tambah();
} elseif ($action === 'edit_fasilitas') {
    $fasilitasController->edit();
} elseif ($action === 'hapus_fasilitas') {
    $fasilitasController->hapus();

// RUTE PEMINJAMAN MAHASISWA & CEK STATUS
} elseif ($action === 'peminjaman' || $action === 'mahasiswa') {
    $mahasiswaController->index();
} elseif ($action === 'simpan_peminjaman') {
    $mahasiswaController->simpan();
} elseif ($action === 'cek_status') {
    $mahasiswaController->status();

// RUTE PENGEMBALIAN
} elseif ($action === 'pengembalian') {
    $pengembalianController->index();
} elseif ($action === 'simpan_pengembalian') {
    $pengembalianController->simpan();

// RUTE ADMIN & AUTH
} elseif ($action === 'admin') {
    $adminController->index();
} elseif ($action === 'status_peminjaman') {
    $adminController->set_status();
} elseif ($action === 'login') {
    $adminController->login();
} elseif ($action === 'proses_login') {
    $adminController->proses_login();
} elseif ($action === 'logout') {
    $adminController->logout();

// RUTE ABOUT
} elseif ($action === 'about') {
    $aboutController->index();

// PENUTUP (JIKA ROUTE TIDAK DITEMUKAN)
} else {
    http_response_code(404);
    echo "Halaman tidak ditemukan";
}
?>