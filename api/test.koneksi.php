<?php
// Ganti data di bawah ini sesuai dengan info database dari panel gtps.cloud kamu
$host = "91.134.85.13"; 
$username = "MehanGG";
$password = "123mehansgg456";
$dbname = "FarmaPS";

// Mencoba melakukan koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    echo "<h1>Koneksi Gagal ❌</h1>";
    echo "<p>Error: " . $conn->connect_error . "</p>";
    echo "<p>Artinya: gtps.cloud kamu kemungkinan tidak mengizinkan Remote MySQL, atau datanya ada yang salah.</p>";
} else {
    echo "<h1>Koneksi Berhasil! ✅</h1>";
    echo "<p>Mantap! Web kamu bisa membaca database game. Kamu siap bikin sistem login web, event catur, dll!</p>";
}

$conn->close();
?>
