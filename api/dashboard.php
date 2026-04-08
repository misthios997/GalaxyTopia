<?php
session_start();

// Mengecek apakah user sudah login. Jika belum, lempar kembali ke halaman login (index.php)
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Galaxytopia</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #1a1a2e; 
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard-container {
            background-color: #16213e;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.5);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        h2 { color: #2ecc71; margin-bottom: 10px; }
        p.subtitle { color: #a2a2a2; margin-bottom: 30px; }
        
        /* Kotak Test sesuai request */
        .test-box {
            background-color: #0f3460;
            color: #e94560;
            font-size: 32px;
            font-weight: bold;
            padding: 40px;
            border: 3px dashed #e94560;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .btn-logout {
            display: inline-block;
            padding: 10px 20px;
            background-color: #c0392b;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-logout:hover {
            background-color: #a53125;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h2>Berhasil Masuk!</h2>
        <p class="subtitle">Halo, <strong><?= htmlspecialchars($_SESSION['user']) ?></strong>!</p>
        
        <div class="test-box">
            TEST
        </div>

        <a href="/logout.php" class="btn-logout">Logout</a>
    </div>

</body>
</html>
