<?php
// Memulai sesi untuk menyimpan status login
session_start();

// Jika user sudah login sebelumnya, langsung arahkan ke dashboard biar tidak perlu login ulang
if (isset($_SESSION['user'])) {
    header("Location: /dashboard.php");
    exit();
}

$pesan_notifikasi = "";

// Mengecek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_growid = $_POST['growid'];
    $input_password = $_POST['password'];

    // URL tujuan ke Lua In-Game kamu
    $url_lua = "https://api.gtps.cloud/g-api/20687/login";
    
    // Menyiapkan data yang akan dikirim ke Lua (Metode POST)
    $data = http_build_query(array('growid' => $input_growid, 'password' => $input_password));
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $data,
            'ignore_errors' => true // Mencegah fatal error di web jika server game sedang mati
        )
    );
    
    // Mengeksekusi pengiriman ke Lua dan menangkap jawabannya
    $context  = stream_context_create($options);
    $response = @file_get_contents($url_lua, false, $context);

    // Mengecek jawaban dari Lua
    if ($response === "sukses") {
        // MENYIMPAN NAMA USER KE SESSION DAN PINDAH HALAMAN
        $_SESSION['user'] = $input_growid;
        header("Location: /dashboard.php");
        exit();
    } elseif ($response === "gagal") {
        $pesan_notifikasi = "<div class='alert error'>❌ GrowID atau Password salah!</div>";
    } else {
        $pesan_notifikasi = "<div class='alert error'>❌ Gagal terhubung ke server game. Pastikan server nyala.</div>";
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
