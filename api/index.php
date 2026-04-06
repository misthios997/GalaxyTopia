<?php
// Memulai sesi untuk menyimpan status login
session_start();
$pesan_notifikasi = "";

// Mengecek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data Database GTPS kamu
    $host = "91.134.85.13"; 
    $username = "MehanGG";
    $password = "123mehansgg456";
    $dbname = "FarmaPS";

    $input_growid = $_POST['growid'];
    $input_password = $_POST['password'];

    try {
        // Melakukan koneksi ke database game
        $conn = new mysqli($host, $username, $password, $dbname);

        // Mencari GrowID di tabel users (Tabel bawaan GTPS pada umumnya)
        $stmt = $conn->prepare("SELECT password FROM users WHERE name = ?");
        $stmt->bind_param("s", $input_growid);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika GrowID ditemukan
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Mengecek kecocokan password
            // Catatan: Jika engine GTPS kamu menggunakan enkripsi (hash) untuk password, bagian ini perlu disesuaikan dengan jenis hash engine kamu.
            if ($input_password === $row['password']) {
                $pesan_notifikasi = "<div class='alert success'>✅ Login Berhasil! Selamat datang, " . htmlspecialchars($input_growid) . ".</div>";
                // Di sini kamu bisa menambahkan $_SESSION['user'] = $input_growid; untuk mengunci halaman dashboard
            } else {
                $pesan_notifikasi = "<div class='alert error'>❌ Password yang kamu masukkan salah!</div>";
            }
        } else {
            $pesan_notifikasi = "<div class='alert error'>❌ GrowID tidak ditemukan di database server!</div>";
        }

        $stmt->close();
        $conn->close();

    } catch (mysqli_sql_exception $e) {
        // Ini akan muncul jika gtps.cloud kamu belum membuka akses Remote MySQL (%)
        $pesan_notifikasi = "<div class='alert error'>❌ Gagal terhubung ke Database GTPS.<br><small>Error: " . $e->getMessage() . "</small><br>Pastikan kamu sudah meminta gtps.cloud untuk membuka Remote MySQL (Allow IP %).</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Galaxytopia</title>
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
        .login-box { 
            background-color: #16213e; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 8px 16px rgba(0,0,0,0.5); 
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        h2 { 
            color: #e94560; 
            margin-bottom: 30px;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #a2a2a2;
            font-size: 14px;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background-color: #0f3460;
            color: #fff;
            font-size: 16px;
            box-sizing: border-box;
        }
        .input-group input:focus {
            outline: 2px solid #e94560;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #e94560;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #c83b51;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 14px;
        }
        .success { background-color: #27ae60; color: #fff; }
        .error { background-color: #c0392b; color: #fff; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Galaxytopia Login</h2>
        
        <?= $pesan_notifikasi ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="growid">GrowID</label>
                <input type="text" id="growid" name="growid" required placeholder="Masukkan GrowID in-game">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan Password in-game">
            </div>
            <button type="submit">Login ke Dashboard</button>
        </form>
    </div>

</body>
</html>
