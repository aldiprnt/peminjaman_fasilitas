<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Fasilitas Kampus</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<!-- NOTIFIKASI FLASH MESSAGE (SUKSES / ERROR) -->
<?php if (isset($_SESSION['success'])) : ?>
    <div style="max-width: 1100px; margin: 15px auto 0; padding: 12px 20px; background-color: #DCFCE7; color: #15803D; border: 1px solid #86EFAC; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-circle-check"></i> <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div style="max-width: 1100px; margin: 15px auto 0; padding: 12px 20px; background-color: #FEE2E2; color: #B91C1C; border: 1px solid #FCA5A5; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-triangle-exclamation"></i> <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>