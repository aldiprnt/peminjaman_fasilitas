<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login System - Peminjaman Fasilitas</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #F7F3EE; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 35px 30px; border-radius: 12px; box-shadow: 0 8px 25px rgba(74, 46, 27, 0.12); width: 340px; border: 1px solid #E8DFD5; }
        .login-title { text-align: center; margin-top: 0; color: #4A2E1B; font-size: 22px; margin-bottom: 20px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #5C3A21; font-size: 14px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px 12px; box-sizing: border-box; border: 1.5px solid #D9C8B4; border-radius: 6px; font-size: 14px; outline: none; }
        input[type="text"]:focus, input[type="password"]:focus { border-color: #8B5A2B; box-shadow: 0 0 5px rgba(139, 90, 43, 0.3); }
        .btn-submit { width: 100%; background: #5C3A21; color: white; border: none; padding: 12px; cursor: pointer; border-radius: 6px; font-size: 15px; font-weight: bold; transition: background 0.2s; }
        .btn-submit:hover { background: #4A2E1B; }
        .info-box { background: #FAF3EB; border-left: 4px solid #8B5A2B; padding: 10px 12px; margin-bottom: 20px; font-size: 12px; color: #5C3A21; border-radius: 0 6px 6px 0; }
    </style>
</head>
<body>

<div class="login-card">
    <h3 class="login-title">🔒 Log In Akun</h3>
    
    <div class="info-box">
        <b>Gunakan Akun Pengujian:</b><br>
        • Admin: <code>admin</code> / <code>admin123</code><br>
        • User: <code>mahasiswa</code> / <code>user123</code>
    </div>

    <form action="index.php?action=proses_login" method="POST">
        <div class="form-group">
            <label>Username / NIM</label>
            <input type="text" name="username" required placeholder="Masukkan username">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Masukkan password">
        </div>
        <button type="submit" class="btn-submit">Masuk</button>
    </form>
    
    <p style="text-align: center; margin-bottom: 0; margin-top: 20px;">
        <a href="index.php?action=fasilitas" style="color: #8B5A2B; text-decoration: none; font-size: 13px; font-weight: 500;">← Kembali ke Katalog Fasilitas</a>
    </p>
</div>

</body>
</html>