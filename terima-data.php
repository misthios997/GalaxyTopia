<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penghubung GTPS ke Web</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #2c3e50; 
            color: #ecf0f1;
            padding: 40px; 
            text-align: center;
        }
        .container { 
            background-color: #34495e; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.3); 
            display: inline-block;
            max-width: 600px;
        }
        h1 { color: #f1c40f; }
        .success { color: #2ecc71; font-size: 1.2em; font-weight: bold; margin-top: 20px;}
        .waiting { color: #e74c3c; font-style: italic; }
        .data-box {
            background-color: #1abc9c;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Penerima Data Lua</h1>
        <p>Halaman ini berfungsi menangkap data yang dikirim dari script Lua In-Game (contoh: Event Catur, GrowID, Gacha).</p>
        <hr>

        <?php
        // Mengecek apakah ada request HTTP POST atau GET yang masuk dari engine GTPS (Lua)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['pesan_dari_game'])) {
            
            // Menangkap data (mendukung metode POST maupun GET dari Lua)
            $pesan = "";
            if (isset($_POST['pesan_dari_game'])) {
                $pesan = $_POST['pesan_dari_game'];
            } elseif (isset($_GET['pesan_dari_game'])) {
                $pesan = $_GET['pesan_dari_game'];
            }

            if ($pesan !== "") {
                echo "<div class='success'>✅ Sinyal dari Game Diterima!</div>";
                echo "<div class='data-box'>";
                echo "<strong>Isi Data dari Lua:</strong> <br><br> " . htmlspecialchars($pesan);
                echo "</div>";
            } else {
                echo "<p class='waiting'>Menunggu data yang valid dari Lua...</p>";
            }

        } else {
            // Tampilan default saat web dibuka normal melalui browser
            echo "<p class='waiting'>Status: Web aktif. Menunggu tembakan data dari script Lua in-game...</p>";
        }
        ?>
    </div>
</body>
</html>
