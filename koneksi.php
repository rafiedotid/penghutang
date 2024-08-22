<?php
// config.php

// Konfigurasi database
$servername = "localhost"; // Ganti dengan server database Anda
$username = "ntfvrwfb_hutang"; // Ganti dengan username database Anda
$password = "ntfvrwfb_hutang"; // Ganti dengan password database Anda
$dbname = "ntfvrwfb_hutang"; // Ganti dengan nama database Anda

$base_url = "http://domainlu.com";

// Token API WhatsApp
$apiToken = "tokenlu"; // Ganti dengan token API Anda (Fonnte)

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
