<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Peminjaman Fasilitas</title>
    <style>
        /* Container utama agar posisi di tengah layar dan berjarak pas */
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-title {
            color: #4A2E1B;
            border-bottom: 3px solid #8B5A2B;
            padding-bottom: 8px;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .btn-back {
            display: inline-block;
            color: #8B5A2B;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .btn-back:hover {
            color: #5C3A21;
            text-decoration: underline;
        }

        /* Kartu Formulir Bernuansa Coklat Warm */
        .form-card {
            background: #FFFFFF;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(74, 46, 27, 0.08);
            border: 1px solid #E8DFD5;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #5C3A21;
            font-size: 14px;
        }

        input[type="text"], 
        input[type="date"], 
        input[type="number"], 
        input[type="file"], 
        select {
            width: 100%;
            padding: 10px 12px;
            box-sizing: border-box;
            border: 1.5px solid #D9C8B4;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            background-color: #FAFAFA;
            transition: all 0.2s ease;
        }

        input[type="text"]:focus, 
        input[type="date"]:focus, 
        input[type="number"]:focus, 
        select:focus {
            border-color: #8B5A2B;
            background-color: #FFFFFF;
            box-shadow: 0 0 5px rgba(139, 90, 43, 0.25);
        }

        .btn-submit {
            width: 100%;
            background: #5C3A21;
            color: white;
            border: none;
            padding: 12px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 15px;
            font-weight: bold;
            margin-top: 10px;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #4A2E1B;
        }
    </style>
</head>
<body>

    <!-- PEMANGGILAN HEADER & NAVBAR DARI FOLDER LAYOUTS -->
    <?php 
    require_once __DIR__ . '/../layouts/header.php'; 
    require_once __DIR__ . '/../layouts/navbar.php'; 
    ?>

    <div class="container">
        <h2 class="page-title">Form Pengajuan Peminjaman</h2>
        <a href="index.php?action=fasilitas" class="btn-back">← Lihat Daftar Fasilitas</a>

        <div class="form-card">
            <form action="index.php?action=simpan_peminjaman" method="POST" enctype="multipart/form-data">

                <!-- DROPDOWN PILIHAN FASILITAS -->
                <div class="form-group">
                    <label>Fasilitas / Barang yang Ingin Dipinjam:</label>
                    <select name="id_fasilitas" required>
                        <option value="">-- Pilih Fasilitas / Barang --</option>
                        <?php if (!empty($list_fasilitas)) : ?>
                            <?php foreach ($list_fasilitas as $item) : ?>
                                <option value="<?= $item['id_fasilitas']; ?>">
                                    <?= htmlspecialchars($item['nama_item']); ?> (Stok: <?= htmlspecialchars($item['stok']); ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>NIM Mahasiswa:</label>
                    <input type="text" name="nim" placeholder="Masukkan NIM" required>
                </div>

                <div class="form-group">
                    <label>Nama Mahasiswa:</label>
                    <input type="text" name="nama_mahasiswa" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Pinjam:</label>
                    <input type="date" name="tgl_pinjam" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Kembali:</label>
                    <input type="date" name="tgl_kembali" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Unit/Item:</label>
                    <input type="number" name="jumlah" value="1" min="1" required>
                </div>

                <div class="form-group">
                    <label>Upload Foto Bukti Peminjaman (KTM / Surat):</label>
                    <input type="file" name="foto_pinjam" accept="image/*" required>
                </div>

                <button type="submit" class="btn-submit">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <!-- PEMANGGILAN FOOTER DARI FOLDER LAYOUTS -->
    <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>