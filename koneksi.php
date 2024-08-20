<?php

// Konfigurasi database
$servername = "localhost"; // Ganti dengan server database Anda
$username = "username"; // Ganti dengan username database Anda
$password = "password"; // Ganti dengan password database Anda
$dbname = "database_name"; // Ganti dengan nama database Anda

// Token API WhatsApp
$apiToken = "YOUR_API_TOKEN"; // Ganti dengan token API Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
