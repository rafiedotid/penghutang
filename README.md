<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>README - Aplikasi Catatan Hutang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1, h2, h3 {
            color: #333;
        }
        code {
            background-color: #f4f4f4;
            padding: 2px 4px;
            border-radius: 4px;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1>Aplikasi Catatan Hutang</h1>

<p>Proyek ini adalah aplikasi catatan hutang sederhana yang dibangun dengan PHP Native. Aplikasi ini memungkinkan pengguna untuk mencatat hutang, mengelola status pembayaran, dan mengirimkan pengingat otomatis kepada penghutang melalui API WhatsApp Gateway.</p>

<h2>Fitur Utama</h2>
<ul>
    <li><strong>Catat Penghutang Baru</strong>: Formulir untuk menambahkan penghutang baru ke dalam database.</li>
    <li><strong>Kelola Hutang</strong>: Menampilkan daftar penghutang, termasuk nama, nomor HP, jumlah hutang, tanggal jatuh tempo, dan status pembayaran.</li>
    <li><strong>Tandai Hutang Lunas</strong>: Mengubah status hutang menjadi lunas, sekaligus mengirimkan pesan terima kasih melalui WhatsApp.</li>
    <li><strong>Pengingat Otomatis</strong>: Mengirimkan pengingat otomatis kepada penghutang yang belum melunasi hutangnya pada tanggal jatuh tempo menggunakan cron job.</li>
</ul>

<h2>Struktur Direktori</h2>
<pre>
/path/to/your/project/
    ├── config.php          # File konfigurasi database dan API
    ├── index.php           # Halaman utama untuk mencatat penghutang baru
    ├── save_debtor.php     # Proses penyimpanan data penghutang baru
    ├── data.php            # Halaman untuk melihat dan mengelola penghutang
    ├── update_status.php   # Proses update status hutang
    ├── send_reminder.php   # Script untuk mengirim pengingat otomatis
    ├── cronjob.sh          # Script cron job (opsional)
    └── README.md           # File ini
</pre>

<h2>Instalasi</h2>
<ol>
    <li><strong>Clone Repository</strong>
        <pre><code>git clone https://github.com/username/repo-name.git
cd repo-name</code></pre>
    </li>
    <li><strong>Konfigurasi Database dan API</strong>
        Edit file <code>config.php</code> dan masukkan detail database serta token API WhatsApp Gateway Anda:
        <pre><code>&lt;?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nama_database";

$apiToken = "YOUR_FONNTE_API_TOKEN"; // Masukkan token API Fonnte Anda

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?&gt;</code></pre>
    </li>
    <li><strong>Setup Database</strong>
        Buat database baru dan jalankan skrip SQL berikut untuk membuat tabel:
        <pre><code>CREATE DATABASE nama_database;

USE nama_database;

CREATE TABLE debtors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('belum_lunas', 'lunas') DEFAULT 'belum_lunas'
);</code></pre>
    </li>
    <li><strong>Menjalankan Aplikasi</strong>
        Aplikasi ini bisa dijalankan di localhost menggunakan server PHP built-in atau server web lainnya seperti Apache.
        <pre><code>php -S localhost:8000</code></pre>
        Buka browser dan akses aplikasi melalui <code>http://localhost:8000</code>.
    </li>
    <li><strong>Mengatur Cron Job (Opsional)</strong>
        Jika Anda ingin mengirim pengingat otomatis setiap hari, tambahkan script berikut ke crontab Anda:
        <pre><code>0 8 * * * /path/to/your/project/cronjob.sh</code></pre>
        Ini akan menjalankan <code>send_reminder.php</code> setiap hari pukul 8 pagi.
    </li>
</ol>

<h2>Kontribusi</h2>
<p>Jika Anda ingin berkontribusi pada proyek ini, silakan fork repository ini dan buat pull request dengan perubahan Anda.</p>

<h2>Lisensi</h2>
<p>Proyek ini dilisensikan di bawah MIT License.</p>

</body>
</html>

